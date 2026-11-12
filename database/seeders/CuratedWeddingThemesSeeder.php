<?php

namespace Database\Seeders;

use App\Models\EventType;
use App\Models\InvitationTemplate;
use Illuminate\Database\Seeder;

class CuratedWeddingThemesSeeder extends Seeder
{
    public function run(): void
    {
        $event = EventType::where('slug', 'wedding')->firstOrFail();
        foreach (config('wedding_curated_themes', []) as $key => $design) {
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
            // Preserve any administrator-supplied pricing, publication choice,
            // creator and template status. Only update code-owned identity fields.
            $settings = $template->settings ?? [];
            $settings = array_merge($settings, [
                'renderer' => 'builtin_wedding',
                'theme' => 'curated_editorial',
                'design' => $key,
                'view' => 'weddings.themes.curated-editorial',
                'description' => $design['description'],
                'thumbnail_url' => $design['scenery'],
                'photo_slots' => array_keys(config('wedding_photos', [])),
                'features' => [
                    'free' => ['cover', 'envelope', 'photos', 'story', 'date', 'venues', 'dress_code', 'gift_note', 'share_url', 'qr_code'],
                    'premium' => array_keys(\App\Support\InvitationPremium::FEATURES),
                ],
                'motion' => $design['animation'],
            ]);
            $template->forceFill([
                'settings' => $settings,
                'version' => max(1, (int) $template->version),
            ])->save();
        }
    }
}
