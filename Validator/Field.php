<?php

namespace Validator;

readonly class Field
{
    /**
     * @param string $name
     * @param string $label
     * @param Rules $rules
     */
    public function __construct(public string $name, public string $label, public Rules $rules)
    {
    }
}
