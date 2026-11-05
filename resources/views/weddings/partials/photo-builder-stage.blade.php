<section class="editor-stage" data-stage="photos" aria-labelledby="photo-stage-title">
    <div class="stage-top photo-stage-head">
        <span class="stage-kicker">Step 04 / 05 · Your images</span>
        <h2 id="photo-stage-title">Your photos.</h2>
        <p>Upload a photo and find its place in the preview.</p>
    </div>
    <div class="stage-scroll photo-stage-scroll">
        <div class="photo-slot-grid" id="photo-slot-grid">
            @foreach($photoSlots as $key => $definition)
            @php
                $uploaded = !empty($photoUrls[$key]);
                $premiumOnlyPhoto = \App\Support\InvitationPremium::lockedGroup($definition['section']);
            @endphp
            @continue($premiumOnlyPhoto && !$hasPremium)
            <article class="photo-slot-card" data-photo-card="{{ $key }}" data-photo-section="{{ $definition['section'] }}">
                <div class="photo-slot-image" data-photo-card-preview="{{ $key }}" style="aspect-ratio:{{ $definition['ratio'] }}"><span class="photo-upload-spinner" aria-hidden="true"><i class="fa-solid fa-circle-notch fa-spin"></i></span>
                    @if($uploaded)
                    <img src="{{ $photoUrls[$key] }}" alt="Your {{ $definition['label'] }} photo" loading="lazy">
                    @else
                    <div class="photo-slot-placeholder"><i class="fa-solid fa-image" aria-hidden="true"></i><small>No photo yet</small></div>
                    @endif
                </div>
                <div class="photo-slot-meta">
                    <strong>{{ $definition['label'] }}</strong>
                    <small>{{ $definition['hint'] }}</small>
                    <div class="photo-slot-actions">
                        <button type="button" class="photo-slot-locate" data-photo-locate="{{ $key }}"><i class="fa-solid fa-crosshairs" aria-hidden="true"></i> Show position</button>
                        <label class="photo-slot-upload" for="upload-{{ $key }}"><i class="fa-solid fa-upload" aria-hidden="true"></i> {{ $uploaded ? 'Replace' : 'Upload' }}
                            <input type="file" id="upload-{{ $key }}" data-photo-input="{{ $key }}" accept="image/jpeg,image/png,image/webp" hidden>
                        </label>
                        <button type="button" class="photo-slot-remove" data-photo-remove="{{ $key }}" @if(!$uploaded) hidden @endif>Remove</button>
                    </div>
                    <div class="photo-slot-status" data-photo-status="{{ $key }}" role="status" aria-live="polite"></div>
                </div>
            </article>
            @endforeach
        </div>
        <div class="photo-security-note"><i class="fa-solid fa-shield-halved" aria-hidden="true"></i>
            JPEG, PNG or WebP · Max 5 MB each. You can add photos later.
        </div>
    </div>
    <div class="stage-footer">
        <button type="button" class="back-btn" id="photos-back"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Back to preview</button>
        <button type="button" class="btn" id="photos-next">Continue to publish <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button>
    </div>
</section>
