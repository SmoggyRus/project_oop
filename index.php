<?php
require_once 'Database.php';

//$users = Database::getInstance()->query("SELECT * FROM users WHERE username IN (?, ?)", ['John Doe','Jane Koe']);
$users = Database::getInstance()->get('users', ['password', '=', 'password1']);
//$users = Database::getInstance()->delete('users', ['username', '=', 'Jane Koe']);


if ($users->error()){
    echo "Error!";
} else {
    foreach ($users->results() as $user) {
        echo $user->username . "<br>";
    }
}
