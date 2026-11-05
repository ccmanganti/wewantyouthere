<?php

namespace Tests\Feature;

use App\Models\EventQuestion;
use App\Models\EventType;
use App\Models\InvitationTemplate;
use App\Models\InvitationWebsite;
use App\Models\User;
use Database\Seeders\RoyalBurgundyWeddingSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RoyalBurgundyWeddingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
        $this->seed(RoyalBurgundyWeddingSeeder::class);
    }

    private function royal(): InvitationTemplate
    {
        return InvitationTemplate::where('slug','royal-burgundy-wedding')->firstOrFail();
    }

    private function owner(string $email = 'owner-royal@example.test'): User
    {
        return User::create([
            'name' => 'Wedding Owner',
            'email' => $email,
            'password' => 'secure-password-123',
        ]);
    }

    private function answers(): array
    {
        return [
            'bride_name' => 'Andrea',
            'groom_name' => 'Miguel',
            'event_title' => 'Our wedding',
            'event_date' => '2027-12-12',
            'venue_name' => 'The Grand Garden',
            'love_story_start' => 'We met in the library.',
        ];
    }

    public function test_seeder_only_offers_v3_design_and_preserves_previous_templates_for_existing_sites(): void
    {
        $this->assertSame('published', $this->royal()->status);
        $this->assertSame('builtin_wedding', $this->royal()->settings['renderer']);
        $this->assertSame('royal_burgundy', $this->royal()->settings['theme']);
        $this->assertSame(3, $this->royal()->version);
        $this->assertContains('venue_ceremony', $this->royal()->settings['photo_slots']);
        $this->assertContains('venue_reception', $this->royal()->settings['photo_slots']);

        $question = EventQuestion::where('event_type_id', EventType::where('slug', 'wedding')->firstOrFail()->id)
            ->where('key','love_story_proposal')->firstOrFail();
        $count = EventQuestion::count();
        $question->update(['is_enabled' => false]);

        $this->seed(RoyalBurgundyWeddingSeeder::class);

        $this->assertSame($count, EventQuestion::count());
        $this->assertFalse($question->fresh()->is_enabled);
        $this->assertDatabaseCount('invitation_templates', 2);
        $this->assertSame(1, InvitationTemplate::where('status','published')->count());
        $this->assertSame('archived', InvitationTemplate::where('slug','ever-after-classic')->firstOrFail()->status);
    }

    public function test_royal_template_is_discoverable_and_has_fullpage_and_five_step_live_editor(): void
    {
        $this->get('/')->assertOk()->assertSee('Royal Burgundy');
        $this->get('/wedding-invitation-templates')->assertOk()->assertSee('Royal Burgundy');

        $this->get('/templates/royal-burgundy-wedding/preview')->assertOk()
            ->assertSee('rb-invite')
            ->assertSee('How it all began.')
            ->assertSee('rbv-chapters')
            ->assertSee('envelope-front.webp')
            ->assertSee('dress-swatches.webp')
            ->assertSee('rbv-calendar')
            ->assertSee('our-people')
            ->assertSee('id="rsvp"', false)
            ->assertSee('data-intro-click-only="true"', false)
            ->assertSee('data-rbv-landscape-letter="true"', false)
            ->assertSee('rbv-letter-photo')
            ->assertSee('images.unsplash.com/photo-1617202000199-15fab1b09935')
            ->assertDontSee('rbv-letter>img')
            ->assertDontSee('device-option')
            ->assertDontSee('replay-button');

        $this->get('/templates/wedding/royal-burgundy-wedding')->assertOk()
            ->assertSee('Step 04 / 05')
            ->assertSee('Add your beautiful moments')
            ->assertSee('data-photo-slot="hero"', false)
            ->assertSee('data-photo-locate="hero"', false)
            ->assertSee('data-photo-edit="hero"', false)
            ->assertSee('images.unsplash.com/photo-1617202000199-15fab1b09935')
            ->assertSee('data-rbv-landscape-letter="true"', false)
            ->assertSee('data-step-navigation="refine"', false)
            ->assertSee('data-step-navigation="photos"', false)
            ->assertSee('data-photo-slot="venue_ceremony"', false)
            ->assertSee('data-photo-slot="venue_reception"', false)
            ->assertSee('preview-envelope-intro', false);
    }

    public function test_anonymous_photo_upload_can_be_previewed_then_published_after_registration(): void
    {
        $this->postJson('/templates/wedding/royal-burgundy-wedding/photos',[
            'slot' => 'hero',
            'photo' => UploadedFile::fake()->image('hero.jpg',900,600),
        ])->assertOk()->assertJsonPath('slot','hero');

        $this->get('/templates/wedding/royal-burgundy-wedding/photos/hero')
            ->assertOk()->assertHeader('Content-Type','image/jpeg');

        $this->post('/templates/wedding/royal-burgundy-wedding/publish',[
            'slug' => 'andrea-miguel-royal',
            'answers' => $this->answers(),
            'sections' => ['entourage' => '1', 'guests' => '1'],
        ])->assertRedirect('/app/register');

        $this->post('/register',[
            'name' => 'Wedding Owner',
            'email' => 'published-royal@example.test',
            'password' => 'secure-password-123',
            'password_confirmation' => 'secure-password-123',
        ])->assertRedirect('/i/andrea-miguel-royal');

        $site = InvitationWebsite::where('slug','andrea-miguel-royal')->firstOrFail();
        $this->assertArrayHasKey('hero', $site->media);
        $this->assertSame('image/jpeg', $site->media['hero']['mime']);
        Storage::disk('local')->assertExists($site->media['hero']['path']);

        $this->get('/i/andrea-miguel-royal')->assertOk()
            ->assertSee('rb-invite')
            ->assertSee('/i/andrea-miguel-royal/photos/hero')
            ->assertDontSee('images.unsplash.com/photo-')
            ->assertSee('We met in the library');

        $this->get('/i/andrea-miguel-royal/photos/hero')->assertOk()
            ->assertHeader('Content-Type','image/jpeg');

        $this->get('/templates/wedding/royal-burgundy-wedding/photos/hero')->assertNotFound();
    }

    public function test_template_art_uses_real_local_webp_assets_instead_of_svg_animations(): void
    {
        foreach ([
            'paper-texture.webp',
            'grand-doors.webp',
            'botanical-engraving.webp',
            'dress-swatches.webp',
            'envelope-back.webp',
            'envelope-front.webp',
            'envelope-flap.webp',
            'envelope-letter.webp',
            'wax-seal.webp',
        ] as $filename) {
            $path = public_path('wedding/royal-burgundy/' . $filename);
            $this->assertFileExists($path);
            $this->assertGreaterThan(1000, filesize($path));
            $this->assertSame(IMAGETYPE_WEBP, getimagesize($path)[2]);
        }
    }

    public function test_venue_photos_are_uploadable_into_the_late_photo_step(): void
    {
        $this->postJson('/templates/wedding/royal-burgundy-wedding/photos', [
            'slot' => 'venue_ceremony',
            'photo' => UploadedFile::fake()->image('chapel.jpg', 1000, 700),
        ])->assertOk()->assertJsonPath('slot', 'venue_ceremony');

        $this->get('/templates/wedding/royal-burgundy-wedding/photos/venue_ceremony')
            ->assertOk()->assertHeader('Content-Type', 'image/jpeg');
    }

    public function test_unsupported_file_types_and_unknown_image_slots_are_rejected(): void
    {
        $this->postJson('/templates/wedding/royal-burgundy-wedding/photos',[
            'slot' => 'not-a-slot',
            'photo' => UploadedFile::fake()->image('photo.jpg'),
        ])->assertUnprocessable()->assertJsonValidationErrors('slot');

        $this->postJson('/templates/wedding/royal-burgundy-wedding/photos',[
            'slot' => 'hero',
            'photo' => UploadedFile::fake()->create('evil.svg',120,'image/svg+xml'),
        ])->assertUnprocessable()->assertJsonValidationErrors('photo');

        $this->get('/templates/wedding/royal-burgundy-wedding/photos/nonexistent')
            ->assertNotFound();
    }

    public function test_draft_photo_is_private_and_cancel_deletes_it(): void
    {
        $this->postJson('/templates/wedding/royal-burgundy-wedding/photos',[
            'slot' => 'portrait_one',
            'photo' => UploadedFile::fake()->image('couple.png'),
        ])->assertOk();
        $key = 'wedding_uploads.'.$this->royal()->id;
        $entry = session($key)['portrait_one'];
        Storage::disk('local')->assertExists($entry['path']);

        $this->post('/templates/wedding/royal-burgundy-wedding/cancel')
            ->assertRedirect('/');
        Storage::disk('local')->assertMissing($entry['path']);
        $this->get('/templates/wedding/royal-burgundy-wedding/photos/portrait_one')->assertNotFound();
    }

    public function test_only_owner_can_manage_published_photos(): void
    {
        $owner = $this->owner();
        $other = $this->owner('stranger-royal@example.test');
        $site = InvitationWebsite::create([
            'user_id' => $owner->id,
            'invitation_template_id' => $this->royal()->id,
            'name' => 'Our Wedding',
            'slug' => 'owned-royal',
            'status' => 'published',
            'answers' => $this->answers(),
        ]);

        $this->actingAs($other)->get("/app/invitations/{$site->id}/photos")->assertForbidden();
        $this->post("/app/invitations/{$site->id}/photos",[
            'slot' => 'hero',
            'photo' => UploadedFile::fake()->image('stranger.jpg'),
        ])->assertForbidden();

        $this->actingAs($owner)->get("/app/invitations/{$site->id}/photos")->assertOk()
            ->assertSee('Your photographs, your story.');

        $this->post("/app/invitations/{$site->id}/photos",[
            'slot' => 'hero',
            'photo' => UploadedFile::fake()->image('owner.jpg'),
        ])->assertRedirect();
        $this->assertNotNull($site->fresh()->media['hero'] ?? null);
        $this->get('/i/owned-royal/photos/hero')->assertOk();

        $this->delete("/app/invitations/{$site->id}/photos/hero")->assertRedirect();
        $this->get('/i/owned-royal/photos/hero')->assertNotFound();
    }
}
