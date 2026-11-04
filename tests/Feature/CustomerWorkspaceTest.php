<?php

namespace Tests\Feature;

use App\Filament\Customer\Resources\Invitations\InvitationResource;
use App\Models\InvitationTemplate;
use App\Models\InvitationWebsite;
use App\Models\User;
use App\Support\InvitationAccounts;
use App\Support\InvitationWebsiteManager;
use Database\Seeders\RoleSeeder;
use Database\Seeders\WeddingBuilderSeeder;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerWorkspaceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
        $this->seed(WeddingBuilderSeeder::class);
    }

    private function user(string $email): User
    {
        return User::create([
            'name' => 'Test Customer',
            'email' => $email,
            'password' => 'secure-password-123',
        ]);
    }

    private function website(User $owner, string $slug): InvitationWebsite
    {
        $template = InvitationTemplate::where('slug', 'ever-after-classic')->firstOrFail();

        return InvitationWebsite::create([
            'user_id' => $owner->id,
            'invitation_template_id' => $template->id,
            'name' => 'Invitation for ' . $slug,
            'slug' => $slug,
            'status' => 'published',
            'answers' => [
                'bride_name' => 'Andrea',
                'groom_name' => 'Miguel',
            ],
        ]);
    }

    public function test_customer_panel_requires_sign_in_and_superadmin_stays_restricted(): void
    {
        $this->get('/app')->assertRedirect();
        $this->get('/app/invitations')->assertRedirect();

        $user = $this->user('customer@example.test');
        $this->actingAs($user);

        $this->get('/app')->assertOk();
        $this->get('/app/invitations')->assertOk();
        $this->get('/app/billing')->assertOk()->assertSee('Free plan');
        $this->get('/app/profile')->assertOk();

        $this->get('/admin')->assertForbidden();
    }

    public function test_customer_can_only_view_and_mutate_their_own_invitation_records(): void
    {
        $owner = $this->user('owner@example.test');
        $other = $this->user('other@example.test');
        $mine = $this->website($owner, 'owned-wedding');
        $theirs = $this->website($other, 'private-wedding');

        $this->actingAs($owner);
        Filament::setCurrentPanel(Filament::getPanel('app'));

        $this->assertSame([$mine->id], InvitationResource::getEloquentQuery()->pluck('id')->all());
        $this->assertTrue(InvitationResource::canEdit($mine));
        $this->assertFalse(InvitationResource::canEdit($theirs));
        $this->assertFalse(InvitationResource::canDelete($theirs));

        $this->get('/app/invitations')->assertOk()->assertDontSee('private-wedding');
    }

    public function test_free_accounts_have_one_slot_even_for_direct_publish_requests(): void
    {
        $user = $this->user('limited@example.test');
        $this->assertSame(1, InvitationAccounts::remainingSites($user));

        $this->website($user, 'one-and-only');
        $this->assertFalse(InvitationAccounts::canCreateWebsite($user));
        $this->assertSame(0, InvitationAccounts::remainingSites($user));

        $this->actingAs($user)->post('/templates/wedding/ever-after-classic/publish', [
            'slug' => 'attempted-second-site',
            'answers' => [
                'bride_name' => 'Andrea',
                'groom_name' => 'Miguel',
                'event_title' => 'Wedding',
                'event_date' => '2027-12-12',
                'venue_name' => 'Garden',
            ],
        ])->assertRedirect('/app/invitations');

        $this->assertDatabaseCount('invitation_websites', 1);

        InvitationWebsite::where('user_id', $user->id)->delete();
        $this->assertTrue(InvitationAccounts::canCreateWebsite($user));
    }

    public function test_changing_a_custom_uri_preserves_the_old_share_link_and_qr_destination(): void
    {
        $owner = $this->user('rename@example.test');
        $website = $this->website($owner, 'original-wedding');

        $renamed = InvitationWebsiteManager::updateOwned(
            $website,
            $owner->id,
            'Our wedding celebration',
            'new-wedding-link',
            'published',
        );

        $this->assertSame('new-wedding-link', $renamed->slug);
        $this->get('/i/original-wedding')->assertRedirect('/i/new-wedding-link');
        $this->get('/invitation-slug-availability?slug=original-wedding')
            ->assertOk()->assertJson(['available' => false]);

        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);
        InvitationWebsiteManager::updateOwned(
            $website,
            $this->user('not-owner@example.test')->id,
            'Unauthorized',
            'stolen-site',
            'published',
        );
    }

    public function test_unpublished_invitation_is_not_publicly_accessible(): void
    {
        $owner = $this->user('draft@example.test');
        $site = $this->website($owner, 'draft-wedding');
        $site->update(['status' => 'draft']);

        $this->get('/i/draft-wedding')->assertNotFound();
    }
}
