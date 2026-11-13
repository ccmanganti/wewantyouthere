<?php

namespace Tests\Feature;

use App\Models\InvitationTemplate;
use App\Models\InvitationTemplatePurchase;
use App\Models\InvitationWebsite;
use App\Models\User;
use App\Support\WeddingAudio;
use Database\Seeders\RoyalBurgundyWeddingSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class WeddingAudioTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
        $this->seed(RoyalBurgundyWeddingSeeder::class);
    }

    private function user(string $address = 'audio-owner@example.test'): User
    {
        return User::create(['name' => 'Music Test Owner', 'email' => $address, 'password' => 'secure-password-123']);
    }

    private function purchase(User $owner, InvitationTemplate $template): void
    {
        InvitationTemplatePurchase::create([
            'user_id' => $owner->id,
            'invitation_template_id' => $template->id,
            'amount_cents' => 99900,
            'currency' => 'PHP',
            'status' => 'paid',
            'provider_session_id' => 'paid_music_'. $owner->id.'_'.$template->id,
            'paid_at' => now(),
        ]);
    }

    private function answers(): array
    {
        return ['bride_name' => 'Mira', 'groom_name' => 'Theo', 'event_date' => '2027-12-12', 'event_title' => 'Our Wedding Celebration', 'venue_name' => 'The Wedding Garden'];
    }

    public function test_all_six_designs_have_distinct_paired_library_tracks(): void
    {
        $defaults = config('wedding_audio.defaults');
        $this->assertCount(6, $defaults);
        $unique = [];
        foreach (config('wedding_curated_themes') as $key => $data) {
            $pair = $defaults[$key];
            $this->assertSame('intro', config('wedding_audio.tracks.'.$pair['intro'].'.role'));
            $this->assertSame('main', config('wedding_audio.tracks.'.$pair['main'].'.role'));
            $this->assertNotContains($pair['intro'], $unique);
            $this->assertNotContains($pair['main'], $unique);
            $unique[] = $pair['intro'];
            $unique[] = $pair['main'];
        }
        $this->assertCount(10, $unique);
    }

    public function test_free_templates_do_not_display_music_studio_or_load_music_player(): void
    {
        $template = InvitationTemplate::where('slug','olive-garden-wedding')->firstOrFail();
        $this->get('/templates/wedding/'.$template->slug)->assertOk()
            ->assertSee('Music & interactive sound effects', false)
            ->assertDontSee('data-music-upload="intro"', false)
            ->assertDontSee('wwyt-audio-bootstrap')
            ->assertDontSee('wedding-audio.js');
        $owner = $this->user();
        $this->actingAs($owner)
            ->postJson('/templates/wedding/'.$template->slug.'/audio', ['slot' => 'intro'])
            ->assertForbidden();

        $this->post('/templates/wedding/'.$template->slug.'/publish',[
            'slug' => 'free-mira-theo', 'answers' => $this->answers(),
            'audio' => ['intro' => ['source'=>'library','track'=>'seal-whisper'],'main'=>['source'=>'none']],
        ])->assertRedirect('/i/free-mira-theo');
        $website = InvitationWebsite::where('slug','free-mira-theo')->firstOrFail();
        $this->assertEmpty($website->answers['_audio'] ?? []);
        $this->get('/i/free-mira-theo')->assertOk()->assertDontSee('wedding-audio.js');
    }

    public function test_paid_editor_has_both_independent_track_controls_and_audio_player(): void
    {
        $template = InvitationTemplate::where('slug','painted-orchard-wedding')->firstOrFail();
        $owner = $this->user(); $this->purchase($owner,$template);
        $this->actingAs($owner)->get('/templates/wedding/'.$template->slug)->assertOk()
            ->assertSee('id="wedding-music-studio"', false)
            ->assertSee('name="audio[intro][source]"', false)
            ->assertSee('name="audio[main][source]"', false)
            ->assertSee('data-music-upload="intro"', false)
            ->assertSee('data-music-upload="main"', false)
            ->assertSee('data-music-sfx',false)
            ->assertSee('wwyt-audio-bootstrap',false)
            ->assertSee('wedding-audio.js');
    }

    public function test_paid_library_selections_are_saved_and_delivered_to_the_guest(): void
    {
        $template = InvitationTemplate::where('slug','destination-ticket-wedding')->firstOrFail();
        $owner=$this->user();$this->purchase($owner,$template);
        $this->actingAs($owner)->post('/templates/wedding/'.$template->slug.'/publish',[
            'slug'=>'soundtrack-voyage',
            'answers'=>$this->answers(),
            'audio'=>[
                'intro'=>['source'=>'library','track'=>'boarding-call'],
                'main'=>['source'=>'library','track'=>'coastal-horizon'],
                'sfx'=>'1','volume'=>'35'
            ],
        ])->assertRedirect('/i/soundtrack-voyage');
        $website=InvitationWebsite::where('slug','soundtrack-voyage')->firstOrFail();
        $this->assertSame('boarding-call',$website->answers['_audio']['intro']['track']);
        $this->assertSame('coastal-horizon',$website->answers['_audio']['main']['track']);
        $this->assertSame(35,$website->answers['_audio']['volume']);
        $this->get('/i/soundtrack-voyage')->assertOk()
            ->assertSee('wwyt-audio-bootstrap')
            ->assertSee('boarding-call')
            ->assertSee('coastal-horizon')
            ->assertSee('wedding-audio.js');
    }

    public function test_invalid_song_id_or_unuploaded_custom_selection_cannot_be_published(): void
    {
        $template = InvitationTemplate::where('slug','pearl-editorial-wedding')->firstOrFail();
        $owner=$this->user();$this->purchase($owner,$template);$this->actingAs($owner);
        $url='/templates/wedding/'.$template->slug.'/publish';
        $this->post($url,['slug'=>'invalid-music','answers'=>$this->answers(),
            'audio'=>['intro'=>['source'=>'library','track'=>'coastal-horizon'],
                'main'=>['source'=>'library','track'=>'pearl-reveal']]])
            ->assertSessionHasErrors('audio');
        $this->post($url,['slug'=>'missing-music','answers'=>$this->answers(),
            'audio'=>['intro'=>['source'=>'custom','track'=>''], 'main'=>['source'=>'none']]])
            ->assertSessionHasErrors('audio');
        $this->assertDatabaseCount('invitation_websites',0);
    }

    public function test_custom_audio_is_private_and_published_only_for_paying_owner(): void
    {
        $template=InvitationTemplate::where('slug','olive-garden-wedding')->firstOrFail();
        $owner=$this->user();$this->purchase($owner,$template);$this->actingAs($owner);
        foreach (['intro','main'] as $slot) {
            $this->postJson('/templates/wedding/'.$template->slug.'/audio',[
                'slot'=>$slot,
                'audio'=>UploadedFile::fake()->create('original-'.$slot.'.mp3',110,'audio/mpeg'),
            ])->assertOk()->assertJsonPath('slot',$slot);
            $this->get('/templates/wedding/'.$template->slug.'/audio/'.$slot)
                ->assertOk()->assertHeader('Content-Type','audio/mpeg');
        }

        $this->post('/templates/wedding/'.$template->slug.'/publish',[
            'slug'=>'music-in-bloom','answers'=>$this->answers(),
            'audio'=>[
                'intro'=>['source'=>'custom'],
                'main'=>['source'=>'custom'],
                'sfx'=>'0', 'volume'=>'60',
            ],
        ])->assertRedirect('/i/music-in-bloom');

        $site=InvitationWebsite::where('slug','music-in-bloom')->firstOrFail();
        $this->assertSame('custom',$site->answers['_audio']['intro']['source']);
        $this->assertFalse($site->answers['_audio']['sfx']);
        foreach(['intro','main'] as $slot){
            $entry=$site->media['audio_'.$slot];
            Storage::disk('local')->assertExists($entry['path']);
            $this->get('/i/music-in-bloom/audio/'.$slot)
                ->assertOk()->assertHeader('Content-Type','audio/mpeg');
            $this->get('/templates/wedding/'.$template->slug.'/audio/'.$slot)->assertNotFound();
        }
        $this->get('/i/music-in-bloom')->assertOk()
            ->assertSee('/i/music-in-bloom/audio/intro')
            ->assertSee('/i/music-in-bloom/audio/main');

        InvitationTemplatePurchase::query()->where('user_id',$owner->id)
            ->where('invitation_template_id',$template->id)->update(['status'=>'refunded']);
        $this->get('/i/music-in-bloom/audio/intro')->assertNotFound();
        $this->get('/i/music-in-bloom')->assertOk()->assertDontSee('wwyt-audio-bootstrap');
    }

    public function test_custom_audio_upload_rejects_svg_and_unknown_slots(): void
    {
        $template=InvitationTemplate::where('slug','burgundy-wax-wedding')->firstOrFail();
        $owner=$this->user();$this->purchase($owner,$template);$this->actingAs($owner);
        $this->postJson('/templates/wedding/'.$template->slug.'/audio',[
            'slot'=>'other','audio'=>UploadedFile::fake()->create('sound.mp3',30,'audio/mpeg'),
        ])->assertUnprocessable()->assertJsonValidationErrors('slot');
        $this->postJson('/templates/wedding/'.$template->slug.'/audio',[
            'slot'=>'intro','audio'=>UploadedFile::fake()->create('danger.svg',30,'image/svg+xml'),
        ])->assertUnprocessable()->assertJsonValidationErrors('audio');
    }
}
