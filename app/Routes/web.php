<?php

use App\Controllers\HomeController;

$app->get('/', new HomeController())->setName('home');
