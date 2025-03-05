<?php
class Session {
    public static function put($name, $value) { // Запись сессии
        return $_SESSION[$name] = $value;
    }

    public static function exists($name) { // Проверка на существование значения в сессии
        return (isset($_SESSION[$name])) ? true : false;
    }

    public static function delete($name) { // Удаление записи из сессии
        if (self::exists($name)) {
            unset($_SESSION[$name]);
        }
    }

    public static function get($name) { // Получение записи из сессии
        return $_SESSION[$name];
    }

    public static function flash($name, $string = '') {
        if (self::exists($name) && self::get($name) !== '') {
            $session = self::get($name);
            self::delete($name);
            return $session;
        } else {
            self::put($name, $string);
        }
    }
}