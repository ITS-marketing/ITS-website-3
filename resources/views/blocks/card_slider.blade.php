{{-- Blok 09: kaarten-slider ("Misschien is dit ook iets voor jou"). Velden: zie App\Blocks\Types\CardSlider --}}
@php
    $cards = array_values(array_filter($data['cards'] ?? [], 'is_array'));
    $gray = ($data['background'] ?? 'white') === 'gray';
    $hex = fn ($v) => is_string($v) && preg_match('/^#([0-9a-f]{3}|[0-9a-f]{6})$/i', $v) ? $v : null;
    $readMore = $data['read_more_label'] ?? 'Lees meer';
@endphp

<section
    @if (filled($data['anchor'] ?? null)) id="{{ $data['anchor'] }}" @endif
    @class([
        'py-28 lg:py-20 2xl:py-28 overflow-hidden',
        'bg-white' => ! $gray,
        'bg-its-gray-light rounded-[30px]' => $gray,
    ])
>
    <div data-slider data-slider-loop>
        <div class="slider-inset">
            <x-heading :data="$data" data-fade />
        </div>

        @if (count($cards))
            <div
                data-slider-track
                data-fade
                class="slider-inset-left mt-8 sm:mt-10 flex gap-5 overflow-x-auto no-scrollbar"
            >
                @foreach ($cards as $card)
                    @php
                        $image = media_url($card['image'] ?? null);
                        $from = $hex($card['gradient_from'] ?? null);
                        $to = $hex($card['gradient_to'] ?? null);
                        $url = $card['url'] ?? null;
                        $tag = filled($url) ? 'a' : 'div';
                    @endphp

                    <{{ $tag }}
                        @if ($tag === 'a') href="{{ $url }}" @endif
                        @class(['group relative block shrink-0 w-[329px] max-w-[85vw] h-[420px] rounded-2xl overflow-hidden transition-transform duration-300 hover:scale-[0.97]', 'gradient-deep' => ! $image && ! ($from && $to)])
                        @if (! $image && $from && $to) style="background: linear-gradient(135deg, {{ $from }}, {{ $to }})" @endif
                    >
                        @if ($image)
                            <img
                                src="{{ $image }}"
                                alt="{{ $card['title'] ?? '' }}"
                                loading="lazy"
                                decoding="async"
                                class="absolute inset-0 size-full object-cover"
                            >
                        @endif
                        <div
                            class="absolute inset-0 opacity-75"
                            style="background: linear-gradient(to top, rgba(0,114,204,0.99) 0%, rgba(0,114,204,0.50) 50%, rgba(0,114,204,0) 100%)"
                        ></div>

                        <div class="absolute inset-x-0 bottom-0 p-6">
                            @if (filled($card['category'] ?? null))
                                <p class="text-[10px] font-semibold text-white/60">{{ $card['category'] }}</p>
                            @endif
                            @if (filled($card['title'] ?? null))
                                <h3 class="mt-1 text-base font-bold text-white leading-snug">{{ $card['title'] }}</h3>
                            @endif
                            @if ($tag === 'a' && filled($readMore))
                                <span class="mt-3 inline-flex items-center gap-1.5 text-xs font-bold text-white/80 transition-all group-hover:text-white group-hover:gap-2.5">
                                    {{ $readMore }}
                                    <x-lucide name="arrow-right" class="size-3.5" />
                                </span>
                            @endif
                        </div>
                    </{{ $tag }}>
                @endforeach

                <div data-slider-spacer class="shrink-0 w-8" aria-hidden="true"></div>
            </div>

            <div class="slider-inset mt-8 flex items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <button
                        type="button"
                        data-slider-prev
                        aria-label="Vorige"
                        @class([
                            'w-11 h-11 rounded-full flex items-center justify-center text-its-dark transition-colors disabled:opacity-30 disabled:cursor-not-allowed',
                            'bg-its-gray-light hover:bg-[#D5D5D5]/40' => ! $gray,
                            'bg-white hover:bg-[#D5D5D5]/40' => $gray,
                        ])
                    >
                        <x-lucide name="chevron-left" class="size-4" />
                    </button>
                    <button
                        type="button"
                        data-slider-next
                        aria-label="Volgende"
                        class="w-11 h-11 rounded-full flex items-center justify-center bg-its-primary hover:bg-[#005fa3] text-white transition-colors disabled:opacity-30 disabled:cursor-not-allowed"
                    >
                        <x-lucide name="chevron-right" class="size-4" />
                    </button>
                </div>
                <div data-slider-dots="dark" class="flex items-center gap-2"></div>
            </div>
        @endif
    </div>
</section>
