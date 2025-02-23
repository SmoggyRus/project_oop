<?php
require_once 'Database.php';

$users = Database::getInstance()->query("SELECT * FROM users");

if ($users->error())
{
    echo "Error!";
} else {
    foreach ($users->results() as $user) {
        echo $user->username . "<br>";
    }
}

if($users->count())
{

}

