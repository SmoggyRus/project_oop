<?php
class User {
    private $db, $data, $session_name, $isLoggedIn, $cookieName;

    public function __construct($user = null) {
        $this->db = Database::getInstance();
        $this->session_name = Config::get('session.user_session');
        $this->cookieName = Config::get('cookie.cookie_name');

        if (!$user) {
            if (Session::exists($this->session_name)) {
                $user = Session::get($this->session_name); // id текущего пользователя

                if ($this->find($user)) {
                    $this->isLoggedIn = true;
                } else {
                    //Logout
                }
            }
        } else {
            $this->find($user);
        }
    }

    public function create($fields = []) {
        $this->db->insert("users", $fields);
    }

    public function update($fields = [], $id = null) {
        if (!$id && $this->isLoggedIn()) {
            $id = $this->data()->id;
        }

        $this->db->update("users", $id, $fields);
    }

    public function login($email = null, $password = null, $remember = false) {
        if (!$email && !$password && $this->exists()) {
            Session::put($this->session_name, $this->data()->id);
        } else {
            $user = $this->find($email);
            if($user) {
                if (password_verify($password, $this->data()->password)){
                    Session::put($this->session_name, $this->data()->id);

                    if ($remember) {
                        $hash = hash('sha256', uniqid()); // Генерация хэша

                        $hashCheck = $this->db->get('user_sessions', ['user_id', '=', $this->data()->id]); //Запрос к БД, поиск текущий записи

                        if (!$hashCheck->count()) { // Если её нет, то записываем в БД
                            $this->db->insert("user_sessions", [
                                'user_id' => $this->data()->id,
                                'hash' => $hash
                            ]);
                        } else {
                            $hash = $hashCheck->first()->hash; // Если есть вытаскиваем запись из БД, и берём хеш
                        }
                       Cookie::put($this->cookieName, $hash, Config::get('cookie.cookie_expiry')); // Прописываем хэш сюда
                    }
                    return true;
                }
                return false;
            }
        }
    }

    public function find($value = null) { // Обертка
        if(is_numeric($value)) {
            $this->data = $this->db->get('users', ['id', '=', $value])->first();
        } else {
            $this->data = $this->db->get('users', ['email', '=', $value])->first();
        }
        if ($this->data) {
            return true;
        }
        return false;
    }

    public function Data() {
        return $this->data;
    }

    public function isLoggedIn() {
        return $this->isLoggedIn;
    }

    public function logout() {
        Session::delete($this->session_name);
        Cookie::delete($this->cookieName);
    }

    public function exists() {
        return (!empty($this->data())) ? true : false;
    }

}