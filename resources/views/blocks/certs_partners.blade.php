{{-- Blok 08: keurmerken (donkere kaart) + partners (witte kaart) --}}
@php
    $certificates = array_filter($data['certificates'] ?? [], fn ($c) => media_url($c['logo'] ?? null));
    $partners = array_filter($data['partners'] ?? [], fn ($p) => filled($p['name'] ?? null));
@endphp

<section
    @if (filled($data['anchor'] ?? null)) id="{{ $data['anchor'] }}" @endif
    class="bg-[#F5F5F7] rounded-[30px] py-14 sm:py-20 lg:py-16 2xl:py-24"
>
    <x-container>
        <div class="grid lg:grid-cols-2 gap-4 sm:gap-5 items-stretch" data-fade-stagger>
            {{-- Keurmerken --}}
            <div class="gradient-secondary rounded-3xl p-5 sm:p-8 2xl:p-10 flex flex-col">
                @if (filled($data['certs_eyebrow'] ?? null))
                    <p class="text-[10px] sm:text-xs font-semibold tracking-wide text-white/40 mb-2 sm:mb-3">{{ $data['certs_eyebrow'] }}</p>
                @endif
                @if (filled($data['certs_title'] ?? null))
                    <h2 class="text-xl sm:text-2xl 2xl:text-3xl font-bold leading-tight text-white">{!! nl_br($data['certs_title']) !!}</h2>
                @endif
                @if (filled($data['certs_body'] ?? null))
                    <p class="mt-3 text-sm leading-relaxed text-white/55">{!! nl_br($data['certs_body']) !!}</p>
                @endif

                @if ($certificates)
                    <ul class="mt-6 sm:mt-10 grid grid-cols-2 sm:grid-cols-3 auto-rows-[72px] gap-2 sm:gap-3">
                        @foreach ($certificates as $cert)
                            <li class="bg-white rounded-2xl p-4 min-h-0">
                                <img
                                    src="{{ media_url($cert['logo']) }}"
                                    alt="{{ $cert['alt'] ?? '' }}"
                                    class="w-full h-full object-contain"
                                    loading="lazy"
                                    decoding="async"
                                >
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            {{-- Partners --}}
            <div class="rounded-3xl bg-white border border-[#D5D5D5]/40 p-5 sm:p-8 2xl:p-10 flex flex-col">
                @if (filled($data['partners_eyebrow'] ?? null))
                    <p class="text-[10px] sm:text-xs font-semibold tracking-wide text-[#020101]/35 mb-2 sm:mb-3">{{ $data['partners_eyebrow'] }}</p>
                @endif
                @if (filled($data['partners_title'] ?? null))
                    <h2 class="text-xl sm:text-2xl 2xl:text-3xl font-bold leading-tight text-its-primary">{!! nl_br($data['partners_title']) !!}</h2>
                @endif
                @if (filled($data['partners_body'] ?? null))
                    <p class="mt-3 text-sm leading-relaxed text-[#020101]/55">{!! nl_br($data['partners_body']) !!}</p>
                @endif

                @if ($partners)
                    <ul class="mt-6 sm:mt-10 grid grid-cols-2 gap-2">
                        @foreach ($partners as $partner)
                            @php
                                $url = $partner['url'] ?? null;
                                $logo = media_url($partner['logo'] ?? null);
                                $external = $url && str_starts_with($url, 'http');
                            @endphp
                            <li>
                                <{{ $url ? 'a' : 'div' }}
                                    @if ($url) href="{{ $url }}" @if ($external) target="_blank" rel="noopener noreferrer" @endif @endif
                                    class="group flex items-center justify-between gap-2 bg-[#F5F5F7] border border-[#D5D5D5]/50 rounded-xl px-3 py-2 sm:px-3.5 sm:py-2.5 hover:border-its-primary/30 hover:shadow-sm transition-all {{ $url ? '' : 'cursor-default' }}"
                                >
                                    <span class="flex items-center gap-2.5 min-w-0">
                                        @if ($logo)
                                            <img src="{{ $logo }}" alt="" class="size-[18px] object-contain shrink-0" loading="lazy" decoding="async">
                                        @else
                                            {{-- Microsoft 4-vierkantjes-placeholder --}}
                                            <span class="grid grid-cols-2 gap-[2px] size-[18px] shrink-0" aria-hidden="true">
                                                <span class="bg-[#F25022]"></span>
                                                <span class="bg-[#7FBA00]"></span>
                                                <span class="bg-[#00A4EF]"></span>
                                                <span class="bg-[#FFB900]"></span>
                                            </span>
                                        @endif
                                        <span class="text-xs font-semibold text-its-dark truncate">{{ $partner['name'] }}</span>
                                    </span>
                                    <x-lucide name="chevron-right" class="size-3.5 text-[#020101]/30 group-hover:text-its-primary group-hover:translate-x-0.5 transition-all" />
                                </{{ $url ? 'a' : 'div' }}>
                            </li>
                        @endforeach
                    </ul>
                @endif

                @if (filled($data['button']['label'] ?? null) || filled($data['secondary_button']['label'] ?? null))
                    <div class="mt-auto pt-8 sm:pt-10 flex flex-col sm:flex-row items-start sm:items-center gap-4 sm:gap-5">
                        <x-button :button="$data['button'] ?? null" />
                        <x-button :button="$data['secondary_button'] ?? null" variant="link" />
                    </div>
                @endif
            </div>
        </div>
    </x-container>
</section>
