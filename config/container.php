<?php

use Psr\Container\ContainerInterface;
use Slim\App;
use DI\Bridge\Slim\Bridge;

return [
    // Application settings
    'settings' => fn () => require __DIR__ . '/settings.php',

    App::class => function (ContainerInterface $container) {
        $app = Bridge::create($container);

        // Register routes
        (require __DIR__ . '/routes.php')($app);
        // Register cache
        (require __DIR__ . '/cache.php')($app);
        // Register middlewares
        (require __DIR__ . '/middlewares.php')($app);

        return $app;
    },
];
