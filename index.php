<?php
require_once 'init.php';

//var_dump(Session::get(Config::get('session.user_session')));

$user = new User();
if ($user->isLoggedIn()) {
    echo "Привет, <a href='logout.php'>{$user->data()->username}</a>";
    echo "<p><a href='logout.php'>Выйти</a></p>";
    echo Session::flash('success', 'Данные успешно изменены');
    echo "<p><a href='update.php'>Редактировать данные</a></p>";
} else {
    echo "<a href='login.php'>Войти</a> или <a href='register.php'>Зарегистрироваться</a>";
}
?>