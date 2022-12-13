<?php

function get_formatted_price($price): string
{
  $price = ceil($price);
  $price = number_format($price, 0, ',', ' ');
  return $price . ' <b class="rub">р</b>';
}


function get_time_left($date)
{
  $final_date = date_create($date);
  $cur_date = date_create("now");
  $diff = date_diff($final_date, $cur_date);

  $format_diff = date_interval_format($diff, "%d %H %I");
  $arr = explode(" ", $format_diff);

  $hours = $arr[0] * 24 + $arr[1];
  $minutes = intval($arr[2]);
  $hours = str_pad($hours, 2, "0", STR_PAD_LEFT);
  $minutes = str_pad($minutes, 2, "0", STR_PAD_LEFT);
  $res[] = $hours;
  $res[] = $minutes;

  return $res;


}

function show_error($error_text): string
{
  return include_template('error.php', [
    'error' => $error_text ?? mysqli_error(),
  ]);
}

function get_categories($link)
{
  $sql_categories = 'SELECT * FROM categories';
  $result_categories = mysqli_query($link, $sql_categories);
  if ($result_categories) {
    return mysqli_fetch_all($result_categories, MYSQLI_ASSOC);
  } else {
    $error = mysqli_error($link);
    show_error($error);
  }

}

function get_lots($link)
{
  $sql_lots =
    'SELECT l.id, l.data_creation, l.lot_name as name, l.image,
       l.start_price as price, l.data_finish as expiration, c.name_category as category
        FROM lots l JOIN categories c on l.category_id = c.id WHERE data_finish > NOW() ORDER BY data_creation DESC';

  $result_lots = mysqli_query($link, $sql_lots);
  return mysqli_fetch_all($result_lots, MYSQLI_ASSOC);
}

function get_lot_by_id($link, $id): bool|mysqli_result
{
  $sql_lot = 'SELECT l.id, l.data_creation, l.lot_name as name, l.image, l.lot_description as description,
                l.start_price as price, l.data_finish as expiration, c.name_category as category
                FROM lots l JOIN categories c on l.category_id = c.id WHERE l.id = ?;';

  $stmt = mysqli_prepare($link, $sql_lot);

  mysqli_stmt_bind_param($stmt, 'i', $id);
  mysqli_stmt_execute($stmt);
  return mysqli_stmt_get_result($stmt);
}

function get_query_create_lot(): string
{
  return 'INSERT INTO lots (lot_name, category_id, lot_description, start_price, step, data_finish, image, user_id)' .
            'VALUES (?, ?, ?, ?, ?, ?, ?, 1)';
}

function create_user($link, $data): bool
{
  $password = password_hash($data['password'], PASSWORD_DEFAULT);

  $sql = "INSERT INTO users (data_registration, email, user_name, user_password, contacts) VALUES (NOW(), ?, ?, ?, ?)";

  $stmt = db_get_prepare_stmt($link, $sql, [$data['email'], $data['name'], $password, $data['message']]);

  return mysqli_stmt_execute($stmt);
}

function validate_category($id, $allowed_list)
{

  if (!in_array($id, $allowed_list)) {
    return 'Указана несуществующая категория';
  }

  return null;
}

function validate_price($price)
{
  if (!$price) {
    return null;
  }

  if (!is_numeric($price)) {
    return "Содержимое поля «начальная цена» должно быть числом";
  }

  if ($price <= 0) {
    return "Содержимое поля «начальная цена» должно быть числом больше нуля";
  }

  return null;
}

function validate_date($date)
{
  if (!$date) {
    return null;
  }

  if (!is_date_valid($date)) {
    return "Содержимое поля «дата завершения» должно быть датой в формате «ГГГГ-ММ-ДД»";
  }

  $date_current = time();
  $date_by_user = strtotime($date);


  if ($date_by_user < $date_current + 60 * 60 * 24) {
    return "Дата должна быть больше текущей не менее чем на один день";
  }

  return null;
}

function validate_step($number)
{
  if (!$number) {
    return null;
  }

  if (!is_numeric($number) || $number < 0) {
    return "Содержимое поля «шаг ставки» должно быть целым числом больше нуля.";
  }


  return null;
}
