
<?php
    $all='';
$F = intval($_GET['s']);
$C = intval($_GET['c']);
$con = mysqli_connect('localhost:3308','root','waseem123123','fasdb');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"ajax_demo");
if($C==1){
$sql= "
	SELECT  * , (select CONCAT(First_Name,' ',Last_Name) from user u where u.id=c.F_Id ) as username
    FROM chat_message c
	WHERE (S_Id = '".$F."' and F_Id!='".$F."' )
	ORDER BY Datetime DESC";
     $GLOBALS['all']=" <li onclick='showmsg()'><a class='text-center' href='#'><strong>See All Alerts</strong><i class='fa fa-angle-right'></i></a></li>";
	}else{

	    $sql= "
	SELECT  * , (select CONCAT(First_Name,' ',Last_Name) from user u where u.id=c.S_Id ) as username
    FROM chat_message c
	WHERE (S_Id = '".$F."' and F_Id!='".$F."' )
	ORDER BY Datetime DESC 
    LIMIT 5";
	}

 $result = mysqli_query($con, $sql);
if (mysqli_num_rows($result) > 0) {
      
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) { 
        $r=NULL;
        echo  " <li><div><strong>".$row["username"]."</strong><span class='pull-right text-muted'>";
        echo "<em>".$row["Datetime"]."</em></span></div>";
      if($row["action"]!=NULL && $row["Device_Id"]!=NULL){
            if($row["action"]==1){

                $r= "<input type='button' value='Turn On' class='btn btn-primary btn-sm ' onclick='' />";
            }
            elseif($row["action"]==0){
                $r= "<input type='button' value='Turn off' class='btn  btn-primary btn-sm ' onclick='' />";
            }
        }
    echo "<div>". $row["Message"]." ".$r."</div>" ;
   echo "</li><li class='divider'></li>";
 }
} else {
    echo "0 results";
} 
mysqli_close($con);
?>

