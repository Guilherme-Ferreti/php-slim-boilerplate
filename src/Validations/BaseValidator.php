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
     * Set error bag and validated data into flash session.
     */
    public function handleFailure() : void
    {
        flash(['errorBag' => $this->errors()] + $this->getValidatedData());
    }

    /** 
     * Returns Rakit ErrorBag containing the validation errors.
    */
    public function errors() : ErrorBag
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
     * Retrieves data that went through validation.
     */
    public function getValidatedData() : array
    {
        return $this->validation->getValidatedData();
    }

    /**
     * Retrieves data that was not validated.
     */
    public function getInvalidData() : array
    {
        return $this->validation->getInvalidData();
    }

    /**
     * Treats data before validation.
     */
    protected function sanitize(array $inputs) : array
    {
        return $inputs;
    }

    /** 
     * Aliases to inputs being validated.
     */
    protected function aliases() : array
    {
        return [];
    }

    /**
     * Messages to be used for validation errors.
     */
    protected function messages() : array 
    {
        return [];
    }
    
    /**
     * Rules to be used for validation.
     */
    abstract protected function rules() : array;
}
