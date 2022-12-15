<?php
// includes
require 'include/rb-mysql.php';
include 'config.php';

// db connectie
R::setup(
    'mysql:host=localhost;dbname=' . $DatabaseName,
    $DatabaseUser,
    $DatabasePassword
  );

  // laten zien laatste 10 wegingen

$wegingen = R::findAll('weging','LIMIT 10');

foreach ($wegingen as $value) {
  echo $value . "\n";
}

?>