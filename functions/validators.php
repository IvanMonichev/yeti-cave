<?php

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

function validate_email($email): ?string
{
  if (!$email) {
    return null;
  }

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    return "Электронная почта должна быть формата email@domain.ru";
  }

  return null;

}
