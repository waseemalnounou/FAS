
<?php
$M = strval($_GET['m']);
$S = intval($_GET['s']);
$T = intval($_GET['t']);
echo $M;
echo $S;
echo $T;
$con = mysqli_connect('localhost:3308','root','waseem123123','fasdb');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"ajax_demo");
$sql="INSERT INTO chat_message(F_Id, S_Id,Message, status) VALUES ('".$S."','".$T."','".$M."','0')";
$result = mysqli_query($con,$sql);
mysqli_close($con);
?>
