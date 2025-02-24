<?php
require_once 'Database.php';
require_once 'Config.php';

$GLOBALS['config'] = [
    'mysql' => [
        'host' => 'localhost',
        'user' => 'root',
        'password' => '',
        'database' => 'project-oop'
    ]
];

//$users = Database::getInstance()->query("SELECT * FROM users WHERE username IN (?, ?)", ['John Doe','Jane Koe']);
//$users = Database::getInstance()->get('users', ['password', '=', 'password1']);
//$users = Database::getInstance()->delete('users', ['username', '=', 'Jane Koe']);

//$id = 3;
//Database::getInstance()->update('users', $id , [
//        'username' => 'Ruslan2',
//        'password' => 'password2'
//    ]);


$users = Database::getInstance()->get('users', ['id', '=', '3']);

echo $users->first()->username;
echo '<br>';
echo $users->first()->password;

//if ($users->error()){
//    echo "Error!";
//} else {
//    foreach ($users->results() as $user) {
//        echo $user->username . "<br>";
//    }
//}
