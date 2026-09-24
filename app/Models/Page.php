<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'blocks',
        'meta_title',
        'meta_description',
        'is_published',
        'is_home',
    ];

    protected function casts(): array
    {
        return [
            'blocks' => 'array',
            'is_published' => 'boolean',
            'is_home' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        // Er is altijd maximaal één homepage.
        static::saving(function (Page $page) {
            if ($page->is_home && $page->isDirty('is_home')) {
                static::where('id', '!=', $page->id)->update(['is_home' => false]);
            }
        });
    }

    public function scopePublished(Builder $query): void
    {
        $query->where('is_published', true);
    }

    public function url(): string
    {
        return $this->is_home ? url('/') : url($this->slug);
    }
}
