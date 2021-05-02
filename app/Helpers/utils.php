<?php

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

function logger(string $name = 'app')
{
    $stream = config('logs.path') . "$name.log";

    $logger = new Monolog\Logger($name);

    $logger->pushHandler(new Monolog\Handler\StreamHandler($stream));

    return $logger;
}

/**
 * Return the URL for the given route.
 * 
 * @param string $routeName     Name of the route.
 * @param array $data           Data to be used in the URI.
 * @param array $queryParams    Data to be used in the query string.
 */
function urlFor(string $routeName, array $data = [], array $queryParams = [])
{
    global $app;

    $routeParser = $app->getRouteCollector()->getRouteParser();

    return $routeParser->urlFor($routeName, $data, $queryParams);
}

/**
 * Redirect user to specified route.
 * 
 * @param string $routeName         Name of the route to redirect to.
 * @param array $data               Data to be binded to the URI.
 * @param array $queryParams        Data to be binded to the route's query string.
 * @param int $status               HTTP response status.
 */
function redirect($response, string $routeName, array $data = [], array $queryParams = [], int $status = 200)
{
    return $response->withHeader('location', urlFor($routeName, $data, $queryParams))->withStatus($status);
}

/**
 * Remove all non-numeric characters from a string.
 */
function onlyNumbers(string $string) : string
{
    return preg_replace("/[^0-9]/", '', $string);
}
