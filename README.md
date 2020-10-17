# GCJA
GIS Cloud job application

## Instalacija

* `git clone <URL>`
* Kreirati `.env.local` te staviti `APP_ENV=prod`
* Postaviti valjani DSN za `DATABASE_URL`
* `composer install -o --no-dev`
* `php bin/console doctrine:migrations:migrate`
* `php bin/console cache:warmup`
* `symfony serve -d (instalirati symfony cli ako se dobije poruka "symfony: command not found"`
