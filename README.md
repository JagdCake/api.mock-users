# api.mock-users
The main things here: 
- the entity classes (database models) in `src/Entity/`, one for API users and the other for mock user data
- the controller class in `src/Controller` handles requests, sends responses

## First Time Setup
#### Symfony 4
- download [composer](https://getcomposer.org/download/) and [install](https://getcomposer.org/doc/00-intro.md#globally) it globally
- run `composer install` 
- start the development server with `bin/console server:run` or `php bin/console server:run`

#### Database:
- create (in .env or .env.local) or export a variable `DATABASE_URL="db_driver://db_user:db_password@db_host:db_port/db_name"`, e.g. `postgres://jagdcake:password_for_stuff@127.0.0.1:5432/stuff`
- delete all migration files inside `src/Migrations/`
- run a migration with `bin/console make:migration`
- make sure the migration won't do something you don't want (like drop every table from your database) by reviewing it, inside `src/Migrations/`
- execute the migration `bin/console doctrine:migrations:migrate`
- connect to your database and create an API user `insert into api_user (id, username, roles, api_token) values (1, 'username', '["ROLE_ADMIN"]'::json, 'apiKey');`
- to test the db connection, first disable debug mode by creating (in .env or .env.local) or exporting `APP_DEBUG=0`, then run `curl -H 'X-AUTH-TOKEN: apiKey' http://localhost:8000/mock_users`, if you have any users in the database you should receive their data as JSON; if you enter a wrong API key you should get `{"message":"Username could not be found."}`
