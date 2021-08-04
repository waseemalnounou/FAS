
<!DOCTYPE html>
<html>
<head>
<style>
table {
    width: 100%;
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid black;
    padding: 5px;
}

th {text-align: left;}
</style>
</head>
<body>

<?php
$q = intval($_GET['q']);
$con = mysqli_connect('localhost:3308','root','waseem123123','fasdb');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}
mysqli_select_db($con,"ajax_demo");
$sql="select u.Id,m.Id,m.Message,u.First_Name,u.Last_Name,u.Img,m.Seen,m.Datetime  from message m inner join user u  where m.F_Id=1 and m.S_Id=6";
$result = mysqli_query($con,$sql);
while($row = mysqli_fetch_array($result)) {
    if($row["Img"]==NULL){$img="/fAS/img/user/user.jpg";}else{$img=$row["Img"];}
    echo  "<li class='left clearfix'><span class='chat-img pull-left'><img width='25' height='25' src='" .$img. "' alt='User Avatar' class='img-circle' /></span><div class='chat-body clearfix'><div class='header'><strong class='primary-font'>".$row["First_Name"]." ".$row["Last_Name"]."</strong><small class='pull-right text-muted'><i class='fa fa-clock-o fa-fw'></i>". $row["Datetime"]."</small></div><p>".$row["Message"]."</p></div></li>" ;
}
mysqli_close($con);
?>
   
</body>


</html> 