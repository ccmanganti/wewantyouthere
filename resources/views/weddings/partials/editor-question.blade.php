@php
    $current = old('answers.'.$question->key, $draft['answers'][$question->key] ?? '');
    $type = in_array($question->type, ['date', 'time', 'number', 'email', 'url'], true) ? $question->type : 'text';
    $isLong = $question->type === 'textarea';
    $canGenerate = isset(config('wedding_message_fields', [])[$question->key]) && ($isLong || $type === 'text');
@endphp
<div class="field {{ $isLong ? 'full' : '' }}">
    <div class="field-heading">
        <label class="field-label" for="question-{{ $question->id }}">
            {{ $question->label }}
            @if($question->is_required)<span class="required" aria-label="required"> *</span>@endif
        </label>
        @if($canGenerate)
        <div class="field-suggestion-actions">
            <button type="button" class="field-generate-btn" data-generate-field="{{ $question->key }}"
                aria-label="Generate a suggestion for {{ $question->label }}" title="Choose a random suggestion from our wedding message collection">
                <i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i> Generate
            </button>
            <button type="button" class="field-undo-btn" data-undo-generated="{{ $question->key }}" hidden
                aria-label="Undo generated suggestion for {{ $question->label }}">Undo</button>
        </div>
        @endif
    </div>
    @if($isLong)
        <textarea id="question-{{ $question->id }}" name="answers[{{ $question->key }}]"
            data-question="{{ $question->key }}" data-required-initial="{{ $question->is_required ? '1' : '0' }}"
            rows="3" placeholder="{{ $question->placeholder }}" {{ $question->is_required ? 'required' : '' }}>{{ $current }}</textarea>
    @else
        <input id="question-{{ $question->id }}" name="answers[{{ $question->key }}]"
            type="{{ $type }}" placeholder="{{ $question->placeholder }}"
            data-question="{{ $question->key }}" data-required-initial="{{ $question->is_required ? '1' : '0' }}"
            value="{{ $current }}" {{ $question->is_required ? 'required' : '' }}
            @if($type === 'number') min="0" @endif
            @if($type === 'text') maxlength="2000" @endif>
    @endif
    @if($canGenerate)<div class="generate-feedback" data-generate-feedback="{{ $question->key }}" role="status" aria-live="polite"></div>@endif
    @if($question->help_text)<div class="helper-text">{{ $question->help_text }}</div>@endif
    @error('answers.'.$question->key)<div class="field-error" role="alert">{{ $message }}</div>@enderror
</div>
