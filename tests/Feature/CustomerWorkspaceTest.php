<?php

namespace Tests\Feature;

use App\Filament\Customer\Auth\Register as CustomerRegister;
use App\Filament\Customer\Resources\Invitations\InvitationResource;
use App\Filament\Customer\Resources\Invitations\Pages\ListInvitations;
use App\Models\InvitationTemplate;
use App\Models\InvitationWebsite;
use App\Models\User;
use App\Support\InvitationAccounts;
use App\Support\InvitationWebsiteManager;
use Database\Seeders\RoleSeeder;
use Database\Seeders\WeddingBuilderSeeder;
use Filament\Facades\Filament;
use Filament\Actions\Testing\TestAction;
use Livewire\Livewire;
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

    public function test_customer_table_and_quick_edit_modal_work_without_an_edit_page(): void
    {
        $owner = $this->user('quick-editor@example.test');
        $site = $this->website($owner, 'original-title');

        $this->actingAs($owner);
        Filament::setCurrentPanel(Filament::getPanel('app'));

        Livewire::test(ListInvitations::class)
            ->assertSuccessful()
            ->assertCanSeeTableRecords([$site])
            ->assertActionVisible(TestAction::make('quickEdit')->table($site))
            ->callAction(TestAction::make('quickEdit')->table($site), data: [
                'name' => 'Updated wedding',
                'slug' => 'new-title',
                'status' => 'published',
            ])
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('invitation_websites', [
            'id' => $site->id,
            'slug' => 'new-title',
            'name' => 'Updated wedding',
        ]);

        $this->get('/i/original-title')->assertRedirect('/i/new-title');
    }

    public function test_content_edit_modal_saves_answers_and_section_visibility(): void
    {
        $owner = $this->user('content-editor@example.test');
        $site = $this->website($owner, 'content-wedding');

        $this->actingAs($owner);
        Filament::setCurrentPanel(Filament::getPanel('app'));

        Livewire::test(ListInvitations::class)
            ->assertSuccessful()
            ->callAction(TestAction::make('editContent')->table($site), data: [
                'answers' => [
                    'bride_name' => 'Updated Bride',
                    'groom_name' => 'Updated Groom',
                    'event_date' => '2027-12-12',
                    'event_title' => 'Updated wedding',
                    'venue_name' => 'New venue',
                ],
                'sections' => ['reception' => false, 'guests' => true],
            ])
            ->assertHasNoFormErrors();

        $site->refresh();
        $this->assertSame('Updated Bride', $site->answers['bride_name']);
        $this->assertFalse($site->answers['_sections']['reception']);
    }

    public function test_filament_registration_creates_a_customer_account_with_user_role(): void
    {
        Filament::setCurrentPanel(Filament::getPanel('app'));

        Livewire::test(CustomerRegister::class)
            ->fillForm([
                'name' => 'New Couple',
                'email' => 'registered-in-filament@example.test',
                'password' => 'secure-password-123',
                'passwordConfirmation' => 'secure-password-123',
            ])
            ->call('register')
            ->assertHasNoFormErrors();

        $user = User::where('email', 'registered-in-filament@example.test')->firstOrFail();
        $this->assertTrue($user->hasRole('User'));
        $this->assertSame('free', $user->account_tier);
    }

    public function test_filament_account_visit_finishes_the_pending_wedding_only_once(): void
    {
        $user = $this->user('finisher@example.test');
        $template = InvitationTemplate::where('slug', 'ever-after-classic')->firstOrFail();

        $this->actingAs($user)->withSession([
            'pending_wedding' => [
                'template_id' => $template->id,
                'slug' => 'finished-after-login',
                'sections' => ['couple' => true, 'ceremony' => true],
                'answers' => [
                    'bride_name' => 'Andrea',
                    'groom_name' => 'Miguel',
                    'event_title' => 'Wedding',
                    'event_date' => '2027-12-12',
                    'venue_name' => 'The Glass Garden',
                ],
            ],
        ])->get('/app')->assertRedirect('/i/finished-after-login');

        $this->assertDatabaseCount('invitation_websites', 1);
        $this->get('/app')->assertOk();
        $this->assertDatabaseCount('invitation_websites', 1);
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

    public function test_owner_can_delete_an_invitation_through_the_filament_modal_and_free_the_slot(): void
    {
        $owner = $this->user('delete@example.test');
        $site = $this->website($owner, 'to-be-deleted');

        $this->actingAs($owner);
        Filament::setCurrentPanel(Filament::getPanel('app'));

        Livewire::test(ListInvitations::class)
            ->assertSuccessful()
            ->callAction(TestAction::make('delete')->table($site))
            ->assertHasNoFormErrors();

        $this->assertDatabaseMissing('invitation_websites', ['id' => $site->id]);
        $this->assertTrue(InvitationAccounts::canCreateWebsite($owner));
        $this->get('/i/to-be-deleted')->assertNotFound();
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
