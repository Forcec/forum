<title>Главная</title>
<?php
include_once "menu.php";

$mass_of_articles = scandir("articles");
foreach ($mass_of_articles as $article) {
    if (is_file("articles/$article")) {
        echo "<div><a href=\"post.php?article=$article\">$article</a></div>";
    }
}

?>