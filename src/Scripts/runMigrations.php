<?php
require __DIR__ .'/../../vendor/autoload.php';


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

$location_mapper->migrate();
$employee_mapper->migrate();
