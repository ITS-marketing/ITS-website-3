<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

if (! function_exists('media_url')) {
    /**
     * URL voor een afbeelding uit het CMS. Accepteert een pad op de public disk,
     * een volledige URL (bv. tijdelijke upload in de preview) of een Filament upload-array.
     */
    function media_url(mixed $value): ?string
    {
        if (is_array($value)) {
            $value = reset($value) ?: null;
        }

        if (blank($value) || ! is_string($value)) {
            return null;
        }

        if (str_starts_with($value, 'http') || str_starts_with($value, '/')) {
            return $value;
        }

        return Storage::disk('public')->url($value);
    }
}

if (! function_exists('setting')) {
    function setting(string $key, mixed $default = null): mixed
    {
        return Setting::get($key, $default);
    }
}

if (! function_exists('nl_br')) {
    /** Escaped tekst met regelbreuken als <br>. */
    function nl_br(?string $text): string
    {
        return nl2br(e($text ?? ''), false);
    }
}
