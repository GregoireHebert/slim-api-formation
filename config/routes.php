<?php

// Define app routes

use Slim\App;

return function (App $app) {
    $app->get('/', \App\Controller\Home::class);
    $app->get('/{name}', \App\Controller\SayMyName::class);
};
