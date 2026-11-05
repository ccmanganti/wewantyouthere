<?php

namespace Tests\Feature;

use App\Models\InvitationWebsite;
use App\Models\InvitationTemplate;
use App\Models\InvitationRsvp;
use App\Models\InvitationTemplatePurchase;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Database\Seeders\RoyalBurgundyWeddingSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuestRsvpTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoyalBurgundyWeddingSeeder::class);
    }

    private function site(string $slug = 'sample-wedding', array $answers = []): InvitationWebsite
    {
        $user = User::create([
            'name' => 'Couple Owner', 'email' => 'owner-'.$slug.'@example.test',
            'password' => 'strong-password-123',
        ]);
        $template = InvitationTemplate::where('slug','royal-burgundy-wedding')->firstOrFail();
        // Existing RSVP behavior is now exercised with a verified paid license.
        InvitationTemplatePurchase::create([
            'user_id' => $user->id, 'invitation_template_id' => $template->id,
            'amount_cents' => 99900, 'currency' => 'PHP', 'status' => 'paid',
            'provider' => 'stripe', 'provider_session_id' => 'cs_test_' . $slug,
            'paid_at' => now(),
        ]);
        return InvitationWebsite::create([
            'user_id' => $user->id,
            'invitation_template_id' => InvitationTemplate::where('slug','royal-burgundy-wedding')->firstOrFail()->id,
            'slug' => $slug,
            'name' => 'Our Wedding',
            'status' => 'published',
            'answers' => array_merge([
                'bride_name' => 'Andrea', 'groom_name' => 'Miguel',
                'event_date' => '2027-12-12', 'guest_limit' => '3',
                'rsvp_deadline' => '2027-11-20',
            ], $answers),
        ]);
    }

    public function test_unpaid_website_has_no_rsvp_form_and_cannot_accept_submissions(): void
    {
        $site = $this->site('unpaid-wedding');
        InvitationTemplatePurchase::where('user_id', $site->user_id)->delete();

        $this->get('/i/unpaid-wedding')->assertOk()
            ->assertDontSee('name="guest_name"', false)
            ->assertDontSee('id="rbv-event-map"', false)
            ->assertDontSee('id="our-people"', false);

        $this->post('/i/unpaid-wedding/rsvp', [
            'guest_name' => 'Guest Example', 'attendance' => 'attending', 'party_size' => 1,
        ])->assertForbidden();
        $this->assertDatabaseCount('invitation_rsvps', 0);
    }

    public function test_public_wedding_displays_real_rsvp_form_not_prototype_controls(): void
    {
        $this->site();
        $this->get('/i/sample-wedding')->assertOk()
            ->assertSee('name="guest_name"', false)
            ->assertSee('name="attendance"', false)
            ->assertSee('name="party_size"', false)
            ->assertSee('aria-label="Open the wedding invitation"', false)
            ->assertSee('data-rbv-open', false)
            ->assertDontSee('Skip introduction')
            ->assertDontSee('OPEN INVITATION')
            ->assertSee('data-intro-click-only="true"', false)
            ->assertDontSee('device-option')
            ->assertDontSee('Replay envelope')
            ->assertDontSee('data-rbv-skip');
    }

    public function test_rsvp_submission_is_stored_and_owner_can_read_it(): void
    {
        $site = $this->site();

        $this->post('/i/sample-wedding/rsvp', [
            'guest_name' => 'Taylor Reyes',
            'attendance' => 'attending',
            'party_size' => '2',
            'message' => 'Looking forward to celebrating!',
            'website' => '',
        ])->assertRedirect('/i/sample-wedding');

        $this->assertDatabaseHas('invitation_rsvps',[
            'invitation_website_id' => $site->id, 'guest_name' => 'Taylor Reyes',
            'attendance' => 'attending', 'guest_count' => 2,
        ]);
        $this->assertSame('Looking forward to celebrating!', InvitationRsvp::firstOrFail()->message);

        $this->actingAs($site->user)->get("/app/invitations/{$site->id}/rsvps")->assertOk()
            ->assertSee('Taylor Reyes')->assertSee('Attending');
    }

    public function test_declined_rsvp_has_zero_attendees(): void
    {
        $this->site();
        $this->post('/i/sample-wedding/rsvp',[
            'guest_name' => 'A Visitor', 'attendance' => 'declined',
        ])->assertRedirect('/i/sample-wedding');
        $this->assertSame(0, InvitationRsvp::firstOrFail()->guest_count);
    }

    public function test_rsvp_rejects_oversized_party_or_hidden_honeypot(): void
    {
        $this->site();
        $this->post('/i/sample-wedding/rsvp',[
            'guest_name' => 'A Visitor','attendance' => 'attending',
            'party_size' => 6,
        ])->assertSessionHasErrors('party_size');

        $this->post('/i/sample-wedding/rsvp',[
            'guest_name' => 'A Visitor','attendance' => 'attending',
            'party_size' => 1, 'website' => 'spam',
        ])->assertSessionHasErrors('website');
        $this->assertDatabaseCount('invitation_rsvps',0);
    }

    public function test_guest_cannot_rsvp_to_an_unpublished_invitation(): void
    {
        $site=$this->site();
        $site->update(['status' => 'draft']);

        $this->post('/i/sample-wedding/rsvp',[
            'guest_name'=>'A Visitor','attendance'=>'attending','party_size'=>1,
        ])->assertNotFound();
    }

    public function test_guest_responses_are_private_to_website_owner(): void
    {
        $site=$this->site();
        $stranger=User::create(['name'=>'Stranger','email'=>'stranger-rsvp@example.test','password'=>'testing']);
        $this->actingAs($stranger)->get("/app/invitations/{$site->id}/rsvps")->assertForbidden();
    }

    public function test_rsvp_after_deadline_is_rejected(): void
    {
        $this->site('expired-wedding', ['rsvp_deadline' => '2024-01-01']);
        $this->post('/i/expired-wedding/rsvp',[
            'guest_name'=>'A Visitor','attendance'=>'attending','party_size'=>1,
        ])->assertSessionHasErrors('attendance');
        $this->assertDatabaseCount('invitation_rsvps',0);
    }
}
