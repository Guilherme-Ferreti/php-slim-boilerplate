<?php

namespace App\Validations;

use Rakit\Validation\Validator; // For more information on how to use this class please see https://github.com/rakit/validation

abstract class BaseValidator
{
    const RULES_DIRECTORY = __DIR__ . '/Rules';

    protected $validation;

    public function __construct(array $inputs)
    {
        $validator = new Validator();

        $this->addCustomValidators($validator);

        $this->validation = $validator->make($this->sanitize($inputs), $this->rules());

        $this->validation->setAliases($this->aliases());
        $this->validation->setMessages($this->messages());

        $this->validation->validate();
    }

    protected function addCustomValidators(Validator $validator)
    {
        $files = scandir(self::RULES_DIRECTORY);

        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $file = str_replace('.php', '', $file);

            $class = "\App\Validations\Rules\\$file";

            $validator->addValidator(strtolower($file), new $class());
        }
    }
    
    public function fails() : bool
    {
        return $this->validation->fails();
    }

    public function getErrors()
    {
        return $this->validation->errors();
    }

    public function getValidData() : array
    {
        return $this->validation->getValidData();
    }

    protected function sanitize(array $inputs) : array
    {
        return $inputs;
    }

    abstract protected function rules() : array;

    abstract protected function aliases() : array;

    abstract protected function messages() : array;
}
