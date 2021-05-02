<?php

require_once __DIR__ . '/../app/config.php';

if (config('app.environment') === 'development') {

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

} else {

    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}

session_start();

date_default_timezone_set(config('app.timezone'));

require_once __DIR__ . '/../vendor/autoload.php';

$app = Slim\Factory\AppFactory::create();

require_once __DIR__ . '/../app/Helpers/utils.php';
require_once __DIR__ . '/../app/Routes/web.php';
require_once __DIR__ . '/../app/Routes/api.php';

$app->addErrorMiddleware((config('app.environment') === 'development'), true, true, logger());

$app->run();
