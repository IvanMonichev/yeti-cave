<?php

function show_error($error_text): string
{
  return include_template('error.php', [
    'error' => $error_text ?? mysqli_error(),
  ]);
}
