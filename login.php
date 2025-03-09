<?php
require_once 'init.php';

if(Input::exists()) {
    if(Token::check(Input::get('token'))) {
        $validate = new Validate();

        $validate->check($_POST, [
            'email' => ['required' => true, 'email' => true],
            'password' => ['required' => true],
        ]);

        if ($validate->passed()) {
            $user = new User();

            $login = $user->login(Input::get('email'), Input::get('password'));
            if($login) {
                echo 'Успешно авторизован!';
            } else {
                echo 'Ошибка авторизации!';
            }
        } else {
            foreach ($validate->errors() as $error) {
                echo $error . '</br>';
            }
        }
    }
}
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Авторизация</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<form action="" method="post">
    <div class="field">
        <label for="email">Email</label>
        <input type="text" name="email" class="text" value="<?= Input::get('email') ?>">
    </div>

    <div class="field">
        <label for="">Пароль</label>
        <input type="password" name="password">
    </div>

    <input type="hidden" name="token" value="<?=Token::generate();?>">
    <div class="field">
        <button type="submit">Войти</button>
    </div>
</form>
</body>
</html>
