{{-- Premium-only maps. Keep placeholders available to paid live editors,
     but never render map embeds or questions for free accounts. --}}
@if($premiumAccess && ($visible('maps') || $isPreview))
<section class="{{ $mapClass ?? '' }} ce2-premium-maps"
         data-preview-section="reception" data-premium-section="maps" id="ce2-maps"
         @if(!$visible('maps')) hidden @endif>
    <span class="ce2-overline">Find your way to us</span>
    <h2 data-field="map_heading">{{ $copy('map_heading', 'Directions') }}</h2>
    <div class="ce2-map-grid">
    @foreach(['ceremony' => 'Ceremony', 'reception' => 'Reception'] as $kind => $label)
        @php
            $address = trim((string) ($answers[$kind.'_address'] ?? ($kind === 'ceremony' ? ($answers['venue_address'] ?? '') : '')));
            $destination = $validExternal($kind.'_map_url') ?: 'https://www.google.com/maps/search/?api=1&query='.rawurlencode($address);
        @endphp
        @if($address !== '' || $isPreview)
        <article class="ce2-map-card" data-ce2-map-kind="{{ $kind }}">
            <h3>{{ $label }}</h3>
            <p data-ce2-map-placeholder @if($address !== '') hidden @endif>Add a {{ strtolower($label) }} address in the editor to display its map.</p>
            <iframe loading="lazy" title="{{ $label }} map" referrerpolicy="no-referrer-when-downgrade"
                    @if($address === '') hidden @else src="https://maps.google.com/maps?q={{ rawurlencode($address) }}&amp;z=14&amp;output=embed" @endif></iframe>
            <a href="{{ $destination }}" target="_blank" rel="noopener noreferrer"
               @if($address === '') hidden @endif>Open map ↗</a>
        </article>
        @endif
    @endforeach
    </div>
</section>
@endif
