<?php

namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class ExampleMiddleware 
{
    public function __invoke(Request $request, RequestHandler $handler) : Response
    {
        $isAuthenticated = false; 

        if ($isAuthenticated === false) {
            $response = new Response();

            $response->getBody()->write('User not authenticated!');

            return $response->withStatus(401);
        }

        $response = $handler->handle($request);

        return $response;
    }
}
