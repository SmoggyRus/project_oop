<?php
require_once 'init.php';

 echo "<p>" . Session::flash('success') . "</p>";
$user = new User();
if ($user->isLoggedIn()) {
    echo "Привет, <a href='/'>{$user->data()->username}</a>";
    echo "<p><a href='logout.php'>Выйти</a></p>";
    echo "<p><a href='update.php'>Редактировать данные</a></p>";
    echo "<p><a href='changepassword.php'>Сменить пароль</a></p>";
} else {
    echo "<a href='login.php'>Войти</a> или <a href='register.php'>Зарегистрироваться</a>";
}
?>