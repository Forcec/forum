<title>Добавить статью</title>
<?php
include_once "menu.php"; ?>
<form class="registration" method="post" action="registration.php">
    email<br>
    <input type="text" class="registration" name="email_of_user"></input><br>
    Пароль<br>
    <input type="password" class="registration" name="repeat_password_of_user"></textarea><br>
    <label class="container"><h6 id="show_password">Показать пароль</h6>
        <input type="checkbox">
        <span class="checkmark"></span>
    </label>

    <input class="registration" type="submit" value="Добавить" name="registration_button">
</form>
