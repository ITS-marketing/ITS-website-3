<?php

namespace App\Blocks\Types;

use App\Blocks\BlockType;
use App\Blocks\Fields;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;

/** Blok 03: "Zo laten wij [iedereen] van ICT houden" — doelgroep-tabs met laptop-mockup. */
class AudienceTabs extends BlockType
{
    public static function name(): string
    {
        return 'audience_tabs';
    }

    public static function label(): string
    {
        return 'Doelgroep-tabs';
    }

    public static function icon(): string
    {
        return 'heroicon-o-user-group';
    }

    public static function sort(): int
    {
        return 30;
    }

    public static function schema(): array
    {
        return [
            Tabs::make()->tabs([
                Tab::make('Kop')->schema([
                    TextInput::make('eyebrow')->label('Eyebrow (klein kopje)'),
                    Grid::make(2)->schema([
                        TextInput::make('title_prefix')->label('Titel vóór het woord')->placeholder('Zo laten wij'),
                        TextInput::make('title_suffix')->label('Titel na het woord')->placeholder('van ICT houden'),
                    ]),
                    Repeater::make('rotating_words')
                        ->label('Wisselende woorden')
                        ->simple(TextInput::make('word')->required())
                        ->defaultItems(0)
                        ->reorderable(),
                    TextInput::make('rotate_interval_ms')
                        ->label('Wissel-interval (ms)')
                        ->numeric()
                        ->minValue(1000)
                        ->default(2800),
                    Select::make('default_tab')
                        ->label('Start-tab')
                        ->helperText('Leeg = eerste tab.')
                        ->options(fn (Get $get): array => collect($get('tabs') ?? [])
                            ->pluck('label')
                            ->filter()
                            ->mapWithKeys(fn ($label) => [$label => $label])
                            ->all()),
                    Fields::anchor(),
                ]),
                Tab::make('Tabs')->schema([
                    Repeater::make('tabs')
                        ->label('Tabs')
                        ->schema([
                            Grid::make(2)->schema([
                                TextInput::make('label')->label('Tab-label')->required()->live(onBlur: true),
                                Select::make('mockup_color')
                                    ->label('Mockup-kleur')
                                    ->options(['primary' => 'Blauw (primary)', 'blue' => 'Donkerblauw', 'dark' => 'Navy (dark)'])
                                    ->default('primary')
                                    ->selectablePlaceholder(false),
                            ]),
                            TextInput::make('title')->label('Titel')->required(),
                            Textarea::make('description')->label('Beschrijving')->rows(3),
                            Fields::bullets(),
                            Fields::button('link', 'Link'),
                            Fields::stats(),
                            Repeater::make('mockup_kpis')
                                ->label('KPI\'s in de mockup')
                                ->helperText('Max. 3. Leeg = waarden uit de statistieken.')
                                ->simple(TextInput::make('value')->required())
                                ->maxItems(3)
                                ->defaultItems(0),
                            Fields::image('image', 'Afbeelding (vervangt de CSS-mockup)'),
                        ])
                        ->collapsible()
                        ->defaultItems(0)
                        ->itemLabel(fn (array $state) => $state['label'] ?? null),
                ]),
            ])->columnSpanFull(),
        ];
    }
}
