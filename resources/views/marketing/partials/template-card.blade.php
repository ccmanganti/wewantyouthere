<article class="mkt-template-card mkt-reveal {{ ($template->settings['theme'] ?? '') === 'royal_burgundy' ? 'mkt-template-royal' : '' }}" data-template-card data-search="{{ strtolower($template->name . ' ' . $template->eventType->name . ' ' . ($template->settings['description'] ?? '') . ' invitation website') }}">
    <div class="mkt-template-cover">
        <img class="mkt-template-stamp" src="{{ asset('brand/wwyt/seal-flat.png') }}" width="43" height="43" loading="lazy" alt="" aria-hidden="true">
        <span class="mkt-template-feature">{{ $template->is_premium ? 'PREMIUM' : 'FREE WEBSITE' }}</span>
        @if(($template->settings['theme'] ?? '') === 'royal_burgundy')
            <div class="rb-catalogue-poster" aria-hidden="true">
                <span class="rb-catalogue-the">The</span>
                <strong>WEDDING <em>day</em></strong>
                <img src="{{ asset('wedding/royal-burgundy/grand-doors.webp') }}"
                     alt="" width="220" height="180" loading="lazy">
                <span class="rb-catalogue-names">Amelia <span>♥</span> Gabriel</span>
                <small>YOU'RE INVITED</small>
            </div>
        @else
            <div class="mini-poster" aria-hidden="true">
                <span class="overline">TOGETHER WITH OUR FAMILIES</span>
                <span class="couple">Amelia<br><small>&amp;</small><br>Gabriel</span>
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
                <span class="mkt-pill">Premium · Coming soon</span>
            @else
                <a class="mkt-button small" href="{{ route('wedding.editor', $template->slug) }}">Use design <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
            @endif
        </div>
    </div>
</article>
