<?php

namespace App\Validations\Rules;

use Rakit\Validation\Rule;

class Unique extends Rule
{
    protected $message = "O valor para o campo :attribute já está cadastrado.";
    protected $fillableParams = ['table', 'column'];

    public function check($value) : bool
    {
        $this->requireParameters($this->fillableParams);

        $table = $this->parameter('table');
        $column = $this->parameter('column');

        $db = new \App\Database\Sql();

        $results = $db->select("SELECT * FROM $table WHERE $column = :value", [':value' => $value]);

        return count($results) === 0;
    }
}
