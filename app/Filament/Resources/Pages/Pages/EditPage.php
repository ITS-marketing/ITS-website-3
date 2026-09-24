<?php

namespace App\Filament\Resources\Pages\Pages;

use App\Filament\Resources\Pages\PageResource;
use App\Http\Controllers\PageController;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\View;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Illuminate\Support\Facades\Cache;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

    public ?string $previewHash = null;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('view')
                ->label('Bekijk pagina')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->color('gray')
                ->url(fn () => $this->record->url(), shouldOpenInNewTab: true),
            DeleteAction::make(),
        ];
    }

    public function getMaxContentWidth(): Width
    {
        return Width::Full;
    }

    public function content(Schema $schema): Schema
    {
        return $schema->components([
            // Preview links: de blok-editor (slide-over) opent rechts over het formulier.
            Grid::make(['default' => 1, '2xl' => 2])->schema([
                View::make('filament.page-preview'),
                $this->getFormContentComponent(),
            ]),
        ]);
    }

    /**
     * Bij elke render (typen, blok toevoegen/slepen/verwijderen) de actuele
     * formulierstaat in de cache zetten, zodat de preview-iframe kan verversen.
     * (rendering i.p.v. dehydrate: in Livewire 4 zijn events bij dehydrate al verzameld.)
     */
    public function rendering(): void
    {
        $data = $this->previewData();

        $state = $this->normalizePreviewState([
            'title' => $data['title'] ?? null,
            'blocks' => $data['blocks'] ?? [],
        ]);

        $hash = md5(serialize($state));

        if ($hash === $this->previewHash) {
            return;
        }

        Cache::put(PageController::previewKey($this->record), $state, now()->addHours(2));

        // Eerste render: iframe laadt zelf al, dus alleen bij echte wijzigingen verversen.
        if ($this->previewHash !== null) {
            $this->dispatch('page-preview-updated');
        }

        $this->previewHash = $hash;
    }

    /**
     * Formulierdata zoals die opgeslagen zou worden (bv. RichEditor-JSON -> HTML),
     * maar zonder validatie en zonder uploads weg te schrijven.
     */
    protected function previewData(): array
    {
        return rescue(function () {
            $state = ['data' => $this->data];
            $this->form->dehydrateState($state);
            $this->form->mutateDehydratedState($state);

            $data = $state['data'] ?? [];

            // Staat er een blok open in de slide-over? Dan de nog niet bevestigde invoer meenemen.
            // Na dehydratie is `blocks` een lijst; de uuid van het item vertalen we naar zijn positie.
            $positions = array_flip(array_keys($this->data['blocks'] ?? []));

            foreach ($this->mountedActions as $index => $mounted) {
                $uuid = $mounted['arguments']['item'] ?? '';
                $item = isset($data['blocks'][$uuid]) ? $uuid : ($positions[$uuid] ?? null);

                if (($mounted['name'] ?? null) !== 'edit' || $item === null || ! isset($data['blocks'][$item])) {
                    continue;
                }

                $schema = $this->getSchema("mountedActionSchema{$index}");
                $actionState = ['mountedActions' => $this->mountedActions];
                $schema?->dehydrateState($actionState);
                $schema?->mutateDehydratedState($actionState);

                $data['blocks'][$item]['data'] = data_get($actionState, "mountedActions.{$index}.data")
                    ?? $mounted['data']
                    ?? $data['blocks'][$item]['data'];
            }

            return $data;
        }, fn () => $this->data ?? [], report: false);
    }

    /** Tijdelijke uploads omzetten naar een URL, zodat ze in de preview te zien zijn. */
    protected function normalizePreviewState(array $state): array
    {
        array_walk_recursive($state, function (&$value) {
            if ($value instanceof TemporaryUploadedFile) {
                $value = rescue(fn () => $value->temporaryUrl(), null, false);
            }
        });

        return $state;
    }
}
