<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Support\Facades\Cache;

class PageController extends Controller
{
    public function home()
    {
        $page = Page::published()->where('is_home', true)->firstOrFail();

        return $this->render($page);
    }

    public function show(string $slug)
    {
        $page = Page::published()->where('slug', $slug)->where('is_home', false)->firstOrFail();

        return $this->render($page);
    }

    /** Toont de (nog niet opgeslagen) staat uit de Filament-editor. */
    public function preview(Page $page)
    {
        $state = Cache::get(static::previewKey($page));

        if ($state) {
            $page->forceFill([
                'title' => $state['title'] ?? $page->title,
                'blocks' => $state['blocks'] ?? [],
            ]);
        }

        return $this->render($page, preview: true);
    }

    public static function previewKey(Page $page): string
    {
        return 'page-preview:'.$page->getKey().':'.auth()->id();
    }

    protected function render(Page $page, bool $preview = false)
    {
        return view('page', [
            'page' => $page,
            // Builder-state kan een lijst of een uuid-keyed array zijn; normaliseer naar een lijst.
            'blocks' => array_values($page->blocks ?? []),
            'preview' => $preview,
        ]);
    }
}
