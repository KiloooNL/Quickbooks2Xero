<?php
// Get config
require_once("config.php");
// Perform $_GET checks
$qbFile = checkGet('qbFile');
$xeroFile = checkGet('xeroFile');
// Init csv
$csv = new csv();
//createCSV();
if(!checkGet('fileToConvert') == "") {
    $csv->openCSV(checkGet('fileToConvert'));
} else { ?>
<!DOCTYPE html>
<head>
<title>Quickbooks2Xero</title>
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="" />
</head>
<body>
<h1>Quickbooks2Xero</h1>
<div class="upload">
	<div class="login-form">
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <div class="button">
			    <h2>Select Quickbooks CSV to upload:</h2><br>
                    <div class="fileUpload btn btn-primary">
                        <span>Browse...</span>
				        <div class="browse"><input type="file" name="fileToUpload" id="fileToUpload" value="browse" class="upload"/></div>
                    </div>
			</div>
            <div class="cancelBtn btn btn-warning">
                <span>Cancel</span>
                <div class="cancel"><a class="cancelBtn" name="cancel" href="index.php"></a></div>
            </div>

            <div class="submitBtn btn btn-success">
                <span>Convert 2 Xero</span>
			    <div class="done"><input type="submit" name="submit" class="submitBtn"/></div>
            </div>
            <div class="clear"> </div>
        </form>
    </div>
	<ul>
	<!-- The file uploads will be shown here -->
	</ul>
</div>
</body>
</html>
<?php } ?>