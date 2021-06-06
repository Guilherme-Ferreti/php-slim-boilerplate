<?php

use App\Controllers\HomeController;
use App\Middlewares\CorsMiddleware;
use Slim\Routing\RouteCollectorProxy;

$app->group('/api', function (RouteCollectorProxy $route) {
    $route->get('/home', new HomeController());

    $route->group('/fruits', function (RouteCollectorProxy $route) {
        $route->get('[/]', function ($request, $response) {
            $response->getBody()->write('Many fruits');
            return $response;
        });

        $route->get('/apples', function ($request, $response) {
            $response->getBody()->write('Apples');
            return $response;
        });

        $route->get('/bananas', function ($request, $response) {
            $response->getBody()->write('Bananas');
            return $response;
        });

        $route->group('/others', function (RouteCollectorProxy $route) {
            $route->get('/oranges', function ($request, $response) {
                $response->getBody()->write('Oranges');
                return $response;
            });
        });
    });
})->add(new CorsMiddleware());
