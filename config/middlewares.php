<?php

use Slim\App;
use App\Middlewares\CorsMiddleware;

return function (App $app) {
    $app->addBodyParsingMiddleware();
    $app->addRoutingMiddleware();
    $app->add(CorsMiddleware::class);
};
