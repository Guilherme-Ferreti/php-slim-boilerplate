<?php

/**
 * File responsable for the application bootstrap.
 */

// Load application settings function
require_once __DIR__ . '/settings.php';

// Set up PHP settings
if (settings('app.environment') === 'development') {

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

} else {

    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}

date_default_timezone_set(settings('app.timezone'));

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

// Create APP instance
$app = Slim\Factory\AppFactory::create();

// Boot database
new \App\Database\Database();

// Load helper functions
require_once __DIR__ . '/../src/Helpers/helpers.php';

// Register middlewares
require_once __DIR__ . '/middleware.php';

// Register application route caching
require_once __DIR__ . '/route-cache.php';

// Register routes
require_once __DIR__ . '/../src/Routes/web.php';
require_once __DIR__ . '/../src/Routes/api.php';

return $app;
