<article class="mkt-template-card mkt-reveal" data-template-card data-search="{{ strtolower($template->name . ' ' . $template->eventType->name . ' wedding elegant ivory invitation website') }}">
    <div class="mkt-template-cover">
        <span class="mkt-template-feature">{{ $template->is_premium ? 'PREMIUM' : 'FREE WEBSITE' }}</span>
        <div class="mini-poster" aria-hidden="true">
            <span class="overline">TOGETHER WITH OUR FAMILIES</span>
            <span class="couple">Amelia<br><small>&</small><br>Gabriel</span>
            <span class="overline">CELEBRATE OUR WEDDING</span>
            <span class="date">DECEMBER 12, 2027</span>
        </div>
    </div>
    <div class="mkt-template-content">
        <div class="mkt-kicker red">{{ $template->eventType->name }} · Website invitation</div>
        <h3>{{ $template->name }}</h3>
        <p>{{ data_get($template->settings, 'description', 'A romantic, mobile-friendly wedding website with all the details your guests need.') }}</p>
        <div class="mkt-template-actions">
            <a class="mkt-button small ghost" href="{{ route('marketing.templateDetail', $template->slug) }}">Details</a>
            <button class="mkt-button small ghost" type="button" data-preview-open
                data-preview-url="{{ route('marketing.templatePreview', $template->slug) }}"
                data-preview-title="{{ $template->name }}">Live preview ↗</button>
            @if(!$canCreate)
                <a class="mkt-button small" href="{{ url('/app/invitations') }}">Manage site →</a>
            @elseif($template->is_premium)
                <span class="mkt-pill">Premium · Coming soon</span>
            @else
                <a class="mkt-button small" href="{{ route('wedding.editor', $template->slug) }}">Use design →</a>
            @endif
        </div>
    </div>
</article>
