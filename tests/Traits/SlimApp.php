<?php

declare(strict_types=1);

namespace App\Tests\Traits;

use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use Slim\App;

trait SlimApp
{
    protected App $app;
    protected ?ContainerInterface $container;

    /**
     * Before each test.
     */
    protected function setUp(): void
    {
        $this->setUpApp();
    }

    protected function setUpApp(): void
    {
        $autodiscover = include PROJECT_ROOT_DIR . '/config/containerServiceAutoRegister.php';

        // Build DI container instance
        $container = (new ContainerBuilder())
            ->addDefinitions($autodiscover(['App\Infrastructure','App\ApiResources', 'App\Middlewares', 'App\Controller', 'App\Tests\Traits']))
            ->addDefinitions(PROJECT_ROOT_DIR . '/config/container.php')
            ->useAttributes(true)
            ->build();

        $this->app = $container->get(App::class);
        $this->setUpContainer($container);
    }

    /**
     * Setup DI container.
     *
     * TestCases must call this method inside setUp().
     *
     * @return void
     */
    protected function setUpContainer(ContainerInterface $container = null): void
    {
        if ($container instanceof ContainerInterface) {
            $this->container = $container;

            return;
        }

        throw new \UnexpectedValueException('Container must be initialized');
    }

    /**
     * Define an object or a value in the container.
     */
    protected function setContainerValue(string $name, mixed $value): void
    {
        if (isset($this->container) && method_exists($this->container, 'set')) {
            $this->container->set($name, $value);

            return;
        }

        throw new \BadMethodCallException('This DI container does not support this feature');
    }
}
