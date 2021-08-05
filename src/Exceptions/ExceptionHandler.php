<?php

namespace App\Exceptions;

use \Throwable;
use Slim\Psr7\Response;
use App\Helpers\View\ViewMaker;
use Slim\Exception\HttpNotFoundException;
use Psr\Http\Message\ServerRequestInterface;

abstract class ExceptionHandler
{
    protected $request;
    protected $exception;
    protected array $responses;

    protected array $dontReportDefaults = [
        HttpNotFoundException::class, 
    ];

    public function __construct()
    {
        $this->registerDefaults();
        $this->register();
    }

    protected function registerDefaults(): void
    {
        $this->setResponse('default', function () {
            if ($this->wantsJson()) {
                return $this->json([
                    'message' => $this->exception->getMessage(),
                    'code' => $this->exception->getCode(),
                    'time' => now(),
                ]);
            }

            return $this->view('site.errors.generic');
        });
    }

    protected function register(): void
    {
        //
    }

    protected function setResponse(string $exceptionClass, callable $callback): void
    {
        $this->responses[$exceptionClass] = $callback;
    }

    protected function getResponse(string $exceptionClass): Response
    {
        $callback = $this->responses[$exceptionClass] ?? $this->responses['default'];

        $response = $callback() ?? $this->responses['default']();

        return $response;
    }

    protected function redirect(string $to): Response
    {
        $response = new Response();

        return $response
            ->withHeader('Location', $to)
            ->withStatus(302);
    }

    protected function json(array $payload, ?int $statusCode = null): Response
    {
        $response = new Response();

        $response->getBody()->write(json_encode($payload));

        return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus($statusCode ?? $this->getStatusCode());
    }

    protected function view(string $path, array $variables = [], ?int $statusCode = null): Response
    {
        $response = new Response();

        $response->getBody()->write(ViewMaker::make($path, $variables + ['exception' => $this->exception]));

        return $response
                ->withHeader('Content-Type', 'text/html')
                ->withStatus($statusCode ?? $this->getStatusCode());
    }

    protected function wantsJson(): bool
    {
        return $this->request->getHeader('Accept')[0] === 'application/json';
    }

    protected function getStatusCode(): int
    {
        return is_http_status_code($this->exception->getCode()) 
            ? $this->exception->getCode()
            : 500;
    }

    protected function shouldReport($exception): bool
    {
        return ! in_array($exception::class, $this->dontReport + $this->dontReportDefaults);
    }

    public function handle(ServerRequestInterface $request, Throwable $exception): Response
    {
        $this->request = $request;
        $this->exception = $exception;

        if ($this->shouldReport($exception)) {
            report($exception);
        }

        return $this->getResponse($exception::class);
    }
}
