<?php

use DI\ContainerBuilder;
use Slim\App;

const PROJECT_ROOT_DIR = __DIR__ . '/..';
require_once PROJECT_ROOT_DIR . '/vendor/autoload.php';

// Build DI container instance
$container = (new ContainerBuilder())
    ->addDefinitions(__DIR__ . '/container.php')
    ->useAttributes(true)
    ->build();

// Create App instance
return $container->get(App::class);
