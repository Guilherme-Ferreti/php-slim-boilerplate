<?php

namespace App\Validations;

use Rakit\Validation\Validator; // For more information on how to use this class please see https://github.com/rakit/validation
use Rakit\Validation\ErrorBag;

abstract class BaseValidator
{
    const RULES_DIRECTORY = __DIR__ . '/Rules';
    const RULES_NAMESPACE = "\App\Validations\Rules\\";

    protected $validation;

    /** Model to be used for the validation rules */
    protected $model;

    public function __construct(array $inputs, $model = null)
    {
        $this->model = $model;

        $validator = new Validator();

        $this->addCustomValidators($validator);

        $this->validation = $validator->make($this->sanitize($inputs), $this->rules());

        $this->validation->setAliases($this->aliases());
        $this->validation->setMessages($this->messages());

        $this->validation->validate();
    }

    /**
     * Adds custom validation rules to the validator object.
     */
    protected function addCustomValidators(Validator $validator)
    {
        $files = scandir(self::RULES_DIRECTORY);

        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $file = str_replace('.php', '', $file);

            $class = self::RULES_NAMESPACE . $file;

            $validator->addValidator(strtolower($file), new $class());
        }
    }
    
    /**
     * Returns if the validation has failed.
     */
    public function fails() : bool
    {
        return $this->validation->fails();
    }

    /** 
     * Returns Rakit ErrorBag containing the validation errors.
    */
    public function getErrors() : ErrorBag
    {
        return $this->validation->errors();
    }

    /**
     * Retrivies data that was successfully validated.
     */
    public function getValidData() : array
    {
        return $this->validation->getValidData();
    }

    /**
     * Treats data before validation.
     */
    protected function sanitize(array $inputs) : array
    {
        return $inputs;
    }

    /**
     * Rules to be used for validation.
     */
    abstract protected function rules() : array;

    /** 
     * Aliases to inputs being validated.
    */
    abstract protected function aliases() : array;

    /**
     * Messages to be used for validation errors.
     */
    abstract protected function messages() : array;
}
