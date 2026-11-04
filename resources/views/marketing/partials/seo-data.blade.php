@php
$siteBase = rtrim(config('app.url'), '/');
$structured = [
  '@context' => 'https://schema.org',
  '@graph' => [
    [
      '@type' => 'Organization',
      '@id' => $siteBase . '/#organization',
      'name' => 'We Want You There',
      'url' => $siteBase,
    ],
    [
      '@type' => 'WebSite',
      '@id' => $siteBase . '/#website',
      'url' => $siteBase,
      'name' => 'We Want You There',
      'description' => 'An online wedding invitation website maker for Filipino celebrations.',
    ],
    [
      '@type' => 'SoftwareApplication',
      'name' => 'We Want You There — Wedding Invitation Website Maker',
      'applicationCategory' => 'DesignApplication',
      'operatingSystem' => 'Web',
      'url' => $siteBase,
      'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'PHP'],
      'description' => 'Create and publish a free wedding invitation website with a guided questionnaire, live preview, custom website link and downloadable QR code.',
    ],
  ],
];
@endphp
<script type="application/ld+json">{!! json_encode($structured, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
