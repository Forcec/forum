<?php
function connect($host = 'localhost', $db, $user = 'root', $pass = '', $charset = 'utf-8')
{
    $host = 'localhost';
    $db = 'forum';
    $user = 'root';
    $pass = '';
    $charset = 'utf8';
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $opt = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    $db = new PDO($dsn, $user, $pass, $opt);
    return $db;
}


function append_user($db, $login_of_user, $email_of_user, $password_of_user)
{
    $sth = $db->prepare("INSERT INTO `users` SET `login` = :login, `email` = :email,
`password` = :password,`date_of_registration` = NOW(), `is_online` = 1");
    $sth->execute(array('login' => $login_of_user, 'email' => $email_of_user, 'password' => $password_of_user));
    $insert_id = $db->lastInsertId();
}

function return_errors_in_db($db, $login_of_user, $email_of_user, $password_of_user) {
    $errors_in_db = [''];
    $stmt = $db->prepare("SELECT * FROM users WHERE login=:login");
    $stmt->execute(array('login' => $login_of_user));
    $is_login_exist = $stmt->fetch();
    if($is_login_exist) {
        array_push($errors_in_db, "Пользователь с таким логином уже существует<br>");
    }

    $stmt = $db->prepare("SELECT * FROM users WHERE email=:email");
    $stmt->execute(array('email' => $email_of_user));
    $is_login_exist = $stmt->fetch();
    if($is_login_exist) {
        array_push($errors_in_db, "Пользователь с таким email уже существует<br>");
    }
        return $errors_in_db;
}

$db = connect('forum', 'root', '', 'utf-8');