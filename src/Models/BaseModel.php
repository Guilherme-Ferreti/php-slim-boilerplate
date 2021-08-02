<?php

namespace App\Models;

use App\Database\Database;

abstract class BaseModel 
{
    use Database;
    
    protected array $attributes = [];

    public function __construct(array $attributes = [])
    {
        $this->setAttributes($attributes);
    }

    /**
     * Set all given attributes into the model.
     */
    public function setAttributes(array $attributes = []): self
    {
        foreach ($attributes as $attribute => $value) {
            $this->{$attribute} = $value;
        }

        return $this;
    }

    public function __set($attribute, $value)
    {
        $method = 'set' . ucfirst($attribute) . 'Attribute';
        
        if (method_exists($this, $method)) {
            return $this->$method($value);
        }

        return $this->attributes[$attribute] = $value;    
    }

    public function __get($attribute)
    {
        $method = 'get' . ucfirst($attribute) . 'Attribute';

        if (method_exists($this, $method)) {
            return $this->$method();
        }

        if (isset($this->attributes[$attribute])) {
            return $this->attributes[$attribute];
        }
    }

    /**
     * Return all class properties as an array.
     * 
     * @return array
     */
    public function toArray(): array
    {
        return array_map(function ($attribute) {
            if (is_subclass_of($attribute, Self::class)) {
                $attribute = $attribute->toArray();
            }

            if (is_array($attribute)) {
                $attribute = array_map(function ($item) {
                    if (is_subclass_of($item, Self::class)) {
                        $item = $item->toArray();
                    }

                    return $item;
                }, $attribute);
            }

            return $attribute;
        }, $this->attributes);
    }
}
