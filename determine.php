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

 // Pak alle metingen van de afgelopen paar minuten en berekend het gemm.
// Bepaal de laaste Tare value
// Bepaal het verschil tussen het gemm. en de tare
// Als dat hoger is dan 50% dan geef een melding 'er is koffie nodig!!!'

$wegingen = R::findAll('weging','ORDER BY id DESC LIMIT 30');


echo "<pre>";
foreach ($wegingen as $value) {
  echo $value . "<br>";
}
echo "</pre>";

// Bereken het gemiddelde van het veld 'gewicht'
$totaal = 0;
foreach($wegingen as $weging) {
  $totaal += $weging->gewicht;
}
$gemiddelde = $totaal / count($wegingen);

echo "Het gemiddelde gewicht van de afgelopen 30 waarden is " . $gemiddelde;

// Zoek de laatste rij met een waarde in het veld 'tare'
$weging = R::findOne('weging', 'tare IS NOT NULL ORDER BY id DESC LIMIT 1');

// Als er een rij is gevonden, haal de waarde op uit het veld 'tare'
if ($weging) {
  $laatsteTare = $weging->tare;
  echo "De laatste waarde in het veld 'tare' is " . $laatsteTare;
} else {
  echo "Er is geen waarde gevonden in het veld 'tare'";
}

?>