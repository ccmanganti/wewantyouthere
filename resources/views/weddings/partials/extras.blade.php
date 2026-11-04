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
