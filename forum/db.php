<?php
define("SALT", "65@@");
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
}

function is_sign_in($db, $email_of_user, $password_of_user)
{
    $stmt = $db->prepare("SELECT * FROM users WHERE email=:email AND password=:password");
    $stmt->execute(['email' => $email_of_user, 'password' => hash("sha256",$password_of_user.SALT)]);
    $is_login_exist = !empty($stmt->fetch());
    if ($is_login_exist) {
        return 1;
    } else {
        return 0;
    }
}

$db = connect('forum', 'root', '', 'utf-8');