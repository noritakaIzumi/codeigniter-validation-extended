<?php

namespace Validator;

class Rules
{
    /**
     * @var string[]
     */
    protected array $rules = [];

    public function _export(): array
    {
        return $this->rules;
    }

    public function required(): static
    {
        $this->rules[] = 'required';
        return $this;
    }

    public function minLength(int $length): static
    {
        $this->rules[] = "min_length[$length]";
        return $this;
    }

    public function maxLength(int $length): static
    {
        $this->rules[] = "max_length[$length]";
        return $this;
    }

    /** @noinspection SpellCheckingInspection */
    public function alphaNumericPunct(): static
    {
        $this->rules[] = "alpha_numeric_punct";
        return $this;
    }
}
