<?php
require_once 'init.php';

if ($link) {
  $error = mysqli_connect_error();
  $content = include_template('error.php', ['error' => $error]);
} else {
  $sql = 'SELECT * FROM lots';
  $result = mysqli_query($link, $sql);

  if ($result) {
    $goods = mysqli_fetch_all($result. MYSQLI_ASSOC);
  } else {
    $error = mysqli_connect_error();
    $content = include_template('error.php', ['error' => $error]);
  }
}

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
