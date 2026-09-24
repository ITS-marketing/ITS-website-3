{{-- Blok 01 — Hero met parallax-achtergrond, quicklinks en doorlopende fotostrip. JS: resources/js/blocks/hero.js --}}
@php
    $bg = media_url($data['background_image'] ?? null);

    // Titel: regels uit de textarea. Slimme breuken = mobiel alleen na regel 1, desktop (lg+) alleen vóór de laatste regel.
    $lines = array_values(array_filter(array_map('trim', preg_split('/\R/', (string) ($data['title'] ?? ''))), 'strlen'));
    $smartBreaks = (bool) ($data['title_responsive_breaks'] ?? true);
    $lastBreak = count($lines) - 2;

    $primary = $data['primary_button'] ?? [];
    $secondary = $data['secondary_button'] ?? [];
    $stats = array_values(array_filter((array) ($data['stats'] ?? []), 'filled'));
    $trustLabels = array_values(array_filter((array) ($data['trust_labels'] ?? []), fn ($l) => filled($l['text'] ?? null)));
    $quicklinks = array_values(array_filter((array) ($data['quicklinks'] ?? []), fn ($q) => filled($q['title'] ?? null)));
    $strip = array_values(array_filter((array) ($data['photo_strip'] ?? []), fn ($p) => media_url($p['image'] ?? null)));
    $speed = is_numeric($data['photo_strip_speed'] ?? null) ? (float) $data['photo_strip_speed'] : 0.7;
    $hasVideo = collect($strip)->contains(fn ($p) => ($p['type'] ?? 'photo') === 'video');

    // YouTube / Vimeo / bestand -> [soort, embed-URL]. Soort '' = placeholder tonen.
    $embed = function (?string $url): array {
        $url = trim((string) $url);
        if ($url === '') {
            return ['', ''];
        }
        if (preg_match('~(?:youtube(?:-nocookie)?\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/|live/)|youtu\.be/)([\w-]{11})~i', $url, $m)) {
            return ['iframe', "https://www.youtube-nocookie.com/embed/{$m[1]}?autoplay=1&rel=0"];
        }
        if (preg_match('~vimeo\.com/(?:video/|channels/[\w-]+/)?(\d+)(?:/([\da-f]+))?~i', $url, $m)) {
            return ['iframe', "https://player.vimeo.com/video/{$m[1]}?autoplay=1".(! empty($m[2]) ? "&h={$m[2]}" : '')];
        }
        if (preg_match('~\.(mp4|webm|ogv)(\?.*)?$~i', $url)) {
            return ['file', media_url($url) ?? $url];
        }

        return str_starts_with($url, 'https://') ? ['iframe', $url] : ['', ''];
    };
@endphp

<section
    @if (filled($data['anchor'] ?? null)) id="{{ $data['anchor'] }}" @endif
    class="relative overflow-hidden flex flex-col"
    data-hero
>
    {{-- Achtergrond + overlay --}}
    <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
        @if ($bg)
            <div class="absolute inset-0 will-change-transform" data-hero-parallax>
                <img
                    src="{{ $bg }}"
                    alt=""
                    class="size-full object-cover object-[75%_top]"
                    fetchpriority="high"
                    decoding="async"
                >
            </div>
        @endif
        <div class="absolute inset-0" style="background: linear-gradient(180deg, rgba(0,88,176,0.72) 0%, rgba(0,85,170,0.68) 35%, #ffffff 80%)"></div>
    </div>

    <div class="relative z-10 flex flex-col max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-[120px] 2xl:px-8 w-full min-h-svh lg:min-h-0 pt-40 sm:pt-48 lg:pt-60 2xl:pt-80 pb-20 sm:pb-24 lg:pb-12">
        {{-- Mobiel: tekst onderaan het scherm --}}
        <div class="flex-1 lg:hidden"></div>

        <div class="lg:pb-[88px] 2xl:pb-32">
            @if (filled($data['badge_text'] ?? null))
                <div data-intro style="--d:0s" class="inline-flex items-center gap-2 mb-4 sm:mb-6 px-3 py-1.5 sm:px-4 sm:py-2 rounded-full bg-[#0D1D2C]/65 border border-white/15 backdrop-blur-sm text-white text-[10px] sm:text-xs font-medium">
                    @if (filled($data['badge_emoji'] ?? null))
                        <span aria-hidden="true">{{ $data['badge_emoji'] }}</span>
                    @endif
                    {{ $data['badge_text'] }}
                </div>
            @endif

            @if ($lines)
                <h1 data-intro style="--d:.1s; text-shadow: 0 2px 12px rgba(0,0,0,0.18)" class="max-w-4xl text-[1.625rem] sm:text-[2.5rem] lg:text-[2.55rem] 2xl:text-[3.4rem] leading-[1.2] sm:leading-[1.1] tracking-tight font-bold text-white mb-4 sm:mb-6">
                    @foreach ($lines as $i => $line)
                        {{ $line }}
                        @if (! $loop->last)
                            @if (! $smartBreaks)
                                <br>
                            @elseif ($i === 0 && $i === $lastBreak)
                                <br>
                            @elseif ($i === 0)
                                <br class="lg:hidden">
                            @elseif ($i === $lastBreak)
                                <br class="hidden lg:block">
                            @endif
                        @endif
                    @endforeach
                </h1>
            @endif

            @if (filled(strip_tags($data['body'] ?? '')))
                <div data-intro style="--d:.2s" class="prose-its max-w-xl text-sm sm:text-base leading-relaxed text-white/80 mb-6 sm:mb-8 [&_p:last-child]:mb-0 [&_strong]:text-white [&_strong]:underline [&_strong]:underline-offset-2 [&_strong]:decoration-white/40 [&_a]:text-white [&_a]:font-bold [&_a]:decoration-white/40 [&_a:hover]:decoration-white">
                    {!! $data['body'] !!}
                </div>
            @endif

            @if (filled($primary['label'] ?? null) || filled($secondary['label'] ?? null))
                <div data-intro style="--d:.3s" class="flex flex-wrap items-center gap-x-6 gap-y-3">
                    @if (filled($primary['label'] ?? null) && filled($primary['url'] ?? null))
                        <a href="{{ $primary['url'] }}" class="gradient-orange inline-flex items-center gap-2 px-6 py-3 sm:px-8 sm:py-4 lg:px-5 lg:py-2.5 2xl:px-8 2xl:py-4 rounded-full text-white font-bold text-sm sm:text-base lg:text-sm 2xl:text-base shadow-lg transition-all hover:shadow-2xl hover:scale-[1.03] active:scale-[0.98]">
                            {{ $primary['label'] }}
                            @if (filled($primary['emoji'] ?? null))
                                <span class="hidden sm:inline" aria-hidden="true">{{ $primary['emoji'] }}</span>
                            @endif
                        </a>
                    @endif
                    @if (filled($secondary['label'] ?? null) && filled($secondary['url'] ?? null))
                        <a href="{{ $secondary['url'] }}" class="inline-flex items-center gap-2 font-bold text-sm sm:text-base lg:text-sm 2xl:text-base text-white/80 hover:text-white hover:gap-3 transition-all">
                            {{ $secondary['label'] }}
                            <x-lucide name="arrow-right" class="size-4" />
                        </a>
                    @endif
                </div>
            @endif
        </div>

        @if ($stats || $trustLabels)
            <div data-intro style="--d:.3s" class="hidden lg:flex items-center justify-between gap-6 mb-4">
                <ul class="flex items-center gap-5 text-[11px] text-white/50">
                    @foreach ($stats as $stat)
                        <li class="flex items-center gap-1.5">
                            <x-lucide name="check" size="11" class="text-its-orange" />
                            {{ $stat }}
                        </li>
                    @endforeach
                </ul>
                @if ($trustLabels)
                    <ul class="flex items-center gap-5 text-[11px] font-medium text-white/75 opacity-75 hover:opacity-100 transition-opacity">
                        @foreach ($trustLabels as $label)
                            @if (! $loop->first)
                                <li class="w-px h-6 bg-white/20" aria-hidden="true"></li>
                            @endif
                            <li class="flex items-center gap-2">
                                @if (filled($label['emoji'] ?? null))
                                    <span aria-hidden="true">{{ $label['emoji'] }}</span>
                                @endif
                                {{ $label['text'] }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @endif

        @if ($quicklinks)
            <div class="grid grid-cols-3 gap-1.5 sm:gap-3 mt-6 lg:mt-0">
                @foreach ($quicklinks as $i => $link)
                    <a
                        href="{{ $link['url'] ?? '#' }}"
                        data-intro
                        style="--d:{{ 0.35 + $i * 0.1 }}s"
                        class="group flex flex-col items-center justify-center text-center gap-2 p-3 sm:flex-row sm:justify-start sm:text-left sm:gap-4 sm:p-4 rounded-xl sm:rounded-2xl bg-white shadow-lg transition-all hover:bg-[#F5F5F7] hover:shadow-xl hover:scale-[1.01]"
                    >
                        @if (filled($link['emoji'] ?? null))
                            <span class="grid place-items-center shrink-0 size-9 sm:size-10 rounded-xl bg-[#F5F5F7] text-base sm:text-lg" aria-hidden="true">{{ $link['emoji'] }}</span>
                        @endif
                        <span class="min-w-0 sm:flex-1">
                            <span class="block text-[11px] sm:text-xs font-bold leading-tight text-its-primary">{{ $link['title'] }}</span>
                            @if (filled($link['subtitle'] ?? null))
                                <span class="hidden sm:block mt-0.5 text-[10px] sm:text-[11px] text-[#020101]/45 truncate">{{ $link['subtitle'] }}</span>
                            @endif
                        </span>
                        <x-lucide name="chevron-right" class="hidden sm:block size-4 text-its-orange transition-transform group-hover:translate-x-0.5" />
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    @if ($data['show_scroll_button'] ?? true)
        <button
            type="button"
            data-hero-scroll
            class="absolute z-20 left-1/2 -translate-x-1/2 top-[calc(100svh-46px)] inline-flex items-center gap-2 px-4 py-2.5 rounded-full border border-its-primary gradient-deep shadow-lg text-xs font-bold text-white transition-all duration-300 data-[hidden]:opacity-0 data-[hidden]:translate-y-2.5 data-[hidden]:pointer-events-none"
        >
            {{ $data['scroll_button_label'] ?? 'Scroll verder' }}
            <x-lucide name="chevron-down" class="size-3.5 animate-bounce" />
        </button>
    @endif

    {{-- Fotostrip: JS dupliceert de set (klaar in de HTML, `hidden`) en laat hem doorlopen. Zonder JS / reduced motion: handmatig scrollen. --}}
    @if ($strip)
        <div data-intro style="--d:.45s" class="relative z-10 pb-12">
            <div class="overflow-x-auto no-scrollbar" data-hero-strip data-speed="{{ $speed }}">
                <div class="flex w-max gap-3" data-hero-strip-track>
                    @foreach ([false, true] as $clone)
                        <div class="flex gap-3" @if ($clone) hidden aria-hidden="true" data-hero-strip-clone @endif>
                            @foreach ($strip as $item)
                                @php
                                    $isVideo = ($item['type'] ?? 'photo') === 'video';
                                    $width = max(120, min(1200, (int) ($item['width'] ?? 520) ?: 520));
                                    $rotation = is_numeric($item['rotation'] ?? null) ? (float) $item['rotation'] : 0;
                                    $caption = $item['caption'] ?? null;
                                    [$videoKind, $videoSrc] = $isVideo ? $embed($item['video_url'] ?? null) : ['', ''];
                                    $cardClass = 'group relative block flex-none h-[280px] sm:h-[400px] lg:h-[520px] rounded-2xl overflow-hidden bg-[#F5F5F7] transition-transform duration-[450ms] ease-out hover:scale-[.94] hover:rotate-(--rot)';
                                    $cardStyle = "aspect-ratio: {$width} / 520; --rot: {$rotation}deg";
                                @endphp

                                @if ($isVideo)
                                    <button
                                        type="button"
                                        class="{{ $cardClass }} text-left cursor-pointer"
                                        style="{{ $cardStyle }}"
                                        data-hero-video="{{ $videoSrc }}"
                                        data-hero-video-kind="{{ $videoKind }}"
                                        aria-label="Video afspelen{{ $caption ? ': '.$caption : '' }}"
                                        @if ($clone) tabindex="-1" @endif
                                    >
                                        <img src="{{ media_url($item['image']) }}" alt="{{ $item['alt'] ?? '' }}" class="size-full object-cover" loading="lazy" decoding="async">
                                        <span class="absolute inset-0 bg-black/35" aria-hidden="true"></span>
                                        <span class="absolute inset-0 m-auto grid place-items-center size-14 rounded-full bg-white/95 shadow-lg transition-transform group-hover:scale-110" aria-hidden="true">
                                            <x-lucide name="play" fill="currentColor" class="size-5 ml-0.5 text-its-primary" />
                                        </span>
                                        @if (filled($caption))
                                            <span class="absolute left-4 right-4 bottom-4 text-white text-xs font-semibold">{{ $caption }}</span>
                                        @endif
                                    </button>
                                @else
                                    <figure class="{{ $cardClass }}" style="{{ $cardStyle }}">
                                        <img src="{{ media_url($item['image']) }}" alt="{{ ($item['alt'] ?? null) ?: ($caption ?? '') }}" class="size-full object-cover" loading="lazy" decoding="async">
                                        @if (filled($caption))
                                            <figcaption class="absolute inset-0 flex items-end p-4 opacity-0 transition-opacity duration-300 group-hover:opacity-100" style="background: linear-gradient(to top, rgba(0,114,204,0.92) 0%, rgba(0,114,204,0) 20%)">
                                                <span class="text-white text-xs font-semibold">{{ $caption }}</span>
                                            </figcaption>
                                        @endif
                                    </figure>
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        @if ($hasVideo)
            <dialog
                data-hero-modal
                aria-label="Video"
                class="fixed inset-0 z-[60] m-0 size-full max-w-none max-h-none p-4 bg-black/85 backdrop:bg-transparent hidden open:flex items-center justify-center"
            >
                <button type="button" data-hero-modal-close class="absolute top-4 right-4 grid place-items-center size-10 rounded-full bg-white/10 text-white hover:bg-white/20 transition-colors" aria-label="Sluiten">
                    <x-lucide name="x" class="size-5" />
                </button>
                <div class="relative w-full max-w-4xl aspect-video bg-its-dark rounded-2xl overflow-hidden shadow-2xl">
                    <div data-hero-modal-frame class="absolute inset-0"></div>
                    <div data-hero-modal-placeholder class="absolute inset-0 flex flex-col items-center justify-center gap-3 p-6 text-center text-white/60">
                        <span class="grid place-items-center size-14 rounded-full bg-white/10">
                            <x-lucide name="play" fill="currentColor" class="size-5 ml-0.5 text-white/70" />
                        </span>
                        <p class="text-sm">Deze video is binnenkort beschikbaar.</p>
                    </div>
                </div>
            </dialog>
        @endif
    @endif
</section>
