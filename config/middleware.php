<?php

/**
 * This file is used for adding global middlewares to the application.
 */

$app->addBodyParsingMiddleware();

$app->addErrorMiddleware((settings('app.environment') === 'development'), true, true, logger());
