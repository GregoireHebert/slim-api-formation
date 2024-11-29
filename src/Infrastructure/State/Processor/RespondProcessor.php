<?php

declare(strict_types=1);

namespace App\Infrastructure\State\Processor;

use ApiPlatform\Metadata\HttpOperation;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

final class RespondProcessor implements ProcessorInterface
{
    public const METHOD_TO_CODE = [
        'POST' => 201,
        'DELETE' => 204,
    ];

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        if ($data instanceof Response || !$operation instanceof HttpOperation) {
            return $data;
        }

        if (!($request = $context['request'] ?? null) || !$request instanceof Request) {
            return $data;
        }

        $headers = [
            'Content-Type' => \sprintf('%s; charset=utf-8', 'application/json'),
            'Vary' => 'Accept',
            'X-Content-Type-Options' => 'nosniff',
            'X-Frame-Options' => 'deny',
        ];

        $status = $operation->getStatus();
        $method = $request->getMethod();

        $status ??= self::METHOD_TO_CODE[$method] ?? 200;

        return new Response(
            $status,
            new Headers($headers),
            (new StreamFactory())->createStream($data),
        );
    }
}
