{{-- Blok 02 — Logo-marquee (CSS-animatie .marquee / .marquee-reverse uit app.css). --}}
@php
    $logos = array_values(array_filter((array) ($data['logos'] ?? []), fn ($l) => filled($l['name'] ?? null) || media_url($l['image'] ?? null)));

    // Eén "kopie" moet breder zijn dan het scherm: vul weinig logo's aan tot minimaal 12 stuks.
    $set = $logos;
    while ($set && count($set) < 12) {
        $set = array_merge($set, $logos);
    }

    $speed = is_numeric($data['speed'] ?? null) && $data['speed'] >= 5 ? (float) $data['speed'] : 45;
    $animation = ($data['direction'] ?? 'reverse') === 'normal' ? 'marquee' : 'marquee-reverse';
@endphp

<section
    @if (filled($data['anchor'] ?? null)) id="{{ $data['anchor'] }}" @endif
    class="bg-white py-8 sm:py-12 overflow-hidden border-b border-[#D5D5D5]/30"
>
    <x-container>
        @if (filled($data['title'] ?? null))
            <p data-fade class="text-center text-xs font-semibold text-[#020101]/30 mb-5 sm:mb-10">{{ $data['title'] }}</p>
        @endif

        @if ($set)
            <div data-fade style="--d:.1s" class="relative overflow-hidden">
                <div class="pointer-events-none absolute inset-y-0 left-0 z-10 w-24" style="background: linear-gradient(to right, white, transparent)"></div>
                <div class="pointer-events-none absolute inset-y-0 right-0 z-10 w-24" style="background: linear-gradient(to left, white, transparent)"></div>

                <div class="{{ $animation }} flex w-max" style="animation-duration: {{ $speed }}s">
                    @foreach ([false, true] as $clone)
                        <ul class="flex shrink-0 items-center gap-6 pr-6 sm:gap-10 sm:pr-10" @if ($clone) aria-hidden="true" @endif>
                            @foreach ($set as $logo)
                                @php
                                    $name = $logo['name'] ?? '';
                                    $img = media_url($logo['image'] ?? null);
                                    $url = $logo['url'] ?? null;
                                    $width = is_numeric($logo['width'] ?? null)
                                        ? (int) $logo['width']
                                        : max(48, min(120, 24 + mb_strlen($name) * 8));
                                @endphp
                                <li class="shrink-0">
                                    @if (filled($url))<a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="block" @if ($clone) tabindex="-1" @endif>@endif
                                    @if ($img)
                                        <img
                                            src="{{ $img }}"
                                            alt="{{ $name }}"
                                            class="h-8 w-auto max-w-[140px] object-contain grayscale opacity-50 transition duration-300 hover:grayscale-0 hover:opacity-100"
                                            loading="lazy"
                                            decoding="async"
                                        >
                                    @else
                                        <span class="block h-8 rounded bg-[#020101]/8" style="width: {{ $width }}px" role="img" aria-label="{{ $name }}"></span>
                                    @endif
                                    @if (filled($url))</a>@endif
                                </li>
                            @endforeach
                        </ul>
                    @endforeach
                </div>
            </div>
        @endif
    </x-container>
</section>
