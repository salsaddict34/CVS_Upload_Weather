<?php
$target_dir = "../../assets/uploads/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
$message = "";

// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
  $check = getimagesize($_FILES["file"]["tmp_name"]);
  if ($check !== false) {
    $message = urlencode("File is an image - " . $check["mime"] . ".");
    $uploadOk = 1;
  } else {
    $message = urlencode("File is not an image.");
    $uploadOk = 0;
    header("Location: http://private.localhost/AFPA-CDA/PHP_XDEBUG/client/src/PHP/Telechargement.php?message=" . $message);
    die;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  $message = urlencode("Sorry, file already exists.");
  $uploadOk = 0;
  header("Location: http://private.localhost/AFPA-CDA/PHP_XDEBUG/client/src/PHP/Telechargement.php?message=" . $message);
  die;
}

// Check file size
if ($_FILES["file"]["size"] > 5000000) {
  $message = urlencode("Sorry, your file is too large.");
  $uploadOk = 0;
  header("Location: http://private.localhost/AFPA-CDA/PHP_XDEBUG/client/src/PHP/Telechargement.php?message=" . $message);
  die;
}

// Allow certain file formats
if (
  $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif"
) {
  $message = urlencode("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
  $uploadOk = 0;
  header("Location: http://private.localhost/AFPA-CDA/PHP_XDEBUG/client/src/PHP/Telechargement.php?message=" . $message);
  die;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  $message = urlencode("Sorry, your file was not uploaded.");
  header("Location: http://private.localhost/AFPA-CDA/PHP_XDEBUG/client/src/PHP/Telechargement.php?message=" . $message);
  die;
  // if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
    $message .= urlencode("The file " . htmlspecialchars(basename($_FILES["file"]["name"])) . " has been uploaded.");
    header("Location: http://private.localhost/AFPA-CDA/PHP_XDEBUG/client/src/PHP/Telechargement.php?message=" . $message);
    die;
  } else {
    $message .= urlencode("Sorry, there was an error uploading your file.");
    header("Location: http://private.localhost/AFPA-CDA/PHP_XDEBUG/client/src/PHP/Telechargement.php?message=" . $message);
    die;
  }
}
