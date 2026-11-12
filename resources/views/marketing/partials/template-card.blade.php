<article class="mkt-template-card mkt-reveal {{ ($template->settings['theme'] ?? '') === 'royal_burgundy' ? 'mkt-template-royal' : '' }}" data-template-card data-search="{{ strtolower($template->name . ' ' . $template->eventType->name . ' ' . ($template->settings['description'] ?? '') . ' invitation website') }}">
    <div class="mkt-template-cover">
        <img class="mkt-template-stamp" src="{{ asset('brand/wwyt/seal-flat.png') }}" width="43" height="43" loading="lazy" alt="" aria-hidden="true">
        <span class="mkt-template-feature">{{ $template->is_premium ? 'PREMIUM DESIGN' : 'FREE WEBSITE' }}</span>
        @if(($template->settings['theme'] ?? '') === 'curated_editorial')
            <div class="curated-catalogue" style="position:relative;min-height:330px;background:{{ data_get(config('wedding_curated_themes'), data_get($template->settings, 'design').'.paper', '#faf6ee') }};overflow:hidden;text-align:center;color:{{ data_get(config('wedding_curated_themes'), data_get($template->settings, 'design').'.accent', '#69253c') }}">
                <img src="{{ data_get($template->settings, 'thumbnail_url') }}" loading="lazy" alt="Photographic mood of {{ $template->name }}" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:.58">
                <div style="position:absolute;left:13%;right:13%;top:18%;bottom:15%;background:#fff9edee;padding:28px 10px;display:flex;align-items:center;justify-content:center;flex-direction:column;border:1px solid #ffffffbd;box-shadow:0 9px 38px #0002">
                    <span style="font:600 9px 'DM Sans',sans-serif;letter-spacing:.2em">WEDDING INVITATION</span>
                    <strong style="font:italic 33px/1.05 Georgia,serif;margin:17px 0">Amelia <span style="font-weight:400">&amp;</span> Gabriel</strong>
                    <span style="font:600 10px 'DM Sans',sans-serif;letter-spacing:.14em">12 · 12 · 2027</span>
                </div>
            </div>
        @elseif(($template->settings['theme'] ?? '') === 'royal_burgundy')
            <div class="rb-catalogue-poster" aria-hidden="true">
                <span class="rb-catalogue-the">The</span>
                <strong>WEDDING <em>day</em></strong>
                <img src="{{ config('wedding_sample_photos.hero') }}"
                     alt="Sample wedding couple in a Royal Burgundy invitation" width="250" height="175" loading="lazy">
                <span class="rb-catalogue-names">Amelia <span>♥</span> Gabriel</span>
                <small>YOU'RE INVITED</small>
            </div>
        @else
            <div class="mini-poster" aria-hidden="true">
                <span class="overline">TOGETHER WITH OUR FAMILIES</span>
                <span class="couple">Amelia <small>&amp;</small> Gabriel</span>
                <img class="mkt-template-couple-photo" src="{{ config('wedding_sample_photos.portrait_two') }}"
                     alt="Sample wedding couple photograph in a digital invitation" width="270" height="135" loading="lazy">
                <span class="overline">CELEBRATE OUR WEDDING</span>
                <span class="date">DECEMBER 12, 2027</span>
            </div>
        @endif
    </div>
    <div class="mkt-template-content">
        <div class="mkt-kicker red">{{ $template->eventType->name }} · Website invitation</div>
        <h3>{{ $template->name }}</h3>
        <p>{{ data_get($template->settings, 'description', 'A romantic, mobile-friendly wedding website with all the details your guests need.') }}</p>
        <div class="mkt-template-actions">
            <a class="mkt-button small ghost" href="{{ route('marketing.templateDetail', $template->slug) }}">Details</a>
            <button class="mkt-button small ghost" type="button" data-preview-open
                data-preview-url="{{ route('marketing.templatePreview', $template->slug) }}"
                data-preview-title="{{ $template->name }}">Live preview <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i></button>
            @if(!$canCreate)
                <a class="mkt-button small" href="{{ url('/app/invitations') }}">Manage site <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
            @elseif($template->is_premium)
                <a class="mkt-button small" href="{{ route('premium.show', $template->slug) }}">Premium · {{ \App\Support\InvitationPremium::price($template) }} <i class="fa-solid fa-lock"></i></a>
            @else
                <a class="mkt-button small" href="{{ route('wedding.editor', $template->slug) }}">Use design <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
            @endif
        </div>
    </div>
</article>
