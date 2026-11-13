{{-- Premium-only, address-derived map; never accept an untrusted embed URL. --}}
@if($premiumAccess && $visible('maps'))
<section class="{{ $mapClass ?? '' }} ce2-premium-maps" data-preview-section="reception" data-premium-section="maps" id="ce2-maps">
    <span class="ce2-overline">Find your way to us</span>
    <h2 data-field="map_heading">{{ $copy('map_heading', 'Directions') }}</h2>
    <div class="ce2-map-grid">
    @foreach(['ceremony' => 'Ceremony', 'reception' => 'Reception'] as $kind => $label)
        @php
            $address = trim((string) ($answers[$kind.'_address'] ?? ($kind === 'ceremony' ? ($answers['venue_address'] ?? '') : '')));
            $destination = $validExternal($kind.'_map_url') ?: 'https://www.google.com/maps/search/?api=1&query='.rawurlencode($address);
        @endphp
        @if($address !== '')
            <article class="ce2-map-card">
                <h3>{{ $label }}</h3>
                <iframe loading="lazy" title="{{ $label }} map" referrerpolicy="no-referrer-when-downgrade" src="https://maps.google.com/maps?q={{ rawurlencode($address) }}&amp;z=14&amp;output=embed"></iframe>
                <a href="{{ $destination }}" target="_blank" rel="noopener noreferrer">Open map ↗</a>
            </article>
        @endif
    @endforeach
    </div>
</section>
@endif
