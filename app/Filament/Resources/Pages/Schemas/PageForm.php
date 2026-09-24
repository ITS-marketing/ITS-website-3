<?php

namespace App\Filament\Resources\Pages\Schemas;

use App\Blocks\BlockRegistry;
use Filament\Actions\Action;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Illuminate\Support\Str;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Pagina')
                    ->columns(2)
                    ->collapsible()
                    ->schema([
                        TextInput::make('title')
                            ->label('Titel')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (?string $state, ?string $old, Set $set, Get $get) {
                                // Slug automatisch meenemen zolang die nog niet handmatig is aangepast.
                                if (blank($get('slug')) || $get('slug') === Str::slug($old)) {
                                    $set('slug', Str::slug($state));
                                }
                            }),
                        TextInput::make('slug')
                            ->required()
                            ->alphaDash()
                            ->unique(ignoreRecord: true),
                        Toggle::make('is_published')->label('Gepubliceerd'),
                        Toggle::make('is_home')->label('Homepage'),
                    ]),

                Section::make('SEO')
                    ->collapsed()
                    ->schema([
                        TextInput::make('meta_title')->label('Meta title')->maxLength(70),
                        Textarea::make('meta_description')->label('Meta description')->rows(2)->maxLength(160),
                    ]),

                Builder::make('blocks')
                    ->label('Blokken')
                    ->blocks(BlockRegistry::filamentBlocks())
                    ->blockPickerColumns(2)
                    ->addActionLabel('Blok toevoegen')
                    ->reorderableWithDragAndDrop()
                    ->cloneable()
                    ->blockNumbers(false)
                    // Previews i.p.v. alle velden inline: houdt de editor licht (anders MB's aan HTML).
                    // Bewerken gebeurt in een slide-over; de live preview blijft links zichtbaar.
                    ->blockPreviews()
                    ->editAction(fn (Action $action) => $action
                        // Standaard vult Filament de modal met de ruwe state; Repeater::simple()-items
                        // worden dan dubbel ingepakt ("[object Object]"). Daarom: gedehydrateerde data.
                        ->fillForm(function (array $arguments, Builder $component): array {
                            $schema = $component->getChildSchema($arguments['item']);
                            $state = ['data' => $component->getLivewire()->data];
                            $schema->dehydrateState($state);
                            $schema->mutateDehydratedState($state);

                            return data_get($state, $schema->getStatePath()) ?? [];
                        })
                        ->slideOver()
                        ->modalWidth(Width::TwoExtraLarge)
                        ->closeModalByClickingAway(false)
                        ->extraModalWindowAttributes(['class' => 'its-block-editor'])),
            ]);
    }
}
