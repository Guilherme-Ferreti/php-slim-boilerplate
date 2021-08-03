<?php

namespace App\Helpers\View;

use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;
use App\Helpers\View\ViewFunctions;

class ViewMaker
{
    public static function make(string $pathToView, array $variables = array(), Response $response = null)
    {
        $pathToView = str_replace('.', '/', $pathToView);

        $debug = (settings('app.environment') === 'dev');

        $settings = [
            'cache' => path(settings('views.cache_path')),
            'debug' => $debug,
            'strict_variables' => $debug,
        ];

        $twig = Twig::create(path(settings('views.path')), $settings);

        $twig->addExtension(new ViewFunctions());

        $defaults = [];

        $variables = array_merge($defaults, $variables);

        $pathToView .= settings('views.extension');

        if ($response) {
            return $twig->render($response, $pathToView, $variables);
        }

        return $twig->fetch(path($pathToView), $variables);
    }
}
