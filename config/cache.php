<?php

if (settings('app.environment') === 'production') {
    $routeCollector = $app->getRouteCollector();
    
    $routeCollector->setCacheFile(settings('routes.cache_path'));
}
