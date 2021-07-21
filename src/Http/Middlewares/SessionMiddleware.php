<?php

namespace App\Http\Middlewares;

use App\Helpers\Session;
use Slim\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class SessionMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler) : Response
    {
        $GLOBALS[Session::FLASH_KEY] = Session::get(Session::FLASH_KEY);
        
        Session::clearFlash();

        return $handler->handle($request);
    }
}
