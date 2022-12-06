<?php
require_once 'init.php';

if (!$link) {
  $error = mysqli_connect_error();
  $error_content = include_template('error.php', ['error' => $error]);
} else {

  $sql_categories = 'SELECT name_category, character_code FROM categories';

  $result_categories = mysqli_query($link, $sql_categories);


  if ($result_categories) {
    $categories = mysqli_fetch_all($result_categories, MYSQLI_ASSOC);
  } else {
    $error = mysqli_connect_error();
    $content = include_template('error.php', ['error' => $error]);
  }

  $sql_lots =
    'SELECT l.data_creation, l.lot_name as name, l.image,
       l.start_price as price, l.data_finish as expiration, c.name_category as category
        FROM lots l JOIN categories c on l.category_id = c.id WHERE data_finish > NOW() ORDER BY data_creation DESC';

  $result_lots = mysqli_query($link, $sql_lots);

  if ($result_lots) {
    $goods = mysqli_fetch_all($result_lots, MYSQLI_ASSOC);
  } else {
    $error = mysqli_connect_error();
    $content = include_template('error.php', ['error' => $error]);
  }
}


$page_content = include_template('main.php', [
  'categories' => $categories,
  'goods' => $goods,
]);

$layout_content = include_template('layout.php', [
  'user_name' => $user_name,
  'title' => $title,
  'categories' => $categories,
  'content' => $page_content,
]);

print($layout_content);

