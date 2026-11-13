{{-- Only shown inside a premium-protected guest section. Form schema matches WeddingRsvpController. --}}
@if(session('rsvp_success') && $isPublishedSite)
    <p class="ce2-rsvp-success" role="status">{{ session('rsvp_success') }}</p>
@else
    <form class="ce2-form {{ $formClass ?? '' }}" method="POST"
          @if($isPublishedSite) action="{{ route('wedding.rsvp.store', $website->slug) }}" @else data-ce2-demo="1" @endif>
        @csrf
        <label>Full name <input name="guest_name" type="text" minlength="2" maxlength="120" required placeholder="Your full name"></label>
        <fieldset><legend>Will you be there?</legend>
            <label><input type="radio" name="attendance" value="attending" required> Joyfully accepts</label>
            <label><input type="radio" name="attendance" value="declined" required> Regretfully declines</label>
        </fieldset>
        <label data-ce2-guests>Number attending <select name="party_size" required>
            @for($i=1;$i<=$guestMax;$i++)
            <option value="{{ $i }}">{{ $i }} {{ $i === 1 ? 'guest' : 'guests' }}</option>
            @endfor
        </select></label>
        <label>Message to the couple <textarea name="message" rows="3" maxlength="500" placeholder="Your wishes (optional)"></textarea></label>
        <label class="ce2-trap" aria-hidden="true">Leave blank <input type="text" name="website" autocomplete="off" tabindex="-1"></label>
        <button type="submit">{{ $submitLabel ?? 'Send confirmation' }}</button>
        <p class="ce2-feedback" data-ce2-form-feedback aria-live="polite" role="status"></p>
        @if($errors->any())<p role="alert">{{ $errors->first() }}</p>@endif
    </form>
@endif
