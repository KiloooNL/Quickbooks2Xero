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

//createCSV();
if($_GET['fileToConvert']) {

    openCSV($file);

    echo '<pre>';
    print_r($csv);
    echo '</pre>';
} else {
    ?>
    <!DOCTYPE html>
    <html>
    <body>

    <form action="upload.php" method="post" enctype="multipart/form-data">
        Select file to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload File" name="submit">
    </form>

    </body>
    </html>
    <?php } ?>
