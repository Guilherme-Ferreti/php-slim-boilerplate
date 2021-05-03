<?php

namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use Slim\Routing\RouteContext;

class CorsMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler) : Response
    {
        $routeContext = RouteContext::fromRequest($request);
        $routingResults = $routeContext->getRoutingResults();
        $methods = $routingResults->getAllowedMethods();
        $requestHeaders = $request->getHeaderLine('Access-Control-Request-Headers');

        if (in_array($request->getHeader('Origin')[0] ?? null, settings('cors.allowed_origins'))) {
            $origin = $request->getHeader('Origin')[0];
        } else {
            $origin = settings('app.domain');
        }

        $response = $handler->handle($request);

        return $response
            ->withHeader('Access-Control-Allow-Origin', $origin)
            ->withHeader('Access-Control-Allow-Methods', implode(', ', $methods))
            ->withHeader('Access-Control-Allow-Headers', $requestHeaders ?: '*')
            ->withHeader('Vary', 'Origin');
    }
}
