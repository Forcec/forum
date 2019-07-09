<title>Вход</title>
<?php
include_once "menu.php";
require_once "db.php" ?>
<form class="registration" method="post" action="sign_in.php">
    email<br>
    <input type="text" class="registration" name="email_of_user"></input><br>
    Пароль<br>
    <input type="password" class="registration" name="password_of_user"></textarea><br>
    <label class="container"><h6 id="show_password">Показать пароль</h6>
        <input type="checkbox">
        <span class="checkmark"></span>
    </label>

    <input class="registration" type="submit" value="Войти" name="sign_in">
</form>
<?php
if (isset($_POST['sign_in'])) {
    if (is_sign_in($db, $_POST['email_of_user'],$_POST['password_of_user'])) {
        session_start();
        $_SESSION['email_of_user'] = $_POST['email_of_user'];
        $_SESSION['password_of_user'] = $_POST['password_of_user'];
        echo 'Здравствуйте, '. $_SESSION["email_of_user"].PHP_EOL;
    } else {
        echo 'Ошибка!';
    }
}