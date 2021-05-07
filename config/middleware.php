<?php

/**
 * This file is used for adding global middlewares to the application.
 * Middlewares added last are the first ones to be executed.
 */

use App\Middlewares\CorsMiddleware;
use App\Exceptions\{
    HTLMRenderer,
    JSONRenderer
};

$app->add(new CorsMiddleware());

$app->addBodyParsingMiddleware();

$app->addRoutingMiddleware();

$errorMiddleware  = $app->addErrorMiddleware((settings('app.environment') === 'development'), true, true);

$errorHandler = $errorMiddleware->getDefaultErrorHandler();

$errorHandler->registerErrorRenderer('text/html', HTLMRenderer::class);
$errorHandler->registerErrorRenderer('application/json', JSONRenderer::class);
