<?php

namespace Tests\Feature;

use App\Models\InvitationTemplate;
use App\Support\CuratedWeddingDesign;
use Database\Seeders\RoyalBurgundyWeddingSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\View;
use Tests\TestCase;

class CuratedWeddingThemesTest extends TestCase
{
    use RefreshDatabase;

    private const OPENINGS = [
        'burgundy-wax' => ['parchment-unroll', 'data-wax-scroll-open'],
        'olive-garden' => ['turning-journal', 'data-journal-open'],
        'painted-orchard' => ['conservatory-gate', 'data-garden-gate-open'],
        'pearl-editorial' => ['velvet-curtain', 'data-editorial-reveal'],
        'destination-ticket' => ['tearaway-ticket', 'data-boarding-ticket-open'],
    ];

    public function test_five_existing_slugs_resolve_to_independent_v4_layouts_and_previews(): void
    {
        $this->seed(RoyalBurgundyWeddingSeeder::class);
        $this->assertSame(6, InvitationTemplate::where('status', 'published')->count());

        foreach (config('wedding_curated_themes') as $key => $design) {
            $template = InvitationTemplate::where('slug', $design['slug'])->firstOrFail();
            $this->assertFalse($template->is_premium);
            $this->assertSame('published', $template->status);
            $this->assertSame('curated_editorial', $template->settings['theme']);
            $this->assertSame($key, $template->settings['design']);
            $this->assertSame($key, CuratedWeddingDesign::forTemplate($template));
            $this->assertSame(CuratedWeddingDesign::REVISION, $template->settings['layout_revision']);
            $this->assertSame('independent_blade_v4', $template->settings['engine']);
            $this->assertSame('weddings.themes.editorial.'.$key, $template->settings['view']);
            $this->assertContains('rsvp', $template->settings['features']['premium']);
            $this->assertContains('photos', $template->settings['features']['free']);
            $this->assertTrue(View::exists('weddings.themes.editorial.'.$key));
            $this->assertTrue(View::exists('weddings.themes.editorial.styles.'.$key));
            $this->assertTrue(View::exists('weddings.themes.editorial.intros.'.$key));
            $this->assertSame(config('wedding_curated_assets.'.$key.'.photos.hero'), $template->settings['thumbnail_url']);
            $this->assertSame(array_keys(CuratedWeddingDesign::photoSlots($template)), $template->settings['photo_slots']);

            $this->get('/wedding-invitation-templates/'.$design['slug'])->assertOk();
            $preview = $this->get('/templates/'.$design['slug'].'/preview')->assertOk();
            $preview->assertSee('data-curated-design="'.$key.'"', false)
                ->assertSee('data-design-revision="'.CuratedWeddingDesign::REVISION.'"', false)
                ->assertSee('data-intro-kind="'.self::OPENINGS[$key][0].'"', false)
                ->assertSee(self::OPENINGS[$key][1], false)
                ->assertSee(config('wedding_curated_showcases.'.$key.'.bride_name'), false);
            $this->get('/templates/wedding/'.$design['slug'])->assertOk()
                ->assertSee('data-photos-enabled="1"', false)
                ->assertSee('data-stage="photos"', false)
                ->assertSee('data-stage="refine"', false);
        }
    }

    public function test_no_two_themes_share_an_intro_or_a_demo_photo(): void
    {
        $this->seed(RoyalBurgundyWeddingSeeder::class);
        $seen = [];
        foreach (config('wedding_curated_themes') as $key => $design) {
            $html = $this->get('/templates/'.$design['slug'].'/preview')->assertOk()->getContent();
            $this->assertStringContainsString(self::OPENINGS[$key][1], $html);
            foreach (self::OPENINGS as $otherKey => [$kind, $control]) {
                if ($otherKey !== $key) {
                    $this->assertStringNotContainsString($control, $html);
                    $this->assertStringNotContainsString('data-intro-kind="'.$kind.'"', $html);
                }
            }
            foreach (config('wedding_curated_assets.'.$key.'.photos') as $url) {
                $this->assertNotContains($url, $seen, 'Duplicated sample photo in '.$key);
                $seen[] = $url;
            }
            $this->assertStringNotContainsString('data-premium-section="guests"', $html);
            $this->assertStringNotContainsString('data-premium-section="program"', $html);
            $this->assertStringNotContainsString('data-premium-section="maps"', $html);
        }
    }

    public function test_wrong_stale_db_theme_metadata_does_not_render_a_different_design(): void
    {
        $this->seed(RoyalBurgundyWeddingSeeder::class);
        $template = InvitationTemplate::where('slug', 'painted-orchard-wedding')->firstOrFail();
        $settings = $template->settings;
        $settings['design'] = 'burgundy-wax';
        $settings['theme'] = 'royal_burgundy';
        $template->update(['settings' => $settings]);

        $this->get('/templates/painted-orchard-wedding/preview')->assertOk()
            ->assertSee('data-intro-kind="conservatory-gate"', false)
            ->assertDontSee('data-intro-kind="parchment-unroll"', false)
            ->assertDontSee('rbv-intro', false);
        $this->get('/templates/wedding/painted-orchard-wedding')->assertOk()
            ->assertSee('data-curated-design="painted-orchard"', false);
    }

    public function test_reseeding_replaces_metadata_without_creating_duplicates_or_losing_pricing(): void
    {
        $this->seed(RoyalBurgundyWeddingSeeder::class);
        $before = InvitationTemplate::whereIn('slug', array_column(config('wedding_curated_themes'), 'slug'))->pluck('id', 'slug')->all();
        $template = InvitationTemplate::where('slug', 'olive-garden-wedding')->firstOrFail();
        $template->update(['status' => 'draft', 'premium_price_cents' => 23900]);
        $this->seed(RoyalBurgundyWeddingSeeder::class);

        $after = InvitationTemplate::whereIn('slug', array_column(config('wedding_curated_themes'), 'slug'))->pluck('id', 'slug')->all();
        $this->assertEqualsCanonicalizing($before, $after);
        $this->assertSame(6, InvitationTemplate::where('status', 'published')->count());
        $template->refresh();
        $this->assertSame('published', $template->status);
        $this->assertSame(23900, $template->premium_price_cents);
        $this->assertSame(CuratedWeddingDesign::REVISION, $template->settings['layout_revision']);
    }

    public function test_curated_templates_are_accepted_by_the_private_photo_upload_endpoint(): void
    {
        $this->seed(RoyalBurgundyWeddingSeeder::class);
        // Missing photo must produce validation (422), not a template-not-found 404.
        $this->postJson('/templates/wedding/olive-garden-wedding/photos', ['slot' => 'hero'])->assertUnprocessable();
        $this->postJson('/templates/wedding/painted-orchard-wedding/photos', ['slot' => 'hero'])->assertUnprocessable();
    }

    public function test_seeder_fails_when_the_new_design_configuration_is_not_deployed(): void
    {
        $this->seed(RoyalBurgundyWeddingSeeder::class);
        config()->set('wedding_curated_themes', []);
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('five wedding designs are missing');
        $this->seed(\Database\Seeders\CuratedWeddingThemesSeeder::class);
    }
}
