# IT Synergy CMS

Laravel 12 + Filament 5 blokken-CMS. Frontend: Blade, Tailwind CSS v4 en vanilla JS (Vite).

## Installatie

```bash
composer install
npm install
cp .env.example .env && php artisan key:generate
php artisan migrate
php artisan storage:link
php artisan db:seed      # admin, media (database/seeders/media), instellingen en homepage
npm run build            # of: npm run dev
php artisan serve
```

- Site: http://127.0.0.1:8000
- Admin: http://127.0.0.1:8000/admin (lokaal: `admin@it-synergy.test` / `password`, of zet `ADMIN_EMAIL`/`ADMIN_PASSWORD` in `.env` vóór het seeden)

## Structuur

| Onderdeel | Waar |
|---|---|
| Bloktypes (admin-velden) | `app/Blocks/Types/*.php` (automatisch ontdekt; nieuw blok = class hier + view in `resources/views/blocks`) |
| Blok-views (frontend) | `resources/views/blocks/{name}.blade.php` |
| Blok-JS | `resources/js/blocks/{name}.js` (automatisch geladen) |
| Gedeelde veldgroepen | `app/Blocks/Fields.php` |
| Gedeelde componenten | `resources/views/components/` (`x-container`, `x-heading`, `x-button`, `x-lucide`) |
| Generieke JS | `resources/js/core/` (header, fade-in, tabs, slider, accordion) |
| Header, footer | `resources/views/partials/`, inhoud via **Site-instellingen** in de admin |
| Pagina-editor + live preview | `app/Filament/Resources/Pages/` |
| Design tokens | `resources/css/app.css` |

## Editor

- Blokken zijn versleepbaar, te klonen en te verwijderen. Een blok bewerk je door erop te klikken (slide-over).
- De live preview (links) toont de pagina met de nog **niet opgeslagen** wijzigingen, ook terwijl je in de slide-over typt. Er is een desktop- en een mobiele weergave.
