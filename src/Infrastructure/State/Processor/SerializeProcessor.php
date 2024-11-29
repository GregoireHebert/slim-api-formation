<?php

declare(strict_types=1);

namespace App\Infrastructure\State\Processor;

use ApiPlatform\Metadata\HttpOperation;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use AutoMapper\AutoMapperInterface;
use Slim\Psr7\Headers;
use Slim\Psr7\Response;

final class SerializeProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly ProcessorInterface $processor,
        private readonly AutoMapperInterface $autoMapper,
    )
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        if ($data instanceof Response || !$operation->canSerialize() || !($request = $context['request'] ?? null)) {
            return $this->processor ? $this->processor->process($data, $operation, $uriVariables, $context) : $data;
        }

        $serialized = json_encode($this->autoMapper->map($data, 'array'));

        return $this->processor ? $this->processor->process($serialized, $operation, $uriVariables, $context) : $serialized;
    }
}
