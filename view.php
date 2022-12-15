<?php
// includes
require 'include/rb-mysql.php';
include 'config.php';

$wegingen = R::findAll('weging','LIMIT 10');

echo $wegingen;

?>