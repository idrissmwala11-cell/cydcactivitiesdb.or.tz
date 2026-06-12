# CYDC Activities Database

Mfumo wa Laravel wa CYDC wenye moduli ya **Results 2026** kwa shule za msingi na sekondari.

## Mahitaji

- PHP 8.2 au zaidi
- Composer 2
- Node.js 20 au zaidi
- MySQL/MariaDB

## Kusakinisha kutoka GitHub

```bash
composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate
npm ci
npm run build
php artisan migrate --force
php artisan storage:link
php artisan optimize
```

Weka taarifa sahihi za database, URL na barua pepe kwenye `.env` kabla ya kuendesha migrations. Web root ya hosting inapaswa kuelekezwa kwenye mzizi wa project hii kwa sababu app imepangiliwa kutumia mzizi kama public path.

## Results 2026

- Primary: Darasa la Nne na Darasa la Saba, alama kwa 50, grade bila division.
- Secondary: Form 2 na Form 4, alama kwa 100 na division.
- Access: admin pamoja na watumiaji wanne waliowekwa kwenye `config/form_two_results.php`.
- Database structure iko kwenye migrations za `2026_06_12_*`.

Database dump ya localhost haijawekwa GitHub kwa sababu ina taarifa binafsi na password hashes. Kwa database iliyopo, import dump salama kwa njia ya phpMyAdmin kisha endesha:

```bash
php artisan migrate --force
```

## Ukaguzi

```bash
composer audit --locked
npm audit
php artisan test
npm run build
```

Endesha ukaguzi huu kabla ya kila deployment.
