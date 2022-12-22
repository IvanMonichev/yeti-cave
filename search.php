<?php
require_once "common/init.php";

$query = trim($_GET["search"] ?? "");
$query = htmlspecialchars($query);

if ($query) {
  $goods = get_found_lots($link, $query);

  $content = include_template("search.php", [
    "categories" => $categories,
    "goods" => $goods,
    "query" => $query,
  ]);

} else {
  $content = include_template("search.php", [
    "categories" => $categories,
    "query" => $query,
  ]);
}

$layout_content = include_template("layout.php", [
  "title" => $title,
  "categories" => $categories,
  "content" => $content,
  "query" => $query,
]);
print($layout_content);
