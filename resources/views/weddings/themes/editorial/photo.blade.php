{{-- Photo frame shared for upload semantics only. Its composition is owned by each design. --}}
<figure class="{{ $class ?? '' }} ce2-photo" data-photo-slot="{{ $slot }}">
    @if($photo($slot))
        <img src="{{ $photo($slot) }}" data-slot-img="{{ $slot }}" loading="{{ ($eager ?? false) ? 'eager' : 'lazy' }}"
             alt="{{ $alt ?? 'A special photo of the couple' }}" @if($eager ?? false) fetchpriority="high" @endif>
    @else
        <div class="rbv-photo-empty ce2-photo-empty" role="img" aria-label="Photo not uploaded"><span aria-hidden="true">✦</span><small>{{ $missing ?? 'Add your photograph' }}</small></div>
    @endif
    @if(!empty($caption))
        <figcaption>{{ $caption }}</figcaption>
    @endif
</figure>
