<?php
require_once("config.php");

// A list of permitted file extensions
$allowed = array('csv');

// Get PHP ini max file size
$maxFileSize = getMaximumFileUploadSize();

if(isset($_POST['submit'])) {
	if(isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] == 0){

		$extension = pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION);

		if(!in_array(strtolower($extension), $allowed)){
			echo '{"status":"error, file ext not allowed"}';
			exit;
		}

		if ($_FILES["fileToUpload"]["size"] >= $maxFileSize) {
			echo "<p>Sorry, your file is too large. Maximum upload size: $maxFileSize.</p>";
			$uploadOk = 0;
		}

		if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], UPLOAD_DIR.$_FILES['fileToUpload']['name'])){ ?>
			{status:success"} <a href="index.php?fileToConvert=<?php echo UPLOAD_DIR . basename($_FILES["fileToUpload"]["name"]); ?>" />Convert to Xero</a>
		<?php
		  exit;
		}
		if(file_exists(UPLOAD_DIR.$_FILES['fileToUpload']['tmp_name'])) {
			echo "Sorry, the file already exists.";
		} else {
			echo "Sorry, there was an error uploading your file.";
		}
	} else {
	echo '{"status":"error - fileToUpload was not sent during POST"}';
	}
} else {
	echo '{"status":"error - submit was not sent during POST"}';
}
var_dump($_POST,$_FILES);
exit;
?>