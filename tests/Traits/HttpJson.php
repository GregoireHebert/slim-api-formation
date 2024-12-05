<?php

namespace App\Tests\Traits;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;

/**
 * HTTP JSON Test Trait.
 *
 * Requires: Http, ArrayTestTrait
 */
trait HttpJson
{
    use SlimApp;
    use Http;

    /**
     * Create a JSON request.
     *
     * @param string $method The HTTP method
     * @param string|UriInterface $uri The URI
     * @param array|null $data The json data
     *
     * @return ServerRequestInterface
     */
    protected function createJsonRequest(
        string $method,
        string|UriInterface $uri,
        array $data = null
    ): ServerRequestInterface {
        $request = $this->createRequest($method, $uri);

        if ($data !== null) {
            $request->getBody()->write((string)json_encode($data));
        }

        $request = $request->withHeader('Accept', 'application/json');

        return $request->withHeader('Content-Type', 'application/json');
    }

    /**
     * Verify that the specified array is an exact match for the returned JSON.
     *
     * @param array $expected The expected array
     * @param ResponseInterface $response The response
     *
     * @return void
     */
    protected function assertJsonData(array $expected, ResponseInterface $response): void
    {
        $data = $this->getJsonData($response);

        self::assertSame($expected, $data);
    }

    /**
     * Verify that the specified array is an exact match for the returned JSON.
     *
     * @param array $expected The expected array
     * @param ResponseInterface $response The response
     *
     * @return void
     */
    protected function assertJsonDataContains(string $key, mixed $expected, ResponseInterface $response): void
    {
        $data = $this->getJsonData($response);

        self::assertArrayHasKey($key, $data);
        self::assertEquals($expected, $data[$key]);
    }

    /**
     * Get JSON response as array.
     *
     * @param ResponseInterface $response The response
     *
     * @return array The data
     */
    protected function getJsonData(ResponseInterface $response): array
    {
        $actual = (string)$response->getBody();
        self::assertJson($actual);

        return (array)json_decode($actual, true);
    }

    /**
     * Verify JSON response.
     *
     * @param ResponseInterface $response The response
     *
     * @return void
     */
    protected function assertJsonContentType(ResponseInterface $response): void
    {
        self::assertStringContainsString('application/json', $response->getHeaderLine('Content-Type'));
    }
}
