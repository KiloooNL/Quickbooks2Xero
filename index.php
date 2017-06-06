<?php 

// Get config
require_once("config.php");

$csv = readCSV("test.csv");
echo '<pre>';
print_r($csv);
echo '</pre>';


//createCSV();

?>