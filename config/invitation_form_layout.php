<?php

// Responsive question ordering for ALL invitation event types. This is
// presentation metadata only; it never changes answer keys or required flags.
// Unknown/new event types simply use the common order and keep other questions.
return [
    'common' => [
        'event_title', 'event_date', 'event_time',
        'venue_name', 'venue_address', 'venue_map_url',
        'host_message', 'rsvp_deadline', 'guest_limit',
    ],
    'types' => [
        'wedding' => [
            'event_title', 'bride_name', 'groom_name', 'event_date', 'event_time',
            'venue_name', 'ceremony_address', 'reception_venue',
            'host_message', 'couple_story', 'hero_quote',
        ],
        'christening' => [
            'event_title', 'child_name', 'mother_name', 'father_name',
            'event_date', 'event_time', 'church_name', 'venue_name',
            'venue_address', 'reception_venue', 'godfathers', 'godmothers',
            'host_message',
        ],
        'birthday' => [
            'event_title', 'celebrant_name', 'age', 'theme',
            'event_date', 'event_time', 'venue_name', 'venue_address',
            'host_message',
        ],
        'debut' => [
            'event_title', 'debutante_name', 'event_date', 'event_time',
            'venue_name', 'venue_address', 'eighteen_roses',
            'eighteen_candles', 'eighteen_treasures', 'host_message',
        ],
        'anniversary' => [
            'event_title', 'couple_names', 'years_together',
            'event_date', 'event_time', 'venue_name', 'venue_address',
            'host_message',
        ],
        'graduation' => [
            'event_title', 'graduate_name', 'school_name', 'degree',
            'event_date', 'event_time', 'venue_name', 'venue_address',
            'host_message',
        ],
        'corporate-event' => [
            'event_title', 'company_name', 'event_organizer',
            'event_date', 'event_time', 'venue_name', 'venue_address',
            'agenda', 'host_message',
        ],
    ],
    'wide_keys' => [
        'event_title', 'venue_name', 'venue_address', 'ceremony_address',
        'reception_address', 'reception_venue', 'venue_map_url',
        'ceremony_map_url', 'reception_map_url', 'church_name',
        'school_name', 'company_name', 'couple_names', 'debutante_name',
        'child_name', 'graduate_name', 'host_message', 'agenda',
        'principal_sponsors', 'godfathers', 'godmothers',
        'eighteen_roses', 'eighteen_candles', 'eighteen_treasures',
    ],
];
