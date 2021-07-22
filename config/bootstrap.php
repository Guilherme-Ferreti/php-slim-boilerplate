<?php

/**
 * File responsable for the application bootstrap.
 */

require_once __DIR__ . '/settings.php';

if (settings('app.environment') === 'production') {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
} else {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

date_default_timezone_set(settings('app.timezone'));

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../src/Helpers/helpers.php';

$containerBuilder = new \DI\ContainerBuilder();

if (settings('app.environment') === 'production') {
    $containerBuilder->enableCompilation(settings('container.cache.compilation_path'));
    $containerBuilder->writeProxiesToFile(true, settings('container.cache.proxies_path'));
}

$containerBuilder->addDefinitions(__DIR__ . '/container.php');

$container = $containerBuilder->build();

$app = \DI\Bridge\Slim\Bridge::create($container);

require_once __DIR__ . '/middleware.php';
require_once __DIR__ . '/route-cache.php';
require_once __DIR__ . '/../src/Http/Routes/web.php';
require_once __DIR__ . '/../src/Http/Routes/api.php';

return $app;
