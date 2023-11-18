<?php

namespace Validator;

readonly class Field
{
    /**
     * @param string $name
     * @param string $label
     * @param FieldRules $rules
     */
    public function __construct(public string $name, public string $label, public FieldRules $rules)
    {
    }
}
