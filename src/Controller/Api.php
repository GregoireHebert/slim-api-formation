<?php

declare(strict_types=1);

namespace App\Controller;

use ApiPlatform\Metadata\HttpOperation;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\State\ProviderInterface;
use App\Infrastructure\State\Provider\DeserializeProvider;
use App\Infrastructure\State\Provider\ReadProvider;
use AutoMapper\AutoMapper;
use AutoMapper\AutoMapperInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class Api
{
    public function __construct(
        private readonly ContainerInterface $container,
        private ProviderInterface $provider,
        private ProcessorInterface $processor,
    )
    {
    }

    public function __invoke(Operation $operation, RequestInterface $request, ResponseInterface $response)
    {
        $uriVariables = $request->getAttribute('__routingResults__')->getRouteArguments();

        if (null === $operation->canRead() && $operation instanceof HttpOperation) {
            $operation = $operation->withRead($operation->getUriVariables() || $this->isMethodSafe($request));
        }

        if (null === $operation->canDeserialize() && $operation instanceof HttpOperation) {
            $operation = $operation->withDeserialize(\in_array($operation->getMethod(), ['POST', 'PUT', 'PATCH'], true));
        }

        $context = ['request' => $request];

        $body = $this->provider->provide($operation, $uriVariables, $context);

        if (null === $operation->canWrite()) {
            $operation = $operation->withWrite(!$this->isMethodSafe($request));
        }

        if (null === $operation->canSerialize()) {
            $operation = $operation->withSerialize(true);
        }

        return $this->processor->process($body, $operation, $uriVariables, $context);
    }

    /**
     * Checks whether or not the method is safe.
     *
     * @see https://tools.ietf.org/html/rfc7231#section-4.2.1
     */
    private function isMethodSafe(RequestInterface $request): bool
    {
        return \in_array($request->getMethod(), ['GET', 'HEAD', 'OPTIONS', 'TRACE']);
    }
}
