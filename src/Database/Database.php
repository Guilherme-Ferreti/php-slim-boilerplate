<?php

namespace App\Database;

Trait Database
{
    protected $db;

    protected function db()
    {
        if (! $this->db) {
            $this->db = new Sql();
        }

        return $this->db;
    }
    
    public static function create($attributes)
    {
        $self = new self($attributes);

        if (! $self->save()) {
            return false;
        }

        return $self;
    }
}