#PHP_CRUD
A simple PHP crud app that uses mysql and a few packages.

## Set Up

1. Create a mysql DB for the application to use
2. copy `.env.example` to a new file called `.env`
3. Fill out the values in your new `.env` file
4. Do a `composer install`
5. Execute `src/Scripts/runMigrations.php` to build out the schema
6. Execute `src/Scripts/SeedData.php` to get some initial values
7. Spin up your php web server with `php -S localhost:8000 index.php`
8. Open a browser and navigate to *localhost:8000*
9. ???
10. Profit