<?php

$target_dir = dirname(__FILE__, 1) . "/uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
if (isset($_POST["submit"])) {
  echo "FUCKING SUBMIT ";
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if ($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}
?>
