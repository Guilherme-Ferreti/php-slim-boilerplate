<?php

/**
 * File used for application's routes cache configuration.
 */

if (settings('app.environment') === 'production') {
    $routeCollector = $app->getRouteCollector();
    
    $routeCollector->setCacheFile(settings('routes.cache_path'));
}
