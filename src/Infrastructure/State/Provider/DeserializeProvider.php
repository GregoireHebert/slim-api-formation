<?php

declare(strict_types=1);

namespace App\Infrastructure\State\Provider;

use ApiPlatform\Metadata\HttpOperation;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use AutoMapper\AutoMapper;
use AutoMapper\AutoMapperInterface;
use Psr\Http\Message\RequestInterface;
use Slim\Psr7\Request;

class DeserializeProvider implements ProviderInterface
{
    public function __construct(
        private readonly ProviderInterface $provider,
        private readonly AutoMapperInterface $autoMapper,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $data = $this->provider->provide($operation, $uriVariables, $context);

        if (!$operation->canDeserialize()) {
            return $data;
        }

        $request = $context['slimRequest'] ?? null;
        if (!$request instanceof Request) {
            throw new \RuntimeException('Request must be an instance of RequestInterface '.gettype($request).' given');
        }

        if (!$operation instanceof HttpOperation) {
            throw new \RuntimeException('Operation must be an instance of HttpOperation '.gettype($operation).' given');
        }

        $method = $operation->getMethod();
        $autoMapperContext = [];

        if (
            null !== $data
            && (
                'POST' === $method
                || 'PATCH' === $method
                || ('PUT' === $method && !($operation->getExtraProperties()['standard_put'] ?? false))
            )
        ) {
            $autoMapperContext['target_to_populate'] = $data;
        }

        return $this->autoMapper->map($request->getParsedBody(), $operation->getClass(), $autoMapperContext);
    }
}
