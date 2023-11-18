<?php

namespace Validator;

readonly class Field
{
    /**
     * @param string $name
     * @param string $label
     * @param FieldRule $fieldRules
     */
    public function __construct(public string $name, public string $label, public FieldRule $fieldRules)
    {
    }
}
