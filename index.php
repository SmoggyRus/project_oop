<?php
session_start();

require_once 'Database.php';
require_once 'Config.php';
require_once 'Validate.php';
require_once 'Input.php';
require_once 'Token.php';
require_once 'Session.php';
require_once 'User.php';
require_once 'Redirect.php';

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

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();

        $validation = $validate->check($_POST,        [
            'username' => [
                'display' => "Никнейм",
                'required' => true,
                'min' => 2,
                'max' => 15,
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
            ]);

            Session::flash('success','Регистрация успешна!');
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
    <title>Главная</title>
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f0f2f5;
            font-family: "Segoe UI", system-ui, sans-serif;
        }

        form {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            width: 320px;
            padding: 25px 20px;
            box-sizing: border-box; /* Добавлено */
        }

        .field {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 4px;
            font-size: 13px;
            color: #333;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            border: 2px solid #e5e7eb;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            box-sizing: border-box; /* Добавлено */
            margin: 0; /* Добавлено */
        }

        input:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 2px rgba(99,102,241,0.2);
        }

        button {
            width: 100%;
            padding: 11px 16px;
            background: #6366f1;
            border: 0;
            border-radius: 6px;
            font-size: 15px;
            color: white;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 8px;
            box-sizing: border-box; /* Добавлено */
        }

        button:hover {
            background: #4f46e5;
            transform: translateY(-1px);
        }

        button:active {
            transform: translateY(0);
        }

        /* Фикс для автозаполнения */
        input:-webkit-autofill {
            -webkit-box-shadow: 0 0 0px 1000px white inset;
            -webkit-text-fill-color: #333;
        }

        /* Адаптивность */
        @media (max-width: 360px) {
            form {
                width: 100%;
                max-width: 320px;
                padding: 20px 15px;
            }
        }
    </style>
</head>
<body>
<form action="" method="post">
    <p><?=Session::flash('success')?></p>
    <div class="field">
        <label for="username">Никнейм</label>
        <input type="text" name="username" class="text" value="<?= Input::get('username') ?>">
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
