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

        // These keys make every event-specific sentence, chapter heading and
        // timeline note in the V3 design editable through the existing builder.
        $editable = [
            'cover_eyebrow' => ['Cover introduction', 'text', 'couple', 'A celebration of love'],
            'cover_tagline' => ['Cover photo tagline', 'text', 'couple', 'One love. One promise. One forever.'],
            'welcome_heading' => ['Invitation greeting heading', 'text', 'couple', "You're invited."],
            'welcome_secondary' => ['Second welcome paragraph', 'textarea', 'couple', 'Your presence will make this beginning even more beautiful.'],
            'editorial_heading' => ['Editorial collage heading', 'text', 'couple', 'Little things, great love.'],
            'editorial_caption_one' => ['Editorial photograph 1 caption', 'text', 'couple', 'Every path led us to you.'],
            'editorial_caption_two' => ['Editorial photograph 2 caption', 'text', 'couple', 'Always, together.'],
            'editorial_quote' => ['Editorial closing quote', 'textarea', 'couple', 'You are my favorite chapter.'],
            'story_heading' => ['Story section heading', 'text', 'couple', 'How it all began.'],
            'story_chapter_one_heading' => ['Story chapter 1 heading', 'text', 'couple', 'When we met'],
            'story_chapter_two_heading' => ['Story chapter 2 heading', 'text', 'couple', 'The little moments'],
            'story_chapter_three_heading' => ['Story chapter 3 heading', 'text', 'couple', 'Our promise'],
            'door_heading' => ['Decorative doorway heading', 'text', 'couple', 'The doors to forever.'],
            'date_caption' => ['Date section caption', 'textarea', 'ceremony', "A day we'll remember for a lifetime."],
            'venue_art_heading' => ['Venue art heading', 'text', 'ceremony', 'Our special place'],
            'venue_intro' => ['Venue introduction', 'textarea', 'ceremony', 'Come celebrate with us.'],
            'map_heading' => ['Map section heading', 'text', 'reception', 'Find your way.'],
            'map_intro' => ['Map directions introduction', 'textarea', 'reception', 'We have saved you a spot.'],
            'timeline_heading' => ['Program timeline heading', 'text', 'program', 'Wedding day program'],
            'guest_arrival_time' => ['Guest arrival time', 'time', 'program', '14:30'],
            'guest_arrival_note' => ['Guest arrival description', 'text', 'program', 'Welcome drinks'],
            'ceremony_timeline_note' => ['Ceremony timeline description', 'text', 'program', 'The ceremony begins'],
            'reception_timeline_note' => ['Reception timeline description', 'text', 'program', 'Dinner and speeches'],
            'celebration_time' => ['Last dance / celebration time', 'time', 'program', '21:00'],
            'celebration_timeline_note' => ['Celebration timeline description', 'text', 'program', 'Dance the night away'],
            'program_details_heading' => ['Program information heading', 'text', 'program', 'What to expect'],
            'program_step_one' => ['Program step 1', 'textarea', 'program', 'Arrive and settle in before the ceremony.'],
            'program_step_two' => ['Program step 2', 'textarea', 'program', 'Join us as we exchange vows.'],
            'program_step_three' => ['Program step 3', 'textarea', 'program', 'Share a meal, a toast, and a few stories.'],
            'program_step_four' => ['Program step 4', 'textarea', 'program', 'Celebrate together on the dance floor.'],
            'people_art_heading' => ['Family collage heading', 'text', 'entourage', 'In good company.'],
            'people_quote' => ['Family collage quote', 'textarea', 'entourage', 'Our forever is sweeter with you beside us.'],
            'entourage_heading' => ['Entourage heading', 'text', 'entourage', 'Our dearest people.'],
            'entourage_intro' => ['Entourage introduction', 'textarea', 'entourage', 'We are surrounded by so much love.'],
            'dress_heading' => ['Dress code decorative heading', 'text', 'details', 'Dress code'],
            'dress_information_heading' => ['Dress information heading', 'text', 'details', 'A few lovely notes'],
            'gallery_heading' => ['Gallery heading', 'text', 'couple', 'Our favorite memories.'],
            'gallery_quote' => ['Gallery closing quote', 'textarea', 'couple', 'Life is a collection of moments.'],
            'guest_details_heading' => ['Guest reminder heading', 'text', 'guests', 'Little reminders.'],
            'closing_quote' => ['Grand closing quote', 'text', 'couple', "We can't wait to see you."],
            'rsvp_heading' => ['RSVP heading', 'text', 'guests', 'Kindly RSVP'],
            'rsvp_contact_heading' => ['RSVP contact heading', 'text', 'guests', "We'd love to hear from you."],
            'photo_caption_one' => ['Gallery featured photo caption', 'text', 'couple', 'Hand in hand, wherever life takes us.'],
            'photo_caption_two' => ['Gallery second photo caption', 'text', 'couple', 'The moments we never forget.'],
            'photo_caption_three' => ['Gallery third photo caption', 'text', 'couple', 'Close to you.'],
            'photo_caption_four' => ['Gallery fourth photo caption', 'text', 'couple', 'A night full of light.'],
        ];
        $position = 6000;
        foreach ($editable as $key => [$label, $type, $group, $placeholder]) {
            EventQuestion::firstOrCreate(
                ['event_type_id' => $event->id, 'key' => $key],
                [
                    'label' => $label, 'type' => $type, 'group_key' => $group,
                    'placeholder' => $placeholder, 'is_enabled' => true,
                    'is_required' => false, 'sort_order' => $position,
                ],
            );
            $position += 10;
        }

        $template = InvitationTemplate::firstOrCreate(['slug' => 'royal-burgundy-wedding'], [
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
                'description' => 'A stationery-inspired wedding website with elegant cream pages, burgundy panels, real envelope opening, wedding calendar, artistic venue sections and interactive photo uploads.',
            ],
        ]);

        // Do not reset administrators' customizations or publication state.
        // Upgrade only the architectural fields needed by the new renderer.
        $settings = $template->settings ?? [];
        $settings['renderer'] = 'builtin_wedding';
        $settings['theme'] = 'royal_burgundy';
        $settings['design'] = 'grand-info-v3';
        $settings['description'] = 'A cinematic 20-section wedding invitation with a click-to-open envelope, romantic galleries, venue maps and a guest RSVP form.';
        $settings['view'] = 'weddings.themes.royal-burgundy';
        $settings['photo_slots'] = array_keys(config('wedding_photos', []));
        $template->forceFill([
            'settings' => $settings,
            'status' => 'published',
            'is_premium' => false,
            'version' => max((int) $template->version, 3),
        ])->save();

        // The client wants one selectable design. Archive rather than delete:
        // older invitations retain their foreign keys, design and public URLs.
        InvitationTemplate::query()->whereKeyNot($template->id)
            ->where('status', 'published')->update(['status' => 'archived']);
    }
}
