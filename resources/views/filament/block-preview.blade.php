{{--
    Compacte preview van een blok in de editor (Builder::blockPreviews()).
    Krijgt de ruwe blokdata als variabelen. Klik = bewerken in de slide-over.
    Inline styles: Filament's CSS is voorgecompileerd.
--}}
@php
    $vars = get_defined_vars();
    $text = fn ($value) => is_string($value) ? trim(strip_tags($value)) : null;

    $heading = collect(['title', 'headline', 'certs_title', 'title_prefix', 'badge_text'])
        ->map(fn ($key) => $text($vars[$key] ?? null))
        ->first(fn ($value) => filled($value));

    $sub = collect(['intro', 'body', 'eyebrow', 'partners_title'])
        ->map(fn ($key) => $text($vars[$key] ?? null))
        ->first(fn ($value) => filled($value));

    // Eerste afbeelding (los veld of in een repeater) als thumbnail.
    $image = null;
    array_walk_recursive($vars, function ($value, $key) use (&$image) {
        if (! $image && is_string($value) && preg_match('/\.(jpe?g|png|webp|gif|svg)$/i', $value)) {
            $image = media_url($value);
        }
    });

    // Aantal items in repeaters (bv. "6 items, 4 cases").
    $counts = collect($vars)
        ->filter(fn ($value, $key) => is_array($value) && array_is_list($value) === false && count($value) > 1 && ! str_starts_with($key, '__') && ! in_array($key, ['app', 'errors', 'vars']))
        ->filter(fn ($value) => is_array(reset($value)))
        ->map(fn ($value) => count($value));
@endphp

<div style="display: flex; gap: 1rem; align-items: center; padding: .75rem 1rem; cursor: pointer;">
    @if ($image)
        <img src="{{ $image }}" alt="" style="width: 72px; height: 48px; object-fit: cover; border-radius: .5rem; flex-shrink: 0;">
    @endif
    <div style="min-width: 0;">
        <div class="text-sm font-semibold text-gray-950 dark:text-white" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
            {{ $heading ?: 'Nog geen titel' }}
        </div>
        @if ($sub)
            <div class="text-xs text-gray-500 dark:text-gray-400" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                {{ \Illuminate\Support\Str::limit($sub, 120) }}
            </div>
        @endif
        @if ($counts->isNotEmpty())
            <div class="text-xs text-gray-400" style="margin-top: .125rem;">
                {{ $counts->map(fn ($n, $key) => $n.' × '.str_replace('_', ' ', $key))->implode(' · ') }}
            </div>
        @endif
    </div>
</div>
