<?php

namespace App\Validations\Rules;

use Rakit\Validation\Rule;

class Array_Values_Unique extends Rule
{
    protected $message = "The field :attribute must contain only unique values.";

    public function check($array) : bool
    {
        $unique = array_unique($array);

        return count($unique) == count($array);
    }
}
