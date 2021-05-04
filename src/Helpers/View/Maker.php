<?php

namespace App\Helpers\View;

use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;
use App\Helpers\View\Functions as ViewFunctions;

class Maker
{
    public static function make(string $pathToView, array $variables = array(), Response $response = null)
    {
        $settings = [
            'cache' => settings('views.cache_path'),
            'debug' => settings('app.debug'),
            'strict_variables' => settings('app.debug'),
        ];

        $twig = Twig::create(settings('views.path'), $settings);

        $twig->addExtension(new ViewFunctions());

        $defaults = [];

        $variables = array_merge($defaults, $variables);

        $pathToView .= settings('views.extension');

        if ($response) {
            return $twig->render($response, $pathToView, $variables);
        }

        return $twig->fetch($pathToView, $variables);

    }
}