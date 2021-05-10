<?php

namespace App\Validations\Rules;

use Rakit\Validation\Rule;
use Illuminate\Database\Capsule\Manager as DB;

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

        $results = DB::table($table)->where($column, $value)->where('id', '!=', $except_id)->get();

        return count($results) === 0;
    }
}
