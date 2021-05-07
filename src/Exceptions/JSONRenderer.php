<?php

namespace App\Exceptions;

use Throwable;
use Slim\Interfaces\ErrorRendererInterface;

/**
 * Responsable for rendering JSON responses when a error occurs.
 */
class JSONRenderer implements ErrorRendererInterface
{
    public function __invoke(Throwable $exception, bool $displayErrorDetails) : string
    {
        logger()->error($exception);

        if (settings('app.environment') === 'development') dd($exception);

        return json_encode([
            'code' => $exception->getCode(),
            'message' => $exception->getMessage(),
        ]);
    }
}
