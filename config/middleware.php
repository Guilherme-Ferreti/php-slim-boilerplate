<?php

$app->addBodyParsingMiddleware();

$app->addErrorMiddleware((settings('app.environment') === 'development'), true, true, logger());
