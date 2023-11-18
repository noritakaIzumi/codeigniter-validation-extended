<?php

namespace Validator;

class FieldRules
{
    /**
     * @var string[]
     */
    protected array $rules = [];
    /**
     * @var array<string, string>
     */
    protected array $errors = [];

    public function getRules(): array
    {
        return $this->rules;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function required(string $message = ''): static
    {
        $this->rules[] = 'required';
        if ($message !== '') {
            $this->errors['required'] = $message;
        }
        return $this;
    }

    public function minLength(int $length, string $message = ''): static
    {
        $this->rules[] = "min_length[$length]";
        if ($message !== '') {
            $this->errors['min_length'] = $message;
        }
        return $this;
    }

    public function maxLength(int $length, string $message = ''): static
    {
        $this->rules[] = "max_length[$length]";
        if ($message !== '') {
            $this->errors['max_length'] = $message;
        }
        return $this;
    }

    /** @noinspection SpellCheckingInspection */
    public function alphaNumericPunct(string $message = ''): static
    {
        $this->rules[] = "alpha_numeric_punct";
        if ($message !== '') {
            $this->errors['alpha_numeric_punct'] = $message;
        }
        return $this;
    }
}
