<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write("Hello world!");
    return $response;
});

$app->get('/{name}', function (Request $request, Response $response, array $args) {
    // insérez le name dans la réponse à l'aide de $args
    $response->getBody()->write("Hello {$args['name']}!");
    return $response;
});

$app->run();
