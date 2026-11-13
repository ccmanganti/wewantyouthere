<?php

namespace Tests\Feature;

use App\Models\InvitationTemplate;
use Database\Seeders\RoyalBurgundyWeddingSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CuratedWeddingThemesTest extends TestCase
{
    use RefreshDatabase;

    public function test_five_designs_are_seeded_without_archiving_royal_burgundy(): void
    {
        $this->seed(RoyalBurgundyWeddingSeeder::class);
        $this->assertSame(6, InvitationTemplate::where('status', 'published')->count());
        foreach (config('wedding_curated_themes') as $key => $design) {
            $template = InvitationTemplate::where('slug', $design['slug'])->firstOrFail();
            $this->assertFalse($template->is_premium);
            $this->assertSame('curated_editorial', $template->settings['theme']);
            $this->assertSame($key, $template->settings['design']);
            $this->assertContains('rsvp', $template->settings['features']['premium']);
            $this->assertContains('photos', $template->settings['features']['free']);
            $this->assertSame(2, $template->settings['layout_revision']);
            $this->assertNotEmpty($template->settings['opening']);
            $this->assertTrue(\Illuminate\Support\Facades\View::exists('weddings.themes.editorial.'.$key));
            $this->assertTrue(\Illuminate\Support\Facades\View::exists('weddings.themes.editorial.styles.'.$key));
            $this->assertSame(config('wedding_curated_assets.'.$key.'.photos.hero'), $template->settings['thumbnail_url']);
            $this->get('/wedding-invitation-templates/'.$design['slug'])->assertOk();
            $this->get('/templates/'.$design['slug'].'/preview')->assertOk()
                ->assertSee('ce2-'.$key, false)
                ->assertSee('data-curated-design="'.$key.'"', false)
                ->assertSee('data-ce2-open', false);
            $this->get('/templates/wedding/'.$design['slug'])->assertOk()
                ->assertSee('data-photos-enabled="1"', false)
                ->assertSee('data-stage="photos"', false)
                ->assertSee('data-stage="refine"', false);
        }
    }

    public function test_each_design_has_its_own_intro_layout_and_photo_library(): void
    {
        $this->seed(RoyalBurgundyWeddingSeeder::class);
        $introductions = [
            'burgundy-wax' => 'bw-letter-trigger',
            'olive-garden' => 'og-book-trigger',
            'painted-orchard' => 'po-gate-trigger',
            'pearl-editorial' => 'pa-curtain-trigger',
            'destination-ticket' => 'dt-boarding-trigger',
        ];
        $seenPhotos = [];
        foreach (config('wedding_curated_themes') as $key => $theme) {
            $html = $this->get('/templates/'.$theme['slug'].'/preview')
                ->assertOk()->getContent();
            $this->assertStringContainsString($introductions[$key], $html);
            foreach ($introductions as $otherKey => $class) {
                if ($otherKey !== $key) $this->assertStringNotContainsString($class, $html);
            }
            $this->assertStringContainsString('data-photo-slot=', $html);
            foreach (config('wedding_curated_assets.'.$key.'.photos') as $url) {
                $this->assertNotContains($url, $seenPhotos, 'Shared demo image across designs: '.$url);
                $seenPhotos[] = $url;
            }
            $this->assertStringNotContainsString('data-premium-section="guests"', $html);
            $this->assertStringNotContainsString('data-premium-section="program"', $html);
            $this->assertStringContainsString('curated-cover', file_get_contents(resource_path('views/marketing/partials/template-card.blade.php')));
        }
    }

    public function test_reseeding_publishes_existing_drafts_and_preserves_admin_pricing(): void
    {
        $this->seed(RoyalBurgundyWeddingSeeder::class);
        $template = InvitationTemplate::where('slug', 'olive-garden-wedding')->firstOrFail();
        $template->update(['status' => 'draft', 'premium_price_cents' => 23900]);
        $this->seed(RoyalBurgundyWeddingSeeder::class);
        $template->refresh();
        $this->assertSame('published', $template->status);
        $this->assertSame(23900, $template->premium_price_cents);
    }

    public function test_seeder_rejects_missing_configuration_instead_of_succeeding_silently(): void
    {
        $this->seed(RoyalBurgundyWeddingSeeder::class);
        config()->set('wedding_curated_themes', []);
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('five wedding designs are missing');
        $this->seed(\Database\Seeders\CuratedWeddingThemesSeeder::class);
    }
}
