<?php
require 'common/init.php';

$content = include_template('sign-up.php', [
  'categories' => $categories
]);

$layout_content = include_template('layout.php', [
  'user_name' => $user_name,
  'title' => $title,
  'categories' => $categories,
  'content' => $content,
]);

print($layout_content);
