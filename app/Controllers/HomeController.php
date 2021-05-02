<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class HomeController 
{
    public function __invoke(Request $request, Response $response)
    {
        $response->getBody()->write('Hello World!');

        return $response;
    }
}
