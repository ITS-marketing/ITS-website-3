{{-- Blok 05: diensten met filter-tabs --}}
@php
    $cards = array_values(array_filter($data['cards'] ?? [], 'is_array'));
    $categories = array_values(array_filter($data['categories'] ?? [], 'is_array'));
    $key = 'services-'.($index ?? 0);
    $tabClass = 'shrink-0 whitespace-nowrap px-2.5 py-1.5 text-[10px] sm:px-4 sm:py-2 sm:text-xs rounded-full font-semibold transition-all bg-white text-[#020101]/60 hover:bg-[#D5D5D5]/40 hover:text-[#020101] data-[active]:bg-its-dark data-[active]:text-white data-[active]:shadow-md data-[active]:hover:bg-its-dark data-[active]:hover:text-white';
@endphp

<section @if (filled($data['anchor'] ?? null)) id="{{ $data['anchor'] }}" @endif class="bg-[#F5F5F7] rounded-[30px] overflow-hidden py-16 sm:py-20 2xl:py-28 mt-8 sm:mt-16">
    <x-container>
        <x-heading :data="$data" data-fade />

        <div data-tabs>
            @if ($categories)
                <div class="mt-8 sm:mt-10 -mx-4 px-4 sm:mx-0 sm:px-0 overflow-x-auto no-scrollbar" data-fade>
                    <div class="flex gap-2 w-max" role="tablist">
                        <button type="button" data-tab="{{ $key }}-all" data-active aria-selected="true" class="{{ $tabClass }}">
                            {{ $data['all_tab_label'] ?? '' ?: 'Alle oplossingen' }}
                        </button>
                        @foreach ($categories as $i => $category)
                            <button type="button" data-tab="{{ $key }}-{{ $i }}" aria-selected="false" class="{{ $tabClass }}">
                                {{ $category['tab_label'] ?? $category['category'] ?? '' }}
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Weergave A: alle kaarten --}}
            <div data-tab-panel="{{ $key }}-all" role="tabpanel">
                @if ($cards)
                    <div class="mt-8 sm:mt-10 grid lg:grid-cols-3 gap-4" data-fade-stagger>
                        @foreach ($cards as $card)
                            @php $bullets = array_values(array_filter($card['bullets'] ?? [], 'filled')); @endphp
                            <div>
                                <div class="bg-white border border-[#D5D5D5]/40 rounded-2xl p-5 sm:p-6 hover:shadow-lg hover:-translate-y-1 hover:border-its-primary/30 transition-all flex flex-col h-full">
                                    @if (filled($card['emoji'] ?? null) || filled($card['category'] ?? null))
                                        <div class="flex items-center gap-2 mb-3">
                                            @if (filled($card['emoji'] ?? null))
                                                <span class="text-lg sm:text-xl leading-none" aria-hidden="true">{{ $card['emoji'] }}</span>
                                            @endif
                                            <span class="text-[10px] sm:text-xs text-[#020101]/50 font-medium">{{ $card['category'] ?? '' }}</span>
                                        </div>
                                    @endif
                                    @if (filled($card['title'] ?? null))
                                        <h3 class="text-[18px] sm:text-xl font-bold text-its-primary leading-snug mb-2">{{ $card['title'] }}</h3>
                                    @endif
                                    @if (filled($card['text'] ?? null))
                                        <p class="text-[12px] sm:text-sm text-[#020101]/60 leading-relaxed mb-4">{!! nl_br($card['text']) !!}</p>
                                    @endif
                                    <ul class="space-y-2 mb-5 flex-1">
                                        @foreach ($bullets as $bullet)
                                            <li class="flex items-start gap-2 text-[12px] sm:text-sm text-[#020101]/70">
                                                <span aria-hidden="true">✅</span>
                                                <span>{{ $bullet }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div>
                                        <x-button :button="$card['link'] ?? null" variant="link" />
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Weergave B: detail per categorie --}}
            @foreach ($categories as $i => $category)
                @php
                    $image = media_url($category['image'] ?? null);
                    $subGrid = array_values(array_filter($category['sub_grid'] ?? [], 'is_array'));
                    $subList = array_values(array_filter($category['sub_list'] ?? [], 'is_array'));
                @endphp
                <div data-tab-panel="{{ $key }}-{{ $i }}" role="tabpanel" hidden>
                    <div class="mt-8 sm:mt-10 grid lg:grid-cols-3 gap-6" data-fade-stagger>
                        {{-- Fotokaart --}}
                        <div class="relative lg:col-span-1 rounded-2xl overflow-hidden p-5 sm:p-7 flex flex-col justify-end min-h-[300px] sm:min-h-[420px]">
                            @if ($image)
                                <img src="{{ $image }}" alt="" loading="lazy" decoding="async" class="absolute inset-0 w-full h-full object-cover">
                            @endif
                            <div class="absolute inset-0" style="background: linear-gradient(to bottom, rgba(0,114,204,0.30) 0%, rgba(0,59,96,0.92) 100%)"></div>
                            <div class="relative z-10">
                                @if (filled($category['emoji'] ?? null) || filled($category['category'] ?? null))
                                    <p class="flex items-center gap-2 text-sm text-white/60 mb-2">
                                        @if (filled($category['emoji'] ?? null))
                                            <span aria-hidden="true">{{ $category['emoji'] }}</span>
                                        @endif
                                        <span>{{ $category['category'] ?? '' }}</span>
                                    </p>
                                @endif
                                @if (filled($category['headline'] ?? null))
                                    <h3 class="text-[18px] sm:text-2xl font-bold text-white leading-snug mb-4 sm:mb-5">{!! nl_br($category['headline']) !!}</h3>
                                @endif
                                <x-button :button="$category['cta'] ?? null" />
                            </div>
                        </div>

                        <div class="lg:col-span-2 flex flex-col gap-4">
                            @if ($subGrid)
                                <div class="grid grid-cols-2 gap-3 sm:gap-4">
                                    @foreach ($subGrid as $item)
                                        @php $tag = filled($item['url'] ?? null) ? 'a' : 'div'; @endphp
                                        <{{ $tag }} @if ($tag === 'a') href="{{ $item['url'] }}" @endif class="group bg-white border border-[#D5D5D5]/40 rounded-2xl p-3 sm:p-5 hover:shadow-md hover:-translate-y-0.5 transition-all">
                                            @if (filled($item['emoji'] ?? null))
                                                <span class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-[#F5F5F7] flex items-center justify-center text-base mb-3" aria-hidden="true">{{ $item['emoji'] }}</span>
                                            @endif
                                            <h4 class="font-bold text-its-primary text-sm flex items-center gap-1">
                                                {{ $item['title'] ?? '' }}
                                                <x-lucide name="arrow-right" size="11" class="text-its-orange transition-transform group-hover:translate-x-0.5" />
                                            </h4>
                                            @if (filled($item['description'] ?? null))
                                                <p class="text-xs text-[#020101]/55 leading-relaxed mt-1">{{ $item['description'] }}</p>
                                            @endif
                                        </{{ $tag }}>
                                    @endforeach
                                </div>
                            @endif

                            @if ($subList)
                                <div class="flex flex-col gap-2">
                                    @foreach ($subList as $item)
                                        @php $tag = filled($item['url'] ?? null) ? 'a' : 'div'; @endphp
                                        <{{ $tag }} @if ($tag === 'a') href="{{ $item['url'] }}" @endif class="group flex items-center gap-4 bg-white border border-[#D5D5D5]/40 rounded-2xl px-5 py-4 hover:shadow-md hover:border-its-primary/30 transition-all">
                                            @if (filled($item['emoji'] ?? null))
                                                <span class="w-10 h-10 shrink-0 rounded-xl bg-[#F5F5F7] flex items-center justify-center text-lg" aria-hidden="true">{{ $item['emoji'] }}</span>
                                            @endif
                                            <span class="flex-1 min-w-0">
                                                <span class="block text-sm font-bold text-its-primary">{{ $item['title'] ?? '' }}</span>
                                                @if (filled($item['description'] ?? null))
                                                    <span class="block text-xs text-[#020101]/50 mt-0.5">{{ $item['description'] }}</span>
                                                @endif
                                            </span>
                                            <x-lucide name="chevron-right" class="size-4 text-its-orange transition-transform group-hover:translate-x-0.5" />
                                        </{{ $tag }}>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if (filled($data['footer_button']['label'] ?? null) && filled($data['footer_button']['url'] ?? null))
            <div class="mt-10 sm:mt-14 flex justify-center" data-fade>
                <x-button :button="$data['footer_button']" variant="outline" class="w-full sm:w-auto justify-between sm:justify-center" />
            </div>
        @endif
    </x-container>
</section>
