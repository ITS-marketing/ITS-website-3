@php
    $nav = setting('header.nav', []);
    $services = array_filter($nav, fn ($item) => ($item['group'] ?? 'services') === 'services');
    $others = array_filter($nav, fn ($item) => ($item['group'] ?? 'services') !== 'services');
    $logo = media_url(setting('general.logo'));
    $siteName = setting('general.site_name', config('app.name'));
    $cta = setting('header.cta', []);
    $mobileCta = setting('header.mobile_cta', []);
    $current = '/'.ltrim(request()->path(), '/');
    $isActive = fn (?string $url) => $url && $url !== '/' && str_starts_with($current, $url);

    // Topbar ligt over een donkere hero (wit) of over een witte pagina (grijs).
    $overlay ??= true;
    [$topText, $topHover, $topActive, $topSep] = $overlay
        ? ['text-white/65', 'hover:text-white', 'aria-pressed:text-white', 'bg-white/20']
        : ['text-[#020101]/55', 'hover:text-its-primary', 'aria-pressed:text-its-primary', 'bg-[#D5D5D5]'];
@endphp

<header data-header class="group/header fixed top-0 inset-x-0 z-50 px-4 sm:px-6 lg:px-8 pt-3.5 pointer-events-none">
    {{-- Topbar (desktop). Klapt in zodra er gescrold wordt. --}}
    <div class="hidden lg:flex items-center justify-between overflow-hidden max-h-10 opacity-100 transition-all duration-300 ease-in-out group-data-[scrolled]/header:max-h-0 group-data-[scrolled]/header:opacity-0 pointer-events-auto text-xs {{ $topText }}">
        <div class="flex items-center gap-4 pb-3">
            @if ($phone = setting('contact.phone'))
                <a href="{{ setting('contact.phone_link', 'tel:'.$phone) }}" class="inline-flex items-center gap-1.5 {{ $topHover }} transition-colors">
                    <x-lucide name="phone" class="size-3" /> {{ $phone }}
                </a>
            @endif
            @if ($email = setting('contact.email'))
                <span class="w-px h-3 {{ $topSep }}"></span>
                <a href="mailto:{{ $email }}" class="inline-flex items-center gap-1.5 {{ $topHover }} transition-colors">
                    <x-lucide name="mail" class="size-3" /> {{ $email }}
                </a>
            @endif
        </div>
        <div class="flex items-center gap-4 pb-3">
            @if ($portal = setting('contact.portal_url'))
                <a href="{{ $portal }}" class="inline-flex items-center gap-1.5 {{ $topHover }} transition-colors">
                    <x-lucide name="external-link" class="size-3" /> Klantportaal
                </a>
            @endif
            @if (setting('header.show_language', true))
                <span class="w-px h-3 {{ $topSep }}"></span>
                <div class="relative">
                    <button type="button" data-lang-toggle aria-label="Taal wisselen" aria-expanded="false" class="inline-flex items-center gap-1.5 {{ $topHover }} transition-colors">
                        <x-lucide name="globe" class="size-3" /> NL <x-lucide name="chevron-down" class="size-2.5" />
                    </button>
                    <div data-lang-menu hidden class="absolute right-0 top-full mt-2 min-w-[88px] bg-white rounded-xl shadow-xl border border-[#D5D5D5]/40 overflow-hidden">
                        <a href="{{ url('/') }}" class="block px-4 py-2.5 text-xs font-medium bg-its-sky text-its-primary">🇳🇱 NL</a>
                        <a href="#" aria-disabled="true" class="block px-4 py-2.5 text-xs font-medium text-[#020101]/60 hover:bg-[#F5F5F7]">🇬🇧 EN</a>
                    </div>
                </div>
            @endif
            @if (setting('header.show_contrast', true))
                <span class="w-px h-3 {{ $topSep }}"></span>
                <button type="button" data-contrast-toggle aria-label="Hoog contrast" aria-pressed="false" class="inline-flex items-center gap-1.5 {{ $topHover }} transition-colors {{ $topActive }} aria-pressed:font-bold">
                    <x-lucide name="sun" class="size-3" /> Hoog contrast
                </button>
            @endif
        </div>
    </div>

    {{-- Desktop: navigatie-pill --}}
    <div class="hidden lg:block pointer-events-auto" data-mega>
        <nav aria-label="Hoofdmenu" class="bg-white rounded-full border border-[#D5D5D5]/50 grid grid-cols-[auto_1fr_auto] items-center h-10 2xl:h-14 px-2 2xl:px-2.5 shadow-[0_4px_24px_rgba(0,0,0,0.07),0_1px_3px_rgba(0,0,0,0.05)]">
            <div class="flex items-center gap-3 pl-2">
                <a href="{{ url('/') }}" class="shrink-0">
                    @if ($logo)
                        <img src="{{ $logo }}" alt="{{ $siteName }}" class="h-5 2xl:h-7 w-auto">
                    @else
                        <span class="font-bold text-its-primary">{{ $siteName }}</span>
                    @endif
                </a>
                <span class="w-px h-5 bg-[#D5D5D5]/60"></span>
            </div>

            <ul class="flex items-center justify-center gap-0.5 2xl:gap-1">
                @foreach ($nav as $i => $item)
                    @if ($i > 0 && ($item['group'] ?? 'services') !== ($nav[$i - 1]['group'] ?? 'services'))
                        <li aria-hidden="true" class="w-px h-4 bg-[#D5D5D5]/60 mx-1"></li>
                    @endif
                    <li>
                        <a
                            href="{{ $item['url'] ?? '#' }}"
                            @if (! empty($item['items'])) data-mega-trigger="{{ $i }}" aria-haspopup="true" aria-expanded="false" @endif
                            @class([
                                'group/link inline-flex items-center gap-1 whitespace-nowrap rounded-full px-2 2xl:px-2.5 py-1.5 2xl:py-2 text-[10px] 2xl:text-[13px] font-medium transition-colors',
                                'text-[#020101]/65 hover:text-its-primary hover:bg-[#F5F5F7] data-[open]:text-its-primary data-[open]:bg-its-sky' => ! $isActive($item['url'] ?? null),
                                'text-its-primary bg-its-sky' => $isActive($item['url'] ?? null),
                            ])
                        >
                            {{ $item['label'] ?? '' }}
                            @if (! empty($item['items']))
                                <x-lucide name="chevron-down" class="size-2.5 transition-transform duration-200 group-data-[open]/link:rotate-180" />
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>

            <div class="flex items-center gap-2 pl-3">
                <span class="w-px h-5 bg-[#D5D5D5]/60"></span>
                @if (filled($cta['label'] ?? null))
                    <a href="{{ $cta['url'] ?? '/contact' }}" class="gradient-orange inline-flex items-center gap-1.5 px-3 2xl:px-5 py-1.5 2xl:py-2.5 text-[11px] 2xl:text-sm font-bold text-white rounded-full transition-all hover:shadow-md hover:scale-[1.03]">
                        {{ $cta['label'] }} <x-lucide name="arrow-right" class="size-3 2xl:size-3.5" />
                    </a>
                @endif
            </div>
        </nav>

        {{-- Mega menu-panelen --}}
        @foreach ($nav as $i => $item)
            @continue(empty($item['items']))
            @php($featured = $item['featured'] ?? [])
            <div data-mega-panel="{{ $i }}" hidden class="mt-2 max-w-[1440px] mx-auto w-full bg-white rounded-3xl border border-[#D5D5D5]/30 overflow-hidden shadow-[0_24px_64px_rgba(0,0,0,0.11),0_4px_16px_rgba(0,0,0,0.06)]">
                <div class="grid grid-cols-[1fr_3fr_1fr]">
                    <div class="p-7 border-r border-[#D5D5D5]/30 flex flex-col">
                        @if (filled($item['emoji'] ?? null))
                            <span class="w-10 h-10 rounded-xl bg-its-sky text-xl flex items-center justify-center mb-4">{{ $item['emoji'] }}</span>
                        @endif
                        <h2 class="font-bold text-its-primary text-lg">{{ $item['label'] ?? '' }}</h2>
                        @if (filled($item['tagline'] ?? null))
                            <p class="mt-1.5 text-xs text-[#020101]/45 leading-relaxed">{{ $item['tagline'] }}</p>
                        @endif
                        <div class="mt-auto pt-6">
                            <x-button label="Lees meer" :url="$item['url'] ?? null" />
                        </div>
                    </div>

                    <div @class(['p-7 grid gap-3 content-start', 'grid-cols-2' => (int) ($item['columns'] ?? 2) === 2, 'grid-cols-1' => (int) ($item['columns'] ?? 2) === 1])>
                        @foreach ($item['items'] as $sub)
                            <a href="{{ $sub['url'] ?? '#' }}" class="group/card flex items-center gap-3.5 p-4 rounded-2xl bg-[#F5F5F7] border border-[#D5D5D5]/60 hover:bg-its-sky hover:border-its-primary/20 transition-colors">
                                @if (filled($sub['emoji'] ?? null))
                                    <span class="w-9 h-9 shrink-0 rounded-xl bg-white flex items-center justify-center">{{ $sub['emoji'] }}</span>
                                @endif
                                <span class="flex-1 min-w-0">
                                    <span class="block font-bold text-its-primary text-sm">{{ $sub['title'] ?? '' }}</span>
                                    @if (filled($sub['description'] ?? null))
                                        <span class="block text-xs text-[#020101]/45 line-clamp-2">{{ $sub['description'] }}</span>
                                    @endif
                                </span>
                                <x-lucide name="chevron-right" class="size-4 text-its-orange opacity-0 -translate-x-1 group-hover/card:opacity-100 group-hover/card:translate-x-0 transition-all" />
                            </a>
                        @endforeach
                    </div>

                    <div class="border-l border-[#D5D5D5]/30 p-4">
                        @if (filled($featured['title'] ?? null))
                            <a href="{{ $featured['url'] ?? '#' }}" class="group/feat relative flex flex-col justify-end h-full min-h-[240px] rounded-2xl overflow-hidden p-5 bg-[linear-gradient(135deg,var(--its-primary),var(--its-blue))]">
                                @if ($img = media_url($featured['image'] ?? null))
                                    <img src="{{ $img }}" alt="" loading="lazy" class="absolute inset-0 w-full h-full object-cover object-top transition-transform duration-500 group-hover/feat:scale-105">
                                @endif
                                <span class="absolute inset-0 bg-[linear-gradient(to_top,rgba(0,18,38,0.95)_0%,rgba(0,114,204,0.40)_60%,rgba(0,114,204,0)_100%)]"></span>
                                <span class="relative">
                                    @if (filled($featured['category'] ?? null))
                                        <span class="block text-[10px] text-white/55 font-semibold mb-1">{{ $featured['category'] }}</span>
                                    @endif
                                    <span class="block text-sm font-bold text-white leading-snug">{{ $featured['title'] }}</span>
                                    <span class="mt-3 inline-flex items-center gap-1.5 text-xs font-bold text-white/80 group-hover/feat:text-white group-hover/feat:gap-2.5 transition-all">
                                        Lees meer <x-lucide name="arrow-right" class="size-3" />
                                    </span>
                                </span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Mobiel --}}
    <div class="lg:hidden pointer-events-auto">
        <div class="bg-white rounded-full border border-[#D5D5D5]/50 flex items-center h-12 pl-4 pr-2 gap-2 shadow-[0_4px_24px_rgba(0,0,0,0.07),0_1px_3px_rgba(0,0,0,0.05)]">
            <a href="{{ url('/') }}" class="mr-auto">
                @if ($logo)
                    <img src="{{ $logo }}" alt="{{ $siteName }}" class="h-6 w-auto">
                @else
                    <span class="font-bold text-its-primary">{{ $siteName }}</span>
                @endif
            </a>
            @if (filled($cta['label'] ?? null))
                <a href="{{ $cta['url'] ?? '/contact' }}" class="gradient-orange px-4 py-2 text-xs font-bold text-white rounded-full">{{ $cta['label'] }}</a>
            @endif
            <button type="button" data-menu-toggle aria-label="Menu openen" aria-expanded="false" class="group/menu w-8 h-8 flex items-center justify-center rounded-full text-[#020101]/70">
                <x-lucide name="menu" class="size-[18px] group-aria-expanded/menu:hidden" />
                <x-lucide name="x" class="size-[18px] hidden group-aria-expanded/menu:block" />
            </button>
        </div>

        <div data-mobile-menu hidden class="mt-2 bg-white rounded-3xl border border-[#D5D5D5]/40 shadow-[0_12px_40px_rgba(0,0,0,0.10)] max-h-[calc(100dvh-6rem)] overflow-y-auto p-2">
            @if ($services)
                <p class="px-4 pt-2 pb-1 text-[10px] font-bold text-its-primary uppercase tracking-widest">Diensten</p>
                <div data-accordion>
                    @foreach ($services as $item)
                        <div data-accordion-item class="group">
                            <button type="button" data-accordion-trigger class="w-full flex items-center gap-3 px-4 py-3 text-sm font-medium text-[#020101]/75 rounded-2xl hover:bg-[#F5F5F7] group-data-[open]:bg-its-sky group-data-[open]:text-its-primary">
                                <span>{{ $item['emoji'] ?? '' }}</span>
                                <span class="flex-1 text-left">{{ $item['label'] ?? '' }}</span>
                                <x-lucide name="chevron-down" class="size-4 text-[#D5D5D5] transition-transform duration-300 group-data-[open]:rotate-180" />
                            </button>
                            <div data-accordion-panel>
                                <div>
                                    <div class="pl-4 pr-2 pb-2 pt-1 grid grid-cols-2 gap-1">
                                        <a href="{{ $item['url'] ?? '#' }}" class="col-span-2 px-3 py-2 text-xs font-bold text-its-primary rounded-xl hover:bg-[#F5F5F7]">Alles over {{ $item['label'] ?? '' }} →</a>
                                        @foreach ($item['items'] ?? [] as $sub)
                                            <a href="{{ $sub['url'] ?? '#' }}" class="px-3 py-2 text-xs text-[#020101]/60 rounded-xl hover:bg-[#F5F5F7]">{{ $sub['title'] ?? '' }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            @if ($others)
                <div class="h-px bg-[#D5D5D5]/30 mx-4 my-1"></div>
                @foreach ($others as $item)
                    <a href="{{ $item['url'] ?? '#' }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-[#020101]/75 rounded-2xl hover:bg-[#F5F5F7]">
                        <span>{{ $item['emoji'] ?? '' }}</span> {{ $item['label'] ?? '' }}
                    </a>
                @endforeach
            @endif

            @if (filled($mobileCta['label'] ?? null))
                <div class="p-2 pt-3">
                    <a href="{{ $mobileCta['url'] ?? '/contact' }}" class="gradient-orange flex items-center justify-center gap-2 w-full px-6 py-3 rounded-full text-sm font-bold text-white">
                        {{ $mobileCta['label'] }} <x-lucide name="arrow-right" class="size-3.5" />
                    </a>
                </div>
            @endif
        </div>
    </div>
</header>
