<?php

namespace Tests\Feature;

use App\Models\EventQuestion;
use App\Models\EventType;
use App\Models\InvitationTemplate;
use App\Models\InvitationWebsite;
use Database\Seeders\WeddingBuilderSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WeddingBuilderTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(WeddingBuilderSeeder::class);
    }

    public function test_homepage_shows_the_seeded_wedding_template(): void
    {
        $this->get('/')->assertOk()->assertSee('Ever After');
        $this->get('/templates/wedding/ever-after-classic')->assertOk()
            ->assertSee('Our entourage');
    }

    public function test_wedding_questions_are_idempotent_and_preserve_admin_disabled_state(): void
    {
        $event = EventType::where('slug', 'wedding')->firstOrFail();
        $question = EventQuestion::where('event_type_id', $event->id)->where('key', 'best_man')->firstOrFail();
        $count = EventQuestion::where('event_type_id', $event->id)->count();
        $this->assertGreaterThan(55, $count);

        $question->update(['is_enabled' => false]);
        $this->seed(WeddingBuilderSeeder::class);

        $this->assertSame($count, EventQuestion::where('event_type_id', $event->id)->count());
        $this->assertFalse($question->fresh()->is_enabled);
    }

    public function test_guest_can_customize_register_and_publish_a_free_invitation(): void
    {
        $this->post('/templates/wedding/ever-after-classic/publish', [
            'answers' => [
                'bride_name' => 'Andrea',
                'groom_name' => 'Miguel',
                'event_title' => 'Andrea & Miguel',
                'event_date' => '2027-12-12',
                'venue_name' => 'The Glass Garden',
                'best_man' => 'Jose',
            ],
            'sections' => ['entourage' => '0', 'reception' => '1'],
        ])->assertRedirect('/register');

        $this->post('/register', [
            'name' => 'Andrea Santos',
            'email' => 'andrea@example.com',
            'password' => 'secure-password-123',
            'password_confirmation' => 'secure-password-123',
        ])->assertRedirect();

        $website = InvitationWebsite::firstOrFail();
        $this->assertSame('published', $website->status);
        $this->assertSame('Andrea', $website->answers['bride_name']);
        $this->assertFalse($website->answers['_sections']['entourage']);
        $this->get('/i/'.$website->slug)->assertOk()->assertSee('Andrea')->assertSee('Miguel');
    }

    public function test_website_cannot_publish_without_required_questions(): void
    {
        $this->post('/templates/wedding/ever-after-classic/publish', [
            'answers' => ['bride_name' => 'Andrea'],
            'sections' => [],
        ])->assertSessionHasErrors(['answers.event_title', 'answers.event_date', 'answers.venue_name']);
        $this->assertDatabaseCount('invitation_websites', 0);
    }
}
