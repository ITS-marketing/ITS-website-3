<?php

namespace App\Blocks\Types;

use App\Blocks\BlockType;
use App\Blocks\Fields;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;

class RichText extends BlockType
{
    public static function name(): string
    {
        return 'rich_text';
    }

    public static function label(): string
    {
        return 'Tekst';
    }

    public static function icon(): string
    {
        return 'heroicon-o-document-text';
    }

    public static function sort(): int
    {
        return 130;
    }

    public static function schema(): array
    {
        return [
            Grid::make(2)->schema([
                TextInput::make('eyebrow')->label('Eyebrow (optioneel)'),
                TextInput::make('title')->label('Titel (optioneel)'),
            ]),
            RichEditor::make('body')
                ->label('Tekst')
                ->toolbarButtons([
                    ['bold', 'italic', 'link'],
                    ['h2', 'h3'],
                    ['bulletList', 'orderedList'],
                    ['undo', 'redo'],
                ]),
            Grid::make(2)->schema([
                Select::make('width')
                    ->label('Breedte')
                    ->options(['narrow' => 'Smal (leesbreedte)', 'wide' => 'Breed (volle container)'])
                    ->default('narrow')
                    ->selectablePlaceholder(false),
                Fields::anchor(),
            ]),
        ];
    }
}
