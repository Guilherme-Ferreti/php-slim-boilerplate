<?php

use App\Controllers\HomeController;
use App\Middlewares\ExampleMiddleware;

$app->get('/', new HomeController())->setName('home')->add(new ExampleMiddleware());

// $app->get('/', HomeController::class . ':index')->setName('home');
