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

        if (count(config('wedding_curated_assets', [])) !== count($designs)
            || count(config('wedding_curated_showcases', [])) !== count($designs)) {
            throw new RuntimeException(
                'The v4 theme photos or sample data are missing. Deploy current code and run php artisan config:clear.'
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
                'view' => 'weddings.themes.editorial.'.$key,
                'description' => $design['description'],
                'thumbnail_url' => config('wedding_curated_assets.'.$key.'.photos.hero') ?: $design['scenery'],
                'photo_slots' => array_keys(\App\Support\CuratedWeddingDesign::photoSlots($template)),
                'layout_revision' => \App\Support\CuratedWeddingDesign::REVISION,
                'sample_profile' => $key,
                'engine' => 'independent_blade_v4',
                'opening' => [
                    'burgundy-wax' => 'breaking_seal_unrolling_parchment',
                    'olive-garden' => 'interactive_botanical_journal',
                    'painted-orchard' => 'hinged_garden_gates_and_petals',
                    'pearl-editorial' => 'cinematic_velvet_curtain_flash',
                    'destination-ticket' => 'boarding_stub_drag_and_takeoff',
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
                'is_premium' => false,
                'settings' => $settings,
                'version' => max(\App\Support\CuratedWeddingDesign::REVISION, (int) $template->version),
            ])->save();
            $this->command?->info("Updated {$template->slug}: design={$key}, layout=v".\App\Support\CuratedWeddingDesign::REVISION.", id={$template->id}");
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

        foreach ($designs as $key => $design) {
            $record = InvitationTemplate::where('slug', $design['slug'])->firstOrFail();
            if (($record->settings['design'] ?? null) !== $key
                || ($record->settings['layout_revision'] ?? null) !== \App\Support\CuratedWeddingDesign::REVISION) {
                throw new RuntimeException("Template {$design['slug']} did not update to its independent v4 design.");
            }
        }
        $this->command?->info('All 5 existing template records now point to distinct v4 layouts. No duplicates were created.');
    }
}
