<?php
require_once "common/init.php";

$query = trim($_GET["search"] ?? "");
$query = htmlspecialchars($query);

if ($query) {
  $lots = get_number_lots($link, $query);
  $current_page = $_GET["page"] ?? 1;
  $limit = 9;
  $page_count = ceil($lots / $limit);
  $offset = ($current_page - 1) * $limit;
  $pages = range(1, $page_count);
  $goods = get_found_lots($link, $query, $limit, $offset);

  $content = include_template("search.php", [
    "categories" => $categories,
    "goods" => $goods,
    "query" => $query,
    "pages" => $pages,
    "page_count" => $page_count,
    "current_page" => $current_page
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
