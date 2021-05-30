<?php

use App\Controllers\HomeController;
use App\Middlewares\CorsMiddleware;
use Slim\Routing\RouteCollectorProxy;

$app->group('/api', function (RouteCollectorProxy $group) {

    $group->get('/home', new HomeController());
})->add(new CorsMiddleware());
