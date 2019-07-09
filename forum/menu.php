<?php
    session_start();
?>
<link rel="stylesheet" href="styles.css">
<nav id="mainNav">
    <ul>
        <li><a href="index.php"><br />Главная</a></li>
        <li><a href="#"><br />Профиль</a></li>
        <li><a href="#"><br />Статьи</a>
            <ul class="sub-menu">
                <li><a href="index.php"> Просмотреть статьи</a></li>
                <li><a href="add_article.php">Добавить статью</a></li>
            </ul>
        </li>
        <li><a href="sign_in.php"><br />Войти</a></li>
        <li><a href="registration.php"><br />Регистрация</a></li>
        <li><?php $email_of_user = $_SESSION['email_of_user']?? "Здравствуй, ".$_SESSION['email_of_user']; echo "<h5>Здравствуй, ".$email_of_user."</h5>"; ?></li>
    </ul>
</nav>
