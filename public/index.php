<?php

use Psr\Http\Message\ResponseInterface as Response;
use DI\Bridge\Slim\Bridge;
use DI\Container;

require __DIR__ . '/../vendor/autoload.php';

$container = new Container();

class ToUpperService{
    public function toUpper($string) {
        return mb_strtoupper($string);
    }
}

$container->set(ToUpperService::class, function () {
    return new ToUpperService();
});

$app = Bridge::create($container);

$app->get('/', function (Response $response) {
    $response->getBody()->write("Hello world!");
    return $response;
});

$app->get('/{name}', function (Response $response, string $name, ToUpperService $toUpper) {
    $str = "Hello {$name}!";

    $str = $toUpper->toUpper($str);

    $response->getBody()->write($str);
    return $response;
});

$app->run();
