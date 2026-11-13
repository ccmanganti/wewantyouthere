<?php

/**
 * Original, self-contained wedding instrumentals for the premium
 * invitation audio library. Each arrangement has its own melodic phrase,
 * chord progression, time signature and instrument combination in Web Audio.
 * No third-party copyrighted recordings are bundled or streamed.
 */
return [
    'uploads' => [
        'max_kb' => 12288,
        'mimes' => [
            'audio/mpeg' => 'mp3', 'audio/mp3' => 'mp3',
            'audio/x-wav' => 'wav', 'audio/wav' => 'wav', 'audio/wave' => 'wav',
            'audio/ogg' => 'ogg', 'audio/mp4' => 'm4a', 'audio/x-m4a' => 'm4a',
        ],
    ],
    'defaults' => [
        'burgundy-wax' => ['intro' => 'seal-whisper', 'main' => 'heirloom-valse'],
        'olive-garden' => ['intro' => 'botanical-page', 'main' => 'garden-afternoon'],
        'painted-orchard' => ['intro' => 'woodland-gates', 'main' => 'orchard-bloom'],
        'pearl-editorial' => ['intro' => 'pearl-reveal', 'main' => 'afterglow-nocturne'],
        'destination-ticket' => ['intro' => 'boarding-call', 'main' => 'coastal-horizon'],
        'royal_burgundy' => ['intro' => 'royal-fanfare', 'main' => 'royal-ballroom'],
    ],
    // Original, fully scored wedding instrumentals. Each melody is organized
    // into measures, with a matching chord progression and 3/4 or 4/4 meter.
    // Existing track IDs stay stable for previously published invitations.
    'tracks' => [
        'seal-whisper' => [
            'title' => 'Candlelit Vows', 'role' => 'intro',
            'description' => 'A gentle wedding prelude for piano and strings',
            'bpm' => 72, 'meter' => 4, 'voice' => 'piano', 'accompaniment' => 'strings',
            'melody' => [72,76,79,76,74,72,69,null,69,72,76,74,72,71,69,null],
            'chords' => [[60,64,67],[57,60,64],[53,57,60],[55,59,62]],
        ],
        'heirloom-valse' => [
            'title' => 'The Heirloom Wedding Waltz', 'role' => 'main',
            'description' => 'A romantic first-dance waltz with piano and warm strings',
            'bpm' => 86, 'meter' => 3, 'voice' => 'piano', 'accompaniment' => 'strings',
            'melody' => [76,79,84,83,79,76,74,76,79,81,79,76,74,72,71,72,76,79,81,79,76,74,72,null],
            'chords' => [[60,64,67],[55,59,62],[57,60,64],[53,57,60],[60,64,67],[57,60,64],[55,59,62],[60,64,67]],
        ],
        'botanical-page' => [
            'title' => 'Garden Aisle Processional', 'role' => 'intro',
            'description' => 'Airy wedding harp and romantic string accompaniment',
            'bpm' => 68, 'meter' => 4, 'voice' => 'harp', 'accompaniment' => 'strings',
            'melody' => [67,72,74,76,79,76,74,null,72,74,76,79,81,79,76,null],
            'chords' => [[60,64,67],[53,57,60],[57,60,64],[55,59,62]],
        ],
        'garden-afternoon' => [
            'title' => 'A Promise in Bloom', 'role' => 'main',
            'description' => 'A graceful garden wedding waltz for harp and cello',
            'bpm' => 78, 'meter' => 3, 'voice' => 'harp', 'accompaniment' => 'cello',
            'melody' => [72,76,79,81,79,76,74,72,69,72,76,79,76,74,72,71,72,74,76,79,76,74,72,null],
            'chords' => [[60,64,67],[53,57,60],[57,60,64],[55,59,62],[60,64,67],[53,57,60],[55,59,62],[60,64,67]],
        ],
        'woodland-gates' => [
            'title' => 'The Garden Wedding Entrance', 'role' => 'intro',
            'description' => 'Lush, slow strings for walking down the aisle',
            'bpm' => 64, 'meter' => 4, 'voice' => 'strings', 'accompaniment' => 'harp',
            'melody' => [67,71,74,79,81,79,76,74,72,74,76,79,81,83,81,null],
            'chords' => [[55,59,62],[60,64,67],[52,55,59],[62,66,69]],
        ],
        'orchard-bloom' => [
            'title' => 'Forever Under the Trees', 'role' => 'main',
            'description' => 'An orchestral wedding waltz with sweeping violin phrases',
            'bpm' => 76, 'meter' => 3, 'voice' => 'strings', 'accompaniment' => 'piano',
            'melody' => [79,81,83,81,79,76,74,76,79,83,81,79,76,74,72,74,76,79,81,79,76,74,71,null],
            'chords' => [[55,59,62],[60,64,67],[52,55,59],[62,66,69],[55,59,62],[60,64,67],[62,66,69],[55,59,62]],
        ],
        'pearl-reveal' => [
            'title' => 'The Bridal Piano Prelude', 'role' => 'intro',
            'description' => 'Elegant wedding piano with a delicate chamber string bed',
            'bpm' => 74, 'meter' => 4, 'voice' => 'piano', 'accompaniment' => 'strings',
            'melody' => [76,79,81,84,83,81,79,null,76,79,81,83,81,79,76,null],
            'chords' => [[60,64,67],[57,60,64],[53,57,60],[55,59,62]],
        ],
        'afterglow-nocturne' => [
            'title' => 'Only You, Always', 'role' => 'main',
            'description' => 'A modern romantic wedding ballad for piano and strings',
            'bpm' => 74, 'meter' => 4, 'voice' => 'piano', 'accompaniment' => 'strings',
            'melody' => [79,81,84,83,81,79,76,74,76,79,81,79,76,74,72,null,74,76,79,81,79,76,74,72,71,72,76,79,76,74,72,null],
            'chords' => [[60,64,67],[57,60,64],[53,57,60],[55,59,62],[60,64,67],[57,60,64],[55,59,62],[60,64,67]],
        ],
        'boarding-call' => [
            'title' => 'Our Forever Journey', 'role' => 'intro',
            'description' => 'A romantic destination wedding overture for piano',
            'bpm' => 76, 'meter' => 4, 'voice' => 'piano', 'accompaniment' => 'harp',
            'melody' => [74,78,81,83,81,78,76,null,74,76,78,81,83,81,78,null],
            'chords' => [[62,66,69],[55,59,62],[59,62,66],[57,61,64]],
        ],
        'coastal-horizon' => [
            'title' => 'Vows by the Sea', 'role' => 'main',
            'description' => 'A flowing seaside wedding melody for flute and strings',
            'bpm' => 82, 'meter' => 3, 'voice' => 'flute', 'accompaniment' => 'strings',
            'melody' => [78,81,83,81,78,76,74,76,78,81,83,86,83,81,78,76,74,76,78,81,78,76,74,null],
            'chords' => [[62,66,69],[55,59,62],[59,62,66],[57,61,64],[62,66,69],[55,59,62],[57,61,64],[62,66,69]],
        ],
        'royal-fanfare' => [
            'title' => 'The Grand Wedding Processional', 'role' => 'intro',
            'description' => 'A timeless bridal entrance with organ and strings',
            'bpm' => 66, 'meter' => 4, 'voice' => 'organ', 'accompaniment' => 'strings',
            'melody' => [74,79,81,83,81,79,76,null,74,76,79,83,86,83,79,null],
            'chords' => [[55,59,62],[60,64,67],[62,66,69],[55,59,62]],
        ],
        'royal-ballroom' => [
            'title' => 'The Royal First Dance', 'role' => 'main',
            'description' => 'An elegant ballroom wedding waltz for strings and piano',
            'bpm' => 84, 'meter' => 3, 'voice' => 'strings', 'accompaniment' => 'piano',
            'melody' => [78,81,86,85,81,78,76,78,81,83,81,78,76,74,73,74,78,81,83,81,78,76,74,null],
            'chords' => [[62,66,69],[55,59,62],[57,61,64],[59,62,66],[55,59,62],[57,61,64],[62,66,69],[62,66,69]],
        ],
    ],
];
