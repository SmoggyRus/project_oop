<?php
class User {
    private $db, $data;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function create($fields = []) {
        $this->db->insert("users", $fields);
    }

    public function login($email = null, $password = null) {
        if($email) {
            $user = $this->find($email);
            if (password_verify($password, $this->getData()->password)){
                Session::put('user_id', $this->getData()->id);
                return true;
            }
            return false;
        }
    }

    public function find($email = null) {
        $this->data = $this->db->get('users', ['email', '=', $email])->first();
        if ($this->data) {
            return true;
        }
        return false;
    }

    public function getData() {
        return $this->data;
    }
}