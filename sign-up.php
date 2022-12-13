<?php
require "common/init.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $form = $_POST;
  $errors = [];

  $req_fields = ["email", "password", "name", "message"];

  foreach ($req_fields as $field) {
    if (empty($form[$field])) {
      $errors = "Не заполнено поле " . $field;
    }
  }

  if (empty($errors)) {
    $email = mysqli_real_escape_string($link, $form["email"]);
    $sql = "SELECT id FROM users WHERE email = '$email'";
    $res = mysqli_query($link, $sql);

    if (mysqli_num_rows($res) > 0) {
      $errors[] = "Пользователь с этим email уже зарегистрирован";
    } else {

      $res = create_user($link, $form);
    }
  }
}

$content = include_template("sign-up.php", [
  "categories" => $categories
]);

$layout_content = include_template("layout.php", [
  "user_name" => $user_name,
  "title" => $title,
  "categories" => $categories,
  "content" => $content,
]);

print($layout_content);
