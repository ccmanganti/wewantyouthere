@php
    $current = old('answers.'.$question->key, $draft['answers'][$question->key] ?? '');
    $type = in_array($question->type, ['date', 'time', 'number', 'email', 'url'], true) ? $question->type : 'text';
    $isLong = $question->type === 'textarea';
@endphp
<div class="field {{ $isLong ? 'full' : '' }}">
    <label class="field-label" for="question-{{ $question->id }}">
        {{ $question->label }}
        @if($question->is_required)<span class="required" aria-label="required"> *</span>@endif
    </label>
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
    @if($question->help_text)<div class="helper-text">{{ $question->help_text }}</div>@endif
    @error('answers.'.$question->key)<div class="field-error" role="alert">{{ $message }}</div>@enderror
</div>
