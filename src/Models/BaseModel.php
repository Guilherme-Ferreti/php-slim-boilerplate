<?php

namespace App\Models;

use App\Database\Sql;

abstract class BaseModel 
{
    public function __construct(array $attributes = [])
    {
        $this->setAttributes($attributes);
    }

    /**
     * Set all given attributes into the model.
     */
    public function setAttributes(array $attributes = [])
    {
        foreach ($attributes as $attribute => $value) {
            $this->{'set' . $attribute}($value);
        }
    }

    /**
     * Case there is no getter or setter defined for the attribute.
     */
    public function __call($method, $args)
    {
        $operation = substr($method, 0, 3);

        $attribute = strtolower(substr($method, 3, strlen($method)));

        switch ($operation) {
            case 'get':
                return $this->{$attribute};

            case 'set':
                $this->{$attribute} = $args[0];
        }
    }

    /**
     * Return all class properties as an array.
     * 
     * @return array
     */
    public function toArray() : array
    {
        $keys = array_keys(get_object_vars($this));

        $hide = ['db'];

        foreach ($keys as $key) {
            if (in_array($key, $hide)) continue;
            
            $attributes[$key] = $this->{'get' . $key}();
        }

        return $attributes;
    }
}
