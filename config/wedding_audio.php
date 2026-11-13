<?php

/**
 * Original, self-contained synthesized musical sketches for the premium
 * invitation audio library. Each tune has its own MIDI-style note sequence,
 * chord progression, tempo and timbre and plays through Web Audio.
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
    'tracks' => [
        'seal-whisper' => [
            'title' => 'Seal & Silk', 'role' => 'intro',
            'description' => 'Delicate bells for the parchment reveal',
            'bpm' => 76, 'voice' => 'bell',
            'melody' => [69,null,72,74,76,null,72,69,67,null,69,72,74,null,72,69], 'chords' => [[57,60,64],[53,57,60],[55,59,62],[52,55,59]],
        ],
        'heirloom-valse' => [
            'title' => 'The Heirloom Waltz', 'role' => 'main',
            'description' => 'Warm piano and romantic strings',
            'bpm' => 92, 'voice' => 'piano',
            'melody' => [72,74,76,null,76,74,72,null,69,72,74,76,74,null,72,null], 'chords' => [[57,60,64],[53,57,60],[55,59,62],[52,55,59]],
        ],
        'botanical-page' => [
            'title' => 'Turning Leaves', 'role' => 'intro',
            'description' => 'Gentle plucked harp notes',
            'bpm' => 84, 'voice' => 'harp',
            'melody' => [67,null,71,74,76,null,74,null,71,69,67,null,69,71,74,null], 'chords' => [[55,59,62],[52,55,59],[57,60,64],[50,54,57]],
        ],
        'garden-afternoon' => [
            'title' => 'Garden Afternoon', 'role' => 'main',
            'description' => 'Sunlit acoustic-inspired instrumental',
            'bpm' => 94, 'voice' => 'harp',
            'melody' => [74,76,78,76,74,71,69,null,71,74,76,null,78,76,74,null], 'chords' => [[55,59,62],[52,55,59],[50,54,57],[57,60,64]],
        ],
        'woodland-gates' => [
            'title' => 'The Secret Path', 'role' => 'intro',
            'description' => 'Dreamy glass harmonics and woodland tones',
            'bpm' => 68, 'voice' => 'pad',
            'melody' => [64,67,71,74,76,null,74,null,71,null,69,67,64,null,67,null], 'chords' => [[52,55,59],[48,52,55],[50,54,57],[47,50,54]],
        ],
        'orchard-bloom' => [
            'title' => 'Under the Blossoms', 'role' => 'main',
            'description' => 'Floating strings and blossoming melody',
            'bpm' => 78, 'voice' => 'pad',
            'melody' => [71,74,76,78,76,74,71,null,69,71,74,76,74,71,69,null], 'chords' => [[52,55,59],[48,52,55],[53,57,60],[50,53,57]],
        ],
        'pearl-reveal' => [
            'title' => 'Atelier Prelude', 'role' => 'intro',
            'description' => 'Minimal glass piano and soft shimmer',
            'bpm' => 88, 'voice' => 'glass',
            'melody' => [76,null,79,81,null,79,76,74,null,72,76,79,null,76,74,null], 'chords' => [[60,64,67],[57,60,64],[53,57,60],[55,59,62]],
        ],
        'afterglow-nocturne' => [
            'title' => 'Afterglow Nocturne', 'role' => 'main',
            'description' => 'Intimate cinematic electric-piano instrumental',
            'bpm' => 80, 'voice' => 'piano',
            'melody' => [79,81,79,76,74,null,76,79,81,null,79,76,74,72,null,null], 'chords' => [[60,64,67],[57,60,64],[53,57,60],[55,59,62]],
        ],
        'boarding-call' => [
            'title' => 'The First Departure', 'role' => 'intro',
            'description' => 'Playful marimba and optimistic travel motif',
            'bpm' => 110, 'voice' => 'marimba',
            'melody' => [72,76,79,null,76,79,84,null,83,79,76,74,72,null,76,null], 'chords' => [[60,64,67],[57,60,64],[55,59,62],[53,57,60]],
        ],
        'coastal-horizon' => [
            'title' => 'Coastal Horizon', 'role' => 'main',
            'description' => 'Bright seaside journey with lilting mallets',
            'bpm' => 102, 'voice' => 'marimba',
            'melody' => [76,79,81,79,76,74,72,null,74,76,79,81,79,76,74,null], 'chords' => [[60,64,67],[55,59,62],[57,60,64],[53,57,60]],
        ],
        'royal-fanfare' => [
            'title' => 'Golden Invitation', 'role' => 'intro',
            'description' => 'Ceremonial glockenspiel and soft chimes',
            'bpm' => 74, 'voice' => 'bell',
            'melody' => [72,76,79,null,84,null,79,76,74,76,79,null,76,74,72,null], 'chords' => [[60,64,67],[55,59,62],[57,60,64],[53,57,60]],
        ],
        'royal-ballroom' => [
            'title' => 'The Royal Evening', 'role' => 'main',
            'description' => 'Classic grand piano evening waltz',
            'bpm' => 88, 'voice' => 'piano',
            'melody' => [69,72,76,77,76,72,69,null,67,69,72,74,72,69,67,null], 'chords' => [[57,60,64],[53,57,60],[55,59,62],[52,55,59]],
        ],
    ],
];
