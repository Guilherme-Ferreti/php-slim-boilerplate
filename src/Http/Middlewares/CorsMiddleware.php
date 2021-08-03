<?php

namespace App\Http\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use Slim\Routing\RouteContext;

class CorsMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler) : Response
    {
        $origin = $request->getHeader('Origin')[0] ?? '';

        if ($this->originIsAllowed($origin)) {
            $response = $handler->handle($request);
        } else {
            $origin = settings('app.domain');
            $response = new Response();
        }

        return $response
            ->withHeader('Access-Control-Allow-Origin', $origin)
            ->withHeader('Access-Control-Allow-Methods', implode(', ', RouteContext::fromRequest($request)->getRoutingResults()->getAllowedMethods()))
            ->withHeader('Access-Control-Allow-Headers', $request->getHeaderLine('Access-Control-Request-Headers') ?: '*')
            ->withHeader('Vary', 'Origin');
    }

    private function originIsAllowed($origin): bool 
    {
        if (settings('app.environment') === 'dev') {
            return true;
        }

        return in_array($origin, settings('cors.allowed_origins'));
    }
}