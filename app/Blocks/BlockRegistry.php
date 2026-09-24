<?php

namespace App\Blocks;

use Filament\Forms\Components\Builder\Block;
use Illuminate\Support\Str;

/**
 * Ontdekt automatisch alle bloktypes in app/Blocks/Types.
 * Nieuw blok = nieuwe class in Types/ + view in resources/views/blocks/.
 */
class BlockRegistry
{
    /** @var array<string, class-string<BlockType>>|null */
    protected static ?array $blocks = null;

    /** @return array<string, class-string<BlockType>> name => class */
    public static function all(): array
    {
        if (static::$blocks !== null) {
            return static::$blocks;
        }

        $blocks = collect(glob(app_path('Blocks/Types/*.php')))
            ->map(fn (string $file) => 'App\\Blocks\\Types\\'.Str::before(basename($file), '.php'))
            ->filter(fn (string $class) => is_subclass_of($class, BlockType::class))
            ->sortBy(fn (string $class) => [$class::sort(), $class::label()])
            ->mapWithKeys(fn (string $class) => [$class::name() => $class]);

        return static::$blocks = $blocks->all();
    }

    /** @return array<Block> */
    public static function filamentBlocks(): array
    {
        return array_values(array_map(fn (string $block) => $block::make(), static::all()));
    }

    public static function view(string $type): ?string
    {
        $block = static::all()[$type] ?? null;

        return $block ? $block::view() : null;
    }
}
