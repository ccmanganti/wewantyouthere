<?php

// Optional editor sub-sections, ordered to follow the invitation itself.
// Questions are filtered against the active database before rendering.
return [
    'couple' => [
        ['title' => 'Invitation cover', 'target' => 'cover', 'fields' => ['cover_eyebrow', 'cover_tagline', 'wedding_hashtag']],
        ['title' => 'Welcome message', 'target' => 'welcome-note', 'fields' => ['welcome_heading', 'welcome_secondary']],
        ['title' => 'Couple portraits', 'target' => 'portrait-collection', 'fields' => ['editorial_heading', 'editorial_caption_one', 'editorial_caption_two', 'editorial_quote']],
        ['title' => 'Our story', 'target' => 'our-story', 'fields' => ['story_heading', 'story_chapter_one_heading', 'love_story_start', 'story_chapter_two_heading', 'love_story_growing', 'story_chapter_three_heading', 'love_story_proposal', 'door_heading']],
        ['title' => 'Photo gallery', 'target' => 'gallery-memories', 'fields' => ['gallery_heading', 'photo_caption_one', 'photo_caption_two', 'photo_caption_three', 'photo_caption_four', 'gallery_quote']],
        ['title' => 'Closing words', 'target' => 'our-moment', 'fields' => ['closing_quote', 'closing_message']],
    ],
    'ceremony' => [
        ['title' => 'Wedding date', 'target' => 'the-date', 'fields' => ['date_caption']],
        ['title' => 'Ceremony venue', 'target' => 'location-details', 'fields' => ['ceremony_venue', 'venue_address', 'venue_art_heading', 'venue_intro']],
        ['title' => 'Extra ceremony notes', 'target' => 'location-details', 'fields' => ['ceremony_type', 'ceremony_notes', 'unplugged_note']],
    ],
    'reception' => [
        ['title' => 'Reception venue', 'target' => 'venue-photo-story', 'fields' => ['after_party_venue', 'after_party_time', 'reception_highlights']],
        ['title' => 'Directions and travel', 'target' => 'location-details', 'fields' => ['parking_instructions', 'transport_instructions', 'accommodation_details', 'livestream_url']],
        ['title' => 'Map wording', 'target' => 'location-map', 'fields' => ['map_heading', 'map_intro', 'reception_map_url']],
    ],
    'entourage' => [
        ['title' => 'Family and wedding party', 'target' => 'our-people', 'fields' => ['matron_of_honor', 'junior_bridesmaids', 'junior_groomsmen', 'flower_girls', 'ring_bearer', 'coin_bearer', 'bible_bearer', 'candle_sponsors', 'veil_sponsors', 'cord_sponsors', 'officiant_name', 'flower_offerers', 'readers', 'secondary_sponsors', 'entourage_heading', 'entourage_intro']],
        ['title' => 'Family tribute', 'target' => 'people-art', 'fields' => ['people_art_heading', 'people_quote', 'parents_message']],
    ],
    'program' => [
        ['title' => 'Wedding timeline', 'target' => 'the-timeline', 'fields' => ['program_title', 'timeline_heading', 'guest_arrival_time', 'guest_arrival_note', 'ceremony_timeline_note', 'reception_timeline_note', 'celebration_time', 'celebration_timeline_note', 'first_dance_time']],
        ['title' => 'Order of events', 'target' => 'program-details', 'fields' => ['program_details_heading', 'program_step_one', 'program_step_two', 'program_step_three', 'program_step_four', 'bridal_procession', 'ceremony_readings', 'guest_activities', 'program_host', 'special_instructions']],
    ],
    'guests' => [
        ['title' => 'Guest details', 'target' => 'guest-details', 'fields' => ['guest_details_heading', 'allow_plus_one', 'children_policy', 'meal_options', 'dietary_requirements', 'invitation_only_note']],
        ['title' => 'RSVP', 'target' => 'rsvp', 'fields' => ['rsvp_heading', 'rsvp_contact_heading', 'contact_phone', 'contact_email', 'wedding_coordinator']],
    ],
    'details' => [
        ['title' => 'Dress code', 'target' => 'dress-information', 'fields' => ['dress_heading', 'dress_information_heading', 'motif_notes', 'attire_examples']],
        ['title' => 'Gift notes', 'target' => 'dress-information', 'fields' => ['gift_registry_url', 'gift_instructions']],
        ['title' => 'Guest FAQs', 'target' => 'guest-details', 'fields' => ['faq_1_question', 'faq_1_answer', 'faq_2_question', 'faq_2_answer', 'faq_3_question', 'faq_3_answer', 'other_reminders']],
    ],
    'video' => [
        ['title' => 'Video section', 'target' => 'wedding-video', 'fields' => ['video_heading', 'video_message']],
    ],
];
