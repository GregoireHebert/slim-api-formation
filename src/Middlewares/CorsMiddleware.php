<?php

namespace App\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\App;

final class CorsMiddleware implements MiddlewareInterface
{
    public function __construct(private App $app)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($request->getMethod() === 'OPTIONS') {
            $response = $this->app->getResponseFactory()->createResponse();
        } else {
            $response = $handler->handle($request);
        }

        $settings = $this->app->getContainer()->get('settings');

        $response = $response
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Access-Control-Allow-Origin', $settings['cors']['Origin'])
            ->withHeader('Access-Control-Allow-Headers', $settings['cors']['Headers'])
            ->withHeader('Access-Control-Allow-Methods', $settings['cors']['Methods'])
            ->withHeader('Cache-Control', $settings['cors']['Cache-Control'])
            ->withHeader('Pragma', 'no-cache');

        if (ob_get_contents()) {
            ob_clean();
        }

        return $response;
    }
}
