<?php declare(strict_types=1);

namespace App\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\App;

final class NotAcceptableMiddleware implements MiddlewareInterface
{
    public function __construct(private App $app)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (0 === count(array_filter($request->getHeader('Accept'), fn ($item) => str_contains($item, 'application/json')))
        ) {
            $response = $this->app->getResponseFactory()->createResponse(406, 'Not Acceptable');
        } else {
            $response = $handler->handle($request);
        }

        if (ob_get_contents()) {
            ob_clean();
        }

        return $response;
    }
}
