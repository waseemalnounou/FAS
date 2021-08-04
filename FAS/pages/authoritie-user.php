
<?php
$A = strval($_GET['a']);
$U = intval($_GET['u']);
$C = intval($_GET['c']);
$con = mysqli_connect('localhost:3308','root','waseem123123','fasdb');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"ajax_demo");
if($C==0){
    //delete
$sql="DELETE from `authorities`WHERE User_ID=".$U." and RR_Id IN (".substr($A,1,-1).")";
$result = mysqli_query($con,$sql);
}
elseif($C==1){
    //insert
$arry=array_map('intval', explode(',', $A));
$Line="";
foreach($arry as $i=>$e ){
if($e==0){continue;}
$Line=$Line."(NULL, ".$U.", ".$e."),";
}
$Line=substr($Line,0,-1);

$sql="INSERT INTO `authorities` (`Id`, `User_ID`, `RR_Id`) VALUES ".$Line;
$result = mysqli_query($con,$sql);

mysqli_close($con);
}
?>
