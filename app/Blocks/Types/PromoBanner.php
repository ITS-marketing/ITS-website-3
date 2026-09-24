<?php

namespace App\Blocks\Types;

use App\Blocks\BlockType;
use App\Blocks\Fields;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;

/** Blok 04: promo-/webinarbanner (MQL). */
class PromoBanner extends BlockType
{
    public static function name(): string
    {
        return 'promo_banner';
    }

    public static function label(): string
    {
        return 'Promo-banner';
    }

    public static function icon(): string
    {
        return 'heroicon-o-megaphone';
    }

    public static function sort(): int
    {
        return 40;
    }

    public static function schema(): array
    {
        return [
            Grid::make(2)->schema([
                Fields::image('image', 'Afbeelding'),
                Grid::make(1)->schema([
                    TextInput::make('image_alt')->label('Alt-tekst afbeelding'),
                    Select::make('image_position')
                        ->label('Positie afbeelding')
                        ->options(['left' => 'Links', 'right' => 'Rechts'])
                        ->default('left')
                        ->selectablePlaceholder(false),
                ])->columnSpan(1),
            ]),
            Grid::make(2)->schema([
                TextInput::make('eyebrow')->label('Eyebrow (klein kopje)'),
                TextInput::make('title')->label('Titel')->required(),
                Textarea::make('body')->label('Tekst')->rows(3)->columnSpanFull(),
            ]),
            Fields::button('button', 'Primaire knop'),
            Fields::button('secondary_button', 'Secundaire link'),
            Fields::anchor(),
        ];
    }
}
