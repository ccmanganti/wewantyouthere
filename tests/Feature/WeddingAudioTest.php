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

    public function test_every_template_has_three_audible_sample_choices_per_soundtrack(): void
    {
        $sets = config('wedding_audio.preview_sets', []);
        $defaults = config('wedding_audio.defaults', []);
        $this->assertCount(6, $sets);
        foreach ($defaults as $theme => $pair) {
            $this->assertArrayHasKey($theme, $sets);
            foreach (['intro', 'main'] as $slot) {
                $tracks = $sets[$theme][$slot] ?? [];
                $this->assertCount(3, $tracks, 'Three choices expected for '.$theme.' '.$slot);
                $this->assertCount(3, array_unique($tracks));
                $this->assertSame($pair[$slot], $tracks[0], 'First choice must be the default');
                foreach ($tracks as $id) {
                    $this->assertSame($slot, config('wedding_audio.tracks.'.$id.'.role'));
                    $this->assertNotEmpty(config('wedding_audio.tracks.'.$id.'.melody'));
                }
            }
        }
    }

    public function test_free_editor_only_shows_sample_preview_audio_not_premium_controls(): void
    {
        $template = InvitationTemplate::where('slug','olive-garden-wedding')->firstOrFail();
        $this->get('/templates/wedding/'.$template->slug)->assertOk()
            ->assertSee('Music & interactive sound effects', false)
            ->assertDontSee('data-music-upload="intro"', false)
            ->assertDontSee('id="wedding-music-studio"', false)
            ->assertSee('wwyt-audio-bootstrap')
            ->assertSee('wedding-audio.js')
            ->assertSee('"demo":true', false)
            ->assertSee('id="wwyt-sample-music"', false)
            ->assertSee('data-demo-track="intro"', false)
            ->assertSee('data-demo-track="main"', false)
            ->assertSee('data-demo-experience', false);
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
        $this->get('/i/free-mira-theo')->assertOk()
            ->assertDontSee('wedding-audio.js')
            ->assertDontSee('id="wwyt-sample-music"', false);
    }

    public function test_public_sample_previews_play_distinct_theme_music_without_premium_purchase(): void
    {
        foreach (config('wedding_curated_themes') as $key => $design) {
            $response = $this->get('/templates/'.$design['slug'].'/preview')->assertOk()
                ->assertSee('wwyt-audio-bootstrap')
                ->assertSee('wedding-audio.js')
                ->assertSee('Sample design')
                ->assertSee('"demo":true', false)
                ->assertSee(config('wedding_audio.defaults.'.$key.'.intro'))
                ->assertSee(config('wedding_audio.defaults.'.$key.'.main'))
                ->assertSee('id="wwyt-sample-music"', false)
                ->assertSee('data-demo-listen="intro"', false)
                ->assertSee('data-demo-listen="main"', false)
                ->assertSee('data-demo-experience', false)
                ->assertSee('"previewSets"', false)
                ->assertDontSee('/i/our-wedding/audio/intro');
        }

        $this->get('/templates/royal-burgundy-wedding/preview')->assertOk()
            ->assertSee('wwyt-audio-bootstrap')
            ->assertSee('royal-fanfare')
            ->assertSee('royal-ballroom')
            ->assertSee('data-demo-listen="intro"', false)
            ->assertSee('data-demo-listen="main"', false);
    }

    public function test_preview_buttons_are_labeled_preview_only(): void
    {
        $this->get('/wedding-invitation-templates')->assertOk()
            ->assertSee('>Preview <i', false)
            ->assertSee('allow="autoplay"', false)
            ->assertDontSee('>Live preview <i', false);
        $this->get('/templates/wedding/olive-garden-wedding')->assertOk()
            ->assertSee('class="review-preview-button"', false)
            ->assertDontSee('> Open full preview', false);
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
    public function test_published_site_music_can_be_changed_without_recreating_the_invitation(): void
    {
        $template=InvitationTemplate::where('slug','pearl-editorial-wedding')->firstOrFail();
        $owner=$this->user();$this->purchase($owner,$template);
        $site=InvitationWebsite::create([
            'user_id'=>$owner->id, 'invitation_template_id'=>$template->id,
            'name'=>'An Editorial Romance', 'slug'=>'owner-music-settings',
            'status'=>'published','answers'=>array_merge($this->answers(), ['_sections'=>[]]),
        ]);
        $this->actingAs($owner)->get('/app/invitations/'.$site->id.'/music')->assertOk()
            ->assertSee('Your invitation\'s soundtrack.', false)
            ->assertSee('name="audio[intro][source]"',false)
            ->assertSee('name="audio[main][source]"',false)
            ->assertSee('wedding-audio.js');

        $this->post('/app/invitations/'.$site->id.'/music',[
            'audio'=>[
                'intro'=>['source'=>'library','track'=>'pearl-reveal'],
                'main'=>['source'=>'library','track'=>'afterglow-nocturne'],
                'sfx'=>'0','volume'=>'70',
            ],
        ])->assertRedirect('/app/invitations/'.$site->id.'/music');

        $site->refresh();
        $this->assertSame('afterglow-nocturne',$site->answers['_audio']['main']['track']);
        $this->assertFalse($site->answers['_audio']['sfx']);
        $this->assertSame(70,$site->answers['_audio']['volume']);
        $this->assertSame('owner-music-settings',$site->slug);
        $this->assertDatabaseCount('invitation_websites',1);
        $this->get('/i/owner-music-settings')->assertOk()->assertSee('afterglow-nocturne');
    }

    public function test_only_owner_with_premium_purchase_can_manage_published_audio(): void
    {
        $template=InvitationTemplate::where('slug','painted-orchard-wedding')->firstOrFail();
        $owner=$this->user();$other=$this->user('unauthorized-music@example.test');
        $site=InvitationWebsite::create([
            'user_id'=>$owner->id,'invitation_template_id'=>$template->id,
            'name'=>'A Garden Wedding','slug'=>'private-music-settings',
            'status'=>'published','answers'=>$this->answers(),
        ]);
        $this->actingAs($other)->get('/app/invitations/'.$site->id.'/music')->assertForbidden();
        $this->actingAs($owner)->get('/app/invitations/'.$site->id.'/music')->assertForbidden();
        $this->purchase($owner,$template);
        $this->get('/app/invitations/'.$site->id.'/music')->assertOk();
    }

    public function test_published_music_manager_can_replace_and_preview_owner_audio(): void
    {
        $template=InvitationTemplate::where('slug','burgundy-wax-wedding')->firstOrFail();
        $owner=$this->user();$this->purchase($owner,$template);
        $site=InvitationWebsite::create([
            'user_id'=>$owner->id,'invitation_template_id'=>$template->id,
            'name'=>'An Heirloom Wedding','slug'=>'change-the-song',
            'status'=>'published','answers'=>$this->answers(),
        ]);
        $this->actingAs($owner);
        $url='/app/invitations/'.$site->id.'/music';
        $this->post($url,[
            'audio'=>[
                'intro'=>['source'=>'custom'],
                'main'=>['source'=>'library','track'=>'heirloom-valse'],
                'volume'=>'40','sfx'=>'1',
            ],
            'music_files'=>['intro'=>UploadedFile::fake()->create('custom-bells.mp3',92,'audio/mpeg')],
        ])->assertRedirect($url);
        $first=$site->fresh()->media['audio_intro']['path'];
        Storage::disk('local')->assertExists($first);
        $this->get($url.'/intro')->assertOk()->assertHeader('Content-Type','audio/mpeg');
        $this->get('/i/change-the-song/audio/intro')->assertOk();

        $this->post($url,[
            'audio'=>[
                'intro'=>['source'=>'custom'],
                'main'=>['source'=>'library','track'=>'heirloom-valse'],
            ],
            'music_files'=>['intro'=>UploadedFile::fake()->create('replacement-bells.mp3',95,'audio/mpeg')],
        ])->assertRedirect($url);
        $second=$site->fresh()->media['audio_intro']['path'];
        $this->assertNotSame($first,$second);
        Storage::disk('local')->assertExists($second);
        Storage::disk('local')->assertMissing($first);
    }

}
