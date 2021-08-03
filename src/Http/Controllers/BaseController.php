<?php

namespace App\Http\Controllers;

use App\Helpers\View\ViewMaker;
use Psr\Http\Message\ResponseInterface as Response;

abstract class BaseController
{
    const POLICIES_NAMESPACE = '\App\Policies\\';

    protected function authorize(string $action, $model, $user = null) : bool
    {
        if (! $user) {
            // Grab authenticated user
            // $user = auth_user();
        }

        if (is_string($model)) {
            $model = "\App\Models\\$model";

            $modelname = str_replace('\\', '', strrchr($model, '\\'));
        }

        if (is_object($model)) {
            $modelname = get_class($model);
        }

        $classname = self::POLICIES_NAMESPACE . $modelname . 'Policy';

        $policy = new $classname();

        return $policy->$action($user, $model);
    }

    protected function view(Response $response, string $pathToView, array $variables = [])
    {
        return ViewMaker::make($pathToView, $variables, $response);
    }

    protected function redirect(Response $response, string $routeName, array $data = [], array $queryParams = [], int $status = 200)
    {
        return $response
                ->withHeader('location', url_for($routeName, $data, $queryParams))
                ->withStatus($status);
    }

    protected function json(Response $response, array $payload = [], int $status = 200): Response
    {
        $response->getBody()->write(json_encode($payload));

        return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus($status);
    }
}
