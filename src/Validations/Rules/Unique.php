<?php

namespace App\Validations\Rules;

use Rakit\Validation\Rule;

class Unique extends Rule
{
    protected $message = "O valor para o campo :attribute já está cadastrado.";
    protected $fillableParams = ['table', 'column', 'except_id'];
    protected $requiredParams = ['table', 'column'];

    public function check($value) : bool
    {
        $this->requireParameters($this->requiredParams);

        $table = $this->parameter('table');
        $column = $this->parameter('column');
        $except_id = (int) $this->parameter('except_id');

        $db = new \App\Database\Sql();

        $results = $db->select("SELECT COUNT($column) AS total_rows FROM $table WHERE $column = :value AND id != :id", [':value' => $value, ':id' => $except_id]);

        return (int) $results[0]['total_rows'] === 0;
    }
}
