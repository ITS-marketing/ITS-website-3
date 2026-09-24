<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Eenvoudige key/value-opslag voor site-brede instellingen (header, footer, contact).
 */
class Setting extends Model
{
    protected $primaryKey = 'key';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['key', 'value'];

    protected function casts(): array
    {
        return ['value' => 'array'];
    }

    public static function allCached(): array
    {
        return Cache::rememberForever('settings', fn () => static::pluck('value', 'key')->all());
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return data_get(static::allCached(), $key, $default);
    }

    public static function setMany(array $values): void
    {
        foreach ($values as $key => $value) {
            static::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        Cache::forget('settings');
    }
}
