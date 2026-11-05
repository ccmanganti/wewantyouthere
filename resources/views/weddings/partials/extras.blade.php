@php
    $previewKeys = [
        'couple' => ['bride_name','groom_name','host_message','event_title'],
        'ceremony' => ['event_date','event_time','ceremony_venue','ceremony_address'],
        'reception' => ['reception_venue','reception_address','reception_time'],
        'entourage' => ['principal_sponsors','maid_of_honor','best_man','groomsmen','bridesmaids'],
        'program' => ['event_schedule'],
        'guests' => ['rsvp_message','rsvp_deadline'],
        'details' => ['dress_code','color_motif','gift_message'],
    ];
    if (($template->settings['design'] ?? '') === 'grand-info-v3') {
        // Do not repeat fields already visible in Royal Burgundy V3's twenty sections.
        $v3Used = array_merge(config('wedding_v3_rendered_fields', []), [
            'story_chapter_one_heading','story_chapter_two_heading','story_chapter_three_heading',
            'love_story_start','love_story_growing','love_story_proposal',
            'guest_arrival_time','guest_arrival_note','ceremony_timeline_note',
            'reception_timeline_note','celebration_time','celebration_timeline_note',
            'program_step_one','program_step_two','program_step_three','program_step_four',
            'bride_parents','groom_parents','principal_sponsors','maid_of_honor',
            'best_man','bridesmaids','groomsmen','secondary_sponsors','flower_girls',
            'ring_bearer','coin_bearer','bible_bearer','candle_sponsors',
            'veil_sponsors','cord_sponsors','officiant_name',
            'photo_caption_one','photo_caption_two','photo_caption_three','photo_caption_four',
        ]);
        foreach ($previewKeys as $section => $keys) {
            $previewKeys[$section] = array_unique(array_merge($keys, $v3Used));
        }
    }
@endphp
@foreach(($questions ?? collect())->get($group, collect()) as $question)
    @if(!in_array($question->key, $previewKeys[$group] ?? [], true) && $question->key !== 'venue_name')
        @php($extraValue = $answers[$question->key] ?? '')
        <div class="invite-extra" data-extra-row="{{ $question->key }}" @if(trim((string)$extraValue) === '') hidden @endif>
            <h3>{{ $question->label }}</h3>
            <p class="pre-line" data-field="{{ $question->key }}">{{ $extraValue }}</p>
        </div>
    @endif
@endforeach
