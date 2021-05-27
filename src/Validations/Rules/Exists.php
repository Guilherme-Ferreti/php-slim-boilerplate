<?php

namespace App\Validations\Rules;

use Rakit\Validation\Rule;

class Exists extends Rule
{
    protected $message = "O valor para o campo :attribute não existe.";
    protected $fillableParams = ['table', 'column'];
    protected $requiredParams = ['table', 'column'];

    public function check($value) : bool
    {
        $this->requireParameters($this->requiredParams);

        $table = $this->parameter('table');
        $column = $this->parameter('column');

        $db = new \App\Database\Sql();

        $results = $db->select("SELECT count($column) AS total_rows FROM $table WHERE $column = :value", [':value' => $value]);

        return (int) $results[0]['total_rows'] >= 1;
    }
}
