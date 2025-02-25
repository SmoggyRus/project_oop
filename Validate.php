<?php

class Validate
{
    private $passed = false,
            $errors = [],
            $db = null;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function check($source, $items = []) {
        foreach ($items as $item => $rules) {
            $display = isset($rules['display']) ? $rules['display'] : str_replace('_', ' ', $item); // Используем название поля, если оно задано


            foreach ($rules as $rule => $rule_value) {
                if ($rule === 'display') continue; // Пропускаем display, тк оно только для сообщений об ошибке

                $value = trim($source[$item]); // Получаем значение поля из данных

                if ($rule == 'required' && empty($value)) {
                    $this->addError("{$display} обязательно для заполнения");
                } elseif (!empty($value)) {
                    switch ($rule) {
                        case 'min':
                            if (strlen($value) < $rule_value) {
                                $this->addError("{$display} должно содержать минимум {$rule_value} символов");
                            }
                            break;
                        case 'max':
                            if (strlen($value) > $rule_value) {
                                $this->addError("{$display} должно содержать максимум {$rule_value} символов");
                            }
                            break;
                        case 'matches':
                            if ($value != $source[$rule_value]) {
                                $this->addError("Поле {$display} должно совпадать с паролем");
                            }
                            break;
                        case 'unique':
                            $check = $this->db->get($rule_value, [$item, '=', $value]);
                            if ($check->count()) {
                                $this->addError("{$display} уже существует");
                            }
                        break;

                    }
                }
            }
        }
        if(empty($this->errors)) {
            $this->passed = true;
        }
        return $this;
    }

    public function addError($error) {
        $this->errors[] = $error;
    }

    public function errors() {
        return $this->errors;
    }

    public function passed() {
        return $this->passed;
    }
}