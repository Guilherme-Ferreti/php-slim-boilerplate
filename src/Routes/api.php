<?php

use Slim\Routing\RouteCollectorProxy;
use App\Controllers\HomeController;

$app->group('/api', function (RouteCollectorProxy $group) {

    $group->get('/home', new HomeController());
});
