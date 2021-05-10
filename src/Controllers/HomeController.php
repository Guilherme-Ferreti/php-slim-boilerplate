<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HomeController extends BaseController
{
    public function __invoke(Request $request, Response $response)
    {
        return view($response, 'site.index', ['title' => 'Homepage! Welcome']);
    }
}
