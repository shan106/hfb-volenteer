# Humanity First Belgium – Volunteer Platform (Laravel)

Dit project is een data-driven Laravel webapplicatie voor Humanity First Belgium met:
- Publieke pagina’s (Home met laatste nieuws + FAQ)
- Authenticatie (login/register/password reset)
- Publieke profielen van vrijwilligers
- Timeline posts + likes
- Admin panel voor beheer van News, FAQ, Users en Contact messages

---

## ✅ Git / Repository

**Repository URL:** <VUL_HIER_JE_GITHUB_REPO_LINK_IN>

> Let op: `vendor/` en `node_modules/` staan in `.gitignore` (niet mee committen).

---

## 🚀 Installatie & opstarten 

### 1) Project clonen
```bash
git clone <REPO_URL>
cd <PROJECT_MAP>
```

### 2) Dependencies installeren
```bash
composer install
npm install
```

### 3) Environment file instellen
Maak `.env` aan op basis van `.env.example`:

```bash
cp .env.example .env
php artisan key:generate
```

Pas in `.env` je database gegevens aan :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=YOUR_DB_NAME
DB_USERNAME=YOUR_DB_USER
DB_PASSWORD=YOUR_DB_PASSWORD
```

### 4) Storage link (voor uploads: profiel foto’s, news images, timeline images)
```bash
php artisan storage:link
```

### 5) Database migreren + seeden
**Belangrijk:** project werkt correct met:
```bash
php artisan migrate:fresh --seed
```

### 6) Frontend build (Vite)
In development:
```bash
npm run dev
```

Of voor productie build:
```bash
npm run build
```

### 7) Laravel server starten
```bash
php artisan serve
```

Open in browser:
- http://127.0.0.1:8000

---

## 🔐 Default Admin Account (vereist door opdracht)

Deze admin wordt automatisch aangemaakt via seeder.

- **Username:** admin  
- **Email:** admin@ehb.be  
- **Password:** Password!321  

> Als deze gegevens niet werken: run opnieuw `php artisan migrate:fresh --seed`.

---

## 🧭 Belangrijkste pagina’s

### Publiek (zonder login)
- `/` Home: laatste nieuws + FAQ preview
- `/news` Nieuws overzicht + detail per item
- `/faq` FAQ pagina (categorieën + vragen/antwoorden)
- `/contact` Contactformulier (publiek)

### Auth (login vereist)
- `/dashboard`
- `/timeline` Timeline (posten + verwijderen eigen posts + like/unlike)
- `/profile` Profile edit
- `/users` Overzicht vrijwilligers (publieke profielen)
- `/users/{user}` Publieke profielpagina

### Admin (login + admin middleware)
- `/admin/dashboard` Admin dashboard
- `/admin/news` News CRUD
- `/admin/faq` FAQ + categorie beheer
- `/admin/users` Users beheren + admin rechten toekennen/afnemen
- `/admin/contact-messages` Contact messages overzicht + filter open/replied + reply

---

## ✅ Features die voldoen aan de minimum requirements

### Login systeem
- Login / Register / Logout
- Password reset (Laravel auth)
- User roles: gewone gebruiker of admin (`is_admin`)
- Admin kan users beheren en admin rights toekennen/afnemen
- Admin kan users manueel aanmaken (via admin users module)

### Profielpagina
- Publieke profielpagina per user
- Ingelogde user kan eigen gegevens aanpassen
- Profielfoto opslag via server (storage)

### Laatste nieuwtjes
- Admin CRUD voor news
- Publieke news list + detail
- News bevat: titel, afbeelding (server), content, publicatiedatum

### FAQ
- Publiek zichtbaar
- Gegroepeerd per categorie
- Admin kan categorieën + Q/A beheren

### Contact
- Publiek contactformulier
- Admin ontvangt e-mail met inhoud (config in `.env`)
- Extra feature: admin panel met overzicht + reply functionaliteit

---

## ⭐ Extra features (voor hogere score)
- Timeline posts met afbeelding upload
- Like/unlike systeem op timeline (many-to-many via `timeline_likes`)
- Admin panel met extra modules (users & contact messages)

---

## 🧱 Technische details / standaarden

- Laravel nieuwste versie gebruikt bij start van project
- Blade views met layouts + componenten (Breeze components)
- XSS protection: Blade escaping `{{ }}` (default)
- CSRF protection: `@csrf` in forms
- Routes met middleware (auth/admin) en route grouping
- Eloquent models per entiteit + relaties:
  - One-to-many (bv. user → timeline posts)
  - Many-to-many (likes pivot table)

---

## 📧 Mail configuratie (Contact form)
Voor lokaal testen kan je bv. Mailtrap gebruiken of `log` driver.

Voorbeeld `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=...
MAIL_PORT=...
MAIL_USERNAME=...
MAIL_PASSWORD=...
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@hfb.local"
MAIL_FROM_NAME="Humanity First Belgium"
```

Of log driver:
```env
MAIL_MAILER=log
```

---

## 📝 Bronvermeldingen (verplicht)

> Voeg hier jouw echte bronnen toe (verplicht als je internetcode gebruikt).

- Laravel documentatie: https://laravel.com/docs  
- Laravel Breeze (auth scaffolding): https://github.com/laravel/breeze  
- TailwindCSS documentatie: https://tailwindcss.com/docs  

**Externe code snippets (indien gebruikt):**
- (VUL AAN) Link + korte beschrijving + waar gebruikt + bevestiging dat je de code begrijpt.

---

## 🧩 Belangrijke opmerkingen
- `vendor/` en `node_modules/` staan niet in git (via `.gitignore`)
- Project is getest met `php artisan migrate:fresh --seed`
- Admin middleware beveiliging actief op `/admin/*`

---


