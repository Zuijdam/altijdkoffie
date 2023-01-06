<?php
//R::debug(false);
// includes
require 'include/rb-mysql.php';
include 'config.php';

// db connectie
R::setup(
    'mysql:host=localhost;dbname=' . $DatabaseName,
    $DatabaseUser,
    $DatabasePassword
  );

// opslaan van waarde uit de querystring in een variabele

$gewicht = $_GET['gewicht'];
$type = $_GET['type'];

//opslaan waarde van weeschaal in custom DB in tabel weging
if($_GET['key']  != $SuperGeheimeKey) exit();

if (isset($_GET['type']) && $_GET['type'] == "meting") {
$weging = R::dispense( 'weging' );
$weging->gewicht = $gewicht;
$weging->datum = date("Y-m-d H:i:s");
$id = R::store( $weging );
}

if (isset($_GET['type']) && $_GET['type'] == "tare") {
$weging = R::dispense( 'weging' );
$weging->tare = $gewicht;
$weging->datum = date("Y-m-d H:i:s");
$id = R::store( $weging );
}

// laatste waarde laten zien op het scherm
$weging= R::load('weging',$id);
echo $weging->gewicht;
?>