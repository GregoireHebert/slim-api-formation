<?php

declare(strict_types=1);

namespace App\Infrastructure\State\Provider;

use ApiPlatform\Metadata\HttpOperation;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Put;
use ApiPlatform\State\Exception\ProviderNotFoundException;
use ApiPlatform\State\ProviderInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ReadProvider implements ProviderInterface
{
    public function __construct(private readonly ContainerInterface $container)
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if (!$operation instanceof HttpOperation) {
            return null;
        }

        if (!$operation->canRead()) {
            return null;
        }

        try {
            $provider = $this->container->get($operation->getProvider() ?? throw new ProviderNotFoundException());
            $data = $provider->provide($operation, $uriVariables, $context);
        } catch (ProviderNotFoundException $e) {
            $data = null;
        }

        if (
            null === $data
            && 'POST' !== $operation->getMethod()
            && ('PUT' !== $operation->getMethod()
                || ($operation instanceof Put && !($operation->getAllowCreate() ?? false))
            )
        ) {
            throw new NotFoundHttpException('Not Found');
        }

        return $data;
    }
}
