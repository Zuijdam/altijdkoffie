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

$wegingen = R::findAll('weging','ORDER BY id DESC LIMIT 10');


echo "<pre>";
foreach ($wegingen as $value) {
  echo $value . "<br>";
}
echo "</pre>";


//
// Pak alle metingen van de afgelopen 30 minuten en berekend het gemm.
// Bepaal de laaste Tare value
// Bepaal het verschil tussen het gemm. en de tare
// Als dat hoger is dan 50% dan geef een melding 'er is koffie nodig!!!'

$tijd = time() - 1800; // tijd 30 minuten geleden
$waarden = R::find('weging', 'datum > ?', [$tijd]);

$waardenArray = array();
foreach($waarden as $waarde) {
  $waardenArray[] = $waarde;
}

// Gebruik de array
print_r($waardenArray);

?>