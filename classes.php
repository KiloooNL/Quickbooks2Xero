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

    function openCSV($file) {
        if(DEBUG_ENABLED) {
            echo "Preparing CSV ($file)<br>";
        }

        // Open CSV
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
         * @var $i - starts at 6 as Quickbooks outputs headers on row 5, data starts at row 6.
         *
         * @var ind - Header array index (Eg; 0 = date)
         *
         * @var arrIndex - the multi-dimensional array index. (Eg; $line_of_text[1][1] = 'name')
         */
        for($i = 6; $i <= count($line_of_text); $i++) {
            $arrIndex = 1;

            for($ind = 0; $ind < count($this->qbHeaders); $ind++) {
                if($line_of_text[$i][$arrIndex] !== NULL) {
                    echo $this->qbHeaders[$ind] . ': ' . $line_of_text[$i][$arrIndex];
                }

                /** Check if Quickbooks has exported this row as a transaction with multiple items
                    The way this is validated is by checking if the date does not exist on the current row,
                    Usually if this is the case, it is the same customer but multiple items */
                if(array_key_exists($i, $line_of_text) && array_key_exists($arrIndex, $line_of_text[$i])) {

                    // TODO: Process Full Name AS WELL as Last & First name BEFORE checking date.

                    if($this->qbHeaders[$ind] == "Date" && $line_of_text[$i][$arrIndex] == NULL) {
                        //echo "This transaction must belong to previous customer. Trying to find date...";

                        if($this->qbHeaders[$ind] == "Date" && $line_of_text[$i - 1][$arrIndex] !== null) {
                            echo "Transaction belongs to previous customer, using date: " . $line_of_text[$i - 1][$arrIndex];
                            $line_of_text[$i][$arrIndex] =  $line_of_text[$i - 1][$arrIndex];
                            // TODO: Update the xero array with this date.

                            // put last/first name here too....
                        }
                    }
                }
                $arrIndex = $arrIndex + 2;
                echo '<br>';
            }

            echo '<br>';
            /*

            // Date
            echo $this->qbHeaders[0] . ': ' . $line_of_text[$i][$arrIndex]; echo '<br>';

            // Receipt #
            $arrIndex = $arrIndex + 2;
            echo $this->qbHeaders[1] . ': ' . $line_of_text[$i][$arrIndex]; echo '<br>';

            // Full Name
            $arrIndex = $arrIndex + 2;
            echo $this->qbHeaders[2] . ': ' . $line_of_text[$i][$arrIndex]; echo '<br>';

            // Qty Sold
            $arrIndex = $arrIndex + 2;
            echo $this->qbHeaders[3] . ': ' . $line_of_text[$i][$arrIndex]; echo '<br>';

            // Total
            $arrIndex = $arrIndex + 2;
            echo $this->qbHeaders[4] . ': ' . $line_of_text[$i][$arrIndex]; echo '<br>';

            // No. of Items
            $arrIndex = $arrIndex + 2;
            echo $this->qbHeaders[5] . ': ' . $line_of_text[$i][$arrIndex]; echo '<br>';

            // Last Name
            $arrIndex = $arrIndex + 2;
            echo $this->qbHeaders[6] . ': ' . $line_of_text[$i][$arrIndex]; echo '<br>';

            // First Name
            $arrIndex = $arrIndex + 2;
            echo $this->qbHeaders[7] . ': ' . $line_of_text[$i][$arrIndex]; echo '<br>';

            // Bill to Street
            $arrIndex = $arrIndex + 2;
            echo $this->qbHeaders[8] . ': ' . $line_of_text[$i][$arrIndex]; echo '<br>';

            // Bill to City
            $arrIndex = $arrIndex + 2;
            echo $this->qbHeaders[9] . ': ' . $line_of_text[$i][$arrIndex]; echo '<br>';

            // Bill to State
            $arrIndex = $arrIndex + 2;
            echo $this->qbHeaders[10] . ': ' . $line_of_text[$i][$arrIndex]; echo '<br>';

            // Bill to Phone
            $arrIndex = $arrIndex + 2;
            echo $this->qbHeaders[11] . ': ' . $line_of_text[$i][$arrIndex]; echo '<br>';

            // Phone
            $arrIndex = $arrIndex + 2;
            echo $this->qbHeaders[12] . ': ' . $line_of_text[$i][$arrIndex]; echo '<br>';
 */
        }

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

        // send the column headers
        fputcsv($file, $this->xeroHeaders);

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