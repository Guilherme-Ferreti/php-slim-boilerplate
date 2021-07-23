<?php

/**
 * This file is used for adding global middlewares to the application.
 * Middlewares added last are the first ones to be executed.
 */

use App\Http\Middlewares\SessionMiddleware;
use Slim\Middleware\MethodOverrideMiddleware;

$app->add(new SessionMiddleware());

$app->addBodyParsingMiddleware();

$app->addRoutingMiddleware();

$app->add(new MethodOverrideMiddleware());

$errorMiddleware = $app->addErrorMiddleware((settings('app.environment') === 'development'), true, true);
$errorMiddleware->setDefaultErrorHandler([new \App\Exceptions\Handler(), 'handle']);
