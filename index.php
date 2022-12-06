<?php
require_once 'init.php';

/** @var object $link */
$categories = get_categories($link);
$goods = get_lots($link);

if ($categories && $goods) {
  $content = include_template('main.php', [
    'categories' => $categories,
    'goods' => $goods,
  ]);
} else {
  $content = include_template('error.php', ['error' => mysqli_error()]);
}

$layout_content = include_template('layout.php', [
  'user_name' => $user_name,
  'title' => $title,
  'categories' => $categories,
  'content' => $content,
]);

print($layout_content);

