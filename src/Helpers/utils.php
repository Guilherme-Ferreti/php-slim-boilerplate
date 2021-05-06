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

/**
 * Store a CSRF token in session. Return HTML input.
 */
function csrf_token() : string
{
    $token = md5(uniqid(rand(), true));

    $_SESSION['csrf_token'] = $token;
    $_SESSION['csrf_token_time'] = time();

    return '<input type="hidden" name="csrf_token" value="' . $token . '">';
}

/**
 * Validate a CSRF token.
 */
function validate_csrf_token(string $token) : bool
{
    if ($token !== $_SESSION['csrf_token']) {
        return false;
    }

    $maxTime = settings('csrf_token.max_time');

    if (($_SESSION['csrf_token_time'] + $maxTime) <= time()) {
        return false;
    }

    return true;
}

/**
 * Delete current CSRF token from session.
 */
function delete_csrf_token() : bool
{
    $_SESSION['csrf_token'] = null;
    $_SESSION['csrf_token_time'] = null;

    return true;
}
