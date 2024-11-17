<?php

// Define app routes

use Slim\App;

return function (App $app) {
    $container = $app->getContainer();
    $env = $container->get('settings')['env'];

    if ($env === 'prod') {
        $cacheDir = $container->get('settings')['cache']['cache_dir'];

        $routeCollector = $app->getRouteCollector();
        $routeCollector->setCacheFile($cacheDir . '/' . $env . '/routes.php');
    }
};
