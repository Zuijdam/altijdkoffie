<?php
//R::debug(false);
// includes
require 'include/rb-mysql.php';
include config.php;

// db connectie
R::setup(
    'mysql:host=localhost;dbname=' . $DatabaseName,
    $DatabaseUser,
    $DatabasePassword
  );

//opslaan waarde van weeschaal in custom DB in tabel weging
$weging = R::dispense( 'weging' );
$weging->gewicht = 1;
$id = R::store( $weging );

?>