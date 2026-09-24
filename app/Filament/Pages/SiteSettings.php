<?php

namespace App\Filament\Pages;

use App\Blocks\Fields;
use App\Models\Setting;
use BackedEnum;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

/**
 * Site-brede instellingen: algemeen, contact, header (menu + mega menu) en footer.
 * Opgeslagen als key/value in `settings` (key = eerste niveau, bv. "header").
 */
class SiteSettings extends Page
{
    protected string $view = 'filament.pages.site-settings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?string $navigationLabel = 'Site-instellingen';

    protected static ?string $title = 'Site-instellingen';

    protected static ?int $navigationSort = 90;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(Setting::allCached());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Tabs::make()->persistTabInQueryString()->tabs([
                    Tab::make('Algemeen')->icon(Heroicon::OutlinedGlobeAlt)->schema([
                        Grid::make(2)->schema([
                            TextInput::make('general.site_name')->label('Sitenaam')->required(),
                            TextInput::make('general.meta_title')->label('Standaard meta title'),
                            Textarea::make('general.meta_description')->label('Standaard meta description')->rows(2)->columnSpanFull(),
                            Fields::image('general.logo', 'Logo (kleur)'),
                            Fields::image('general.logo_white', 'Logo (wit, footer)'),
                        ]),
                    ]),

                    Tab::make('Contact')->icon(Heroicon::OutlinedPhone)->schema([
                        Grid::make(2)->schema([
                            TextInput::make('contact.phone')->label('Telefoon (weergave)'),
                            TextInput::make('contact.phone_link')->label('Telefoon (link)')->placeholder('tel:+31…'),
                            TextInput::make('contact.email')->label('E-mail')->email(),
                            TextInput::make('contact.portal_url')->label('Klantportaal-URL'),
                            TextInput::make('contact.kvk')->label('KvK'),
                            TextInput::make('contact.btw')->label('BTW'),
                            TextInput::make('contact.iban')->label('IBAN'),
                        ]),
                    ]),

                    Tab::make('Header')->icon(Heroicon::OutlinedBars3)->schema([
                        Grid::make(2)->schema([
                            Fields::button('header.cta', 'Contactknop'),
                            Fields::button('header.mobile_cta', 'Knop onderaan mobiel menu'),
                            Toggle::make('header.show_language')->label('Taalkeuze tonen')->default(true),
                            Toggle::make('header.show_contrast')->label('Hoog-contrast-knop tonen')->default(true),
                        ]),
                        Repeater::make('header.nav')
                            ->label('Hoofdmenu')
                            ->collapsible()
                            ->collapsed()
                            ->itemLabel(fn (array $state) => trim(($state['emoji'] ?? '').' '.($state['label'] ?? '')))
                            ->schema([
                                Grid::make(4)->schema([
                                    TextInput::make('label')->label('Label')->required(),
                                    TextInput::make('url')->label('Link')->required(),
                                    Fields::emoji(),
                                    Select::make('group')
                                        ->label('Groep')
                                        ->helperText('Diensten staan op mobiel onder "Diensten".')
                                        ->options(['services' => 'Dienst', 'other' => 'Overig'])
                                        ->default('services')
                                        ->selectablePlaceholder(false),
                                ]),
                                Section::make('Mega menu')
                                    ->collapsed()
                                    ->schema([
                                        Grid::make(2)->schema([
                                            TextInput::make('tagline')->label('Tagline'),
                                            Select::make('columns')->label('Kolommen')->options([1 => '1', 2 => '2'])->default(2),
                                        ]),
                                        Repeater::make('items')
                                            ->label('Items')
                                            ->collapsible()
                                            ->collapsed()
                                            ->defaultItems(0)
                                            ->itemLabel(fn (array $state) => trim(($state['emoji'] ?? '').' '.($state['title'] ?? '')))
                                            ->schema([
                                                Grid::make(3)->schema([
                                                    Fields::emoji(),
                                                    TextInput::make('title')->label('Titel')->required(),
                                                    TextInput::make('url')->label('Link'),
                                                ]),
                                                TextInput::make('description')->label('Beschrijving'),
                                            ]),
                                        Fieldset::make('Uitgelichte kaart')->columns(2)->schema([
                                            TextInput::make('featured.category')->label('Categorie'),
                                            TextInput::make('featured.title')->label('Titel'),
                                            TextInput::make('featured.url')->label('Link'),
                                            Fields::image('featured.image', 'Afbeelding'),
                                        ]),
                                    ]),
                            ]),
                    ]),

                    Tab::make('Footer')->icon(Heroicon::OutlinedQueueList)->schema([
                        TextInput::make('footer.tagline')->label('Tagline'),
                        Repeater::make('footer.columns')
                            ->label('Linkkolommen')
                            ->collapsible()
                            ->collapsed()
                            ->grid(2)
                            ->itemLabel(fn (array $state) => $state['title'] ?? null)
                            ->schema([
                                TextInput::make('title')->label('Kop')->required(),
                                Repeater::make('links')
                                    ->label('Links')
                                    ->schema([
                                        TextInput::make('label')->label('Tekst')->required(),
                                        TextInput::make('url')->label('Link')->required(),
                                    ])
                                    ->columns(2),
                            ]),
                        Repeater::make('footer.socials')
                            ->label('Social media')
                            ->columns(3)
                            ->schema([
                                TextInput::make('short')->label('Afkorting')->placeholder('in')->maxLength(3)->required(),
                                TextInput::make('name')->label('Naam')->placeholder('LinkedIn')->required(),
                                TextInput::make('url')->label('URL')->url()->required(),
                            ]),
                        Repeater::make('footer.legal')
                            ->label('Juridische links')
                            ->columns(2)
                            ->collapsible()
                            ->schema([
                                TextInput::make('label')->label('Tekst')->required(),
                                TextInput::make('url')->label('Link')->required(),
                            ]),
                        TextInput::make('footer.copyright')
                            ->label('Copyright')
                            ->helperText(':year wordt vervangen door het huidige jaar.'),
                    ]),
                ]),
            ]);
    }

    public function save(): void
    {
        Setting::setMany($this->form->getState());

        Notification::make()->success()->title('Instellingen opgeslagen')->send();
    }
}
