<?php

namespace App\Middlewares;

use Slim\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class CsrfMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler) : Response 
    {
        $parsedBody = (array) $request->getParsedBody();

        $token = $parsedBody['csrf_token'] ?? null;

        if (! $token || ! validate_csrf_token($token)) {
            throw new \Slim\Exception\HttpBadRequestException($request, 'Invalid CSRF Token');
        }

        delete_csrf_token();

        return $handler->handle($request);
    }
}
