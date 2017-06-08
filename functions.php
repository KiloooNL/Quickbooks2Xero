<?php

require_once("config.php");
require_once("classes.php");

// Open CSV
function openCSV($file) {
    $line_of_text = "";

    $file_handle = fopen($file, 'r');
    while(!feof($file_handle)) {
        //$csvInArray = array_map('str_getcsv', file('data.csv'));
        $line_of_text[] = fgetcsv($file_handle, 1024);
    }
    fclose($file_handle);

    return $line_of_text;
}

/**
function parseCSV($string, $separatorChar = ',', $enclosureChar = '"', $newlineChar = "\n") {
    // @author: Klemen Nagode
    $array = array();
    $size = strlen($string);
    $columnIndex = 0;
    $rowIndex = 0;
    $fieldValue="";
    $isEnclosured = false;
    for($i = 0; $i < $size; $i++) {

        $char = $string{$i};
        $addChar = "";

        if($isEnclosured) {
            if($char==$enclosureChar) {
                if($i+1<$size && $string{$i+1}==$enclosureChar){
                    // escaped char
                    $addChar=$char;
                    $i++; // dont check next char
                } else{
                    $isEnclosured = false;
                }
            } else {
                $addChar=$char;
            }
        } else {
            if($char==$enclosureChar) {
                $isEnclosured = true;
            } else {
                if($char==$separatorChar) {
                    $array[$rowIndex][$columnIndex] = $fieldValue;
                    $fieldValue="";
                    $columnIndex++;
                } elseif($char==$newlineChar) {
                    echo $char;
                    $array[$rowIndex][$columnIndex] = $fieldValue;
                    $fieldValue="";
                    $columnIndex=0;
                    $rowIndex++;
                } else {
                    $addChar=$char;
                }
            }
        }

        if($addChar!=""){
            $fieldValue.=$addChar;

        }
    }

    if($fieldValue) { // save last field
        $array[$rowIndex][$columnIndex] = $fieldValue;
    }

    return $array;
}*/


// Create new CSV
function createCSV($destinationFile) {
    // output headers so that the file is downloaded rather than displayed
    header('Content-type: text/csv');

    if(!isset($destinationFile)) {
        $destinationFile = XERO_CODE . date('d-m-Y');
    }

    header('Content-Disposition: attachment; filename="'.$destinationFile.'.csv"');

    // do not cache the file
    header('Pragma: no-cache');
    header('Expires: 0');

    // create a file pointer connected to the output stream
    $file = fopen('php://output', 'w');

    // send the column headers
    fputcsv($file, array('Column 1', 'Column 2', 'Column 3', 'Column 4', 'Column 5'));

    // Sample data. This can be fetched from mysql too
    $data = array(
        array('Data 11', 'Data 12', 'Data 13', 'Data 14', 'Data 15'),
        array('Data 21', 'Data 22', 'Data 23', 'Data 24', 'Data 25'),
        array('Data 31', 'Data 32', 'Data 33', 'Data 34', 'Data 35'),
        array('Data 41', 'Data 42', 'Data 43', 'Data 44', 'Data 45'),
        array('Data 51', 'Data 52', 'Data 53', 'Data 54', 'Data 55')
    );

    // output each row of the data
    foreach ($data as $row)
    {
        fputcsv($file, $row);
    }
    echo $destinationFile;

    exit();

    /***
     * Or with MySQL DB
     *
    // Open the connection
    $link = mysqli_connect('localhost', 'my_user', 'my_password', 'my_db');

    //query the database
    $query = 'SELECT field1, field2, field3, field4, field5 FROM table';

    if ($rows = mysqli_query($link, $query))
    {
    // loop over the rows, outputting them
    while ($row = mysqli_fetch_assoc($rows))
    {
    fputcsv($output, $row);
    }
    // free result set
    mysqli_free_result($result);
    }
    // close the connection
    mysqli_close($link);
     */
}

function convertSizeToBytes($sSize)
{
    if ( is_numeric( $sSize) ) {
        return $sSize;
    }
    $sSuffix = substr($sSize, -1);
    $iValue = substr($sSize, 0, -1);
    switch(strtoupper($sSuffix)){
        case 'P':
            $iValue *= 1024;
        case 'T':
            $iValue *= 1024;
        case 'G':
            $iValue *= 1024;
        case 'M':
            $iValue *= 1024;
        case 'K':
            $iValue *= 1024;
            break;
    }
    return $iValue;
}

function getMaximumFileUploadSize()
{
    return min(convertSizeToBytes(ini_get('post_max_size')), convertSizeToBytes(ini_get('upload_max_filesize')));
}

?>