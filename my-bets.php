<?php

require_once "common/init.php";

$user_id = $_SESSION["user"]["id"];
$bets = get_bets($link, $user_id);


$content = include_template("my-bets.php", [
  "categories" => $categories,
  "bets" => $bets,
]);

$layout_content = include_template("layout.php", [
  "title" => $title,
  "categories" => $categories,
  "content" => $content,
]);

print($layout_content);
