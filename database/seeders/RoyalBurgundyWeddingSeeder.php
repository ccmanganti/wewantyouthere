<?php

namespace Database\Seeders;

use App\Models\EventQuestion;
use App\Models\EventType;
use App\Models\InvitationTemplate;
use Illuminate\Database\Seeder;

class RoyalBurgundyWeddingSeeder extends Seeder
{
    public function run(): void
    {
        // Seeds the shared questions first. No duplicate questionnaire per design.
        $this->call(WeddingBuilderSeeder::class);
        $event = EventType::where('slug', 'wedding')->firstOrFail();

        $additional = [
            'love_story_start' => ['How we met', 'textarea', 'couple', 'A little about where it all began…'],
            'love_story_growing' => ['Our favorite chapter', 'textarea', 'couple', 'A special memory or how your love grew…'],
            'love_story_proposal' => ['The proposal', 'textarea', 'couple', 'Tell your proposal story…'],
            'bridal_procession' => ['Bridal procession', 'textarea', 'program', 'The order of the processional…'],
            'ceremony_readings' => ['Ceremony readings and prayers', 'textarea', 'program', 'Readings, hymns, and prayers…'],
            'reception_highlights' => ['Reception highlights', 'textarea', 'program', 'First dance, cake cutting, speeches…'],
            'parents_message' => ['Message from the families', 'textarea', 'entourage', 'A message or acknowledgements from both families…'],
            'secondary_sponsors' => ['Secondary sponsors', 'textarea', 'entourage', 'Names and roles, one per line…'],
            'wedding_coordinator' => ['Wedding coordinator / contact', 'text', 'guests', 'Contact name for guest inquiries'],
        ];
        $order = 5000;
        foreach ($additional as $key => [$label, $type, $group, $placeholder]) {
            EventQuestion::firstOrCreate(
                ['event_type_id' => $event->id, 'key' => $key],
                [
                    'label' => $label,
                    'type' => $type,
                    'is_required' => false,
                    'is_enabled' => true,
                    'sort_order' => $order,
                    'group_key' => $group,
                    'placeholder' => $placeholder,
                ],
            );
            $order += 10;
        }

        InvitationTemplate::firstOrCreate(['slug' => 'royal-burgundy-wedding'], [
            'event_type_id' => $event->id,
            'name' => 'Royal Burgundy · The Grand Wedding',
            'status' => 'published',
            'is_premium' => false,
            'version' => 1,
            'settings' => [
                'renderer' => 'builtin_wedding',
                'view' => 'weddings.themes.royal-burgundy',
                'theme' => 'royal_burgundy',
                'photo_slots' => array_keys(config('wedding_photos', [])),
                'description' => 'Editorial burgundy, candlelit gold, and ivory. A complete wedding website featuring love story, entourage, program, venue, photos and RSVP details.',
            ],
        ]);
    }
}
