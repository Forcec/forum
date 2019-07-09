<title>Регистрация</title>
<?php
include_once "menu.php";
#region Проверка корректности данных для регистрации
require_once("db.php");

function check_registration($login_of_user, $email_of_user,
                            $password_of_user, $repeat_password_of_user, $db)
{
    $check = 1;
    if (count(return_errors_in_login($login_of_user)) != 1 || count(return_errors_in_email($email_of_user)) != 1
        || count(return_errors_in_password($password_of_user)) != 1 ||
        count(return_errors_in_repeat_password($repeat_password_of_user, $password_of_user)) != 1 ||
        count(return_errors_in_db($db, $_POST['login_of_user'], $_POST['email_of_user'], $_POST['password_of_user'])) != 1) {
        $check = 0;
        print_errors($login_of_user, $email_of_user, $password_of_user, $repeat_password_of_user, $db);
    }
    return $check;
}

function print_errors($login_of_user, $email_of_user,
                      $password_of_user, $repeat_password_of_user, $db)
{
    $errors = return_errors($login_of_user, $email_of_user, $password_of_user, $repeat_password_of_user, $db);
    echo '<div class = "print_errors">';
    foreach ($errors as $error) {
        echo $error;
    }
    echo '</div>';
}

function return_errors($login_of_user, $email_of_user, $password_of_user, $repeat_password_of_user, $db)
{

    return array_merge(return_errors_in_login($login_of_user), return_errors_in_email($email_of_user),
        return_errors_in_password($password_of_user), return_errors_in_repeat_password($repeat_password_of_user, $password_of_user), return_errors_in_db($db, $_POST['login_of_user'], $_POST['email_of_user'], $_POST['password_of_user']));
}

function return_errors_in_login($login_of_user)
{
    $errors_in_login = [""];
    if (strlen($login_of_user) > 60) {
        array_push($errors_in_login, "Слишком большой логин<br>");
    }
    if ($login_of_user == '') {
        array_push($errors_in_login, "Введите логин<br>");
    }
    if (!preg_match("/^[A-Za-z0-9]+$/x", $login_of_user)) {
        array_push($errors_in_login,
            "Для логина разрешены только латинские символы и цифры<br>");
    }
    if (empty($errors_in_login)) {
        return "";
    }
    return $errors_in_login;
}


function return_errors_in_email($email_of_user)
{
    $errors_in_email = [""];
    if (strlen($email_of_user) > 60) {
        array_push($errors_in_email, "Слишком большой email<br>");
    }
    if ($email_of_user == '') {
        array_push($errors_in_email, "Введите email<br>");
    }
    if (!preg_match('/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]
    {1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u', $email_of_user)) {
        array_push($errors_in_email, "Некорректный email<br>");
    }
    if (empty($errors_in_email)) {
        return "";
    }
    return $errors_in_email;
}

function return_errors_in_password($password_of_user)
{
    $errors_in_password = [""]; // костыыыыль
    if (!preg_match("/(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z!@#$%^&*]{6,}/", $password_of_user)) {
        array_push($errors_in_password, "Пароль должен иметь минимум 6 символов и состоять из латинских символов 
верхнего и нижнего регистра и хотя бы одной цифры<br>");
    }
    if ($password_of_user == '') {
        array_push($errors_in_password, "Введите пароль<br>");
    }
    if (empty($errors_in_password)) {
        return "";
    }
    return $errors_in_password;
}

function return_errors_in_repeat_password($repeat_password_of_user, $password_of_user)
{
    $errors_in_repeat_password = [""];
    if ($repeat_password_of_user == '') {
        array_push($errors_in_repeat_password, "Пароль не введен повторно<br>");
    }
    if ($password_of_user != $repeat_password_of_user) {
        array_push($errors_in_repeat_password, "Повторный пароль введен неверно<br>");
    }
    if (empty($errors_in_repeat_password)) {
        return "";
    }
    return $errors_in_repeat_password;
}

function return_errors_in_db($db, $login_of_user, $email_of_user, $password_of_user)
{
    $errors_in_db = [''];
    $stmt = $db->prepare("SELECT * FROM users WHERE login=:login");
    $stmt->execute(array('login' => $login_of_user));
    $is_login_exist = $stmt->fetch();
    if ($is_login_exist) {
        array_push($errors_in_db, "Пользователь с таким логином уже существует<br>");
    }

    $stmt = $db->prepare("SELECT * FROM users WHERE email=:email");
    $stmt->execute(array('email' => $email_of_user));
    $is_login_exist = $stmt->fetch();
    if ($is_login_exist) {
        array_push($errors_in_db, "Пользователь с таким email уже существует<br>");
    }
    return $errors_in_db;
}

#endregion

?>
<form class="registration" method="post" action="registration.php">

    Логин<br>
    <input type="text" class="registration" name="login_of_user"><br>
    email<br>
    <input type="text" class="registration" name="email_of_user"></input><br>
    Пароль<br>
    <input type="password" id="password_of_user" class="registration" name="password_of_user"></textarea><br>
    Подтверждение пароля<br>
    <input type="password" class="registration" name="repeat_password_of_user"></textarea><br>
    <label class="container" id="show_password"><a href="#">Показать пароль</a>
        <input type="checkbox" ">
        <span class="checkmark"></span>
    </label>

    <input class="registration" type="submit" value="Добавить" name="registration_button">
</form>
<?php
if (isset($_POST['registration_button'])) {
    if (check_registration($_POST['login_of_user'], $_POST['email_of_user'],
        $_POST['password_of_user'], $_POST['repeat_password_of_user'], $db)) {
        append_user($db, $_POST['login_of_user'], $_POST['email_of_user'], hash('sha256', $_POST['password_of_user'] . SALT));
    }
} ?>
<script type="text/javascript" src="js/jquery-2.1.1.js"></script>
<script src="scripts.js"></script>