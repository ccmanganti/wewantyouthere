<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>{{ $template->name }} — Wedding Website Preview</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    @include('weddings.partials.invitation-theme-styles')
    <style>html{scroll-behavior:smooth}body{margin:0;background:#fbf8f1}.wedding-invite{min-height:100vh}body .demo-notice{position:fixed;left:16px;bottom:16px;z-index:80;background:#1B1717;color:#EDEBDD;border-radius:8px;font:600 11px 'DM Sans',sans-serif;padding:11px 14px;box-shadow:0 8px 28px #0004}</style>
</head>
<body>
@include('weddings.partials.invitation', ['isPreview' => false, 'answers' => $answers, 'sections' => $sections, 'questions' => $questions])
<div class="demo-notice">Sample design · Example names and details</div>
</body></html>
