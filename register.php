<?php
require_once 'init.php';

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();

        $validation = $validate->check($_POST, [
            'username' => [
                'display' => "Никнейм",
                'required' => true,
                'min' => 2,
                'max' => 15,
                'unique' => 'users'
            ],
            'email' => [
                'display' => "Email",
                'required' => true,
                'email' => true,
                'unique' => 'users'
            ],
            'password' => [
                'display' => "Пароль",
                'required' => true,
                'min' => 3,
            ],
            'password_again' => [
                'display' => "Повторите пароль",
                'required' => true,
                'matches' => 'password'
            ]
        ]);


        if ($validation->passed()) {
            $user = new User();

            $user->create([
                'username' => Input::get('username'),
                'password' => password_hash(Input::get('password'), PASSWORD_DEFAULT),
                'email' => Input::get('email')
            ]);

            Session::flash('success', 'Регистрация успешна!');
            //Redirect::to('test.php');
        } else {
            foreach ($validation->errors() as $error) {
                echo $error . "</br>";
            }
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Регистрация</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<form action="" method="post">
    <span><?=Session::flash('success')?></span>
    <div class="field">
        <label for="username">Никнейм</label>
        <input type="text" name="username" class="text" value="<?= Input::get('username') ?>">
    </div>

    <div class="field">
            <label for="email">Email</label>
            <input type="text" name="email" class="text" value="<?= Input::get('email') ?>">
    </div>

    <div class="field">
        <label for="">Пароль</label>
        <input type="password" name="password">
    </div>

    <div class="field">
        <label for="">Повторите пароль</label>
        <input type="password" name="password_again">
    </div>

    <input type="hidden" name="token" value="<?=Token::generate();?>">
    <div class="field">
        <button type="submit">Отправить</button>
    </div>
</form>
</body>
</html>