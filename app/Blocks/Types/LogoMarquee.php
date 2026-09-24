<?php

namespace App\Blocks\Types;

use App\Blocks\BlockType;
use App\Blocks\Fields;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;

class LogoMarquee extends BlockType
{
    public static function name(): string
    {
        return 'logo_marquee';
    }

    public static function label(): string
    {
        return 'Logo-marquee';
    }

    public static function icon(): string
    {
        return 'heroicon-o-building-office-2';
    }

    public static function sort(): int
    {
        return 20;
    }

    public static function schema(): array
    {
        return [
            TextInput::make('title')->label('Titel'),
            Grid::make(3)->schema([
                TextInput::make('speed')
                    ->label('Duur van één ronde (seconden)')
                    ->numeric()
                    ->minValue(5)
                    ->default(45),
                Select::make('direction')
                    ->label('Richting')
                    ->options(['reverse' => 'Naar rechts (origineel)', 'normal' => 'Naar links'])
                    ->default('reverse')
                    ->selectablePlaceholder(false),
                Fields::anchor(),
            ]),
            Repeater::make('logos')
                ->label('Logo\'s')
                ->schema([
                    TextInput::make('name')->label('Naam')->required(),
                    TextInput::make('url')->label('Link (optioneel)')->url(),
                    Fields::image('image', 'Logo (optioneel)')
                        ->helperText('Wordt grijs getoond, in kleur bij hover. Zonder logo: grijs placeholder-blok.'),
                    TextInput::make('width')
                        ->label('Breedte placeholder (px)')
                        ->numeric()
                        ->minValue(24)
                        ->maxValue(240)
                        ->helperText('Alleen zonder logo. Leeg = op basis van de naam.'),
                ])
                ->columns(2)
                ->defaultItems(0)
                ->reorderable()
                ->collapsible()
                ->collapsed()
                ->itemLabel(fn (array $state) => $state['name'] ?? null),
        ];
    }
}
