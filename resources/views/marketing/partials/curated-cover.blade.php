@php
    $design = $template->settings['design'] ?? 'burgundy-wax';
    $sample = config('wedding_curated_assets.'.$design.'.photos.hero');
    $art = config('wedding_curated_assets.'.$design.'.decor', []);
@endphp
<div class="ce2-catalogue ce2-catalogue-{{ $design }}" data-template-cover-design="{{ $design }}" aria-label="{{ $template->name }} sample cover">
    @if($design === 'burgundy-wax')
        <div class="ce2-catalogue-dark" style="background-image:linear-gradient(#25071699,#25071699),url('{{ $art['flowers'] ?? '' }}')"></div>
        <div class="ce2-catalogue-letter"><span>THE WEDDING OF</span><strong>Amelia <i>&amp;</i> Gabriel</strong><small>DECEMBER 12 · 2027</small><div class="ce2-catalogue-seal">✦</div></div>
    @elseif($design === 'olive-garden')
        <div class="ce2-catalogue-olive-photo"><img src="{{ $sample }}" alt="Botanical wedding portrait sample" loading="lazy"></div>
        <div class="ce2-catalogue-book"><span>THE BOTANICAL JOURNAL</span><strong>Amelia <i>&amp;</i> Gabriel</strong><small>A LOVE THAT GROWS</small><b>✿</b></div>
    @elseif($design === 'painted-orchard')
        <div class="ce2-catalogue-forest" style="background-image:linear-gradient(#182e2480,#182e2480),url('{{ $art['forest'] ?? '' }}')"></div>
        <div class="ce2-catalogue-arch"><span>THE SECRET GARDEN</span><strong>Amelia <i>&amp;</i> Gabriel</strong><small>12 DECEMBER 2027</small><em>❀</em></div>
    @elseif($design === 'pearl-editorial')
        <div class="ce2-catalogue-editorial"><span>ARE ONE · WEDDING ISSUE</span><strong>AMELIA <i>&amp;</i> GABRIEL</strong><img src="{{ $sample }}" alt="Editorial black and white wedding portrait sample" loading="lazy"><div class="ce2-catalogue-pearls"></div><small>THE BEGINNING OF FOREVER</small></div>
    @else
        <div class="ce2-catalogue-destination" style="background-image:linear-gradient(#142e4980,#142e4980),url('{{ $art['destination'] ?? '' }}')">
            <div class="ce2-catalogue-ticket"><span>✈ WEDDING BOARDING PASS</span><strong>AMELIA <i>and</i> GABRIEL</strong><div><small>FLIGHT 001</small><small>12 DEC 2027</small></div><p>BOARDING FOR LOVE</p></div>
        </div>
    @endif
</div>
