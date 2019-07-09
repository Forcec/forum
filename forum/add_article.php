<title>Добавить статью</title>
<?php
include_once "menu.php"; ?>
<form class="add_article" method="post">
    Название статьи<br>
    <input class="add_article" type="text" name="title_of_article"><br>
    Содержание<br>
    <textarea class="add_article" name="content_of_article" rows="5"></textarea><br>
    <input class="add_article" name="add_article" type="submit" value="Добавить">
</form>

<?php

function check_article($title, $content)
{
    $check = 1;
    if ($title == '') {
        echo 'Пустое название.';
        $check = 0;
    } else if (file_exists("articles/$title")) {
        echo 'Такой заголовок уже есть.';
        $check = 0;
    } else if ($title == '' || $content == '') {
        echo 'Заполните все поля';
        $check = 0;
    } else if (preg_match("/[^`a-zа-яё ]/iu", $title)) {
        $check = 0;
        echo "Недопустимые символы в заголовке";
    }
    return $check;
}


function add_article($title, $content)
{
    if (count($_POST) > 0) {
        if (!check_article($title, $content)) {
            return 0;
        }
        file_put_contents("articles/$title", $content);
        echo "<script>document.location.replace('index.php');</script>";
        exit();
    } else {
        $msg = '';
    }
}
function translit($str)
{
    $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
    $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
    return str_replace($rus, $lat, $str);
}
if(isset($_SESSION['login_of_user']))    {
    if (isset($_POST['add_article'])) {
        $text = "<div>".trim($_POST['content_of_article'])."</div>";
        add_article(trim(translit($_POST['title_of_article'])).".html", $text);
    }
}
else {
    echo "<h4>Для написания статей необходима авторизация</h4>";
}

?>
