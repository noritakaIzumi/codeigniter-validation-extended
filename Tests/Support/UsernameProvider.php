<?php

namespace Tests\Support;

readonly class UsernameProvider
{
    /**
     * @param array $data an array of data to validate
     * @param bool $isValid expected result of validator
     * @param string $message message if test fails
     */
    public function __construct(public array $data, public bool $isValid, public string $message)
    {
    }
}
