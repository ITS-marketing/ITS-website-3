<?php

namespace App\Blocks\Types;

use App\Blocks\BlockType;
use App\Blocks\Fields;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;

/** Blok 06: donkere proces-slider met genummerde stappen per fase. */
class ProcessSlider extends BlockType
{
    public static function name(): string
    {
        return 'process_slider';
    }

    public static function label(): string
    {
        return 'Proces-slider';
    }

    public static function icon(): string
    {
        return 'heroicon-o-arrow-path';
    }

    public static function sort(): int
    {
        return 60;
    }

    public static function schema(): array
    {
        return [
            Tabs::make('process_slider_tabs')->tabs([
                Tab::make('Inhoud')->schema([
                    Fields::heading(),
                    Fields::button('link', 'Link naast de kop'),
                    Fields::anchor(),
                ]),

                Tab::make('Fasen')->schema([
                    Repeater::make('phases')
                        ->label('Fasen')
                        ->schema([
                            TextInput::make('name')->label('Naam')->required()->live(onBlur: true),
                            ColorPicker::make('color')->label('Kleur')->hex()->default('#0072CC'),
                        ])
                        ->columns(2)
                        ->defaultItems(0)
                        ->collapsible()
                        ->itemLabel(fn (array $state) => $state['name'] ?? null),
                ]),

                Tab::make('Stappen')->schema([
                    Repeater::make('steps')
                        ->label('Stappen')
                        ->schema([
                            Grid::make(2)->schema([
                                TextInput::make('label')->label('Label (pill linksboven)')->required(),
                                Select::make('phase')
                                    ->label('Fase')
                                    ->options(fn (Get $get) => collect($get('../../phases') ?? [])
                                        ->pluck('name')
                                        ->filter()
                                        ->unique()
                                        ->mapWithKeys(fn ($name) => [$name => $name])
                                        ->all()),
                            ]),
                            Fields::image('image'),
                            TextInput::make('title')->label('Titel')->required(),
                            Textarea::make('text')->label('Tekst')->rows(3),
                            TextInput::make('loop_badge')
                                ->label('Herhaal-badge (optioneel)')
                                ->placeholder('Cyclus herhaalt vanaf stap 4'),
                        ])
                        ->defaultItems(0)
                        ->collapsible()
                        ->collapsed()
                        ->itemLabel(fn (array $state) => trim(($state['label'] ?? '').' — '.($state['title'] ?? ''), ' —') ?: null),
                ]),
            ]),
        ];
    }
}
