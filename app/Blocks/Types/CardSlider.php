<?php

namespace App\Blocks\Types;

use App\Blocks\BlockType;
use App\Blocks\Fields;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;

/** Blok 09: "Misschien is dit ook iets voor jou" — slider met fotokaarten. */
class CardSlider extends BlockType
{
    public static function name(): string
    {
        return 'card_slider';
    }

    public static function label(): string
    {
        return 'Kaarten-slider';
    }

    public static function icon(): string
    {
        return 'heroicon-o-rectangle-stack';
    }

    public static function sort(): int
    {
        return 90;
    }

    public static function schema(): array
    {
        return [
            Fields::heading(),
            Grid::make(2)->schema([
                Fields::background(),
                TextInput::make('read_more_label')->label('Tekst "lees meer"')->default('Lees meer'),
            ]),
            Repeater::make('cards')
                ->label('Kaarten')
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('category')->label('Categorie'),
                        TextInput::make('title')->label('Titel')->required(),
                        TextInput::make('url')->label('Link')->placeholder('/over-ons')->columnSpanFull(),
                    ]),
                    Fieldset::make('Beeld')->columns(2)->schema([
                        Fields::image('image')
                            ->helperText('Leeg laten = kleurverloop hieronder.')
                            ->columnSpanFull(),
                        ColorPicker::make('gradient_from')->label('Verloop van')->hex(),
                        ColorPicker::make('gradient_to')->label('Verloop naar')->hex(),
                    ]),
                ])
                ->defaultItems(0)
                ->collapsible()
                ->collapsed()
                ->itemLabel(fn (array $state) => $state['title'] ?? null),
            Fields::anchor(),
        ];
    }
}
