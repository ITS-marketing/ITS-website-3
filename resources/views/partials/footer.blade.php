@php
    $logo = media_url(setting('general.logo_white'));
    $siteName = setting('general.site_name', config('app.name'));
    $columns = setting('footer.columns', []);
    $socials = setting('footer.socials', []);
    $legal = setting('footer.legal', []);
    $company = array_filter([
        'KvK' => setting('contact.kvk'),
        'BTW' => setting('contact.btw'),
        'IBAN' => setting('contact.iban'),
    ]);
@endphp

{{-- Sticky onder de content: komt bij het einde van de pagina "onder de content vandaan". --}}
<footer class="gradient-footer sticky bottom-0 overflow-hidden">
    <x-container class="py-8 sm:py-14">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-[200px_1fr_1fr_1fr_1fr_1fr] gap-x-6 gap-y-6 sm:gap-y-10">
            <div class="col-span-2 sm:col-span-3 lg:col-span-1 flex flex-col gap-4 sm:gap-5">
                <a href="{{ url('/') }}" class="inline-block">
                    @if ($logo)
                        <img src="{{ $logo }}" alt="{{ $siteName }}" width="160" height="56" loading="lazy" class="w-40 h-auto object-contain object-left">
                    @else
                        <span class="text-xl font-bold text-white">{{ $siteName }}</span>
                    @endif
                </a>

                @if ($tagline = setting('footer.tagline'))
                    <p class="text-white/40 text-xs">{{ $tagline }}</p>
                @endif

                @if ($company)
                    <dl class="text-xs text-white/40 space-y-1">
                        @foreach ($company as $label => $value)
                            <div><dt class="inline text-white/25">{{ $label }}:</dt> <dd class="inline">{{ $value }}</dd></div>
                        @endforeach
                    </dl>
                @endif

                @if ($socials)
                    <div class="flex gap-2">
                        @foreach ($socials as $social)
                            <a href="{{ $social['url'] ?? '#' }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $social['name'] ?? '' }}"
                               class="w-8 h-8 rounded-full bg-white/8 hover:bg-white/15 border border-white/10 text-white/50 hover:text-white text-[10px] font-bold uppercase flex items-center justify-center transition-colors">
                                {{ $social['short'] ?? '' }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            @foreach ($columns as $column)
                <nav aria-label="{{ $column['title'] ?? '' }}">
                    <h2 class="text-its-primary text-xs font-bold mb-4">{{ $column['title'] ?? '' }}</h2>
                    <ul class="space-y-2.5">
                        @foreach ($column['links'] ?? [] as $link)
                            <li><a href="{{ $link['url'] ?? '#' }}" class="text-white/45 hover:text-white text-xs transition-colors">{{ $link['label'] ?? '' }}</a></li>
                        @endforeach
                    </ul>
                </nav>
            @endforeach
        </div>
    </x-container>

    <div class="border-t border-white/8">
        <x-container class="py-4 flex flex-col sm:flex-row items-center justify-between gap-3 text-[11px] text-white/25">
            <p>{{ str_replace(':year', date('Y'), setting('footer.copyright', '© :year '.$siteName)) }}</p>
            @if ($legal)
                <ul class="flex flex-wrap justify-center gap-x-5 gap-y-1">
                    @foreach ($legal as $link)
                        <li><a href="{{ $link['url'] ?? '#' }}" class="hover:text-white/60 transition-colors">{{ $link['label'] ?? '' }}</a></li>
                    @endforeach
                </ul>
            @endif
        </x-container>
    </div>
</footer>
