<?php

namespace App\Blocks\Types;

use App\Blocks\BlockType;
use App\Blocks\Fields;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

class CertsPartners extends BlockType
{
    public static function name(): string
    {
        return 'certs_partners';
    }

    public static function label(): string
    {
        return 'Keurmerken & partners';
    }

    public static function icon(): string
    {
        return 'heroicon-o-check-badge';
    }

    public static function sort(): int
    {
        return 80;
    }

    public static function schema(): array
    {
        return [
            Tabs::make()->tabs([
                Tab::make('Keurmerken (links)')->schema([
                    TextInput::make('certs_eyebrow')->label('Eyebrow (klein kopje)'),
                    TextInput::make('certs_title')->label('Titel'),
                    Textarea::make('certs_body')->label('Tekst')->rows(2),
                    Repeater::make('certificates')
                        ->label('Certificaten')
                        ->schema([
                            Fields::image('logo', 'Logo')->directory('media/certs')->required(),
                            TextInput::make('alt')->label('Alt-tekst')->required(),
                        ])
                        ->columns(2)
                        ->defaultItems(0)
                        ->reorderable()
                        ->collapsible()
                        ->itemLabel(fn (array $state) => $state['alt'] ?? null),
                ]),
                Tab::make('Partners (rechts)')->schema([
                    TextInput::make('partners_eyebrow')->label('Eyebrow (klein kopje)'),
                    TextInput::make('partners_title')->label('Titel'),
                    Textarea::make('partners_body')->label('Tekst')->rows(2),
                    Repeater::make('partners')
                        ->label('Partners')
                        ->schema([
                            TextInput::make('name')->label('Naam')->required(),
                            TextInput::make('url')->label('Link (optioneel)')->placeholder('/partners/autotask'),
                            Fields::image('logo', 'Logo/icoon (optioneel, anders Microsoft-placeholder)')
                                ->directory('media/partners')
                                ->columnSpanFull(),
                        ])
                        ->columns(2)
                        ->defaultItems(0)
                        ->reorderable()
                        ->collapsible()
                        ->itemLabel(fn (array $state) => $state['name'] ?? null),
                    Fields::button('button', 'Primaire knop'),
                    Fields::button('secondary_button', 'Secundaire link'),
                ]),
                Tab::make('Instellingen')->schema([
                    Fields::anchor(),
                ]),
            ])->columnSpanFull(),
        ];
    }
}
