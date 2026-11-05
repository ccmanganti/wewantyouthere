<?php

// Keep the first editing pass intentionally short. All other enabled questions
// are offered later under optional "Fine-tune template" accordions.
// Keys stay compatible with existing wedding answer records.
return [
    'couple' => ['event_title', 'bride_name', 'groom_name', 'host_message', 'couple_story',
        'bride_mother', 'bride_father', 'groom_mother', 'groom_father'],
    'ceremony' => ['event_date', 'event_time', 'ceremony_venue', 'venue_name', 'ceremony_address'],
    'reception' => ['reception_venue', 'reception_time', 'reception_address'],
    'entourage' => ['principal_sponsors', 'maid_of_honor', 'best_man', 'bridesmaids', 'groomsmen'],
    'program' => ['event_schedule', 'ceremony_program', 'reception_program'],
    'guests' => ['rsvp_message', 'rsvp_deadline', 'guest_limit', 'contact_name'],
    'details' => ['dress_code', 'color_motif', 'gift_message'],
];
