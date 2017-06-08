<?php

class csv {
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
}
?>