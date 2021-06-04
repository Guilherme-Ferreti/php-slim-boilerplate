<?php

use Monolog\Logger;
use App\Helpers\Session;
use App\Helpers\View\ViewMaker;
use Monolog\Handler\StreamHandler;
use Psr\Http\Message\UploadedFileInterface;
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
 * Get or set values into session.
 */
function session($key = null, $default = null)
{
    if (is_string($key)) {
        return Session::get($key, $default);
    }

    if (is_array($key)) {
        $keys = $key;

        foreach ($keys as $key => $value) {
            Session::set($key, $value);
        }
        
        return $keys;
    }

    return Session::getAll();
}

/**
 * Get or set values into flash session.
 */
function flash($key = null, $default = null)
{
    if (is_string($key)) {
        return Session::getFlash($key, $default);
    }

    if (is_array($key)) {
        $keys = $key;

        foreach ($key as $key => $value) {
            Session::setFlash($key, $value);
        }
        
        return $keys;
    }

    return Session::get(Session::FLASH_KEY);
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
    $routeParser = $GLOBALS['app']->getRouteCollector()->getRouteParser();

    return $routeParser->urlFor($routeName, $data, $queryParams);
}

/**
 * Redirect user to specified route.
 */
function redirect(Response $response, string $routeName, array $data = [], array $queryParams = [], int $status = 200)
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

    $session_tokens = session('csrf_tokens') ?? [];

    $session_tokens[] = [
        'value' => $token, 
        'time' => time()
    ];

    session(['csrf_tokens' => $session_tokens]);

    return '<input type="hidden" name="csrf_token" value="' . $token . '">';
}

/**
 * Validate a CSRF token.
 */
function validate_csrf_token(string $token) : bool
{
    $session_tokens = session('csrf_tokens') ?? [];

    $maxTime = settings('csrf_token.max_time');

    foreach ($session_tokens as $session_token) {
        if ($token === $session_token['value'] && ($session_token['time'] + $maxTime) >= time()) {
            return true;
        }
    }

    return false;
}

/**
 * Delete current CSRF token from session.
 */
function delete_csrf_tokens() : bool
{
    session(['csrf_tokens' => null]);

    return true;
}

function encrypt(string $value, string $classname = 'OpenSSL')
{
    $classname = "\App\Helpers\Cryptography\\$classname";

    return $classname::encrypt($value);
}

function decrypt(string $value, string $classname = 'OpenSSL')
{
    $classname = "\App\Helpers\Cryptography\\$classname";

    return $classname::decrypt($value);
}

function now() : string
{
    return date('Y-m-d H:i:s');
}

function method(string $method) : string
{
    return '<input type="hidden" name="_METHOD" value="' . strtoupper($method) . '"/>';
}

/**
 * Checks if a model exists in the given array.
 */
function model_is_in_array($model, array $array) : bool
{
    foreach ($array as $value) {
        if (is_numeric($value) && $model->getId() == $value) {
            return true;
        }

        if (is_object($value) && $model->getId() == $value->getId()) {
            return true;
        }
    }

    return false;
}

/**
 * Add DIRECTORY_SEPARATOR to path segments.
 */
function path(string $path) : string
{
    $path = str_replace('//', '/', $path);
    
    return str_replace('/', DIRECTORY_SEPARATOR, $path);
}

function makeFilename(UploadedFileInterface $file) : string
{
    $extension = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);

    $basename = bin2hex(random_bytes(8));

    return sprintf('%s.%0.8s', $basename, $extension);
}

function mimetype(string $path) : string
{
    $mime_types = [
        'txt'   => 'text/plain',
        'htm'   => 'text/html',
        'html'  => 'text/html',
        'php'   => 'text/html',
        'css'   => 'text/css',
        'csv'   => 'text/csv',
        'js'    => 'application/javascript',
        'json'  => 'application/json',
        'xml'   => 'application/xml',
        'swf'   => 'application/x-shockwave-flash',
        'flv'   => 'video/x-flv',

        // images
        'png'   => 'image/png',
        'jpe'   => 'image/jpeg',
        'jpeg'  => 'image/jpeg',
        'jpg'   => 'image/jpeg',
        'gif'   => 'image/gif',
        'bmp'   => 'image/bmp',
        'ico'   => 'image/vnd.microsoft.icon',
        'tiff'  => 'image/tiff',
        'tif'   => 'image/tiff',
        'svg'   => 'image/svg+xml',
        'svgz'  => 'image/svg+xml',

        // archives
        'zip' => 'application/zip',
        'rar' => 'application/x-rar-compressed',
        'exe' => 'application/x-msdownload',
        'msi' => 'application/x-msdownload',
        'cab' => 'application/vnd.ms-cab-compressed',

        // audio/video
        'mp3'   => 'audio/mpeg',
        'qt'    => 'video/quicktime',
        'mov'   => 'video/quicktime',

        // adobe
        'pdf'   => 'application/pdf',
        'psd'   => 'image/vnd.adobe.photoshop',
        'ai'    => 'application/postscript',
        'eps'   => 'application/postscript',
        'ps'    => 'application/postscript',

        // ms office
        'doc'   => 'application/msword',
        'rtf'   => 'application/rtf',
        'xls'   => 'application/vnd.ms-excel',
        'ppt'   => 'application/vnd.ms-powerpoint',
        'docx'  => 'application/msword',
        'xlsx'  => 'application/vnd.ms-excel',
        'pptx'  => 'application/vnd.ms-powerpoint',

        // open office
        'odt'   => 'application/vnd.oasis.opendocument.text',
        'ods'   => 'application/vnd.oasis.opendocument.spreadsheet',
    ];

    return $mime_types[pathinfo($path, PATHINFO_EXTENSION)] ?? 'application/octet-stream';
}
