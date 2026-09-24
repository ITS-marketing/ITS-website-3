<?php

namespace App\Blocks\Types;

use App\Blocks\BlockType;
use App\Blocks\Fields;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;

class CtaCard extends BlockType
{
    public static function name(): string
    {
        return 'cta_card';
    }

    public static function label(): string
    {
        return 'Afsluitende CTA-kaart';
    }

    public static function icon(): string
    {
        return 'heroicon-o-megaphone';
    }

    public static function sort(): int
    {
        return 110;
    }

    public static function schema(): array
    {
        return [
            Grid::make(2)->schema([
                Fields::image('background_image', 'Achtergrondfoto'),
                Fields::image('icon_image', 'Beeldmerk (klein, boven de titel)'),
            ]),
            Textarea::make('title')->label('Titel (Enter = regelbreuk)')->rows(2)->required(),
            Textarea::make('body')->label('Tekst (Enter = regelbreuk)')->rows(2),
            Fields::button('button', 'Knop (volle breedte)'),
            Fields::toggle('show_contact', 'Toon contactgegevens (telefoon + e-mail uit de site-instellingen)'),
            Repeater::make('logos')
                ->label("Logo's onderaan")
                ->schema([
                    Fields::image('image', 'Logo')->required(),
                    TextInput::make('alt')->label('Alt-tekst')->required(),
                ])
                ->columns(2)
                ->defaultItems(0)
                ->reorderable()
                ->collapsible()
                ->itemLabel(fn (array $state) => $state['alt'] ?? null),
            Fields::anchor(),
        ];
    }
}
