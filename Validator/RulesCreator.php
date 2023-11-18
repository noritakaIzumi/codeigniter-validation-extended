<?php

namespace Validator;

/**
 * CodeIgniter のバリデーターに渡すルールの配列を生成するクラス。
 * @see https://codeigniter.com/user_guide/libraries/validation.html#:~:text=Or%20as%20a%20labeled%20style%3A
 */
class RulesCreator
{
    /**
     * @var Field[]
     */
    protected array $fields = [];

    public function addField(Field $field): void
    {
        $this->fields[] = $field;
    }

    public function export(): array
    {
        $rules = [];
        foreach ($this->fields as $field) {
            $rules[$field->name] = [
                'label' => $field->label,
                'rules' => $field->fieldRules->export(),
            ];
        }

        return $rules;
    }
}
