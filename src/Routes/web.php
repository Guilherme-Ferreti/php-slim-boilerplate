<?php

use App\Controllers\HomeController;

$app->get('/', new HomeController())->setName('home');

// $app->get('/', HomeController::class . ':index')->setName('home')->add(new ExampleMiddleware());
