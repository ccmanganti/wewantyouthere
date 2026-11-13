<?php

namespace Database\Seeders;

use App\Models\EventType;
use App\Models\InvitationTemplate;
use Illuminate\Database\Seeder;
use RuntimeException;

class CuratedWeddingThemesSeeder extends Seeder
{
    public function run(): void
    {
        $designs = config('wedding_curated_themes');
        // Cached config or an incomplete deployment previously resulted in a
        // successful no-op. Fail clearly rather than claiming themes were seeded.
        if (!is_array($designs) || count($designs) < 5) {
            throw new RuntimeException(
                'The five wedding designs are missing from Laravel configuration. '
                .'Deploy the latest code, run php artisan config:clear, then seed again.'
            );
        }

        $event = EventType::where('slug', 'wedding')->firstOrFail();
        if (!$event->is_active) {
            throw new RuntimeException('Wedding event type is inactive; enable it before publishing designs.');
        }

        foreach ($designs as $key => $design) {
            $template = InvitationTemplate::firstOrCreate(
                ['slug' => $design['slug']],
                [
                    'event_type_id' => $event->id,
                    'name' => $design['name'],
                    'status' => 'published',
                    'is_premium' => false,
                    'version' => 1,
                    'settings' => [],
                ]
            );
            // Keep administrator pricing and creator information intact. An
            // explicit seed is also a request to make this curated collection
            // publicly selectable, including records previously left as drafts.
            $settings = $template->settings ?? [];
            $settings = array_merge($settings, [
                'renderer' => 'builtin_wedding',
                'theme' => 'curated_editorial',
                'design' => $key,
                'view' => 'weddings.themes.curated-editorial',
                'description' => $design['description'],
                'thumbnail_url' => config('wedding_curated_assets.'.$key.'.photos.hero') ?: $design['scenery'],
                'photo_slots' => array_keys(config('wedding_curated_assets.'.$key.'.photos', [])),
                'layout_revision' => 2,
                'opening' => [
                    'burgundy-wax' => 'unfolding_wax_letter',
                    'olive-garden' => 'turning_botanical_book',
                    'painted-orchard' => 'opening_conservatory_gates',
                    'pearl-editorial' => 'cinematic_velvet_curtain',
                    'destination-ticket' => 'tearing_boarding_pass',
                ][$key],
                'features' => [
                    'free' => ['animated_introduction', 'unique_layout', 'photos', 'story', 'date', 'venues', 'dress_code', 'gift_note', 'share_url', 'qr_code'],
                    'premium' => array_keys(\App\Support\InvitationPremium::FEATURES),
                ],
                'motion' => $design['animation'],
            ]);
            $template->forceFill([
                'event_type_id' => $event->id,
                'status' => 'published',
                'settings' => $settings,
                'version' => max(2, (int) $template->version),
            ])->save();
        }

        // Prevent silent success when a stale or inconsistent DB record causes
        // the public catalogue filter to hide a seeded design.
        $visibleCount = InvitationTemplate::query()
            ->whereIn('slug', array_column($designs, 'slug'))
            ->where('event_type_id', $event->id)
            ->where('status', 'published')
            ->where('settings->renderer', 'builtin_wedding')
            ->count();

        if ($visibleCount !== count($designs)) {
            throw new RuntimeException(
                "Only {$visibleCount} of ".count($designs).' curated wedding designs are publicly eligible.'
            );
        }
    }
}
