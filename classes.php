<?php

class csv {
    /** @array $qbHeaders - This array stores the default Quickbooks headers
    Note: Quickbooks puts blank columns after each header, hence the empty elements */
    var $qbHeaders = array(
    'Date',
    'Receipt #',
    'Full Name',
    'Qty Sold',
    'Total',
    'No. of Items',
    'Last Name',
    'First Name',
    'Bill To Street',
    'Bill To City',
    'Bill To State',
    'Bill To ZIP',
    'Phone');

    /** @array $xeroHeaders - This array stores the default xero csv headers */
    var $xeroHeaders = array('ContactName',
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

    var $xeroData = array();

    function openCSV($file) {

        /** See if file exists first */
        if(!file_exists($file)) {
            echo "File does not exist.";
            header('Location: index.php');
            exit;
        }

        echo "Preparing CSV ($file)<br>";
        $file_handle = fopen($file, 'r');
        echo "Opening CSV...<br>";
        while(!feof($file_handle)) {
            $line_of_text[] = fgetcsv($file_handle, 1024);
        } fclose($file_handle);
        echo "Closing CSV...<br><br>";

        // Show headers
        echo "Headers: ";
        for($i = 0; $i < count($this->qbHeaders); $i++) {
            echo $line_of_text[5][$i] . ' ';
        }
        echo "<br>";

        /** Loop function
         * @var $row - represents csv row. starts at 6 as Quickbooks outputs headers on row 5, data starts at row 6.
         * @var $col - represents csv column. (Eg; $line_of_text[5][1] = 'name')
         *
         * @var ind - Header array index (Eg; 0 = date)
         *
         */
        for($row = 6; $row < count($line_of_text); $row++) {
            $col = 1; echo count($line_of_text);


            for($ind = 0; $ind < count($this->qbHeaders); $ind++) {
                if($line_of_text[$row][$col] !== NULL) {
                    echo $this->qbHeaders[$ind] . ': ' . $line_of_text[$row][$col];
                }

                /** Check if Quickbooks has exported this row as a transaction with multiple items
                The way this is validated is by checking if the date does not exist on the current row,
                Usually if this is the case, it is the same customer but multiple items */
                if(array_key_exists($row, $line_of_text) && array_key_exists($col, $line_of_text[$row])) {

                    /** ---- Sort through each row to see if this row is of a previous transaction ---- */
                    foreach($this->qbHeaders as $header) {

                        /** If this row's column is blank, try looking at the previous row to see if there was data there */
                        if($this->qbHeaders[$ind] == $header && $line_of_text[$row][$col] == NULL) {
                            if($this->qbHeaders[$ind] == $header && $line_of_text[$row - 1][$col] !== $header) {
                                /** Last entry was NOT blank, update current row to previous row */

                                /** if First Name . ' ' . Last Name !== full name */
                                if($line_of_text[$row][15] . ' ' . $line_of_text[$row][13] !== $line_of_text[$row][5]) {
                                    // todo:
                                    // grab row <full name> and insert as 'item description' for xero
                                    // then replace full name with actual full name
                                    $itemDesc = $line_of_text[$row][5];

                                    $line_of_text[$row][$col] = $line_of_text[$row - 1][$col];
                                    echo $line_of_text[$row][$col];
                                    $line_of_text[$row][5] = $line_of_text[$row - 1][15] . ' ' . $line_of_text[$row - 1][13];
                                }
                                // Update xero data array
                            }
                        }
                    }
                }
                $col = $col + 2;
                echo '<br>';

            }
            echo '<br>';

        }

        print "<pre>";
        print_r($this->xeroData);
        print "</pre>";
        return $line_of_text;
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

        // send the column headers
        fputcsv($file, $this->xeroHeaders);

        // output each row of the data
        foreach ($this->xeroData as $row)
        {
            fputcsv($file, $row);
        }
        echo $destinationFile;

        exit();
    }
}
?>