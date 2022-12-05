<?php
require_once 'helpers.php';
require_once 'functions.php';
require_once 'config/timezone.php';
$db = require_once 'config/db.php';

$link = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);
mysqli_set_charset($link, 'utf-8');
