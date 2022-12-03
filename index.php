<?php
require_once('helpers.php');
require_once('data.php');

$is_auth = rand(0, 1);

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

?>
