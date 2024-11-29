<?php

declare(strict_types=1);

namespace App\Infrastructure\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

class WriteProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly ProcessorInterface $processor,
        private readonly ContainerInterface $container
    )
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        if (
            $data instanceof Response
            || !($operation->canWrite() ?? true)
            || !$operation->getProcessor()
        ) {
            return $this->processor ? $this->processor->process($data, $operation, $uriVariables, $context) : $data;
        }

        $processorInstance = $this->container->get($operation->getProcessor());

        $data = $processorInstance->process($data, $operation, $uriVariables, $context);

        return $this->processor ? $this->processor->process($data, $operation, $uriVariables, $context) : $data;
    }
}
