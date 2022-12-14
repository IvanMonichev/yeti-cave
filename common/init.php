<?php
session_start();
require_once 'functions/helpers.php';
require_once 'models/models.php';
require_once 'config/timezone.php';
$db = require_once 'config/db.php';

$link = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);

if (!$link) {
  $error = mysqli_connect_error();
}

mysqli_set_charset($link, 'utf-8');
$title = "Yeti Cave";
$categories = get_categories($link);
