<?php

declare(strict_types=1);

namespace App\Infrastructure\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use AutoMapper\AutoMapper;
use AutoMapper\AutoMapperInterface;
use Psr\Http\Message\RequestInterface;

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

        $request = $context['request'] ?? null;
        if (!$request instanceof RequestInterface) {
            throw new \RuntimeException('Request must be an instance of RequestInterface');
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
