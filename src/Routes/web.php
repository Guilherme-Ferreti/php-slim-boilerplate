<?php

use App\Controllers\HomeController;
use App\Middlewares\CsrfMiddleware;

$app->get('/', new HomeController())->setName('home');

// $app->get('/', HomeController::class . ':index')->setName('home')->add(new CsrfMiddleware());
