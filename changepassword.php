<?php
require_once 'init.php';

$user = new User();

$validate = new Validate();
$validation = $validate->check($_POST, [
    'current_password' => [
        'display' => "Текущий пароль",
        'required' => true,
        'min' => 3
    ],
    'new_password' => [
        'display' => "Новый пароль",
        'required' => true,
        'min' => 3
    ],
    'new_password_again' => [
        'display' => "Повторите новый пароль",
        'required' => true,
        'min' => 3,
        'matches' => 'new_password'
    ],
]);

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        if ($validate->passed()) {

            if (password_verify(Input::get('current_password'), $user->data()->password)) {
                $user->update(['password' => password_hash(Input::get('new_password'), PASSWORD_DEFAULT)]);
                Session::flash('success','Пароль успешно изменён!');
                Redirect::to('index.php');
            } else {
                echo 'Текущий пароль указан неверно!';
            }
        } else {
            foreach ($validation->errors() as $error) {
                echo $error . "</br>";
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
    <title>Смена пароля</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<form action="" method="post">
    <div class="field">
        <label for="">Текущий пароль</label>
        <input type="password" name="current_password">
    </div>
    <div class="field">
        <label for="">Новый пароль</label>
        <input type="password" name="new_password">
    </div>

    <div class="field">
        <label for="">Повторите новый пароль</label>
        <input type="password" name="new_password_again">
    </div>

    <input type="hidden" name="token" value="<?=Token::generate()?>">
    <div class="field">
        <button type="submit">Сменить пароль</button>
    </div>
</form>
</body>
</html>