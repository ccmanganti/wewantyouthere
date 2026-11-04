<section class="editor-stage" data-stage="photos" aria-labelledby="photo-stage-title">
    <div class="stage-top photo-stage-head">
        <span class="stage-kicker">Step 03 / 04 · Make it yours</span>
        <h2 id="photo-stage-title">Add your beautiful moments.</h2>
        <p>Select a photo placement below. The live website preview will scroll to that area and highlight it. Upload or replace photos without leaving the builder.</p>
    </div>
    <div class="stage-scroll photo-stage-scroll">
        <div class="photo-editor-hint"><i class="fa-solid fa-hand-pointer" aria-hidden="true"></i>
            <div><strong>Know exactly where each photo goes.</strong><span>Choose a slot or click the camera button inside the website preview. Photos are saved privately while you build.</span></div>
        </div>
        <div class="photo-slot-grid" id="photo-slot-grid">
            @foreach($photoSlots as $key => $definition)
            @php $uploaded = !empty($photoUrls[$key]); @endphp
            <article class="photo-slot-card" data-photo-card="{{ $key }}" data-photo-section="{{ $definition['section'] }}">
                <div class="photo-slot-image" data-photo-card-preview="{{ $key }}" style="aspect-ratio:{{ $definition['ratio'] }}">
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
            JPEG, PNG or WebP · Up to 5 MB and 6000 × 6000 pixels per photo. Images are private while you're building. You can skip photos now and add them after publishing.
        </div>
    </div>
    <div class="stage-footer">
        <button type="button" class="back-btn" id="photos-back"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Back to details</button>
        <button type="button" class="btn" id="photos-next">Review invitation <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button>
    </div>
</section>
