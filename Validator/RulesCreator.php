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

    public function addField(Field $field): static
    {
        $this->fields[] = $field;
        return $this;
    }

    public function export(): array
    {
        $rules = [];
        foreach ($this->fields as $field) {
            $rule = [
                'label' => $field->label,
                'rules' => $field->rules->getRules(),
            ];
            $errors = $field->rules->getErrors();
            if ($errors !== []) {
                $rule['errors'] = $errors;
            }

            $rules[$field->name] = $rule;
        }

        return $rules;
    }
}
