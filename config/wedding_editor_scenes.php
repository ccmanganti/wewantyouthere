<?php

// Organizes editor questions by the wedding INVITATION's visual order, not by
// the original flat questionnaire order. The keys remain unchanged so saved
// answers, database questions, publishing and customer edits all stay compatible.
// Each scene has a unique ID per question group; multiple groups can point to
// the same invitation section (e.g. ceremony and reception details).
return [
    'couple' => [
        [
            'id' => 'cover', 'target' => 'cover',
            'label' => 'Opening cover', 'description' => 'Names, invitation title and first impression',
            'fields' => ['event_title', 'bride_name', 'groom_name', 'bride_full_name', 'groom_full_name', 'cover_eyebrow', 'cover_tagline', 'wedding_hashtag'],
        ],
        [
            'id' => 'welcome-note', 'target' => 'welcome-note',
            'label' => 'Welcome message', 'description' => 'Your personal invitation message',
            'fields' => ['welcome_heading', 'host_message', 'welcome_secondary'],
        ],
        [
            'id' => 'portrait-collection', 'target' => 'portrait-collection',
            'label' => 'Couple portraits', 'description' => 'Captions and editorial photographs',
            'fields' => ['editorial_heading', 'editorial_caption_one', 'editorial_caption_two', 'editorial_quote'],
        ],
        [
            'id' => 'our-story', 'target' => 'our-story',
            'label' => 'Our love story', 'description' => 'How you met, moments and proposal',
            'fields' => ['story_heading', 'couple_story', 'love_story_start', 'story_chapter_one_heading', 'love_story_growing', 'story_chapter_two_heading', 'love_story_proposal', 'story_chapter_three_heading', 'hero_quote'],
        ],
        [
            'id' => 'the-doors', 'target' => 'the-doors',
            'label' => 'A new chapter', 'description' => 'Decorative transition text',
            'fields' => ['door_heading'],
        ],
        [
            'id' => 'gallery-memories', 'target' => 'gallery-memories',
            'label' => 'Photo gallery', 'description' => 'Photo captions and memories',
            'fields' => ['gallery_heading', 'photo_caption_one', 'photo_caption_two', 'photo_caption_three', 'photo_caption_four', 'gallery_quote'],
        ],
        [
            'id' => 'our-moment', 'target' => 'our-moment',
            'label' => 'Final message', 'description' => 'The invitation\'s closing words',
            'fields' => ['closing_quote', 'closing_message'],
        ],
        [
            'id' => 'our-people', 'target' => 'our-people',
            'label' => 'Family names', 'description' => 'Parents and family information',
            'fields' => ['bride_parents', 'groom_parents'],
        ],
    ],
    'ceremony' => [
        [
            'id' => 'the-date', 'target' => 'the-date',
            'label' => 'Wedding date', 'description' => 'Calendar and ceremony timing',
            'fields' => ['event_date', 'date_caption'],
        ],
        [
            'id' => 'venue-art', 'target' => 'venue-art',
            'label' => 'Ceremony venue', 'description' => 'Primary venue and opening venue art',
            'fields' => ['venue_name', 'venue_art_heading'],
        ],
        [
            'id' => 'location-details', 'target' => 'location-details',
            'label' => 'Ceremony details', 'description' => 'Time, address and directions',
            'fields' => ['event_time', 'ceremony_venue', 'venue_address', 'venue_map_url', 'ceremony_address', 'ceremony_map_url', 'ceremony_type', 'ceremony_notes', 'venue_intro'],
        ],
        [
            'id' => 'guest-details', 'target' => 'guest-details',
            'label' => 'Ceremony reminders', 'description' => 'Guest information for the ceremony',
            'fields' => ['unplugged_note'],
        ],
    ],
    'reception' => [
        [
            'id' => 'location-details', 'target' => 'location-details',
            'label' => 'Reception details', 'description' => 'Reception venue and event time',
            'fields' => ['reception_venue', 'reception_address', 'reception_time', 'after_party_venue', 'after_party_time'],
        ],
        [
            'id' => 'venue-photo-story', 'target' => 'venue-photo-story',
            'label' => 'Reception atmosphere', 'description' => 'Reception photo captions and details',
            'fields' => ['reception_highlights'],
        ],
        [
            'id' => 'location-map', 'target' => 'location-map',
            'label' => 'Directions and maps', 'description' => 'Getting to the celebration',
            'fields' => ['reception_map_url', 'map_heading', 'map_intro', 'transport_instructions'],
        ],
        [
            'id' => 'guest-details', 'target' => 'guest-details',
            'label' => 'Travel and parking', 'description' => 'Parking, accommodation and other information',
            'fields' => ['parking_instructions', 'accommodation_details', 'livestream_url'],
        ],
    ],
    'entourage' => [
        [
            'id' => 'our-people', 'target' => 'our-people',
            'label' => 'Wedding party', 'description' => 'Parents, sponsors and entourage',
            'fields' => ['principal_sponsors', 'maid_of_honor', 'matron_of_honor', 'best_man', 'bridesmaids', 'groomsmen', 'junior_bridesmaids', 'junior_groomsmen', 'flower_girls', 'ring_bearer', 'coin_bearer', 'bible_bearer', 'candle_sponsors', 'veil_sponsors', 'cord_sponsors', 'officiant_name', 'secondary_sponsors', 'flower_offerers', 'readers', 'entourage_heading', 'entourage_intro'],
        ],
        [
            'id' => 'people-art', 'target' => 'people-art',
            'label' => 'Family tribute', 'description' => 'Family collage and appreciation',
            'fields' => ['people_art_heading', 'people_quote', 'parents_message'],
        ],
    ],
    'program' => [
        [
            'id' => 'the-timeline', 'target' => 'the-timeline',
            'label' => 'Timeline', 'description' => 'Order and times of the wedding day',
            'fields' => ['program_title', 'event_schedule', 'timeline_heading', 'guest_arrival_time', 'guest_arrival_note', 'ceremony_timeline_note', 'reception_timeline_note', 'celebration_time', 'celebration_timeline_note', 'first_dance_time'],
        ],
        [
            'id' => 'program-details', 'target' => 'program-details',
            'label' => 'Program details', 'description' => 'Ceremony, reception and special moments',
            'fields' => ['ceremony_program', 'reception_program', 'program_details_heading', 'program_step_one', 'program_step_two', 'program_step_three', 'program_step_four', 'bridal_procession', 'ceremony_readings', 'guest_activities', 'program_host', 'special_instructions'],
        ],
    ],
    'guests' => [
        [
            'id' => 'guest-details', 'target' => 'guest-details',
            'label' => 'Guest reminders', 'description' => 'Attendance rules and guest policies',
            'fields' => ['allow_plus_one', 'children_policy', 'meal_options', 'dietary_requirements', 'invitation_only_note', 'guest_details_heading'],
        ],
        [
            'id' => 'rsvp', 'target' => 'rsvp',
            'label' => 'RSVP form', 'description' => 'Deadline, guest count and welcome message',
            'fields' => ['guest_limit', 'rsvp_deadline', 'rsvp_message', 'rsvp_heading'],
        ],
        [
            'id' => 'rsvp-contact', 'target' => 'rsvp',
            'label' => 'Contact details', 'description' => 'Who guests should contact',
            'fields' => ['contact_name', 'contact_phone', 'contact_email', 'wedding_coordinator', 'rsvp_contact_heading'],
        ],
    ],
    'details' => [
        [
            'id' => 'dress-art', 'target' => 'dress-art',
            'label' => 'Wedding colors', 'description' => 'Colors and outfit inspiration',
            'fields' => ['color_motif', 'dress_heading', 'attire_examples'],
        ],
        [
            'id' => 'dress-information', 'target' => 'dress-information',
            'label' => 'Attire and gifts', 'description' => 'Dress code, gifts and registry',
            'fields' => ['dress_code', 'motif_notes', 'dress_information_heading', 'gift_message', 'gift_registry_url', 'gift_instructions'],
        ],
        [
            'id' => 'guest-details', 'target' => 'guest-details',
            'label' => 'FAQs and reminders', 'description' => 'Answers to common guest questions',
            'fields' => ['faq_1_question', 'faq_1_answer', 'faq_2_question', 'faq_2_answer', 'faq_3_question', 'faq_3_answer', 'other_reminders'],
        ],
        [
            'id' => 'our-moment', 'target' => 'our-moment',
            'label' => 'Final note', 'description' => 'A final message from the couple',
            'fields' => ['closing_message'],
        ],
    ],
];
