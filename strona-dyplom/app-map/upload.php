<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 50000000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if ($imageFileType != "gpkg" ) {
  echo "Sorry, only GPKG files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}
echo "<pre>";
echo shell_exec("ogr2ogr -t_srs EPSG:4326 /home/adam/dyplom/strona-dyplom/app-map/vector_store/aplikacja.gpkg /home/adam/dyplom/strona-dyplom/app-map/'$target_file'");
echo "</pre>";
//$source = $target_dir . basename($_FILES["fileToUpload"]["name"]);
//$destination = '/home/adam/dyplom/strona-dyplom/app-map/vector_store/aplikacja.gpkg';
//if( !copy($source, $destination) ) {
//    echo "File can't be copied! \n";
//}
//else {
//	echo "File has been copied! \n";
//}
if (!unlink($target_file )) {
    echo ("$target_file  cannot be deleted due to an error");
}
else {
    echo ("$target_file  zostanie przetworzone");
}

chmod("/home/adam/dyplom/strona-dyplom/app-map/vector_store/aplikacja.gpkg", 0777);
echo "<pre>";
echo shell_exec("ogrinfo -so /home/adam/dyplom/strona-dyplom/app-map/vector_store/aplikacja.gpkg");
echo "</pre>";
?>

