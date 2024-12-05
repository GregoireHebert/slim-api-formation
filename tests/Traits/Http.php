<?php

namespace App\Tests\Traits;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use RuntimeException;

/**
 * HTTP Test Trait.
 */
trait Http
{
    /**
     * Create a server request.
     *
     * @param string $method The HTTP method
     * @param string|UriInterface $uri The URI
     * @param array $serverParams The server parameters
     *
     * @throws RuntimeException
     *
     * @return ServerRequestInterface The request
     */
    protected function createRequest(
        string $method,
        string|UriInterface $uri,
        array $serverParams = []
    ): ServerRequestInterface {
        if (!$this->container instanceof ContainerInterface) {
            throw new RuntimeException('DI container not found');
        }

        $factory = $this->container->get(ServerRequestFactoryInterface::class);

        return $factory->createServerRequest($method, $uri, $serverParams);
    }

    /**
     * Create a new response.
     *
     * @param int $code HTTP status code; defaults to 200
     * @param string $reasonPhrase Reason phrase to associate with status code
     *
     * @throws RuntimeException
     *
     * @return ResponseInterface The response
     */
    protected function createResponse(int $code = 200, string $reasonPhrase = ''): ResponseInterface
    {
        if (!$this->container instanceof ContainerInterface) {
            throw new RuntimeException('DI container not found');
        }

        $factory = $this->container->get(ResponseFactoryInterface::class);

        return $factory->createResponse($code, $reasonPhrase);
    }

    /**
     * Assert that the response body contains a string.
     *
     * @param string $expected The expected string
     * @param ResponseInterface $response The response
     *
     * @return void
     */
    protected function assertResponseContains(string $expected, ResponseInterface $response): void
    {
        $body = (string)$response->getBody();

        $this->assertStringContainsString($expected, $body);
    }
}