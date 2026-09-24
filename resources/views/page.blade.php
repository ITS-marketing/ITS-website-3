<x-layouts.site
    :title="$page->meta_title ?: ($page->is_home ? null : $page->title.' — '.setting('general.site_name', config('app.name')))"
    :description="$page->meta_description"
    :overlay="($blocks[0]['type'] ?? null) === 'hero'"
>
    @foreach ($blocks as $block)
        @php($view = \App\Blocks\BlockRegistry::view($block['type'] ?? ''))

        @if ($view && view()->exists($view))
            @include($view, ['data' => $block['data'] ?? [], 'index' => $loop->index])
        @elseif ($preview)
            <div class="max-w-3xl mx-auto my-6 p-4 rounded-xl bg-amber-50 text-amber-800 text-sm">
                Onbekend bloktype: <code>{{ $block['type'] ?? '?' }}</code>
            </div>
        @endif
    @endforeach
</x-layouts.site>
