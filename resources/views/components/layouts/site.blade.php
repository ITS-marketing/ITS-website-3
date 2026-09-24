@props(['title' => null, 'description' => null, 'overlay' => false])

@php
    $siteName = setting('general.site_name', config('app.name'));
    $title = $title ?: setting('general.meta_title', $siteName);
    $description = $description ?: setting('general.meta_description');
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    @if ($description)
        <meta name="description" content="{{ $description }}">
    @endif
    <meta property="og:title" content="{{ $title }}">
    @if ($description)
        <meta property="og:description" content="{{ $description }}">
    @endif
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:locale" content="nl_NL">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Vóór render: JS-flag (voor fade-ins) en hoog-contrast uit localStorage. --}}
    <script>
        document.documentElement.classList.add('js');
        try { if (localStorage.getItem('hc') === '1') document.documentElement.setAttribute('data-hc', ''); } catch (e) {}
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full flex flex-col antialiased font-sans bg-white">
    {{-- Wrapper boven de footer: de sticky footer komt eronder vandaan ("reveal"). --}}
    <div class="relative z-[1] bg-white">
        @include('partials.header', ['overlay' => $overlay])

        {{-- Zonder hero bovenaan: ruimte vrijhouden onder de fixed header. --}}
        <main @class(['pt-24 lg:pt-36' => ! $overlay])>
            {{ $slot }}
        </main>
    </div>

    @include('partials.footer')
</body>
</html>
