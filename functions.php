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

function get_categories($link)
{
  $sql_categories = 'SELECT name_category, character_code FROM categories';
  $result_categories = mysqli_query($link, $sql_categories);
  return mysqli_fetch_all($result_categories, MYSQLI_ASSOC);
}

function get_lots($link)
{
  $sql_lots =
    'SELECT l.data_creation, l.lot_name as name, l.image,
       l.start_price as price, l.data_finish as expiration, c.name_category as category
        FROM lots l JOIN categories c on l.category_id = c.id WHERE data_finish > NOW() ORDER BY data_creation DESC';

  $result_lots = mysqli_query($link, $sql_lots);
  return mysqli_fetch_all($result_lots, MYSQLI_ASSOC);
}