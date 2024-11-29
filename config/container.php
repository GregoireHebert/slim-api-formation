<?php

use AutoMapper\AutoMapper;
use AutoMapper\AutoMapperInterface;
use Psr\Container\ContainerInterface;
use ApiPlatform\State\ProviderInterface;
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
    AutoMapperInterface::class => static fn() => AutoMapper::create(),
    \App\Infrastructure\State\Provider\ReadProvider::class => DI\autowire(),
    \App\Infrastructure\State\Provider\DeserializeProvider::class => function(ContainerInterface $c) {
        return new \App\Infrastructure\State\Provider\DeserializeProvider(
            $c->get(\App\Infrastructure\State\Provider\ReadProvider::class),
            $c->get(AutoMapperInterface::class)
        );
    },
    ProviderInterface::class => DI\get(\App\Infrastructure\State\Provider\DeserializeProvider::class),

    \App\Infrastructure\State\Processor\RespondProcessor::class => DI\autowire(),
    \App\Infrastructure\State\Processor\SerializeProcessor::class => function(ContainerInterface $c) {
        return new \App\Infrastructure\State\Processor\SerializeProcessor(
            $c->get(\App\Infrastructure\State\Processor\RespondProcessor::class),
            $c->get(AutoMapperInterface::class)
        );
    },
    \App\Infrastructure\State\Processor\WriteProcessor::class => function(ContainerInterface $c) {
        return new \App\Infrastructure\State\Processor\WriteProcessor(
            $c->get(\App\Infrastructure\State\Processor\SerializeProcessor::class),
            $c
        );
    },
    \ApiPlatform\State\ProcessorInterface::class => DI\get(\App\Infrastructure\State\Processor\WriteProcessor::class),
];
