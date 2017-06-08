<?php
require_once("config.php");

$targetDir = UPLOAD_DIR;
$targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);

$uploadOk = 1;

$fileType = pathinfo($targetFile,PATHINFO_EXTENSION);
$maxFileSize = getMaximumFileUploadSize();

if(isset($_POST["submit"])) {

}

// Check if file already exists
if (file_exists($targetFile)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] >= $maxFileSize) {
    echo "<p>Sorry, your file is too large. Maximum upload size: $maxFileSize.</p>";
    $uploadOk = 0;
}
// Allow certain file formats
if($fileType != "csv") {
    echo "<p>The file you are trying to upload is not a .CSV file.</p>";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
        echo "<p>The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.</p>";
        ?>
        <a href="index.php?fileToConvert=<?php echo $targetDir . basename($_FILES["fileToUpload"]["name"]); ?>" />Convert to Xero</a>
    </body>
    </html>
<?php
    } else {
        echo "<p>Sorry, there was an error uploading your file.</p>";
    }
}
?>