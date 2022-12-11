<?php

require_once 'common/init.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $categories_id = array_column($categories, "id");
  $required = ['lot-name', 'category', 'message', 'lot-rate', 'lot-step', 'lot-date'];
  $errors = [];

  $rules = [
    'category' => function($value) use ($categories_id) {
      return validate_category($value, $categories_id);
    },
    'lot-rate' => function($value) {
      return validate_price($value);
    },
    'lot-date' => function($value) {
      return validate_date($value);
    },
    'lot-step' => function($value) {
      return validate_step($value);
    }
  ];

  $lot = filter_input_array(INPUT_POST,
    [
      "lot-name" => FILTER_DEFAULT,
      "category" => FILTER_DEFAULT,
      "message" => FILTER_DEFAULT,
      "lot-rate" => FILTER_DEFAULT,
      "lot-step" => FILTER_DEFAULT,
      "lot-date" => FILTER_DEFAULT
    ], true);


  foreach ($lot as $field => $value) {
    if (isset($rules[$field])) {
      $rule = $rules[$field];
      $errors[$field] = $rule($value);
    }
    if (in_array($field, $required) && empty($value)) {
      $errors[$field] = "Поле $field нужно заполнить";
    }
  }

  $errors = array_filter($errors);

  if (!empty($_FILES['lot-image']['name'])) {
    $tmp_name = $_FILES['lot-image']['tmp_name'];
    $path = $_FILES['lot-image']['name'];
    $filename = 'image-' . uniqid() . '.' . preg_replace('/^.*\.(.*)$/U', '$1', $_FILES['lot-image']['name']);

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $file_type = finfo_file($finfo, $tmp_name);

    if ($file_type !== "image/jpg" && $file_type !== "image/png" && $file_type !== "image/jpeg") {
      $errors['lot-image'] = 'Допустимые форматы файла: jpg, jpeg, png';
    } else {
      $lot = $_POST;
      $lot['image'] = $filename;
      move_uploaded_file($tmp_name, 'uploads/' . $filename);
    }
  } else {
    $errors['lot-image'] = 'Вы не загрузили файл';
  }

  if (count($errors)) {
    $content = include_template('add-lot.php', ['lot' => $lot, 'errors' => $errors, 'categories' => $categories]);
  } else {



    $sql = get_query_create_lot();
    $stmt = db_get_prepare_stmt($link, $sql, $lot);
    $res = mysqli_stmt_execute($stmt);

    if ($res) {
      $lot_id = mysqli_insert_id($link);

      header("Location: lot.php?id=" . $lot_id);
    }
  }
} else {
  $content = include_template('add-lot.php', [
    'categories' => $categories,
  ]);
}

$layout_content = include_template('layout.php', [
  'user_name' => $user_name,
  'title' => $title,
  'categories' => $categories,
  'content' => $content,
]);

print($layout_content);
