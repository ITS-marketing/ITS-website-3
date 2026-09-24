{{-- Blok 06: proces-slider (donker). Velden: zie App\Blocks\Types\ProcessSlider --}}
@php
    $steps = array_values(array_filter($data['steps'] ?? [], 'is_array'));

    // Fase-naam => hex-kleur
    $phaseColors = collect($data['phases'] ?? [])
        ->filter(fn ($p) => is_array($p) && filled($p['name'] ?? null))
        ->mapWithKeys(fn ($p) => [$p['name'] => $p['color'] ?? null])
        ->all();

    // '#2BA84A' + alpha => 'rgba(43,168,74,.8)'; ongeldige kleur => null
    $rgba = function (?string $hex, float $alpha): ?string {
        $hex = ltrim((string) $hex, '#');
        if (strlen($hex) === 3) {
            $hex = preg_replace('/(.)/', '$1$1', $hex);
        }
        if (! preg_match('/^[0-9a-f]{6}$/i', $hex)) {
            return null;
        }
        [$r, $g, $b] = array_map('hexdec', str_split($hex, 2));

        return "rgba({$r},{$g},{$b},{$alpha})";
    };
@endphp

<section
    @if (filled($data['anchor'] ?? null)) id="{{ $data['anchor'] }}" @endif
    class="gradient-secondary rounded-[30px] overflow-hidden py-20 sm:py-28 lg:py-28 2xl:py-40"
>
    <div data-slider>
        {{-- Kop --}}
        <div class="slider-inset">
            <div class="grid lg:grid-cols-3 gap-4 sm:gap-10 items-end" data-fade>
                <x-heading :data="\Illuminate\Support\Arr::except($data, ['intro'])" :dark="true" class="lg:col-span-2" />

                @if (filled($data['intro'] ?? null) || filled($data['link']['label'] ?? null))
                    <div>
                        @if (filled($data['intro'] ?? null))
                            <p class="text-white/60 text-base leading-relaxed">{!! nl_br($data['intro']) !!}</p>
                        @endif
                        <x-button :button="$data['link'] ?? null" variant="link" class="mt-4" />
                    </div>
                @endif
            </div>
        </div>

        @if (count($steps))
            {{-- Kaarten --}}
            <div
                data-slider-track
                data-fade-stagger
                class="slider-inset-left mt-10 sm:mt-14 flex gap-5 overflow-x-auto no-scrollbar"
            >
                @foreach ($steps as $i => $step)
                    @php
                        $hex = $phaseColors[$step['phase'] ?? ''] ?? null;
                        $solid = $rgba($hex, 1) ?? 'var(--its-primary)';
                        $soft = $rgba($hex, 0.8) ?? 'rgba(0,114,204,0.80)';
                        $image = media_url($step['image'] ?? null);
                    @endphp

                    <article class="group shrink-0 w-[445px] max-w-[85vw]">
                        <div class="relative h-[240px] rounded-2xl overflow-hidden bg-white/5 transition-transform duration-300 group-hover:-translate-y-1">
                            @if ($image)
                                <img
                                    src="{{ $image }}"
                                    alt="{{ $step['title'] ?? '' }}"
                                    loading="lazy"
                                    decoding="async"
                                    class="absolute inset-0 size-full object-cover"
                                >
                            @endif
                            <div class="absolute inset-0 bg-black/25"></div>

                            <div class="absolute top-4 left-4 inline-flex items-center gap-2 bg-white/90 backdrop-blur-sm rounded-full pl-1.5 pr-3 py-1.5">
                                <span
                                    class="w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold text-white"
                                    style="background: {{ $solid }}"
                                >{{ $i + 1 }}</span>
                                @if (filled($step['label'] ?? null))
                                    <span class="text-xs font-semibold text-its-dark">{{ $step['label'] }}</span>
                                @endif
                            </div>

                            @if (filled($step['phase'] ?? null))
                                <span
                                    class="absolute bottom-4 right-4 px-3 py-1 rounded-full text-xs font-semibold text-white"
                                    style="background: {{ $soft }}"
                                >{{ $step['phase'] }}</span>
                            @endif
                        </div>

                        @if (filled($step['title'] ?? null))
                            <h3 class="mt-5 text-base font-bold text-white">{{ $step['title'] }}</h3>
                        @endif
                        @if (filled($step['text'] ?? null))
                            <p class="mt-2 text-sm text-white/55 leading-relaxed">{!! nl_br($step['text']) !!}</p>
                        @endif

                        @if (filled($step['loop_badge'] ?? null))
                            <span
                                class="inline-flex items-center gap-1.5 mt-3 px-3 py-1.5 rounded-full text-xs font-semibold border"
                                style="color: {{ $solid }}; border-color: {{ $rgba($hex, 0.25) ?? 'rgba(0,114,204,0.25)' }}; background: {{ $rgba($hex, 0.07) ?? 'rgba(0,114,204,0.07)' }}"
                            >
                                <x-lucide name="rotate-ccw" size="11" />
                                {{ $step['loop_badge'] }}
                            </span>
                        @endif
                    </article>
                @endforeach

                <div data-slider-spacer class="shrink-0 w-8" aria-hidden="true"></div>
            </div>

            {{-- Navigatie --}}
            <div class="slider-inset mt-8 sm:mt-10 flex items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <button
                        type="button"
                        data-slider-prev
                        aria-label="Vorige stap"
                        class="w-11 h-11 rounded-full flex items-center justify-center bg-white/10 hover:bg-white/20 text-white transition-colors disabled:opacity-30 disabled:cursor-not-allowed"
                    >
                        <x-lucide name="chevron-left" class="size-4" />
                    </button>
                    <button
                        type="button"
                        data-slider-next
                        aria-label="Volgende stap"
                        class="w-11 h-11 rounded-full flex items-center justify-center bg-its-primary hover:bg-[#005fa3] text-white transition-colors disabled:opacity-30 disabled:cursor-not-allowed"
                    >
                        <x-lucide name="chevron-right" class="size-4" />
                    </button>
                </div>
                <div data-slider-dots="light" class="flex items-center gap-2"></div>
            </div>
        @endif
    </div>
</section>
