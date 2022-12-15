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

//opslaan waarde van weeschaal in custom DB in tabel weging
if($_GET['key']  != $SuperGeheimeKey) exit();

$weging = R::dispense( 'weging' );
$weging->gewicht = $gewicht;
$weging->datum = date("Y-m-d", strtotime("-1 days"));
$weging->time = time();
$id = R::store( $weging );


// laatste waarde laten zien op het scherm
$weging= R::load('weging',$id);
echo $weging->gewicht;
?>