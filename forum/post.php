<?php
include_once "menu.php";
function check_request($get_request)
{
    $check = 1;
    for ($i = 0; $i < strlen($get_request); ++$i) {
        if (!(is_integer($get_request[$i]) or is_string($get_request[$i])
            or $get_request[$i] == '-')) {
            $check = 0;
        }
    }
    if (!ctype_alnum($get_request)) {
        echo 'Неверные параметры!';
        $check = 0;
    }
    if ($get_request == null) {
        echo 'Ошибка 404, не передано название';
        $check = 0;
    }
    if (!file_exists('articles/' . $get_request)) {
        echo 'Ошибка 404. Нет такой статьи!';
        $check = 0;
    }
    return $check;
}

function go_to_file($get_request)
{
    if (check_request($get_request)) {
        $content = file_get_contents('articles/' . $get_request);
        echo nl2br($content);
    }
}

$article = $_GET['article'] ?? null;
go_to_file($article);
