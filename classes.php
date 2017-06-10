<?php

class csv {

    function openCSV($file) {
        if(DEBUG_ENABLED) {
            echo "Preparing CSV ($file)<br>";
        }
        $file_handle = fopen($file, 'r');
        echo "Opening CSV...<br>";

        $file_handle = fopen($file, 'r');
        while (!feof($file_handle) ) {
            //$csvInArray = array_map('str_getcsv', file('data.csv'));
            $line_of_text[] = fgetcsv($file_handle, 1024);
        }
        fclose($file_handle);
        for($i = 0; $i < count($line_of_text); $i++) {
            print_r($line_of_text[$i]); echo "[array]<br>";
        }

        echo "Closing CSV...<br>";
        return $line_of_text;
    }

    function convertCSV($inputFile) {

    }

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


        /** @array $xeroHeaders - This array stores the default xero csv headers */
        $xeroHeaders = array('ContactName',
        'EmailAddress',
        'POAddressLine1',
        'POAddressLine2',
        'POAddressLine3',
        'POAddressLine4',
        'POCity',
        'PORegion',
        'POPostalCode',
        'POCountry',
        'InvoiceNumber',
        'Reference',
        'InvoiceDate',
        'DueDate',
        'PlannedDate',
        'Total',
        'TaxTotal',
        'InvoiceAmountPaid',
        'InvoiceAmountDue',
        'InventoryItemCode',
        'Description',
        'Quantity',
        'UnitAmount',
        'Discount',
        'LineAmount',
        'AccountCode',
        'TaxType',
        'TaxAmount',
        'TrackingName1',
        'TrackingOption1',
        'TrackingName2',
        'TrackingOption2',
        'Currency',
        'Type',
        'Sent',
        'Status');
        
        // send the column headers
        fputcsv($file, $xeroHeaders);

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
}
?>