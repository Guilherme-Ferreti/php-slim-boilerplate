<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use App\Helpers\View\ViewMaker;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Dump given variables and exit the application.
 */
function dd()
{
    foreach (func_get_args() as $arg) {
        echo '<pre>';
        var_dump($arg);
        echo '</pre>';
    }

    exit;
}

/**
 * Return a new Logger instance.
 */
function logger(string $name = 'app')
{
    $stream = settings('logs.path') . "$name.log";

    $logger = new Logger($name);

    $logger->pushHandler(new StreamHandler($stream));

    return $logger;
}

/**
 * Render a view.
 * 
 * Different from ViewMaker::make(), this function receives Response as it's first argument.
 * 
 * This helper function should be used to make controllers cleaner.
 */
function view(Response $response, string $pathToView, array $variables = [])
{
   return ViewMaker::make($pathToView, $variables, $response);
}

/**
 * Return the URL for the given route.
 */
function url_for(string $routeName, array $data = [], array $queryParams = [])
{
    global $app;

    $routeParser = $app->getRouteCollector()->getRouteParser();

    return $routeParser->urlFor($routeName, $data, $queryParams);
}

/**
 * Redirect user to specified route.
 */
function redirect($response, string $routeName, array $data = [], array $queryParams = [], int $status = 200)
{
    return $response->withHeader('location', url_for($routeName, $data, $queryParams))->withStatus($status);
}

/**
 * Remove all non-numeric characters from a string.
 */
function only_numbers(string $string) : string
{
    return preg_replace("/[^0-9]/", '', $string);
}
