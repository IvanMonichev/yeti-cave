<?php
require_once('config.php');
require_once('helpers.php');
require_once('functions.php');
require_once('data.php');

$page_content = include_template('main.php', [
  'categories' => $categories,
  'goods' => $goods,
]);

/** @var string $user_name */
/** @var string $title */
$layout_content = include_template('layout.php', [
  'user_name' => $user_name,
  'title' => $title,
  'categories' => $categories,
  'content' => $page_content,
]);

print($layout_content);

?>
