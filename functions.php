<?php

function get_formatted_price($price): string
{
  $price = ceil($price);
  $price = number_format($price, 0, ',', ' ');
  return  $price . ' <b class="rub">р</b>';
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
