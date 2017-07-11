<?php

require_once("config.php");
require_once("classes.php");

function checkGet($getToGet) {
    if(isset($_GET[$getToGet])) {
        $getToGet = $_GET[$getToGet];
        return $getToGet;
    }
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