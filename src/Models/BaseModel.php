<?php

namespace App\Models;

use App\Database\Sql;

abstract class BaseModel 
{
    protected $db;

    public function __construct($attributes = array())
    {
        $this->setAttributes($attributes);
    }

    /**
     * Set all given attributes into the model.
     */
    public function setAttributes($attributes = array())
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

        $attribute = substr($method, 3, strlen($method));

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
        unset($this->db);

        $keys = array_keys(get_object_vars($this));

        foreach ($keys as $key) {
            $attributes[$key] = $this->{'get' . $key}();
        }

        return $attributes;
    }

    /**
     * Return database instance. 
     * 
     * @return App\Database\Sql
     */
    protected function db()
    {
        if (! $this->db) {
            $this->db = new Sql();
        }

        return $this->db;
    }
}
