<?php

namespace App\Blocks;

use Filament\Forms\Components\Builder\Block;
use Illuminate\Support\Str;

/**
 * Eén bloktype = één class in app/Blocks/Types (admin-velden)
 * + één Blade-view in resources/views/blocks/{name}.blade.php (frontend).
 */
abstract class BlockType
{
    /** Unieke sleutel, snake_case. Wordt opgeslagen als `type` in de JSON. */
    abstract public static function name(): string;

    abstract public static function label(): string;

    public static function icon(): string
    {
        return 'heroicon-o-square-3-stack-3d';
    }

    /** Volgorde in de blokkenkiezer. */
    public static function sort(): int
    {
        return 100;
    }

    /** Filament-velden voor dit blok. */
    abstract public static function schema(): array;

    public static function make(): Block
    {
        return Block::make(static::name())
            // Ingeklapt blok toont ook de titel, zodat lange pagina's overzichtelijk blijven.
            ->label(fn (?array $state) => filled($title = strip_tags($state['title'] ?? ''))
                ? static::label().' — '.Str::limit($title, 50)
                : static::label())
            ->icon(static::icon())
            ->preview('filament.block-preview')
            ->schema(static::schema());
    }

    public static function view(): string
    {
        return 'blocks.'.static::name();
    }
}
