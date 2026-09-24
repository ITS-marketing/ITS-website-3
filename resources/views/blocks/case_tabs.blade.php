{{-- Blok 07: klantcases per branche. Velden: zie App\Blocks\Types\CaseTabs. JS: resources/js/blocks/case_tabs.js --}}
@php
    $cases = array_values(array_filter($data['cases'] ?? [], 'is_array'));
    $hex = fn ($v) => is_string($v) && preg_match('/^#([0-9a-f]{3}|[0-9a-f]{6})$/i', $v) ? $v : null;
    $overlay = 'linear-gradient(to right, rgba(0,59,96,0.92) 0%, rgba(0,72,153,0.72) 40%, rgba(0,114,204,0.25) 75%, transparent 100%), linear-gradient(to top, rgba(0,27,54,0.75) 0%, transparent 55%)';
@endphp

<section
    @if (filled($data['anchor'] ?? null)) id="{{ $data['anchor'] }}" @endif
    class="bg-white py-16 sm:py-20 lg:py-20 2xl:py-28"
>
    <x-container>
        <x-heading :data="$data" data-fade />

        @if (count($cases))
            <div data-tabs data-case-tabs class="mt-6 sm:mt-8">
                {{-- Tab-knoppen --}}
                <div role="tablist" class="flex gap-2 overflow-x-auto no-scrollbar -mx-4 px-4 sm:mx-0 sm:px-0" data-fade>
                    @foreach ($cases as $i => $case)
                        <button
                            type="button"
                            data-tab="case-{{ $i }}"
                            @if ($i === 0) data-active @endif
                            class="shrink-0 whitespace-nowrap px-2.5 py-1.5 text-[10px] sm:px-4 sm:py-2 sm:text-xs rounded-full font-semibold transition-all bg-its-gray-light text-[#020101]/60 hover:bg-[#D5D5D5]/40 hover:text-[#020101] data-[active]:bg-its-dark data-[active]:text-white data-[active]:shadow-md"
                        >{{ $case['tab'] ?? 'Case '.($i + 1) }}</button>
                    @endforeach
                </div>

                {{-- Panelen --}}
                @foreach ($cases as $i => $case)
                    @php
                        $image = media_url($case['image'] ?? null);
                        $from = $hex($case['gradient_from'] ?? null);
                        $to = $hex($case['gradient_to'] ?? null);
                        $words = preg_split('/\s+/u', trim((string) ($case['quote'] ?? '')), -1, PREG_SPLIT_NO_EMPTY);
                        $stats = array_values(array_filter($case['stats'] ?? [], 'is_array'));
                        $byline = implode(', ', array_filter([$case['author'] ?? null, $case['role'] ?? null], 'filled'));
                    @endphp

                    <div data-tab-panel="case-{{ $i }}" role="tabpanel" @if ($i !== 0) hidden @endif class="mt-6 sm:mt-8">
                        <div
                            @class(['relative rounded-3xl overflow-hidden h-[340px] sm:h-[460px]', 'gradient-secondary' => ! $image && ! ($from && $to)])
                            @if (! $image && $from && $to) style="background: linear-gradient(135deg, {{ $from }}, {{ $to }})" @endif
                            data-fade
                        >
                            @if ($image)
                                <img
                                    src="{{ $image }}"
                                    alt="{{ $case['client'] ?? '' }}"
                                    loading="lazy"
                                    decoding="async"
                                    class="absolute inset-0 size-full object-cover"
                                >
                            @endif
                            <div class="absolute inset-0" style="background: {{ $overlay }}"></div>

                            @if (filled($case['client'] ?? null))
                                <div class="absolute top-4 left-4 sm:top-6 sm:left-6 bg-white rounded-xl px-3 py-2 sm:px-4 sm:py-2.5 shadow-lg text-xs sm:text-sm font-bold text-its-dark">
                                    {{ $case['client'] }}
                                </div>
                            @endif

                            <div class="absolute inset-x-0 bottom-0 p-5 sm:p-8">
                                @if (count($words))
                                    <blockquote
                                        data-quote
                                        data-reveal
                                        class="group text-lg sm:text-2xl 2xl:text-3xl font-bold text-white leading-snug max-w-2xl"
                                    >
                                        @foreach ($words as $w => $word)
                                            <span class="inline-block overflow-hidden align-bottom"><span
                                                class="inline-block [transform:translateY(110%)] group-data-[reveal]:animate-[lineReveal_.55s_cubic-bezier(0.16,1,0.3,1)_both]"
                                                style="animation-delay: {{ round($w * 0.03, 2) }}s"
                                            >{{ $w === 0 ? '"' : '' }}{{ $word }}{{ $loop->last ? '"' : '' }}</span></span>{{ $loop->last ? '' : ' ' }}
                                        @endforeach
                                    </blockquote>
                                @endif

                                @if ($byline !== '')
                                    <p class="mt-3 sm:mt-5 text-white/60 text-xs sm:text-sm">— {{ $byline }}</p>
                                @endif

                                <div class="mt-4 sm:mt-6 flex flex-col items-start sm:flex-row sm:items-center gap-3 sm:gap-5">
                                    <x-button :label="$data['primary_label'] ?? null" :url="$case['case_url'] ?? null" />
                                    <x-button :label="$data['secondary_label'] ?? null" :url="$case['industry_url'] ?? null" variant="link-white" />
                                </div>
                            </div>
                        </div>

                        @if (count($stats))
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-5 border-t border-[#D5D5D5]/40 pt-5">
                                @foreach ($stats as $stat)
                                    <div class="flex items-baseline gap-2">
                                        <span class="text-2xl font-bold text-its-primary">{{ $stat['value'] ?? '' }}</span>
                                        <span class="text-sm text-[#020101]/50">{{ $stat['label'] ?? '' }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </x-container>
</section>
