<?php
require_once "common/init.php";
require_once "functions/validators.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $errors = [];
  $required = ["email", "password"];

  $rules = [
    "email" => function ($value) {
      return validate_email($value);
    }
  ];

  $user = filter_input_array(INPUT_POST,
    [
      "email" => FILTER_DEFAULT,
      "password" => FILTER_DEFAULT,
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

  $form = $_POST;
  $email = mysqli_real_escape_string($link, $form["email"]);
  $sql = "SELECT * FROM users WHERE email = '$email'";
  $res = mysqli_query($link, $sql);
  $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;

  if(!count($errors) and $user) {
    if(password_verify($form["password"], $user["user_password"])) {
      $_SESSION["user"] = $user;
    } else {
      $errors["password"] = "Неверный пароль";
    }
  } else {
    if (empty($errors["email"])) {
      $errors["email"] = "Пользователь не найден";
    }
  }

  if (count($errors)) {
    $content = include_template("sign-in.php", [
      "categories" => $categories,
      "user" => $user,
      "errors" => $errors
    ]);
  }

} else {
  $content = include_template("sign-in.php", [
    "categories" => $categories,
  ]);
}

$content = include_template("sign-in.php", [
  "categories" => $categories,
]);

$layout_content = include_template("layout.php", [
  "user_name" => $user_name,
  "title" => $title,
  "categories" => $categories,
  "content" => $content,
]);

print($layout_content);
