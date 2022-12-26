<?php
require_once "common/init.php";
require_once "functions/validators.php";

$id_lot = intval($_GET["id"]);
$arr = get_lot_by_id($link, $id_lot);
$lot = mysqli_fetch_array($arr, MYSQLI_ASSOC);
$min_bet = $lot["price"] + $lot["step"];

if ($arr) {
  if (!mysqli_num_rows($arr)) {
    http_response_code(404);
    $content = show_error("Такого лота не существует");
  } else {
    $content = include_template("lot.php", [
      "categories" => $categories,
      "lot" => $lot,
      "min_bet" => $min_bet,
    ]);
  }
} else {
  http_response_code(404);
  $content = show_error();
}

if (isset($_SESSION["user"])) {
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $errors = [];
    $required = ["cost"];


    $rules = [
      "cost" => function ($value) {
        return validate_price($value);
      }
    ];

    $cost = filter_input_array(INPUT_POST,
      [
        "cost" => FILTER_DEFAULT,
      ], true);

    foreach ($cost as $field => $value) {
      if (isset($rules[$field])) {
        $rule = $rules[$field];
        $errors[$field] = $rule($value);
      }

      if (in_array($field, $required) && empty($value)) {
        $errors[$field] = "Поле $field нужно заполнить";
      }
    }

    if ($min_bet > intval($cost["cost"])) {
      $errors["cost"] = "Минимальная ставка – $min_bet!";
    }

    echo "<pre>";
    var_dump($_SESSION["user"]["id"]);
    echo "</pre>";

    echo "<pre>";
    var_dump($lot["user_id"]);
    echo "</pre>";

    if ($_SESSION["user"]["id"] == $lot["user_id"]) {
      $errors["cost"] = "Данный лот создан вами";
    }

    $errors = array_filter($errors);

    if (count($errors)) {
      $content = include_template("lot.php", [
        "errors" => $errors,
        "categories" => $categories,
        "lot" => $lot,
        "min_bet" => $min_bet,
        "cost" => $cost["cost"]
      ]);
    } else {
      $bet["cost"] = $_POST["cost"];
      $bet["user_id"] = $_SESSION["user"]["id"];
      $bet["lot_id"] = $id_lot;

      $result = create_bet($link, $bet);
      if ($result) {
        $content = include_template("lot.php", [
          "categories" => $categories,
          "lot" => $lot,
        ]);
      }
    }
  }
}

$layout_content = include_template("layout.php", [
  "title" => $title,
  "categories" => $categories,
  "content" => $content,
]);

print($layout_content);
