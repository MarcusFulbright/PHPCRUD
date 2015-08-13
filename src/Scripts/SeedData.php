<?php
require __DIR__ .'/../../vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__.'/../../');
$dotenv->load();

$config = new \Spot\Config();
$config->addConnection(
    'mysql',
    [
        'dbname'   => getenv('DB_NAME'),
        'user'     => getenv('DB_USER'),
        'password' => getenv('DB_PASSWORD'),
        'host'     => getenv('DB_HOST'),
        'driver'   => 'pdo_mysql'
    ]
);

$locator = new \Spot\Locator($config);
$location_mapper = $locator->mapper('Mbright\Entities\Location');
$employee_mapper = $locator->mapper('Mbright\Entities\Employee');

$locations = [
    'Atlanta',
    'Nashville',
    'Chicago'
];

foreach ($locations as $location) {
    $location_mapper->create(['name' => $location]);
}

$employee_mapper->create(
    [
        'firstName' => 'John',
        'lastName'  => 'Wick',
        'phone'     => '555-555-5555',
        'email'     => 'jon.wick@gmail.com',
        'location'  => 1
    ]
);

