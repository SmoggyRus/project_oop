<?php
require_once 'Database.php';
require_once 'Config.php';
require_once 'Validate.php';
require_once 'Input.php';


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


//$users = Database::getInstance()->get('users', ['id', '=', '3']);
//
//echo $users->first()->username;

if (Input::exists()) {
    $validate = new Validate();

    $validation = $validate->check($_POST, [
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
        echo 'passed';
    } else {
        foreach ($validation->errors() as $error) {
            echo $error . "</br>";
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
        /* Стиль для body */
        body {
            margin: 0;
            height: 100vh; /* Высота на весь экран */
            display: grid; /* Активируем Grid */
            place-items: center; /* Одновременное центрирование по горизонтали и вертикали */
            background-color: #f4f4f9; /* Фоновый цвет */
            font-family: Arial, sans-serif; /* Шрифт */
        }

        /* Стиль для формы */
        form {
            background-color: #ffffff; /* Белый фон формы */
            padding: 20px; /* Внутренние отступы */
            border-radius: 8px; /* Закругленные углы */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Тень для объема */
            width: 300px; /* Ширина формы */
        }

        /* Стиль для блоков field */
        .field {
            margin-bottom: 15px; /* Отступ между полями */
        }

        /* Стиль для меток */
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        /* Стиль для полей ввода */
        input[type="text"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        /* Стиль для кнопки */
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff; /* Синий фон */
            color: white; /* Белый текст */
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        /* Стиль для кнопки при наведении */
        button:hover {
            background-color: #0056b3; /* Темно-синий фон */
        }
    </style>
</head>
<body>
<form action="" method="post">
    <div class="field">
        <label for="username">Никнейм</label>
        <input type="text" name="username" class="text" value="<?= Input::get('username') ?>">
    </div>
    <div class="field">
        <label for="">Пароль</label>
        <input type="text" name="password">
    </div>
    <div class="field">
        <label for="">Повторите пароль</label>
        <input type="text" name="password_again">
    </div>
    <div class="field">
        <button type="submit">Отправить</button>
    </div>
</form>
</body>
</html>
