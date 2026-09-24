<?php

namespace App\Blocks\Types;

use App\Blocks\BlockType;
use App\Blocks\Fields;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;

class Hero extends BlockType
{
    public static function name(): string
    {
        return 'hero';
    }

    public static function label(): string
    {
        return 'Hero';
    }

    public static function icon(): string
    {
        return 'heroicon-o-sparkles';
    }

    public static function sort(): int
    {
        return 10;
    }

    public static function schema(): array
    {
        return [
            Tabs::make('hero')->tabs([
                Tab::make('Inhoud')->schema([
                    Grid::make(4)->schema([
                        Fields::emoji('badge_emoji')->label('Badge-emoji'),
                        TextInput::make('badge_text')->label('Badge-tekst')->columnSpan(3),
                    ]),
                    Textarea::make('title')
                        ->label('Titel (H1)')
                        ->rows(3)
                        ->required()
                        ->helperText('Elke Enter is een regel. Met "slimme regelbreuken" aan: mobiel alleen een breuk na regel 1, desktop alleen vóór de laatste regel.'),
                    Fields::toggle('title_responsive_breaks', 'Slimme regelbreuken (zoals origineel)'),
                    RichEditor::make('body')
                        ->label('Tekst')
                        ->toolbarButtons([['bold', 'italic', 'underline', 'link'], ['undo', 'redo']]),
                    Fields::bullets('stats', 'Kenmerken met vinkje (alleen desktop)'),
                    Repeater::make('trust_labels')
                        ->label('Keurmerk-labels (alleen desktop)')
                        ->schema([
                            Fields::emoji(),
                            TextInput::make('text')->label('Tekst')->required()->columnSpan(3),
                        ])
                        ->columns(4)
                        ->defaultItems(0)
                        ->collapsible()
                        ->itemLabel(fn (array $state) => trim(($state['emoji'] ?? '').' '.($state['text'] ?? '')) ?: null),
                    Fields::anchor(),
                ]),

                Tab::make('Knoppen')->schema([
                    Fieldset::make('Primaire knop (oranje)')
                        ->columns(3)
                        ->schema([
                            TextInput::make('primary_button.label')->label('Tekst'),
                            TextInput::make('primary_button.url')->label('Link')->placeholder('/contact'),
                            Fields::emoji('primary_button.emoji')->label('Emoji (vanaf tablet)'),
                        ]),
                    Fields::button('secondary_button', 'Secundaire knop (tekstlink)'),
                    Fieldset::make('"Scroll verder"-knop')
                        ->columns(2)
                        ->schema([
                            Fields::toggle('show_scroll_button', 'Tonen'),
                            TextInput::make('scroll_button_label')->label('Tekst')->default('Scroll verder'),
                        ]),
                ]),

                Tab::make('Quicklinks')->schema([
                    Repeater::make('quicklinks')
                        ->label('Quicklinks (max. 3)')
                        ->schema([
                            Fields::emoji(),
                            TextInput::make('title')->label('Titel')->required()->columnSpan(3),
                            TextInput::make('subtitle')->label('Subtitel (niet op mobiel)')->columnSpan(2),
                            TextInput::make('url')->label('Link')->required()->placeholder('/support')->columnSpan(2),
                        ])
                        ->columns(4)
                        ->maxItems(3)
                        ->defaultItems(0)
                        ->collapsible()
                        ->itemLabel(fn (array $state) => trim(($state['emoji'] ?? '').' '.($state['title'] ?? '')) ?: null),
                ]),

                Tab::make('Fotostrip')->schema([
                    TextInput::make('photo_strip_speed')
                        ->label('Snelheid (px per frame)')
                        ->numeric()
                        ->minValue(0)
                        ->step(0.1)
                        ->default(0.7)
                        ->helperText('0 = stilstaand. Origineel: 0.7'),
                    Repeater::make('photo_strip')
                        ->label('Foto\'s en video\'s')
                        ->schema([
                            Fields::image()->required()->columnSpanFull(),
                            TextInput::make('alt')->label('Alt-tekst'),
                            TextInput::make('caption')->label('Onderschrift'),
                            TextInput::make('width')
                                ->label('Breedte (px bij 520px hoog)')
                                ->numeric()
                                ->minValue(120)
                                ->maxValue(1200)
                                ->default(520),
                            TextInput::make('rotation')
                                ->label('Rotatie bij hover (graden)')
                                ->numeric()
                                ->step(0.1)
                                ->default(1),
                            Select::make('type')
                                ->label('Type')
                                ->options(['photo' => 'Foto', 'video' => 'Video'])
                                ->default('photo')
                                ->selectablePlaceholder(false)
                                ->live(),
                            TextInput::make('video_url')
                                ->label('Video-URL (YouTube, Vimeo of .mp4)')
                                ->url()
                                ->helperText('Leeg = nette placeholder in de modal.')
                                ->visible(fn (Get $get) => $get('type') === 'video'),
                        ])
                        ->columns(2)
                        ->defaultItems(0)
                        ->reorderable()
                        ->collapsible()
                        ->collapsed()
                        ->itemLabel(fn (array $state) => ($state['caption'] ?? null) ?: ($state['alt'] ?? null)),
                ]),

                Tab::make('Achtergrond')->schema([
                    Fields::image('background_image', 'Achtergrondfoto')
                        ->helperText('Krijgt automatisch de blauwe overlay en een subtiel parallax-effect.'),
                ]),
            ])->contained(false),
        ];
    }
}
