<?php

/**
 * This file is used for adding global middlewares to the application.
 */

use \App\Middlewares\HttpNotFoundMiddleware;

$app->addBodyParsingMiddleware();

$app->addRoutingMiddleware();

$app->add(new HttpNotFoundMiddleware());

$app->addErrorMiddleware((settings('app.environment') === 'development'), true, true, logger());
