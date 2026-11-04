<?php

namespace Database\Seeders;

use App\Models\EventQuestion;
use App\Models\EventType;
use App\Models\InvitationTemplate;
use Illuminate\Database\Seeder;

class WeddingBuilderSeeder extends Seeder
{
    public function run(): void
    {
        $eventType = EventType::firstOrCreate(
            ['slug' => 'wedding'],
            ['name' => 'Wedding', 'is_active' => true],
        );

        $position = 10;

        foreach (config('wedding_builder.groups', []) as $group => $definition) {
            foreach ($definition['questions'] as $key => $field) {
                [$label, $type, $required, $placeholder] = $field;

                $question = EventQuestion::firstOrCreate(
                    ['event_type_id' => $eventType->id, 'key' => $key],
                    [
                        'label' => $label, 'type' => $type,
                        'is_required' => $required, 'is_enabled' => true,
                        'sort_order' => $position, 'group_key' => $group,
                        'placeholder' => $placeholder,
                    ],
                );

                // Backfill grouping for questions created by the earlier seeder.
                // Never reset an administrator's enabled/required settings.
                if (! $question->wasRecentlyCreated && in_array($question->group_key, ['extra', '', null], true)) {
                    $question->update(['group_key' => $group, 'placeholder' => $question->placeholder ?: $placeholder]);
                }

                $position += 10;
            }
        }

        InvitationTemplate::firstOrCreate(
            ['slug' => 'ever-after-classic'],
            [
                'event_type_id' => $eventType->id,
                'name' => 'Ever After · Classic Ivory',
                'status' => 'published',
                'is_premium' => false,
                'version' => 1,
                'settings' => [
                    'renderer' => 'builtin_wedding',
                    'view' => 'invitations.themes.ever-after',
                    'description' => 'An elegant, timeless wedding invitation with botanical accents.',
                ],
            ],
        );
    }
}
