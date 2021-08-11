<?php

namespace App\Http\Controllers;

use Slim\Psr7\Response;
use App\Models\BaseModel;
use App\Helpers\View\ViewMaker;

abstract class BaseController
{
    const POLICIES_NAMESPACE = '\App\Policies\\';

    protected function authorize(string $action, string|BaseModel $model, $user = null): bool
    {
        $model_class = is_string($model) ? $model : get_class($model);

        $model_class = str_replace('\\', '', strrchr($model_class, '\\'));

        $policy_class = self::POLICIES_NAMESPACE . $model_class . 'Policy';

        $policy = new $policy_class();

        return $policy->$action($user ?? auth_user(), $model);
    }

    protected function view(string $pathToView, array $variables = []): Response
    {
        return ViewMaker::make($pathToView, $variables, new Response());
    }

    protected function redirect(string $routeName, array $data = [], array $queryParams = [], int $status = 200): Response
    {
        return (new Response())
                ->withHeader('location', url_for($routeName, $data, $queryParams))
                ->withStatus($status);
    }

    protected function json(array $payload = [], int $status = 200): Response
    {
        $response = new Response();

        $response->getBody()->write(json_encode($payload));

        return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus($status);
    }
}
