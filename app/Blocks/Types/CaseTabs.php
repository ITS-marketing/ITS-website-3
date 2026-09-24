<?php

namespace App\Blocks\Types;

use App\Blocks\BlockType;
use App\Blocks\Fields;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

/** Blok 07: klantcases per branche (tabs met grote quote-kaart + stats). */
class CaseTabs extends BlockType
{
    public static function name(): string
    {
        return 'case_tabs';
    }

    public static function label(): string
    {
        return 'Klantcases (tabs)';
    }

    public static function icon(): string
    {
        return 'heroicon-o-chat-bubble-bottom-center-text';
    }

    public static function sort(): int
    {
        return 70;
    }

    public static function schema(): array
    {
        return [
            Tabs::make('case_tabs_tabs')->tabs([
                Tab::make('Inhoud')->schema([
                    Fields::heading(),
                    Grid::make(2)->schema([
                        TextInput::make('primary_label')->label('Tekst knop "case"')->default('Lees het hele verhaal'),
                        TextInput::make('secondary_label')->label('Tekst link "branche"')->default('Meer over deze branche'),
                    ]),
                    Fields::anchor(),
                ]),

                Tab::make('Cases')->schema([
                    Repeater::make('cases')
                        ->label('Cases')
                        ->schema([
                            Grid::make(2)->schema([
                                TextInput::make('tab')->label('Tab-label (branche)')->required(),
                                TextInput::make('client')->label('Klantnaam (label op kaart)'),
                            ]),
                            Textarea::make('quote')->label('Quote')->rows(2)->required(),
                            Grid::make(2)->schema([
                                TextInput::make('author')->label('Auteur'),
                                TextInput::make('role')->label('Rol (bv. "Directeur, KOERS")'),
                                TextInput::make('case_url')->label('Link naar case')->placeholder('/klantcases/...'),
                                TextInput::make('industry_url')->label('Link naar branche')->placeholder('/it-voor-...'),
                            ]),
                            Fieldset::make('Beeld')->columns(2)->schema([
                                Fields::image('image')
                                    ->helperText('Leeg laten = kleurverloop hieronder.')
                                    ->columnSpanFull(),
                                ColorPicker::make('gradient_from')->label('Verloop van')->hex(),
                                ColorPicker::make('gradient_to')->label('Verloop naar')->hex(),
                            ]),
                            Fields::stats(),
                        ])
                        ->defaultItems(0)
                        ->collapsible()
                        ->collapsed()
                        ->itemLabel(fn (array $state) => trim(($state['tab'] ?? '').' — '.($state['client'] ?? ''), ' —') ?: null),
                ]),
            ]),
        ];
    }
}
