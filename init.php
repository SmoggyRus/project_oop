<?php
session_start();

require_once 'classes/Database.php';
require_once 'classes/Config.php';
require_once 'classes/Validate.php';
require_once 'classes/Input.php';
require_once 'classes/Token.php';
require_once 'classes/Session.php';
require_once 'classes/User.php';
require_once 'classes/Redirect.php';

$GLOBALS['config'] = [
    'mysql' => [
        'host' => 'localhost',
        'user' => 'root',
        'password' => '',
        'database' => 'project-oop'
    ],
    'session' => [
        'token_name' => 'token',
        'user_session' => ' user_id'
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


//$users = Database::getInstance()->get('users', ['id', '=', '3']);
//
//echo $users->first()->username;
