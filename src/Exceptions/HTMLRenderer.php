<?php

namespace App\Exceptions;

use Throwable;
use App\Helpers\View\ViewMaker;
use Slim\Exception\HttpNotFoundException;
use Slim\Interfaces\ErrorRendererInterface;

/**
 * Responsable for rendering HTML responses when a error occurs.
 */
class HTMLRenderer implements ErrorRendererInterface
{
    public function __invoke(Throwable $exception, bool $displayErrorDetails) : string
    {
        logger()->error($exception);

        if (settings('app.environment') === 'development') dd($exception);

        if ($exception instanceof HttpNotFoundException) {
            return ViewMaker::make('site/errors/page-not-found');
        }

        return ViewMaker::make('site/errors/generic', compact('exception'));
    }
}
