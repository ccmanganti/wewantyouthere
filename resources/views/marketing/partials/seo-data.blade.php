@php
$siteBase = rtrim(config('seo.canonical_base') ?: config('app.url'), '/');
$structured = [
    '@context' => 'https://schema.org',
    '@type' => 'SoftwareApplication',
    'name' => 'We Want You There — Wedding Invitation Website Maker',
    'applicationCategory' => 'DesignApplication',
    'operatingSystem' => 'Web',
    'url' => $siteBase . '/',
    'publisher' => ['@id' => $siteBase . '/#organization'],
    'description' => 'Create a wedding invitation website with a guided questionnaire, live preview, custom website link and downloadable QR code.',
];
if ($templates->contains(fn ($template) => !$template->is_premium)) {
    $structured['offers'] = ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'PHP'];
}
@endphp
<script type="application/ld+json">{!! json_encode($structured, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
