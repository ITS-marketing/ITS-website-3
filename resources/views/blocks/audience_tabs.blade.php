{{-- Blok 03: doelgroep-tabs ("Zo laten wij [iedereen] van ICT houden") --}}
@php
    $words = array_values(array_filter($data['rotating_words'] ?? [], 'filled'));
    $tabs = array_values(array_filter($data['tabs'] ?? [], 'is_array'));
    $defaultTab = $data['default_tab'] ?? null;
    $activeIndex = 0;
    foreach ($tabs as $i => $tab) {
        if (filled($defaultTab) && ($tab['label'] ?? null) === $defaultTab) {
            $activeIndex = $i;
            break;
        }
    }

    $colors = [
        'primary' => ['bar' => 'bg-its-primary', 'text' => 'text-its-primary'],
        'blue' => ['bar' => 'bg-its-blue', 'text' => 'text-its-blue'],
        'dark' => ['bar' => 'bg-its-dark', 'text' => 'text-its-dark'],
    ];
@endphp

<section @if (filled($data['anchor'] ?? null)) id="{{ $data['anchor'] }}" @endif class="bg-white py-16 sm:py-20 2xl:py-28">
    <x-container>
        <x-heading :data="$data" align="center" data-fade>
            <x-slot:title>
                {{ $data['title_prefix'] ?? '' }}
                @if ($words)
                    <span
                        class="inline-block text-its-dark transition-[opacity,transform] duration-300"
                        data-rotating-word
                        data-words="{{ json_encode($words) }}"
                        data-interval="{{ (int) ($data['rotate_interval_ms'] ?? 2800) ?: 2800 }}"
                    >{{ $words[0] }}</span>
                @endif
                {{ $data['title_suffix'] ?? '' }}
            </x-slot:title>
        </x-heading>

        @if ($tabs)
            <div data-tabs>
                {{-- Tabs: gecentreerd, op mobiel horizontaal scrollbaar --}}
                <div class="mt-8 sm:mt-10 -mx-4 px-4 sm:mx-0 sm:px-0 overflow-x-auto no-scrollbar" data-fade>
                    <div class="flex gap-2 w-max mx-auto" role="tablist">
                        @foreach ($tabs as $i => $tab)
                            <button
                                type="button"
                                data-tab="audience-{{ $index ?? 0 }}-{{ $i }}"
                                @if ($i === $activeIndex) data-active aria-selected="true" @else aria-selected="false" @endif
                                class="shrink-0 whitespace-nowrap px-2.5 py-1.5 text-[10px] sm:px-4 sm:py-2 sm:text-xs rounded-full font-semibold transition-all bg-[#F5F5F7] text-[#020101]/60 hover:bg-[#D5D5D5]/40 hover:text-[#020101] data-[active]:bg-its-dark data-[active]:text-white data-[active]:shadow-md data-[active]:hover:bg-its-dark data-[active]:hover:text-white"
                            >{{ $tab['label'] ?? '' }}</button>
                        @endforeach
                    </div>
                </div>

                @foreach ($tabs as $i => $tab)
                    @php
                        $color = $colors[$tab['mockup_color'] ?? 'primary'] ?? $colors['primary'];
                        $stats = array_values(array_filter($tab['stats'] ?? [], 'is_array'));
                        $kpis = array_values(array_filter($tab['mockup_kpis'] ?? [], 'filled'));
                        if (! $kpis) {
                            $kpis = array_values(array_filter(array_column($stats, 'value'), 'filled'));
                        }
                        $kpis = array_slice($kpis, 0, 3);
                        $image = media_url($tab['image'] ?? null);
                        $bullets = array_values(array_filter($tab['bullets'] ?? [], 'filled'));
                    @endphp

                    <div data-tab-panel="audience-{{ $index ?? 0 }}-{{ $i }}" role="tabpanel" @if ($i !== $activeIndex) hidden @endif>
                        <div class="mt-10 sm:mt-14 grid lg:grid-cols-2 gap-8 lg:gap-12 2xl:gap-20 items-center" data-fade>
                            {{-- Tekst --}}
                            <div class="lg:order-2">
                                @if (filled($tab['title'] ?? null))
                                    <h3 class="text-[18px] sm:text-2xl font-bold text-its-primary mb-4 leading-snug">{{ $tab['title'] }}</h3>
                                @endif
                                @if (filled($tab['description'] ?? null))
                                    <p class="text-[#020101]/60 leading-relaxed mb-5 text-base">{!! nl_br($tab['description']) !!}</p>
                                @endif
                                @if ($bullets)
                                    <ul class="space-y-2.5 mb-6">
                                        @foreach ($bullets as $bullet)
                                            <li class="flex items-center gap-2.5 text-sm text-[#020101]/70">
                                                <span aria-hidden="true">✅</span>
                                                <span>{{ $bullet }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                                <x-button :button="$tab['link'] ?? null" variant="link" />
                                @if ($stats)
                                    <div class="grid grid-cols-2 gap-3 mt-8">
                                        @foreach ($stats as $stat)
                                            <div class="rounded-2xl bg-[#F5F5F7] border border-[#D5D5D5]/40 p-5">
                                                <div class="text-3xl font-bold text-its-primary">{{ $stat['value'] ?? '' }}</div>
                                                <div class="text-sm text-[#020101]/50 mt-1">{{ $stat['label'] ?? '' }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            {{-- Mockup --}}
                            <div class="lg:order-1">
                                @if ($image)
                                    <img src="{{ $image }}" alt="{{ $tab['title'] ?? '' }}" loading="lazy" decoding="async" class="w-full rounded-2xl shadow-2xl object-cover">
                                @else
                                    <div aria-hidden="true">
                                        <div class="rounded-2xl overflow-hidden shadow-2xl border border-[#D5D5D5]/40 bg-white">
                                            <div class="h-9 flex items-center gap-1.5 px-4 {{ $color['bar'] }}">
                                                <span class="w-2.5 h-2.5 rounded-full bg-white/20"></span>
                                                <span class="w-2.5 h-2.5 rounded-full bg-white/20"></span>
                                                <span class="w-2.5 h-2.5 rounded-full bg-white/20"></span>
                                                <span class="flex-1 h-4 rounded bg-white/10 max-w-xs mx-auto"></span>
                                            </div>
                                            <div class="aspect-[4/3] overflow-hidden flex bg-gradient-to-br from-white to-[#F5F5F7]/60">
                                                <div class="w-14 shrink-0 border-r border-[#D5D5D5]/40 p-2 space-y-2">
                                                    @for ($s = 0; $s < 5; $s++)
                                                        <div class="h-6 rounded-md bg-[#F5F5F7]"></div>
                                                    @endfor
                                                </div>
                                                <div class="flex-1 min-w-0 p-3 sm:p-5 flex flex-col gap-2 sm:gap-3">
                                                    @if ($kpis)
                                                        <div class="grid grid-cols-3 gap-2">
                                                            @foreach ($kpis as $kpi)
                                                                <div class="rounded-xl border border-[#D5D5D5]/40 bg-white p-2 sm:p-3">
                                                                    <div class="h-1.5 w-8 rounded-full bg-[#D5D5D5]/60 mb-2"></div>
                                                                    <div class="text-xs sm:text-base font-bold truncate {{ $color['text'] }}">{{ $kpi }}</div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                    @for ($s = 0; $s < 4; $s++)
                                                        <div class="h-5 sm:h-8 shrink-0 rounded-lg border border-[#D5D5D5]/40 bg-white"></div>
                                                    @endfor
                                                    <div class="grid grid-cols-2 gap-2">
                                                        <div class="h-14 sm:h-20 rounded-xl border border-[#D5D5D5]/40 bg-white"></div>
                                                        <div class="h-14 sm:h-20 rounded-xl border border-[#D5D5D5]/40 bg-white"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="h-3 bg-[#D5D5D5]/60 rounded-b-xl mx-6"></div>
                                        <div class="h-1.5 bg-[#D5D5D5]/40 rounded-full mt-0.5"></div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </x-container>
</section>
