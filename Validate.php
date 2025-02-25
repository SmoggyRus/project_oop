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
            foreach ($rules as $rule => $rule_value) {

                $value = trim($source[$item]); // Получаем значение поля из данных

                if ($rule == 'required' && empty($value)) {
                    $this->addError("{$item} обязательно для заполнения");
                } elseif (!empty($value)) {
                    switch ($rule) {
                        case 'min':
                            if (strlen($value) < $rule_value) {
                                $this->addError("{$item} должно содержать минимум {$rule_value} символов");
                            }
                            break;
                        case 'max':
                            if (strlen($value) > $rule_value) {
                                $this->addError("{$item} должно содержать максимум {$rule_value} символов");
                            }
                            break;
                        case 'matches':
                            if ($value != $source[$rule_value]) {
                                $this->addError("{$rule_value} не совпадает");
                            }
                            break;
                        case 'unique':
                            $check = $this->db->get($rule_value, [$item, '=', $value]);
                            if ($check->count()) {
                                $this->addError("{$item} уже существует");
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