<?php

use App\Http\Controllers\HomeController;
use App\Http\Middlewares\CsrfMiddleware;

$app->get('/', new HomeController())->setName('home');

// $app->get('/', HomeController::class . ':index')->setName('home')->add(new CsrfMiddleware());
