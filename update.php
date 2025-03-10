<?php
require_once 'init.php';

$user = new User();

$validate = new Validate();
$validation = $validate->check($_POST, [
    'username' => [
        'display' => "Никнейм",
        'required' => true,
        'min' => 2,
        'max' => 15,
        'unique' => 'users'
    ]
]);

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        if ($validate->passed()) {
            $user->update([
                'username' => Input::get('username')
            ]);
            Session::flash('success','Данные успешно обновлены!');
            Redirect::to('index.php');
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
    <title>Редактирование данных</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<form action="" method="post">
    <div class="field">
        <label for="username">Никнейм</label>
        <input type="text" name="username" class="text" value="<?=$user->data()->username?>">
    </div>

    <input type="hidden" name="token" value="<?=Token::generate()?>">
    <div class="field">
        <button type="submit">Изменить</button>
    </div>
</form>
</body>
</html>