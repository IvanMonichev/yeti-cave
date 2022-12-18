<?php
require_once "common/init.php";
require_once "functions/validators.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $errors = [];
  $required = ["email", "password", "name", "message"];

  $rules = [
    "email" => function ($value) {
      return validate_email($value);
    }
  ];

  $user = filter_input_array(INPUT_POST,
    [
      "email" => FILTER_DEFAULT,
      "password" => FILTER_DEFAULT,
      "name" => FILTER_DEFAULT,
      "message" => FILTER_DEFAULT,
    ], true);


  foreach ($user as $field => $value) {
    if (isset($rules[$field])) {
      $rule = $rules[$field];
      $errors[$field] = $rule($value);
    }

    if (in_array($field, $required) && empty($value)) {
      $errors[$field] = "Поле $field нужно заполнить";
    }
  }

  $errors = array_filter($errors);

  if (count($errors)) {
    $content = include_template("sign-up.php", [
      "categories" => $categories,
      "user" => $user,
      "errors" => $errors,
    ]);
  } else {
    $user = $_POST;
    $email = $user['email'];
    $sql = "SELECT id FROM users WHERE email = '$email'";
    $res = mysqli_query($link, $sql);

    if (mysqli_num_rows($res) > 0) {
      $errors["email"] = "Пользователь с этим email уже зарегистрирован";
      $content = include_template("sign-up.php", [
        "categories" => $categories,
        "user" => $user,
        "errors" => $errors,
      ]);
    } else {
      $res = create_user($link, $user);
      if ($res) {
        $content = include_template("sign-up.php", [
          "categories" => $categories,
        ]);
        $lot_id = mysqli_insert_id($link);
        header("Location: /");
      }
    }
  }
} else {
  $content = include_template("sign-up.php", [
    "categories" => $categories,
  ]);
}

if (isset($_SESSION["user"])) {
  header('HTTP/1.0 403 Forbidden', true, 403);
  echo "Доступ запрещён. Код ошибки – 403.";
} else {
  $layout_content = include_template("layout.php", [
    "title" => $title,
    "categories" => $categories,
    "content" => $content,
  ]);
  print($layout_content);
}
