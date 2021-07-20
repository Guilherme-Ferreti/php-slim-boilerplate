<?php

namespace App\Resources;

/**
 * Resources keep the logic for parsing any model to an array.
 */
abstract class BaseResource
{
    /**
     * Returns a model as an array.
     */
    public static function toArray($model) : array
    {
        return $model->toArray();
    }

    /**
     * Transforms an array of models into a commmon array.
     */
    public static function collection(array $models) : array
    {
        return array_map(fn ($model) => self::toArray($model), $models);
    }
}
