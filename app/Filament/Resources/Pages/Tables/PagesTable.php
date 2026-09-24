<?php

namespace App\Filament\Resources\Pages\Tables;

use App\Models\Page;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Titel')->searchable()->sortable(),
                TextColumn::make('slug')->color('gray'),
                IconColumn::make('is_home')->label('Home')->boolean(),
                IconColumn::make('is_published')->label('Gepubliceerd')->boolean(),
                TextColumn::make('updated_at')->label('Gewijzigd')->since()->sortable(),
            ])
            ->defaultSort('updated_at', 'desc')
            ->recordActions([
                Action::make('view')
                    ->label('Bekijk')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(fn (Page $record) => $record->url(), shouldOpenInNewTab: true),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
