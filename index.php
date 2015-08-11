<?php

require 'vendor/autoload.php';

use Aura\Router\RouterFactory;

    $router_factory = new RouterFactory();
    $router = $router_factory->newInstance();

    $view_factory = new \Aura\View\ViewFactory;
    $view = $view_factory->newInstance();
    $view_registry = $view->getViewRegistry();
    $view_registry->set('index', 'views/index.php');

    $router->add('index','')
        ->addValues([
            'format'=> '.html',
            'action'=> function() use ($view) {
                header('Content-Type: text/html');
                $view->setData([
                    'name' => 'John Wick'
                ]);
                $view->setView('index');
                return $view->__invoke();
            }
        ]);


    $path = parse_url($_REQUEST['REQUEST_URI'], PHP_URL_PATH);
    $route = $router->match($path, $_SERVER);
    $action = $route->params['action'];

    echo $action->__invoke();
?>