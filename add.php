<?php

require_once 'common/init.php';

$content = include_template('add-lot.php', [
  'categories' => $categories,
]);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $lot = $_POST;

  $filename = 'image-' . uniqid() . '.' . preg_replace('/^.*\.(.*)$/U', '$1', $_FILES['lot-image']['name']);
  $lot['image'] = $filename;
  move_uploaded_file($_FILES['lot-image']['tmp_name'], 'uploads/' . $filename);
  var_dump($lot);
  echo '<br />';

  $sql = get_query_create_lot();
  $stmt = db_get_prepare_stmt($link, $sql, $lot);
  $res = mysqli_stmt_execute($stmt);
  var_dump($res);
  if ($res) {
    $lot_id = mysqli_insert_id($link);

    header("Location: lot.php?id=" . $lot_id);
  }
}

$layout_content = include_template('layout.php', [
  'user_name' => $user_name,
  'title' => $title,
  'categories' => $categories,
  'content' => $content,
]);

print($layout_content);