<?php

namespace Tests\Feature;

use App\Models\InvitationTemplate;
use App\Models\InvitationTemplatePurchase;
use App\Models\InvitationWebsite;
use App\Models\User;
use Database\Seeders\RoyalBurgundyWeddingSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class InvitationPremiumTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoyalBurgundyWeddingSeeder::class);
    }

    private function template(): InvitationTemplate
    {
        return InvitationTemplate::where('slug', 'royal-burgundy-wedding')->firstOrFail();
    }

    private function user(): User
    {
        return User::create([
            'name' => 'Premium Tester',
            'email' => 'premium-tester@example.test',
            'password' => 'a-long-password-123',
        ]);
    }

    private function answers(): array
    {
        return [
            'bride_name' => 'Mia',
            'groom_name' => 'Liam',
            'event_title' => 'The wedding of Mia and Liam',
            'event_date' => '2027-12-12',
            'venue_name' => 'Garden Hall',
            'ceremony_address' => 'Garden Hall, Philippines',
            'reception_venue' => 'Wedding Garden',
            'host_message' => 'Join us for our wedding.',
            'event_schedule' => "3 PM Ceremony\n6 PM Dinner",
            'principal_sponsors' => 'Sponsor One',
            'video_embed_url' => 'https://youtu.be/abcdefghijk',
            'video_message' => 'Our prenup film',
        ];
    }

    public function test_all_six_premium_sections_are_hidden_without_an_entitlement(): void
    {
        $sections = [
            'couple' => true,
            'ceremony' => true,
            'reception' => true,
            'entourage' => true,
            'program' => true,
            'guests' => true,
            'video' => true,
            'maps' => true,
            'ceremony_details' => true,
        ];
        $filtered = \App\Support\InvitationPremium::filterSections($sections, false);

        foreach (['entourage', 'program', 'guests', 'video', 'maps', 'ceremony_details'] as $key) {
            $this->assertFalse($filtered[$key], $key);
        }
        $this->assertTrue($filtered['couple']);
        $this->assertTrue($filtered['reception']);
        $this->assertSame($sections, \App\Support\InvitationPremium::filterSections($sections, true));
    }

    public function test_premium_price_is_stored_per_template_and_displayed_in_pesos(): void
    {
        $template = $this->template();
        $template->update(['premium_price_cents' => 129900, 'is_premium' => true]);
        $this->assertSame('₱1,299.00', \App\Support\InvitationPremium::price($template->fresh()));
        $this->get('/upgrade/' . $template->slug)->assertOk()->assertSee('₱1,299.00');
    }

    public function test_unpaid_editor_shows_six_locked_premium_choices_and_price(): void
    {
        $this->get('/templates/wedding/royal-burgundy-wedding')->assertOk()
            ->assertSee('data-locked-feature="maps"', false)
            ->assertSee('data-locked-feature="rsvp"', false)
            ->assertSee('data-locked-feature="video"', false)
            ->assertSee('data-locked-feature="program"', false)
            ->assertSee('data-locked-feature="entourage"', false)
            ->assertSee('data-locked-feature="ceremony"', false)
            ->assertSee('premium-unlock-dialog')
            ->assertSee('₱999.00');
    }

    public function test_unpaid_publish_cannot_enable_premium_sections_with_modified_request(): void
    {
        $this->actingAs($this->user())->post('/templates/wedding/royal-burgundy-wedding/publish', [
            'answers' => $this->answers(),
            'sections' => [
                'program' => '1','entourage' => '1','guests' => '1','video' => '1',
                'reception' => '1',
            ],
            'premium_options' => ['maps' => '1', 'ceremony_details' => '1'],
        ])->assertRedirect();

        $site = InvitationWebsite::firstOrFail();
        foreach (['program','entourage','guests','video','maps','ceremony_details'] as $section) {
            $this->assertFalse((bool) $site->answers['_sections'][$section], $section);
        }
        $this->assertArrayNotHasKey('video_embed_url', $site->answers);

        $this->get('/i/' . $site->slug)->assertOk()
            ->assertDontSee('id="rbv-event-map"', false)
            ->assertDontSee('name="guest_name"', false)
            ->assertDontSee('youtube-nocookie.com/embed');
    }

    public function test_verified_payment_unlocks_sections_and_safe_video(): void
    {
        $user = $this->user();
        InvitationTemplatePurchase::create([
            'user_id' => $user->id, 'invitation_template_id' => $this->template()->id,
            'amount_cents' => 99900, 'currency' => 'PHP', 'status' => 'paid',
            'provider_session_id' => 'cs_paid_test', 'paid_at' => now(),
        ]);
        $this->actingAs($user);
        $this->get('/templates/wedding/royal-burgundy-wedding')->assertOk()
            ->assertDontSee('data-locked-feature="maps"', false);

        $this->post('/templates/wedding/royal-burgundy-wedding/publish', [
            'answers' => $this->answers(),
            'sections' => [
                'program' => '1','entourage' => '1','guests' => '1','video' => '1',
                'reception' => '1',
            ],
            'premium_options' => ['maps' => '1', 'ceremony_details' => '1'],
        ])->assertRedirect();

        $site = InvitationWebsite::firstOrFail();
        foreach (['program','entourage','guests','video','maps','ceremony_details'] as $section) {
            $this->assertTrue((bool) $site->answers['_sections'][$section], $section);
        }
        $this->get('/i/' . $site->slug)->assertOk()
            ->assertSee('id="rbv-event-map"', false)
            ->assertSee('youtube-nocookie.com/embed/abcdefghijk')
            ->assertSee('name="guest_name"', false);
    }

    public function test_checkout_does_not_take_payment_without_configured_provider(): void
    {
        $this->actingAs($this->user());
        config()->set('services.stripe.secret', null);
        config()->set('services.stripe.webhook_secret', null);
        $this->post('/upgrade/royal-burgundy-wedding/checkout')
            ->assertRedirect()->assertSessionHasErrors('checkout');
        $this->assertDatabaseCount('invitation_template_purchases', 0);
    }

    public function test_stripe_checkout_session_can_be_created_and_signed_webhook_grants_access(): void
    {
        $user = $this->user();
        $this->actingAs($user);
        config()->set('services.stripe.secret', 'sk_test_mock');
        config()->set('services.stripe.webhook_secret', 'whsec_test_secret');

        Http::fake([
            'api.stripe.com/v1/checkout/sessions' => Http::response([
                'id' => 'cs_test_premium_123',
                'url' => 'https://checkout.stripe.com/c/pay/cs_test_premium_123',
            ], 200),
        ]);

        $this->post('/upgrade/royal-burgundy-wedding/checkout')
            ->assertRedirect('https://checkout.stripe.com/c/pay/cs_test_premium_123');

        $purchase = InvitationTemplatePurchase::firstOrFail();
        $this->assertSame('pending', $purchase->status);
        $this->assertSame(99900, $purchase->amount_cents);

        $event = [
            'type' => 'checkout.session.completed',
            'data' => ['object' => [
                'id' => 'cs_test_premium_123',
                'metadata' => ['purchase_id' => (string) $purchase->id],
                'payment_status' => 'paid',
                'mode' => 'payment',
                'currency' => 'php',
                'amount_total' => 99900,
            ]],
        ];
        $payload = json_encode($event);
        $timestamp = time();
        $signature = hash_hmac('sha256', $timestamp . '.' . $payload, 'whsec_test_secret');

        $this->call('POST', '/webhooks/stripe/wwyt', [], [], [], [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_STRIPE_SIGNATURE' => "t={$timestamp},v1={$signature}",
        ], $payload)->assertOk();

        $this->assertSame('paid', $purchase->fresh()->status);

        // Calling the event twice must not duplicate an entitlement.
        $this->call('POST', '/webhooks/stripe/wwyt', [], [], [], [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_STRIPE_SIGNATURE' => "t={$timestamp},v1={$signature}",
        ], $payload)->assertOk();
        $this->assertDatabaseCount('invitation_template_purchases', 1);
    }

    public function test_random_video_hosts_cannot_be_embedded(): void
    {
        $this->assertNull(\App\Support\InvitationVideo::embed('https://example.com/hack'));
        $this->assertNull(\App\Support\InvitationVideo::embed('javascript:alert(1)'));
        $this->assertSame('https://www.youtube-nocookie.com/embed/abcdefghijk',
            \App\Support\InvitationVideo::embed('https://youtu.be/abcdefghijk'));
    }
}
