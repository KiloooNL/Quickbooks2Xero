<?php

require_once("config.php");
require_once("classes.php");


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