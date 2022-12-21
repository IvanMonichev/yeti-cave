<?php
require_once "common/init.php";

$search = $_GET["search"] ?? "";

if ($search) {
  $sql = "SELECT "
}

$content = include_template("search.php", [
  "categories" => $categories,
]);

$layout_content = include_template("layout.php", [
  "title" => $title,
  "categories" => $categories,
  "content" => $content,
]);
print($layout_content);
