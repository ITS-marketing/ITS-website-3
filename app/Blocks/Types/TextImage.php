<?php

namespace App\Blocks\Types;

use App\Blocks\BlockType;
use App\Blocks\Fields;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

class TextImage extends BlockType
{
    public static function name(): string
    {
        return 'text_image';
    }

    public static function label(): string
    {
        return 'Tekst + afbeelding';
    }

    public static function icon(): string
    {
        return 'heroicon-o-photo';
    }

    public static function sort(): int
    {
        return 120;
    }

    public static function schema(): array
    {
        return [
            Tabs::make()->tabs([
                Tab::make('Inhoud')->schema([
                    Fields::heading(intro: false),
                    Fields::richText(),
                    Fields::bullets('bullets', 'Opsomming (✅)'),
                    Fields::button('button', 'Primaire knop'),
                    Fields::button('secondary_button', 'Secundaire link'),
                ]),
                Tab::make('Afbeelding')->schema([
                    Fields::image(),
                    TextInput::make('image_alt')->label('Alt-tekst'),
                ]),
                Tab::make('Instellingen')->schema([
                    Grid::make(3)->schema([
                        Select::make('image_position')
                            ->label('Afbeelding')
                            ->options(['right' => 'Rechts', 'left' => 'Links'])
                            ->default('right')
                            ->selectablePlaceholder(false),
                        Fields::background(),
                        Fields::anchor(),
                    ]),
                ]),
            ])->columnSpanFull(),
        ];
    }
}
