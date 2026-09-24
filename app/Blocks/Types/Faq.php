<?php

namespace App\Blocks\Types;

use App\Blocks\BlockType;
use App\Blocks\Fields;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;

class Faq extends BlockType
{
    public static function name(): string
    {
        return 'faq';
    }

    public static function label(): string
    {
        return 'FAQ';
    }

    public static function icon(): string
    {
        return 'heroicon-o-question-mark-circle';
    }

    public static function sort(): int
    {
        return 100;
    }

    public static function schema(): array
    {
        return [
            Fields::heading(),
            Fields::button('button', 'Knop (rechts naast de kop)'),
            Repeater::make('items')
                ->label('Vragen')
                ->schema([
                    TextInput::make('question')->label('Vraag')->required(),
                    Fields::richText('answer', 'Antwoord')->required(),
                ])
                ->defaultItems(0)
                ->reorderable()
                ->collapsible()
                ->itemLabel(fn (array $state) => $state['question'] ?? null),
            Grid::make(3)->schema([
                Fields::toggle('first_open', 'Eerste vraag standaard open'),
                Fields::toggle('schema', 'FAQ-schema (JSON-LD) voor Google'),
                Fields::anchor(),
            ]),
        ];
    }
}
