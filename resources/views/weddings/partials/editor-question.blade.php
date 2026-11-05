@php
    $current = old('answers.'.$question->key, $draft['answers'][$question->key] ?? '');
    $type = in_array($question->type, ['date', 'time', 'number', 'email', 'url'], true) ? $question->type : 'text';
    $isLong = $question->type === 'textarea';
    $canGenerate = array_key_exists($question->key, config('wedding_message_fields', [])) && ($isLong || $type === 'text');
    $displayLabel = [
        'bride_name' => "Bride's name",
        'groom_name' => "Groom's name",
        'bride_mother' => "Bride's mother",
        'bride_father' => "Bride's father",
        'groom_mother' => "Groom's mother",
        'groom_father' => "Groom's father",
        'venue_name' => 'Ceremony venue',
        'ceremony_venue' => 'Alternative ceremony venue wording',
    ][$question->key] ?? $question->label;
    $familyField = in_array($question->key, ['bride_mother','bride_father','groom_mother','groom_father'], true);
    // The wedding form places related short inputs together and gives
    // important titles, venues and long-form messages room to breathe.
    $wideField = $isLong || in_array($question->key, [
        'event_title', 'venue_name', 'ceremony_address',
        'reception_venue', 'reception_address', 'reception_time',
        'contact_name', 'dress_code', 'color_motif',
    ], true);
@endphp
<div class="field {{ $wideField ? 'full field--wide' : 'field--half' }}" data-layout-key="{{ $question->key }}">
    <div class="field-heading">
        <label class="field-label" for="question-{{ $question->id }}">
            {{ $displayLabel }}
            @if($question->is_required)<span class="required" aria-label="required"> *</span>@endif
        </label>
        @if($canGenerate)
        <div class="field-suggestion-actions">
            <button type="button" class="field-generate-btn" data-generate-field="{{ $question->key }}"
                aria-label="Generate a suggestion for {{ $displayLabel }}" title="Choose a random suggestion from our wedding message collection">
                <i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i> Generate
            </button>
            <button type="button" class="field-undo-btn" data-undo-generated="{{ $question->key }}" hidden
                aria-label="Undo generated suggestion for {{ $displayLabel }}">Undo</button>
        </div>
        @endif
    </div>
    @if($isLong)
        <textarea id="question-{{ $question->id }}" name="answers[{{ $question->key }}]"
            data-question="{{ $question->key }}" @if($familyField) data-family-field="true" @endif data-required-initial="{{ $question->is_required ? '1' : '0' }}"
            rows="3" placeholder="{{ $question->placeholder }}" {{ $question->is_required ? 'required' : '' }}>{{ $current }}</textarea>
    @else
        <input id="question-{{ $question->id }}" name="answers[{{ $question->key }}]"
            type="{{ $type }}" placeholder="{{ $question->placeholder }}"
            data-question="{{ $question->key }}" @if($familyField) data-family-field="true" @endif data-required-initial="{{ $question->is_required ? '1' : '0' }}"
            value="{{ $current }}" {{ $question->is_required ? 'required' : '' }}
            @if($type === 'number') min="0" @endif
            @if($type === 'text') maxlength="2000" @endif>
    @endif
    @if($canGenerate)<div class="generate-feedback" data-generate-feedback="{{ $question->key }}" role="status" aria-live="polite"></div>@endif
    @if($question->help_text)<div class="helper-text">{{ $question->help_text }}</div>@endif
    @error('answers.'.$question->key)<div class="field-error" role="alert">{{ $message }}</div>@enderror
</div>
