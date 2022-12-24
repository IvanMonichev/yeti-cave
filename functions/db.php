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

function get_number_lots($link, $query)
{
  $sql = "SELECT COUNT(*) as count FROM lots
            WHERE MATCH(lot_name, lot_description) AGAINST(?);";
  $stmt = mysqli_prepare($link, $sql);
  mysqli_stmt_bind_param($stmt, "s", $query);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  return mysqli_fetch_assoc($result)["count"];
}

function get_found_lots($link, $query, $limit, $offset)
{
  $sql =
    "SELECT l.id, l.lot_name as name, l.start_price as price, l.data_finish as expiration,
            l.image, c.name_category as category
        FROM lots l JOIN categories c on l.category_id = c.id
        WHERE MATCH(lot_name, lot_description) AGAINST(?) ORDER BY data_creation DESC LIMIT ? OFFSET ?";

  $stmt = mysqli_prepare($link, $sql);
  mysqli_stmt_bind_param($stmt, 'sii', $query, $limit, $offset);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  return mysqli_fetch_all($result, MYSQLI_ASSOC);
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


