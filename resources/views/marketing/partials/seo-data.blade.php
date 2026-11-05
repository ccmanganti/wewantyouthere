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
      'alternateName' => 'WWYT',
      'description' => 'Free wedding invitation website maker in the Philippines with optional premium features.',
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
