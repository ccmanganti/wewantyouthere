@php
    $videoEnabled = ($sections['video'] ?? false) && ($premiumAccess ?? false);
    $videoUrl = \App\Support\InvitationVideo::embed($answers['video_embed_url'] ?? null);
    $isPreview = $isPreview ?? false;
    $isSample = $isSample ?? false;
@endphp
@if(($videoEnabled && ($videoUrl || $isPreview)) || ($isPreview && ($premiumAccess ?? false)) || ($isSample && $videoUrl))
<section class="wwyt-premium-video" id="wedding-video" data-preview-section="video" @if(!($sections['video'] ?? false)) hidden @endif>
    <div class="wwyt-premium-video-inner">
        <span class="wwyt-video-eyebrow">A MOMENT TO SHARE</span>
        <h2 data-field="video_heading">{{ $answers['video_heading'] ?? 'A message from us' }}</h2>
        <p data-field="video_message">{{ $answers['video_message'] ?? '' }}</p>
        @if($videoUrl)
            <div class="wwyt-video-frame">
                <iframe src="{{ $videoUrl }}" title="Our wedding video"
                    loading="lazy" referrerpolicy="strict-origin-when-cross-origin"
                    allow="accelerometer; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen></iframe>
            </div>
        @elseif($isPreview)
            <div class="wwyt-video-empty">Paste a YouTube or Vimeo URL in your Video Message section to preview your film.</div>
        @endif
    </div>
</section>
@endif
