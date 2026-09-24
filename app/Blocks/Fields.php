<?php

namespace App\Blocks;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;

/**
 * Herbruikbare veldgroepen, zodat alle blokken dezelfde datastructuur gebruiken.
 */
class Fields
{
    /** eyebrow / title / intro — gebruik in Blade: <x-heading :data="$data" /> */
    public static function heading(bool $intro = true): Grid
    {
        return Grid::make(2)->schema(array_filter([
            TextInput::make('eyebrow')->label('Eyebrow (klein kopje)'),
            TextInput::make('title')->label('Titel')->required(),
            $intro ? Textarea::make('intro')->label('Intro')->rows(2)->columnSpanFull() : null,
        ]));
    }

    /** Knop: {name}.label, {name}.url — gebruik in Blade: <x-button :button="$data['button'] ?? null" /> */
    public static function button(string $name = 'button', string $label = 'Knop'): Fieldset
    {
        return Fieldset::make($label)
            ->columns(2)
            ->schema([
                TextInput::make("{$name}.label")->label('Tekst'),
                TextInput::make("{$name}.url")->label('Link')->placeholder('/contact'),
            ]);
    }

    public static function image(string $name = 'image', string $label = 'Afbeelding'): FileUpload
    {
        return FileUpload::make($name)
            ->label($label)
            ->image()
            ->disk('public')
            ->directory('media')
            ->imageEditor();
    }

    public static function emoji(string $name = 'emoji'): TextInput
    {
        return TextInput::make($name)->label('Emoji')->maxLength(16);
    }

    /** Eenvoudige opsomming (bullets) als lijst van strings. */
    public static function bullets(string $name = 'bullets', string $label = 'Opsomming'): Repeater
    {
        return Repeater::make($name)
            ->label($label)
            ->simple(TextInput::make('text')->required())
            ->defaultItems(0)
            ->reorderable();
    }

    /** Statistieken: value + label. */
    public static function stats(string $name = 'stats'): Repeater
    {
        return Repeater::make($name)
            ->label('Statistieken')
            ->schema([
                TextInput::make('value')->label('Waarde')->required(),
                TextInput::make('label')->label('Label')->required(),
            ])
            ->columns(2)
            ->defaultItems(0)
            ->collapsible();
    }

    public static function richText(string $name = 'body', string $label = 'Tekst'): RichEditor
    {
        return RichEditor::make($name)
            ->label($label)
            ->toolbarButtons([['bold', 'italic', 'link'], ['bulletList', 'orderedList'], ['undo', 'redo']]);
    }

    /** Achtergrond-variant die meerdere blokken delen. */
    public static function background(array $options = ['white' => 'Wit', 'gray' => 'Lichtgrijs']): Select
    {
        return Select::make('background')
            ->label('Achtergrond')
            ->options($options)
            ->default(array_key_first($options))
            ->selectablePlaceholder(false);
    }

    public static function anchor(): TextInput
    {
        return TextInput::make('anchor')->label('Anker-ID (optioneel)')->alphaDash();
    }

    public static function toggle(string $name, string $label, bool $default = true): Toggle
    {
        return Toggle::make($name)->label($label)->default($default);
    }
}
