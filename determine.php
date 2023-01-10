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

$wegingen = R::findAll('weging','ORDER BY id DESC LIMIT 5');


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
echo "<br>";

// Zoek de laatste rij met een waarde in het veld 'tare'
$weging = R::findOne('weging', 'tare IS NOT NULL ORDER BY id DESC LIMIT 1');

// Als er een rij is gevonden, haal de waarde op uit het veld 'tare'
if ($weging) {
  $laatsteTare = $weging->tare;
  echo "De laatste waarde in het veld 'tare' is " . $laatsteTare;
} else {
  echo "Er is geen waarde gevonden in het veld 'tare'";
}

// en hier de berekening om iets te doen als het verschil groter is den 50%
$verschil = abs($laatsteTare - $gemiddelde);
$procent = $verschil / $laatsteTare * 100;

  // Als het verschil groter is dan xx%, toon een melding
  if ($procent > 5 ) {
    echo "<br>";
    echo "Het verschil tussen laatsteTare en het gemiddelde is groter dan 50%! KOFFIE BESTELLEN MAAR!!!!";
  
    $url = "https://api.telegram.org/" . $bot ."/sendMessage?chat_id=-1001228018473&text=koffietijd!";
    $contents = file_get_contents($url);
    echo "<pre>";
    echo $contents;
    echo "</pre>";

  }

?>