<?php
require 'common/init.php';

$categories = get_categories($link);

$id_lot = intval($_GET['id']);
$arr = get_lot_by_id($link, $id_lot);

if ($result = get_lot_by_id($link, $id_lot)) {
  if (!mysqli_num_rows($result)) {
    $content = show_error('Такого лота не существует');
  } else {
    $lot = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $content = include_template('lot.php', [
      'categories' => $categories,
      'lot' => $lot,
    ]);
  }
} else {
  $content = show_error();
}

$layout_content = include_template('layout.php', [
  'user_name' => $user_name,
  'title' => $title,
  'categories' => $categories,
  'content' => $content,
]);

print($layout_content);