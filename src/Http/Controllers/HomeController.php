<?php

namespace App\Http\Controllers;

use Psr\Http\Message\ResponseInterface as Response;

class HomeController extends BaseController
{
    public function __invoke(Response $response)
    {
        return $this->view($response, 'site.index', ['title' => 'Homepage! Welcome']);
    }
}
