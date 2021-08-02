<?php

namespace App\Database;

use App\Database\Sql;

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
}