<?php

namespace App\Validations;

class ExampleValidator extends BaseValidator
{
    protected function rules() : array
    {
        return [
            'email' => 'required|email'
        ];
    }

    protected function aliases() : array
    {
        return [
            'email' => 'E-mail Address'
        ];
    }

    protected function messages() : array
    {
        return [
            'email:required' => 'Preencha o :attribute, pateta!'
        ];
    }
}