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
            $this->get('/wedding-invitation-templates/'.$design['slug'])->assertOk();
            $this->get('/templates/'.$design['slug'].'/preview')->assertOk()
                ->assertSee('ce-'.$key, false);
            $this->get('/templates/wedding/'.$design['slug'])->assertOk()
                ->assertSee('data-photos-enabled="1"', false)
                ->assertSee('data-stage="photos"', false)
                ->assertSee('data-stage="refine"', false);
        }
    }

    public function test_reseeding_preserves_template_admin_publication_and_pricing(): void
    {
        $this->seed(RoyalBurgundyWeddingSeeder::class);
        $template = InvitationTemplate::where('slug', 'olive-garden-wedding')->firstOrFail();
        $template->update(['status' => 'draft', 'premium_price_cents' => 23900]);
        $this->seed(RoyalBurgundyWeddingSeeder::class);
        $template->refresh();
        $this->assertSame('draft', $template->status);
        $this->assertSame(23900, $template->premium_price_cents);
    }
}
