<?php

namespace App\Controllers;

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
}
