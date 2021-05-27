<?php

namespace App\Validations\Rules;

use Rakit\Validation\Rule;

class Array_Values_Unique extends Rule
{
    protected $message = "O campo :attribute deve conter valores únicos.";

    public function check($array) : bool
    {
        $unique = array_unique($array);

        return count($unique) == count($array);
    }
}
