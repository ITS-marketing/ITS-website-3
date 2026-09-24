{{--
    Knop/link. Rendert niets als label of url leeg is.
    <x-button :button="$data['button'] ?? null" variant="primary|link|link-white|outline" size="md|lg" />
    Of los: <x-button label="Contact" url="/contact" />
--}}
@props([
    'button' => null,
    'label' => null,
    'url' => null,
    'variant' => 'primary',
    'size' => 'md',
    'icon' => 'arrow-right',
])

@php
    $label ??= $button['label'] ?? null;
    $url ??= $button['url'] ?? null;
    $external = $url && str_starts_with($url, 'http');

    $classes = match ($variant) {
        'link' => 'inline-flex items-center gap-1.5 text-sm font-bold text-its-orange hover:gap-2.5 transition-all',
        'link-white' => 'inline-flex items-center gap-1.5 text-sm font-bold text-white/80 hover:text-white hover:gap-2.5 transition-all',
        'outline' => 'inline-flex items-center gap-2 px-5 py-2.5 sm:px-7 sm:py-3.5 rounded-full border border-[#D5D5D5]/60 bg-white text-xs sm:text-sm font-semibold text-[#020101]/60 hover:border-its-primary/40 hover:text-its-primary transition-all',
        default => match ($size) {
            'lg' => 'gradient-orange inline-flex items-center justify-center gap-2 px-6 py-3 sm:px-8 sm:py-4 rounded-full text-white font-bold text-sm sm:text-base transition-all hover:shadow-2xl hover:scale-[1.03] active:scale-[0.98]',
            default => 'gradient-orange inline-flex items-center justify-center gap-2 px-4 py-2 sm:px-6 sm:py-3 rounded-full text-white font-bold text-xs sm:text-sm transition-all hover:shadow-xl hover:scale-[1.02] active:scale-[0.98]',
        },
    };
@endphp

@if (filled($label) && filled($url))
    <a
        href="{{ $url }}"
        @if ($external) target="_blank" rel="noopener noreferrer" @endif
        {{ $attributes->merge(['class' => $classes]) }}
    >
        {{ $slot->isEmpty() ? $label : $slot }}
        @if ($icon)
            <x-lucide :name="$icon" class="size-3.5" />
        @endif
    </a>
@endif
