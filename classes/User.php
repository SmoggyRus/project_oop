<?php
class User {
    private $db, $data, $session_name, $isLoggedIn;

    public function __construct($user = null) {
        $this->db = Database::getInstance();
        $this->session_name = Config::get('session.user_session');

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

    public function login($email = null, $password = null) {
        if($email) {
            $user = $this->find($email);
            if (password_verify($password, $this->getData()->password)){
                Session::put($this->session_name, $this->getData()->id);
                return true;
            }
            return false;
        }
    }

    public function find($value = null) {
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

    public function getData() {
        return $this->data;
    }

    public function isLoggedIn() {
        return $this->isLoggedIn;
    }
}