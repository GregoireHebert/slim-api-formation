<?php

// Define app routes

use Slim\App;

return function (App $app) {
    $app->get('/', function (\Psr\Http\Message\RequestInterface $request, \Psr\Http\Message\ResponseInterface $response) {
        $response->getBody()->write("Hello world!");
        return $response;
    });
};
