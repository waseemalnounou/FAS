<?php    
 error_reporting(0);
    include("config.php");
     function Redirect($url, $permanent = false)
{
    if (headers_sent() === false)
    {
        header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }

    exit();
}
       function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}
$target_dir = "../img/user/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.</br>";
        $src= basename( $_FILES["fileToUpload"]["name"]);
        $fullsrc="/fas/img/user/".$src;
        if (!$db||$src=NULL||$src='') {
   echo "plese try later";
}
else{
    try{
        echo $fullsrc;
        echo $_SESSION['user_Id'];
        echo "UPDATE user SET Img='".$fullsrc."' where Id=".$_SESSION['user_Id'];
    $sql = "UPDATE user SET Img='".$fullsrc."' where Id=".$_SESSION['user_Id'];
if (mysqli_query($db, $sql)) {
    alert("new image saved"); 
    Redirect('userprofile.php', false);
} else {
     alert("new image not saved");
}
}
    catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

}

    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
 Redirect('userprofile.php', false);
?>