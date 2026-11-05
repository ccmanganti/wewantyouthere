<?php

// Shared across the builder, public invitation, and owner photo manager.
// Never accept arbitrary keys, paths, MIME types or SVG uploads from clients.
return [
    'hero' => ['label' => 'Main wedding portrait', 'section' => 'couple', 'hint' => 'Your main portrait on the invitation cover', 'ratio' => '4 / 5'],
    'portrait_one' => ['label' => 'First portrait', 'section' => 'couple', 'hint' => 'The first photo in your couple introduction', 'ratio' => '4 / 5'],
    'portrait_two' => ['label' => 'Second portrait', 'section' => 'couple', 'hint' => 'The second photo in your couple introduction', 'ratio' => '4 / 5'],
    'story_one' => ['label' => 'How it began', 'section' => 'couple', 'hint' => 'First chapter of your love story', 'ratio' => '4 / 5'],
    'story_two' => ['label' => 'Growing together', 'section' => 'couple', 'hint' => 'Second chapter of your love story', 'ratio' => '4 / 5'],
    'story_three' => ['label' => 'The proposal', 'section' => 'couple', 'hint' => 'Final chapter before the wedding', 'ratio' => '4 / 5'],
    'venue_ceremony' => ['label' => 'Ceremony venue photo', 'section' => 'ceremony', 'hint' => 'The church, garden or ceremony setting', 'ratio' => '4 / 3'],
    'venue_reception' => ['label' => 'Reception venue photo', 'section' => 'reception', 'hint' => 'Your reception hall or celebration space', 'ratio' => '4 / 3'],
    'gallery_one' => ['label' => 'Favorite memory', 'section' => 'couple', 'hint' => 'Large featured photo in your gallery', 'ratio' => '4 / 5'],
    'gallery_two' => ['label' => 'Gallery photograph 2', 'section' => 'couple', 'hint' => 'Photo alongside your featured memory', 'ratio' => '1 / 1'],
    'gallery_three' => ['label' => 'Gallery photograph 3', 'section' => 'couple', 'hint' => 'Another memory to share', 'ratio' => '1 / 1'],
    'gallery_four' => ['label' => 'Gallery photograph 4', 'section' => 'couple', 'hint' => 'Final gallery memory', 'ratio' => '4 / 5'],
    'editorial_portrait' => ['label' => 'Editorial overlay portrait', 'section' => 'couple', 'hint' => 'Second photo layered over your main editorial portrait', 'ratio' => '4 / 5'],
    'guest_art_portrait' => ['label' => 'Family & friends collage portrait', 'section' => 'entourage', 'hint' => 'Photo in the family and entourage art panel', 'ratio' => '4 / 5'],
    'quote_portrait' => ['label' => 'Romantic quote photograph', 'section' => 'couple', 'hint' => 'Background photograph for the romantic quote', 'ratio' => '16 / 9'],
    'closing_portrait' => ['label' => 'Closing wedding photograph', 'section' => 'guests', 'hint' => 'Your beautiful closing photo behind the RSVP callout', 'ratio' => '16 / 9'],
    'gallery_five' => ['label' => 'Gallery photograph 5', 'section' => 'couple', 'hint' => 'A fifth memory in the photo gallery', 'ratio' => '4 / 5'],
    'gallery_six' => ['label' => 'Gallery photograph 6', 'section' => 'couple', 'hint' => 'A sixth memory in the photo gallery', 'ratio' => '4 / 5'],
    'gallery_seven' => ['label' => 'Gallery photograph 7', 'section' => 'couple', 'hint' => 'A seventh memory in the photo gallery', 'ratio' => '4 / 5'],
    'rsvp_portrait' => ['label' => 'Closing portrait', 'section' => 'guests', 'hint' => 'Photo beside the RSVP invitation', 'ratio' => '4 / 5'],
];
