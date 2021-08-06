<?php

namespace App\Validations;

use Rakit\Validation\ErrorBag;
use App\Exceptions\ValidationException;
use App\Models\BaseModel;
use Rakit\Validation\Validator; // For more information on how to use this class please see https://github.com/rakit/validation

abstract class BaseValidator
{
    const RULES_DIRECTORY = __DIR__ . '/Rules';
    const RULES_NAMESPACE = "\App\Validations\Rules\\";

    protected $validation;

    /** Model to be used for the validation rules */
    protected $model;

    /** 
     * Model that should be ignored whe validating.
    */
    public function ignore(BaseModel $model): self
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Run the validation.
     */
    public function validate(array $inputs): array
    {
        $validator = new Validator();

        $this->addCustomRules($validator);

        $this->validation = $validator->make($this->sanitize($inputs), $this->rules());

        $this->validation->setAliases($this->aliases());
        $this->validation->setMessages($this->messages());

        $this->validation->validate();

        if ($this->validation->fails()) {
            throw new ValidationException($this);
        }

        return $this->validation->getValidData();
    }

    /**
     * Adds custom validation rules to the validator object.
     */
    protected function addCustomRules(Validator $validator)
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
     * Set error bag and validated data into flash session.
     */
    public function flashErrorBagAndValidatedInputs(): void
    {
        flash(['errorBag' => $this->errors()] + $this->validation->getValidatedData());
    }

    /** 
     * Returns Rakit ErrorBag containing the validation errors.
    */
    public function errors(): ErrorBag
    {
        return $this->validation->errors();
    }

    /**
     * Treats data before validation.
     */
    protected function sanitize(array $inputs): array
    {
        return $inputs;
    }

    /** 
     * Aliases to inputs being validated.
     */
    protected function aliases(): array
    {
        return [];
    }

    /**
     * Messages to be used for validation errors.
     */
    protected function messages(): array 
    {
        return [];
    }
    
    /**
     * Rules to be used for validation.
     */
    abstract protected function rules(): array;
}
