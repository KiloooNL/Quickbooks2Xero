<?php
require_once("config.php");


// A list of permitted file extensions
$allowed = array('csv');

// Get PHP ini max file size
$maxFileSize = getMaximumFileUploadSize();

if(isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] == 0){

	$extension = pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION);

	if(!in_array(strtolower($extension), $allowed)){
		echo '{"status":"error"}';
		exit;
	}

    if ($_FILES["fileToUpload"]["size"] >= $maxFileSize) {
        echo "<p>Sorry, your file is too large. Maximum upload size: $maxFileSize.</p>";
        $uploadOk = 0;
    }

	if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], UPLOAD_DIR.$_FILES['fileToUpload']['name'])){ ?>
		{status:success"}<a href="index.php?fileToConvert=<?php echo $targetDir . basename($_FILES["fileToUpload"]["name"]); ?>" />Convert to Xero</a>
	<?php exit;
	}
}

echo '{"status":"error"}';
exit;
?>