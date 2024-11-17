<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;

final class SayMyName
{
    public function __invoke(ResponseInterface $response, string $name): ResponseInterface
    {
        $response->getBody()->write("Hello $name!");

        return $response;
    }
}
