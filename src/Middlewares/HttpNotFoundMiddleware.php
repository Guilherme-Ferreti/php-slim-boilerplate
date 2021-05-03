<?php

namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use Slim\Exception\HttpNotFoundException;

class HttpNotFoundMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler) : Response 
    {
        try {
            $response = $handler->handle($request);

            return $response;
        } catch (HttpNotFoundException $httpException) {

            logger()->error($httpException);

            $response = new Response();
    
            $response->getBody()->write('Page not found, sorry!');
    
            return $response->withStatus(404);
        }
    }
}
