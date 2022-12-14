<?php
//R::debug(false);
// includes
require 'Includes/rb-mysql.php';

// db connectie
R::setup( 'mysql:host=localhost;dbname=huetlaan',
'root', 'NJM5aZzLpppXFz1!' ); //for both mysql or mariaDB 


//opslaan waarde van weeschaal in custom DB in tabel weging
$weging = R::dispense( 'weging' );
$weging->gewicht = 1;
$id = R::store( $weging );

?>