<?php

// Get config
require_once("config.php");

if(defined($_GET['qb_file'])) {
    $qbFile = $_GET['qb_file'];
} else {
    $qbFile = "";
}

if(defined($_GET['xero_file'])) {
    $xeroFile = $_GET['xero_file'];
} else {
    $xeroFile = "";
}

if(DEBUG_ENABLED) {
    if($qbFile == "") {
        echo "No Quickbooks file specified<br>";
    } else {
        echo "Quickbooks file: " . $qbFile . "<br>";
    }

    if($xeroFile == "") {
        echo "No Xero file specified<br>";
    } else {
        echo "Xero file: " . $xeroFile . "<br>";
    }
}


$csv = readCSV("test.csv");
echo '<pre>';
print_r($csv);
echo '</pre>';


//createCSV();

?>