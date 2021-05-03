<?php

/**
 * This file is used for adding global middlewares to the application.
 * Middlewares added last are the first ones to be executed.
 */

use App\Middlewares\{
    CorsMiddleware,
    HttpNotFoundMiddleware,
};

$app->add(new HttpNotFoundMiddleware());

$app->add(new CorsMiddleware());

$app->addBodyParsingMiddleware();

$app->addRoutingMiddleware();

$app->addErrorMiddleware((settings('app.environment') === 'development'), true, true, logger());
