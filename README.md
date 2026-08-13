# Humanity First Belgium – Volunteer Platform

Een data-driven Laravel webapplicatie voor Humanity First Belgium: publieke informatie over de organisatie (nieuws, FAQ, vrijwilligersprofielen), een besloten timeline voor ingelogde vrijwilligers, en een admin panel voor het beheer van alle content.

**Stack:** Laravel 12 · PHP 8.2+ · Blade · TailwindCSS · Vite · SQLite of MySQL

---

## Installatie

### 1) Project clonen

```bash
git clone <REPO_URL>
cd hfb-volenteer
```

### 2) Dependencies installeren

```bash
composer install
npm install
```

Vereiste PHP-extensies: `fileinfo`, `mbstring`, `openssl`, `curl`, `zip`, en `pdo_sqlite` (of `pdo_mysql`).

### 3) Environment instellen

```bash
cp .env.example .env
php artisan key:generate
```

**Database.** Het project werkt out of the box met SQLite. Maak daarvoor een leeg bestand aan:

```bash
touch database/database.sqlite
```

Wil je MySQL gebruiken, pas dan het `.env` bestand aan:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=YOUR_DB_NAME
DB_USERNAME=YOUR_DB_USER
DB_PASSWORD=YOUR_DB_PASSWORD
```

### 4) Storage link

Nodig voor het tonen van geüploade afbeeldingen (profielfoto's, nieuwsafbeeldingen, timeline-afbeeldingen):

```bash
php artisan storage:link
```

### 5) Database migreren en vullen

```bash
php artisan migrate:fresh --seed
```

### 6) Frontend assets bouwen

```bash
npm run build      # productie
# of
npm run dev        # development met hot reload
```

### 7) Server starten

```bash
php artisan serve
```

De site draait op http://127.0.0.1:8000

---

## Accounts

Alle seed-accounts gebruiken hetzelfde wachtwoord: `Password!321`

| Rol | Username | Email |
|---|---|---|
| **Admin** | admin | admin@ehb.be |
| Vrijwilliger | amina | amina@example.be |
| Vrijwilliger | tomv | tom@example.be |
| Vrijwilliger | fatima | fatima@example.be |
| *(en nog 5 andere vrijwilligers)* | | |

Werken de gegevens niet, run dan opnieuw `php artisan migrate:fresh --seed`.

---

## Pagina's

### Publiek (geen login nodig)

| Route | Beschrijving |
|---|---|
| `/` | Home: laatste nieuws, FAQ-preview, aanbevolen vrijwilligers |
| `/news` | Nieuwsoverzicht met featured artikel |
| `/news/{slug}` | Nieuwsdetail met reacties |
| `/faq` | FAQ, gegroepeerd per categorie |
| `/users` | Vrijwilligersoverzicht met zoekfunctie |
| `/users/{user}` | Publieke profielpagina |
| `/contact` | Contactformulier |

### Ingelogd

| Route | Beschrijving |
|---|---|
| `/dashboard` | Persoonlijk dashboard |
| `/profile` | Eigen profiel bewerken |
| `/timeline` | Timeline: posten, verwijderen, liken |

### Admin (login + admin-rechten)

| Route | Beschrijving |
|---|---|
| `/admin/dashboard` | Admin dashboard |
| `/admin/news` | Nieuws CRUD |
| `/admin/faq` | FAQ-categorieën en vragen beheren |
| `/admin/users` | Gebruikers CRUD + admin-rechten toekennen/afnemen |
| `/admin/contact-messages` | Contactberichten bekijken, filteren en beantwoorden |

---

## Functionele minimumvereisten

### Login systeem
- Registratie, login, logout en 'remember me'
- Wachtwoord reset via e-mail
- Twee rollen via de `is_admin` kolom: gewone gebruiker of admin
- Enkel admins kunnen andere gebruikers admin maken of die rechten afnemen (`POST /admin/users/{user}/toggle-admin`)
- Enkel admins kunnen manueel een gebruiker aanmaken, met de keuze om die meteen admin te maken
- Eén default admin wordt aangemaakt via `AdminUserSeeder`

### Profielpagina
- Elke vrijwilliger heeft een publieke profielpagina, ook zichtbaar voor niet-ingelogde bezoekers
- Een ingelogde gebruiker past zijn eigen gegevens aan via `/profile`
- Velden: username, verjaardag, profielfoto (opgeslagen op de server via `storage/app/public/avatars`) en een 'over mij' tekst

### Laatste nieuwtjes
- Admins voegen nieuwsitems toe, wijzigen en verwijderen ze
- Elke bezoeker ziet de lijst en het detail per nieuwtje
- Velden: titel, afbeelding (server), content, publicatiedatum
- URL's gebruiken een slug in plaats van een id

### FAQ pagina
- Vragen en antwoorden, gegroepeerd per categorie
- Admins beheren zowel de categorieën als de vraag/antwoord-items
- Elke bezoeker kan de FAQ raadplegen

### Contact pagina
- Elke bezoeker kan het contactformulier invullen
- Bij verzending ontvangt de admin een e-mail met de inhoud (`ContactFormSubmitted` mailable)
- Het bericht wordt ook opgeslagen in de database

---

## Extra features

### 1. Admin panel voor contactberichten
Alle ingezonden contactformulieren komen in een beheerpaneel terecht. Admins kunnen filteren op openstaand of beantwoord, een bericht in detail bekijken, en er rechtstreeks vanuit het panel op antwoorden. Bij het versturen van een antwoord wordt het bericht automatisch gemarkeerd als beantwoord, met registratie van het tijdstip en wie het afhandelde.

### 2. Reacties op nieuwsberichten
Ingelogde gebruikers plaatsen reacties onder een nieuwsartikel. Reacties tonen de avatar en gebruikersnaam van de auteur met een link naar diens profiel, plus een relatieve tijdsaanduiding. Een gebruiker kan zijn eigen reacties verwijderen, admins kunnen elke reactie verwijderen. Het aantal reacties is zichtbaar op het nieuwsoverzicht. Niet-ingelogde bezoekers lezen de reacties wel, maar krijgen een link naar de loginpagina in plaats van het formulier.

### 3. Timeline met posts
Een besloten tijdlijn waar ingelogde vrijwilligers berichten plaatsen, met optionele afbeelding. Gebruikers verwijderen hun eigen posts. Gepagineerd op 10 posts per pagina.

### 4. Like-systeem op de timeline
Gebruikers liken en unliken posts. De relatie is many-to-many via de `timeline_likes` pivot-tabel, met een unique constraint op `user_id` + `timeline_post_id` zodat dubbele likes onmogelijk zijn. Het aantal likes per post wordt geteld via `withCount`.

### 5. Zoekfunctie voor vrijwilligers
Op `/users` zoeken bezoekers op gebruikersnaam, naam of de 'over mij' tekst. De zoekterm blijft behouden bij paginering (`withQueryString`), het aantal resultaten wordt getoond, en er is een knop om de zoekopdracht te wissen. Ook op de homepage staat een zoekbalk die doorstuurt naar dit overzicht.

### 6. Aanbevolen vrijwilligers op de homepage
De homepage toont vier willekeurig geselecteerde vrijwilligers via `inRandomOrder()`. Bij elke refresh verschijnt een andere selectie, zodat bezoekers telkens andere profielen ontdekken.

### 7. Admin dashboard
Een apart overzichtspaneel voor beheerders met snelle toegang tot alle beheersmodules.

### 8. Volledig gebruikersbeheer
Naast het toekennen van admin-rechten kunnen admins gebruikers aanmaken, bewerken en verwijderen, met een eigen zoekfunctie op naam, username en e-mail.

### 9. FAQ met categoriebeheer en zichtbaarheid
Categorieën zijn apart beheerbaar en hebben een instelbare volgorde. Per vraag bepaalt een `is_public` vlag of die publiek zichtbaar is.

### 10. Uitgebreide seed-data
De database wordt gevuld met 8 vrijwilligers, 6 nieuwsberichten, reacties daarop, en 4 FAQ-categorieën met 14 vragen. Zo is de site meteen na installatie volledig bruikbaar.

---

## Technische invulling

### Views
- **Twee layouts:** `layouts/app.blade.php` voor de applicatie, `layouts/guest.blade.php` voor de authenticatiepagina's
- **Componenten:** onder meer een zelfgemaakte `x-volunteer-card` die hergebruikt wordt op de homepage én in het vrijwilligersoverzicht, naast de Breeze-componenten (`x-text-input`, `x-primary-button`, `x-nav-link`, `x-modal`, ...)
- **Control structures:** `@if`, `@auth`, `@forelse`, `@foreach`, `@php`
- **XSS-protection:** alle output via `{{ }}`, wat standaard escaped. Waar HTML nodig is (FAQ-antwoorden met regeleindes) wordt `nl2br(e($value))` gebruikt, dus escaping vóór het omzetten van newlines
- **CSRF-protection:** `@csrf` in elk POST/PUT/DELETE formulier
- **Client-side validatie:** `required`, `minlength`, `maxlength`, `type="email"` en `accept` op de formuliervelden

### Routes
- Alle routes verwijzen naar controller methods (uitgezonderd de homepage-closure)
- Gegroepeerd per toegangsniveau: publiek, `auth`, en `auth + admin`
- De admin-groep gebruikt een prefix `admin` en een name-prefix `admin.`
- Zelfgeschreven `AdminMiddleware`, geregistreerd als alias `admin` in `bootstrap/app.php`
- Route model binding, waaronder binding op slug voor nieuwsberichten

### Controllers
- Logica opgesplitst per entiteit
- Resource controllers voor CRUD: `Admin\NewsItemController` en `Admin\UserController`
- Autorisatiechecks in `NewsCommentController` (`abort_unless`) zodat enkel de auteur of een admin een reactie kan verwijderen

### Models en relaties
| Relatie | Type |
|---|---|
| `User` → `NewsItem` | one-to-many |
| `User` → `TimelinePost` | one-to-many |
| `User` → `NewsComment` | one-to-many |
| `NewsItem` → `NewsComment` | one-to-many |
| `FaqCategory` → `Faq` | one-to-many |
| `User` ↔ `TimelinePost` (likes) | many-to-many via `timeline_likes` |

### Database
- Werkt met `php artisan migrate:fresh --seed`
- Foreign keys met `cascadeOnDelete`
- Unique constraints op e-mail, username, nieuws-slug en de likes-pivot

---

## Mail configuratie

Het contactformulier en de reply-functie versturen e-mail. Voor lokaal testen volstaat de log-driver, waarbij mails in `storage/logs/laravel.log` terechtkomen:

```env
MAIL_MAILER=log
```

Voor echte verzending (bijvoorbeeld via Mailtrap):

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=...
MAIL_PASSWORD=...
MAIL_FROM_ADDRESS="noreply@hfb.local"
MAIL_FROM_NAME="Humanity First Belgium"
```

Het adres uit `MAIL_FROM_ADDRESS` ontvangt de contactformulieren.

---

## Bronvermeldingen

- Laravel documentatie — https://laravel.com/docs
- Laravel Breeze, gebruikt als basis voor de authenticatie-scaffolding (login, registratie, wachtwoord reset, profielpagina en de bijhorende Blade-componenten) — https://github.com/laravel/breeze
- TailwindCSS documentatie, voor de utility classes in alle views — https://tailwindcss.com/docs
- Laravel documentatie over file storage, voor de upload-afhandeling en `storage:link` — https://laravel.com/docs/filesystem
- Laravel documentatie over Eloquent relationships, voor de opzet van de one-to-many en many-to-many relaties — https://laravel.com/docs/eloquent-relationships

Alle overige code is zelf geschreven. De Breeze-scaffolding is aangepast waar nodig: extra kolommen op het User-model, de avatar-upload in `ProfileController`, en aangepaste styling in de views.

---

## Opmerkingen

- `vendor/` en `node_modules/` staan in `.gitignore` en zitten niet in de repository
- `public/storage` is een symlink en wordt niet meegecommit; draai `php artisan storage:link` na het clonen
- Nieuwsberichten uit de seeder hebben geen afbeelding; die voeg je toe via het admin panel. De views tonen een nette placeholder waar een afbeelding ontbreekt