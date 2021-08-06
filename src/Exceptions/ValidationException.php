<?php

namespace App\Exceptions;

use App\Validations\BaseValidator;

class ValidationException extends \Exception
{
    protected $message = 'The provided inputs are invalid.';
    protected $code = 422;
    public $validator;

    public function __construct(BaseValidator $validator)
    {
        $this->validator = $validator;
    }
}
