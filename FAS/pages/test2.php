
<?php
$F = intval($_GET['q']);
$S = intval($_GET['r']);
$con = mysqli_connect('localhost:3308','root','waseem123123','fasdb');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"ajax_demo");
$sql= "
	SELECT TOP 50 * FROM chat_message 
	WHERE (F_Id = '".$F."' 
	AND S_Id = '".$S."') 
	OR (F_Id = '".$S."' 
	AND S_Id = '".$F."') 
	ORDER BY Datetime ASC
	";
    $result = mysqli_query($con, $sql);
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {

    echo "<p>" . $row['Message'] . "</p>";
 }
} else {
    echo "0 results";
} 

mysqli_close($con);
?>
