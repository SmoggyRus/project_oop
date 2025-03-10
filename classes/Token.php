<?php
class Token {
    public static function generate() {
        return Session::put(Config::get('session.token_name'), md5(uniqid())); // Генерация токена сессии
    }

    public static function check($token) {
        $tokenName = Config::get('session.token_name'); //token

        if (Session::exists($tokenName) && $token == Session::get($tokenName)) {
            Session::delete($tokenName);
            return true;
        }
        return false;
    }
}
