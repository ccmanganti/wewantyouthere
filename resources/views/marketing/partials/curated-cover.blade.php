@php
    $design = \App\Support\CuratedWeddingDesign::forTemplate($template);
    if ($design === null) throw new \InvalidArgumentException('Unknown wedding cover.');
    $sample = config('wedding_curated_assets.'.$design.'.photos.hero');
    $art = config('wedding_curated_assets.'.$design.'.decor', []);
    $showcase = config('wedding_curated_showcases.'.$design, []);
    $bride = $showcase['bride_name'] ?? 'Elena';
    $groom = $showcase['groom_name'] ?? 'Nicolas';
    $showDate = \Carbon\CarbonImmutable::parse($showcase['event_date'] ?? '2027-12-12')->format('d M Y');
@endphp
<div class="ce2-catalogue ce2-catalogue-{{ $design }}" data-template-cover-design="{{ $design }}" aria-label="{{ $template->name }} sample cover">
    @if($design === 'burgundy-wax')
        <div class="ce2-catalogue-dark" style="background-image:linear-gradient(#25071699,#25071699),url('{{ $art['flowers'] ?? '' }}')"></div>
        <div class="ce2-catalogue-letter"><span>THE WEDDING OF</span><strong>{{ $bride }} <i>&amp;</i> {{ $groom }}</strong><small>{{ strtoupper($showDate) }}</small><div class="ce2-catalogue-seal">✦</div></div>
    @elseif($design === 'olive-garden')
        <div class="ce2-catalogue-olive-photo"><img src="{{ $sample }}" alt="Botanical wedding portrait sample" loading="lazy"></div>
        <div class="ce2-catalogue-book"><span>THE BOTANICAL JOURNAL</span><strong>{{ $bride }} <i>&amp;</i> {{ $groom }}</strong><small>A LOVE THAT GROWS</small><b>✿</b></div>
    @elseif($design === 'painted-orchard')
        <div class="ce2-catalogue-forest" style="background-image:linear-gradient(#182e2480,#182e2480),url('{{ $art['forest'] ?? '' }}')"></div>
        <div class="ce2-catalogue-arch"><span>THE SECRET GARDEN</span><strong>{{ $bride }} <i>&amp;</i> {{ $groom }}</strong><small>{{ strtoupper($showDate) }}</small><em>❀</em></div>
    @elseif($design === 'pearl-editorial')
        <div class="ce2-catalogue-editorial"><span>ARE ONE · WEDDING ISSUE</span><strong>{{ strtoupper($bride) }} <i>&amp;</i> {{ strtoupper($groom) }}</strong><img src="{{ $sample }}" alt="Editorial black and white wedding portrait sample" loading="lazy"><div class="ce2-catalogue-pearls"></div><small>THE BEGINNING OF FOREVER</small></div>
    @else
        <div class="ce2-catalogue-destination" style="background-image:linear-gradient(#142e4980,#142e4980),url('{{ $art['destination'] ?? '' }}')">
            <div class="ce2-catalogue-ticket"><span>✈ WEDDING BOARDING PASS</span><strong>{{ strtoupper($bride) }} <i>and</i> {{ strtoupper($groom) }}</strong><div><small>FLIGHT 001</small><small>{{ strtoupper($showDate) }}</small></div><p>BOARDING FOR LOVE</p></div>
        </div>
    @endif
</div>
