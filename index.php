<?php

require 'vendor/autoload.php';

use Aura\Router\RouterFactory;

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

$config = new \Spot\Config();
$config->addConnection(
    'mysql',
    [
        'dbname' => getenv('DB_NAME'),
        'user' => getenv('DB_USER'),
        'password' => getenv('DB_PASSWORD'),
        'host' => getenv('DB_HOST'),
        'driver' => 'pdo_mysql'
    ]
);
$locator = new \Spot\Locator($config);

$di = [
    'view' => function() {
        $view_factory = new \Aura\View\ViewFactory;
        $view = $view_factory->newInstance();
        $view_registry = $view->getViewRegistry();
        $view_registry->set('index', 'views/index.php');
        $view_registry->set('employee_form', 'views/employee_form.php');
        return $view;
    },
    'managers' => [
        'employee' => function() use ($locator) {
            return new \Mbright\Manager\EmployeeManager(new \Aura\Filter\FilterFactory(), $locator);
        },
        'location' => function() use ($locator) {
            return new \Mbright\Manager\LocationManager($locator);
        }
    ],
];
$router_factory = new RouterFactory();
$router = $router_factory->newInstance();
$router->add('index','/')
    ->addValues([
        'format'=> '.html',
        'action'=> function() use ($di) {
            $view = $di['view']->__invoke();
            $manager = $di['managers']['employee']->__invoke();
            $view->setView('index');
            $view->setData([
                'employees' => $manager->get()
            ]);
            return $view->__invoke();
        }
    ]);
$router->addGet('employee_form', '/employee{/id}')
    ->addValues([
        'format' => '.html',
        'action' => function($params) use ($di) {
            $view = $di['view']->__invoke();
            $manager = $di['managers']['location']->__invoke();
            $view->setView('employee_form');
            $view->setData([
                'locations' => $manager->get()
            ]);
            if (isset($params['id'])) {
                $employee_manager = $di['managers']['employee']->__invoke();
                $employee = $employee_manager->get($params['id']);
                $view->addData([
                    'data' => $employee->toArray()
                ]);
            }
            return $view->__invoke();
        }
    ]);
$router->addPost('create', '/employee')
    ->addValues([
        'format' => '.html',
        'action' => function() use ($di) {
            $manager = $di['managers']['employee']->__invoke();
            try {
                $manager->create($_POST);
                header('location: http://localhost:8000');
                exit();
            } catch (\Mbright\Exception\ValidationException $e) {
                $view = $di['view']->__invoke();
                $view->setView('employee_form');
                $view->setData([
                    'errors' => $e->getMessage(),
                    'locations' => $di['managers']['location']->__invoke()->get(),
                    'data' => $_POST
                ]);
                return $view->__invoke();
            }
        }
    ]);
$router->addPost('update', '/employee/{id}')
    ->addTokens([
        'id' => '\d+'
    ])
    ->addValues([
        'format' => '.html',
        'action' => function ($params) use ($di) {
            $manager = $di['managers']['employee']->__invoke();
            $employee = $manager->get($params['id']);
            try {
                $manager->update($_POST, $employee);
                header('location: http://localhost:8000');
                exit();
            } catch (\Mbright\Exception\ValidationException $e) {
                $view = $di['view']->__invoke();
                $view->setView('employee_form');
                $view->setData([
                    'errors' => $e->getMessage(),
                    'data' => $_POST,
                    'locations' => $di['managers']['locations']->__invoke()->get()
                ]);
                return $view->__invoke();
            }
        }
    ]);

$router->addPost('delete', '/employee/{id}/delete')
    ->addTokens([
        'id' => '\d+'
    ])
    ->addValues([
        'format' => '.html',
        'action' => function ($params) use ($di) {
            $manager = $di['managers']['employee']->__invoke();
            $employee = $manager->get((int)$params['id']);
            $manager->delete($employee);
            header('location: http://localhost:8000');
            exit();
        }
    ]);

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$route = $router->match($path, $_SERVER);
$action = $route->params['action'];
echo $action->__invoke($route->params);