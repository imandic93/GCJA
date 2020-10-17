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

## Sync podataka

Kako bi se podaci sinkronizirali, potrebno je podesiti Cron job koji ce se izvrsavati nakon zeljenog vremena. Za sync podataka je dostupan Command `app:sync-data` koji izvrsava sinkronizaciju. Primjer linije u crontabu za osvjezavanje podataka:

`*/5 * * * * /usr/bin/php /var/www/gja/bin/console app:sync-data`
