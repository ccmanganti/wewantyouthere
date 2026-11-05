<?php

// Shared field presentation order for every wedding invitation template.
// These are existing question keys, not additional inputs or hard requirements.
// Keys not listed here retain their original order after the priority fields;
// templates can still enable/disable questions independently.
return [
    'couple' => [
        'event_title',
        'bride_name', 'groom_name',
        'host_message', 'couple_story', 'hero_quote',
        'wedding_hashtag',
    ],
    'ceremony' => [
        'event_date', 'event_time',
        'venue_name', 'ceremony_address', 'venue_address',
    ],
    'reception' => [
        'reception_venue', 'reception_time', 'reception_address',
    ],
    'entourage' => [
        'principal_sponsors', 'maid_of_honor', 'best_man', 'bridesmaids', 'groomsmen',
    ],
    'program' => [
        'event_schedule', 'ceremony_program', 'reception_program',
    ],
    'guests' => [
        'rsvp_message', 'rsvp_deadline', 'guest_limit', 'contact_name',
    ],
    'details' => [
        'dress_code', 'color_motif', 'gift_message',
    ],
];
