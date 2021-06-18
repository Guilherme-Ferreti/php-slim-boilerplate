<?php

/**
 * This file is used for adding global middlewares to the application.
 * Middlewares added last are the first ones to be executed.
 */

use App\Middlewares\SessionMiddleware;
use App\Exceptions\Renders\{
    HTMLRenderer,
    JSONRenderer
};
use Slim\Middleware\MethodOverrideMiddleware;

$app->add(new SessionMiddleware());

$app->addBodyParsingMiddleware();

$app->addRoutingMiddleware();

$app->add(new MethodOverrideMiddleware());

$errorMiddleware  = $app->addErrorMiddleware((settings('app.environment') === 'development'), true, true);

$errorHandler = $errorMiddleware->getDefaultErrorHandler();

$errorHandler->registerErrorRenderer('text/html', HTMLRenderer::class);
$errorHandler->registerErrorRenderer('application/json', JSONRenderer::class);
