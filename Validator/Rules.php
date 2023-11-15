<?php

namespace Validator;

class Rules
{
    protected const DELIMITER = '|';
    /**
     * @var string[]
     */
    protected array $rules = [];

    public function _export(): string
    {
        return implode(self::DELIMITER, $this->rules);
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
}
