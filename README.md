# Test Supabase

Repositorio para hacer un test de conexion con Supabase

## Pasos para iniciar

* `composer install`
* `npm install`
* `npm run build`
* `php artisan migrate`
* `php artisan db:seed`
* `composer dev`

## Para conectarse con Supabase (Postgress)

Debe cambiar en el archivo .env las siguientes lineas, el DB_URL lo obtienen cuando hacen click en Connect por si no lo copian cuando crean el proyecto en supabase, tener en cuenta que no pueden usar PATCH no esta soportado, solo PUT para actualizar, todo lo relacionado con CRUD, lo tienen en CLIENTS (Model, Controller, Route, Views (Pages), Print to PDF (con blade), etc).

DB_CONNECTION=pgsql

DB_URL=postgres://postgres.xxxx:password@xxxx.pooler.supabase.com:5432/postgres

La documentacion [Docu](https://supabase.com/docs/guides/getting-started/quickstarts/laravel)
