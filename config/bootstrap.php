<?php

use DI\ContainerBuilder;
use Slim\App;

const PROJECT_ROOT_DIR = __DIR__ . '/..';
require_once PROJECT_ROOT_DIR . '/vendor/autoload.php';

// Detect environment
$_ENV['APP_ENV'] ??= $_SERVER['APP_ENV'] ?? 'dev';

$autodiscover = include PROJECT_ROOT_DIR . '/config/containerServiceAutoRegister.php';

// Build DI container instance
$container = (new ContainerBuilder())
    ->addDefinitions($autodiscover(['App\Infrastructure','App\ApiResources', 'App\Middlewares', 'App\Controller']))
    ->addDefinitions(PROJECT_ROOT_DIR . '/config/container.php')
    ->useAttributes(true)
//    ->enableCompilation(PROJECT_ROOT_DIR . '/var/cache/'.$_ENV['APP_ENV'])
    ->build();

// Create App instance
return $container->get(App::class);
