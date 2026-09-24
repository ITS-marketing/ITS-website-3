<?php

namespace App\Blocks\Types;

use App\Blocks\BlockType;
use App\Blocks\Fields;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

/** Blok 05: diensten met filter-tabs ("Alles wat jouw IT nodig heeft"). */
class ServicesFilter extends BlockType
{
    public static function name(): string
    {
        return 'services_filter';
    }

    public static function label(): string
    {
        return 'Diensten met filter-tabs';
    }

    public static function icon(): string
    {
        return 'heroicon-o-squares-2x2';
    }

    public static function sort(): int
    {
        return 50;
    }

    public static function schema(): array
    {
        return [
            Tabs::make()->tabs([
                Tab::make('Kop')->schema([
                    Fields::heading(),
                    TextInput::make('all_tab_label')->label('Label tab "alle"')->default('Alle oplossingen'),
                    Fields::button('footer_button', 'Knop onder de diensten'),
                    Fields::anchor(),
                ]),
                Tab::make('Kaarten (alle)')->schema([
                    Repeater::make('cards')
                        ->label('Kaarten')
                        ->schema([
                            Grid::make(3)->schema([
                                Fields::emoji(),
                                TextInput::make('category')->label('Categorie')->columnSpan(2),
                            ]),
                            TextInput::make('title')->label('Titel')->required(),
                            Textarea::make('text')->label('Tekst')->rows(2),
                            Fields::bullets(),
                            Fields::button('link', 'Link'),
                        ])
                        ->collapsible()
                        ->collapsed()
                        ->defaultItems(0)
                        ->itemLabel(fn (array $state) => trim(($state['emoji'] ?? '').' '.($state['title'] ?? '')) ?: null),
                ]),
                Tab::make('Categorieën')->schema([
                    Repeater::make('categories')
                        ->label('Categorieën (één tab per categorie)')
                        ->schema([
                            Grid::make(3)->schema([
                                TextInput::make('tab_label')->label('Tab-label (incl. emoji)')->required(),
                                Fields::emoji(),
                                TextInput::make('category')->label('Categorie-label'),
                            ]),
                            Textarea::make('headline')->label('Headline')->rows(2)->helperText('Enter = regelbreuk.'),
                            Fields::image('image', 'Detail-afbeelding'),
                            Fields::button('cta', 'Knop'),
                            self::subItems('sub_grid', 'Tegels (2 kolommen)'),
                            self::subItems('sub_list', 'Lijst'),
                        ])
                        ->collapsible()
                        ->collapsed()
                        ->defaultItems(0)
                        ->itemLabel(fn (array $state) => $state['tab_label'] ?? null),
                ]),
            ])->columnSpanFull(),
        ];
    }

    protected static function subItems(string $name, string $label): Repeater
    {
        return Repeater::make($name)
            ->label($label)
            ->schema([
                Grid::make(3)->schema([
                    Fields::emoji(),
                    TextInput::make('title')->label('Titel')->required()->columnSpan(2),
                ]),
                Textarea::make('description')->label('Beschrijving')->rows(2),
                TextInput::make('url')->label('Link')->placeholder('/online-werkplek'),
            ])
            ->collapsible()
            ->collapsed()
            ->defaultItems(0)
            ->itemLabel(fn (array $state) => trim(($state['emoji'] ?? '').' '.($state['title'] ?? '')) ?: null);
    }
}
