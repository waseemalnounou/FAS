<?php
/* init page */ error_reporting(0);
try{
include("config.php");
 $UID=$_SESSION['user_Id'];
  $dbdlt=FALSE;$dbupd=FALSE;$dbins=FALSE;$dbdis=FALSE;
    function Redirect($url, $permanent = false)
{
    if (headers_sent() === false)
    {
        header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }

    exit();
}
     if($UID==NULL){
      Redirect('login.php', false);
   }else{
      $sql = "SELECT * FROM user WHERE Id ='$UID'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $count = mysqli_num_rows($result);    
      // return user info if is not exis redirect to logout
      if($count == 1) {       
         $user_name = $row["First_Name"]. " " .$row["Last_Name"];
         $user_Img=$row["Img"];
            
      }else{
          Redirect('login.php', false);
      }
   }

      function authorities($db)
   {                    
    if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
else
{   
 $sql = "SELECT  rr.id,Role_Name from roleresources rr inner join Role ro ON rr.Role_Id=ro.id INNER join  resources re ON rr.Resoources_Id=re.Id      inner JOIN authorities a ON a.RR_Id=rr.Id where re.Resources_Name='device' and a.User_ID=".$_SESSION['user_Id'];
 $result = mysqli_query($db, $sql);
 $count = mysqli_num_rows($result);  
    if ($count > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) { 
          switch($row["Role_Name"]){
              case 'delete data':
                $GLOBALS["dbdlt"]=TRUE;
              break;
              case 'insert data':
               $GLOBALS["dbins"]=TRUE;
              break;
              case 'open page':
              $openpage=TRUE;
              break;
              case 'update data':
              $GLOBALS["dbupd"]=TRUE;
              break;
              case 'display data':
              $GLOBALS["dbdis"]=TRUE;
              break;
          }
    }
  }
else
{
 Redirect('404.php', false);
    }
  }   
   
   if(!$openpage){ Redirect('404.php', false);}     
   }
   authorities($db);
       function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}
function initraspberrylist($db){
        if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
else
{
 $sql = "SELECT g.Id,g.GPIO_Number,(select r.Name from raspberry r where g.raspberry_id=r.id) as rasname FROM gpio g";
 $result = mysqli_query($db, $sql);
 $count = mysqli_num_rows($result);  
    if ($count > 0) {
    // output data of each row
    echo "<select class='form-control'  name='GName'><option>please select</option>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<option value='".$row["Id"]."' >".$row["rasname"]." GPIO ".$row["GPIO_Number"]."</option>";
    }
     echo "</select>";
  }
else
{
    echo "0 results please add raspberry First";
    }
  }
}
function initunitelist($db){
        if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
else
{
 $sql = "SELECT Id,Name FROM unite";
 $result = mysqli_query($db, $sql);
 $count = mysqli_num_rows($result);  
    if ($count > 0) {
    // output data of each row
    echo "<select class='form-control'  name='UName'><option>please select</option>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<option value='".$row["Id"]."' >".$row["Name"]."</option>";
    }
     echo "</select>";
  }
else
{
    echo "0 results please add raspberry First";
    }
  }
}
/*  end init page */
/* load page*/

    function  filltable($db){                      
    if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
else
{
 $sql = "SELECT *,(select Name  from unite r where g.Unite_id=r.Id) as UName,(select GPIO_Number from GPIO p where g.GPIO_id=p.Id) as NGPIO   FROM device g";
 $result = mysqli_query($db, $sql);
 $count = mysqli_num_rows($result);  
    if ($count > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
    if($row['Img']==""){$img="/FAS/img/icon/010-plug-4.png";}else{$img=$row['Img'];}   
        echo "<tr id='".$row["Id"]."' ><td>" . "<input type='radio'  class='btn btn-warning btn-lg btn-block' name='selectedrow' " . "value='".$row["Id"]."'/>". "</td><td>"."<img src='" .$img."' alt='user img' width='50' height='50' >". "</td><td data-value='UName' >". $row["UName"]. "</td><td data-value='Name' >".  $row["Name"]. "</td><td data-value='NGPIO'>" . $row["NGPIO"]. "</td><td data-value='Des'>" .  $row["Description"]. "</td></tr>";

    }
  }
else
{
    echo "0 results";
    }
  }
} 
/* end load page*/
/* page event */
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
      $_SESSION["msg"] ="the DB not avilable";
    $_SESSION["typ"] ='w';
}
else{
try {
    // ADD device
if(isset($_POST['submit'])){ 
if($_POST['submit']=='Save'){
if(isset($_POST['UName'])&&isset($_POST['GName'])&&isset($_POST['txtn'])&&isset($_POST['txtd'])&&isset($_POST['hfimg'])){
     $sql = "INSERT INTO device(Unite_Id,Name,GPIO_id,Description,Img)
    VALUES('".$_POST["UName"]."','".$_POST["txtn"]."','".$_POST["GName"]."','".$_POST["txtd"]."','/fas/img/icon/".$_POST["hfimg"]."')";
if (mysqli_query($db, $sql)) {
     $_SESSION["msg"] ="new device is added";
     $_SESSION["typ"] ='s'; 
} else {
     $_SESSION["msg"] ="err:device not added";
     $_SESSION["typ"] ='w';
}

    }     /* end add device */ /*delete device*/
      }elseif($_POST['submit']=='delete'){
       $id= $_POST["hf"];
       $sql = "DELETE FROM device WHERE id=$id";

if (mysqli_query($db, $sql)) {
   
     $_SESSION["msg"] ="deleted";
     $_SESSION["typ"] ='s';
    
} else {
     $_SESSION["msg"] ="not deleted";
     $_SESSION["typ"] ='w';
}

      } /* end delete device */ /*edit device*/
      elseif($_POST['submit']=='update'){
           $id= $_POST["hf"];
if(isset($_POST['UName'])&&isset($_POST['GName'])&&isset($_POST['txtn'])&&isset($_POST['txtd'])&&isset($_POST['hfimg'])){
     $sql = "UPDATE device SET  Unite_Id='".$_POST["UName"]."',Name='".$_POST["txtn"]."',GPIO_id='".$_POST["GName"]."',Description='".$_POST["txtd"]."',Img='/fas/img/icon/".$_POST["hfimg"]."' where Id='$id'";

if (mysqli_query($db, $sql)) {
    
      $_SESSION["msg"] ="device information is updated";
      $_SESSION["typ"] ='s';
} else {
      $_SESSION["msg"] ="err:device not update";
      $_SESSION["typ"] ='w';
            }
         } 
      }/*end edit device*/
   }
}
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

}
}
catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
/*end page event*/
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>device</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script> 
    <style>
               svg{
            width: 250px;
            height: 250px;
  display: block;
  margin: auto;
}
         img{
             border-radius: 50%;
        }
        input[type="search"]{
            width: 75% !important;
        }
     td,th{
            text-align:center;
        }
    #med,#msv
       {
            display: none;
        }
         .userimg {
            border-radius: 50%;
            margin-top:0px ;
            margin-bottom:0px;
                margin-right:25px;
                margin-left: 25px;   
            border:#808080 soild 2px;
        }
        .icon:hover{
            opacity: 0.3;
            cursor :pointer;
        }
        .onlyimg{         
  display: block;
  margin-left: auto;
  margin-right: auto;
  width: 50%;
  border-radius: 0;
          }
    </style>
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                 <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
  <a class="navbar-brand" href="index.php">Facility Automation System</a> 
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
        
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="userprofile.php"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="sys.php"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout
                        </a>

                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                          <!--user img -->
                              <div class="row" style="">   
<?php 

if($user_Img<>''){
    echo  "<img class='userimg' src="."$user_Img". " alt='user image' height='50' width='50' >";
   
}else
{ 
    echo  '<img  src="\FAS\img\user\user.jpg" class="userimg"  alt="user image" height="50 width="50" />';
    }
     echo $user_name;
?>                
                         </div>     
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                     
                        <li>
                            <a href="userprofile.php"><i class="fa fa-table fa-fw"></i>Profile</a>
                        </li>
                       
                        <li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i>Facility Structure<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="Unite.php">Unite</a>
                                </li>
                                      <li>
                                    <a href="raspberry.php">raspberry</a>
                                </li>
                                   <li>
                                    <a href="GPIO.php">GPIO</a>
                                </li>
                                <li>
                                    <a href="Device.php">Device</a>
                                </li>
                             
                                <li>
                                    <a href="sensor.php">sensor</a>
                                </li>
                              
                             
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i>Admin<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                              <li>
                                    <a href="#">User <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="add_user.php">user control panale</a>
                                        </li>
                                        <li>
                                            <a href="address.php">address</a>
                                        </li>
                                        <li>
                                            <a href="contact.php">contact</a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-third-level -->
                                </li>
                                <li>
                                    <a href="#">security<span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="Role.php">Role</a>
                                        </li>
                                        <li>
                                            <a href="authoritie.php">authorities</a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-third-level -->
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                                                  <li>
<!--clock-->
<svg version="1.1" id="clock" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 width="150px" height="150px" viewBox="50 50 400 500" 
	 xml:space="preserve">
<circle id="face" fill="#F4F3ED" cx="243.869" cy="250.796" r="130.8"/>
<path id="rim" fill="#383838" d="M243.869,101.184c-82.629,0-149.612,66.984-149.612,149.612c0,82.629,66.983,149.612,149.612,149.612
	S393.48,333.425,393.48,250.796S326.498,101.184,243.869,101.184z M243.869,386.455c-74.922,0-135.659-60.736-135.659-135.659
	c0-74.922,60.737-135.659,135.659-135.659c74.922,0,135.658,60.737,135.658,135.659
	C379.527,325.719,318.791,386.455,243.869,386.455z"/>
<g id="inner">
	<g opacity="0.2">
		<path fill="#C4C4C4" d="M243.869,114.648c-75.748,0-137.154,61.406-137.154,137.153c0,75.749,61.406,137.154,137.154,137.154
			c75.748,0,137.153-61.405,137.153-137.154C381.022,176.054,319.617,114.648,243.869,114.648z M243.869,382.56
			c-72.216,0-130.758-58.543-130.758-130.758s58.542-130.758,130.758-130.758c72.216,0,130.758,58.543,130.758,130.758
			S316.085,382.56,243.869,382.56z"/>
	</g>
	<g>
		<path fill="#282828" d="M243.869,113.637c-75.748,0-137.154,61.406-137.154,137.153c0,75.749,61.406,137.154,137.154,137.154
			c75.748,0,137.153-61.405,137.153-137.154C381.022,175.043,319.617,113.637,243.869,113.637z M243.869,381.548
			c-72.216,0-130.758-58.542-130.758-130.757c0-72.216,58.542-130.758,130.758-130.758c72.216,0,130.758,58.543,130.758,130.758
			C374.627,323.005,316.085,381.548,243.869,381.548z"/>
	</g>
</g>
<g id="markings">
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="243.5" y1="139" x2="243.5" y2="133"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="231.817" y1="139.651" x2="231.19" y2="133.684"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="220.266" y1="141.52" x2="219.018" y2="135.65"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="208.973" y1="144.585" x2="207.119" y2="138.879"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="198.063" y1="148.814" x2="195.623" y2="143.333"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="187.655" y1="154.161" x2="184.655" y2="148.965"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="177.862" y1="160.566" x2="174.335" y2="155.712"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="168.792" y1="167.96" x2="164.778" y2="163.501"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="160.545" y1="176.262" x2="156.087" y2="172.246"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="153.211" y1="185.379" x2="148.358" y2="181.852"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="146.871" y1="195.214" x2="141.675" y2="192.213"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="141.593" y1="205.658" x2="136.112" y2="203.216"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="137.436" y1="216.596" x2="131.729" y2="214.741"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="134.445" y1="227.909" x2="128.576" y2="226.66"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="132.653" y1="239.472" x2="126.685" y2="238.843"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="132.079" y1="251.16" x2="126.079" y2="251.158"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="132.73" y1="262.843" x2="126.762" y2="263.468"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="134.598" y1="274.395" x2="128.729" y2="275.64"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="137.664" y1="285.688" x2="131.958" y2="287.539"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="141.893" y1="296.598" x2="136.412" y2="299.035"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="147.24" y1="307.006" x2="142.043" y2="310.004"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="153.645" y1="316.799" x2="148.791" y2="320.323"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="161.04" y1="325.868" x2="156.58" y2="329.881"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="169.341" y1="334.115" x2="165.325" y2="338.572"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="178.459" y1="341.449" x2="174.931" y2="346.302"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="188.294" y1="347.789" x2="185.292" y2="352.984"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="198.738" y1="353.066" x2="196.295" y2="358.548"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="209.676" y1="357.223" x2="207.82" y2="362.93"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="220.989" y1="360.214" x2="219.739" y2="366.084"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="232.552" y1="362.006" x2="231.922" y2="367.975"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="244.239" y1="362.58" x2="244.237" y2="368.582"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="255.921" y1="361.93" x2="256.547" y2="367.898"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="267.472" y1="360.062" x2="268.719" y2="365.932"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="278.765" y1="356.996" x2="280.619" y2="362.703"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="289.675" y1="352.767" x2="292.116" y2="358.248"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="300.083" y1="347.42" x2="303.083" y2="352.616"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="309.876" y1="341.015" x2="313.403" y2="345.869"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="318.946" y1="333.621" x2="322.96" y2="338.08"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="327.193" y1="325.319" x2="331.651" y2="329.334"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="334.527" y1="316.201" x2="339.38" y2="319.728"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="340.868" y1="306.367" x2="346.063" y2="309.367"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="346.146" y1="295.924" x2="351.626" y2="298.364"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="350.303" y1="284.986" x2="356.008" y2="286.84"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="353.294" y1="273.673" x2="359.162" y2="274.92"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="355.087" y1="262.11" x2="361.052" y2="262.737"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="356" y1="250.5" x2="362" y2="250.5"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="355.355" y1="238.781" x2="361.323" y2="238.153"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="353.489" y1="227.193" x2="359.359" y2="225.945"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="350.422" y1="215.864" x2="356.129" y2="214.01"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="346.188" y1="204.918" x2="351.669" y2="202.477"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="340.833" y1="194.474" x2="346.029" y2="191.474"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="334.415" y1="184.647" x2="339.269" y2="181.12"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="327.004" y1="175.545" x2="331.463" y2="171.529"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="318.684" y1="167.268" x2="322.699" y2="162.807"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="309.543" y1="159.905" x2="313.07" y2="155.049"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="299.684" y1="153.538" x2="302.683" y2="148.34"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="289.212" y1="148.237" x2="291.652" y2="142.753"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="278.245" y1="144.059" x2="280.097" y2="138.351"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="266.9" y1="141.05" x2="268.145" y2="135.179"/>
	<line fill="none" stroke="#3F3F3F" stroke-miterlimit="10" x1="255.302" y1="139.244" x2="255.927" y2="133.275"/>
	<polygon fill="#3F3F3F" points="247.391,133 243.5,141.05 239.609,133 	"/>
	<polygon fill="#3F3F3F" points="188.022,147.021 188.677,155.938 181.283,150.912 	"/>
	<polygon fill="#3F3F3F" points="143.617,188.848 148.643,196.243 139.726,195.588 	"/>
	<polygon fill="#3F3F3F" points="126.074,247.273 134.125,251.165 126.076,255.056 	"/>
	<polygon fill="#3F3F3F" points="140.095,306.644 149.013,305.988 143.988,313.382 	"/>
	<polygon fill="#3F3F3F" points="181.922,351.049 189.318,346.022 188.663,354.938 	"/>
	<polygon fill="#3F3F3F" points="240.349,368.591 244.24,360.54 248.13,368.589 	"/>
	<polygon fill="#3F3F3F" points="299.718,354.569 299.062,345.652 306.457,350.677 	"/>
	<polygon fill="#3F3F3F" points="344.123,312.742 339.096,305.348 348.012,306.002 	"/>
	<polygon fill="#3F3F3F" points="362,254.316 353.951,250.426 362,246.534 	"/>
	<polygon fill="#3F3F3F" points="347.934,194.779 339.018,195.435 344.042,188.04 	"/>
	<polygon fill="#3F3F3F" points="305.984,150.252 298.59,155.277 299.244,146.361 	"/>
	<rect x="282" y="152.98" fill="none" width="17.366" height="27.947"/>
	<text transform="matrix(1 0 0 1 282 174.4307)" fill="#303030" font-family="'Futura-Medium'" font-size="26">1</text>
	<rect x="320.699" y="188.474" fill="none" width="17.202" height="26.267"/>
	<text transform="matrix(1 0 0 1 320.6987 209.9229)" fill="#303030" font-family="'Futura-Medium'" font-size="26">2</text>
	<rect x="335.04" y="238.872" fill="none" width="21.03" height="24.585"/>
	<text transform="matrix(1 0 0 1 335.0396 260.3213)" fill="#303030" font-family="'Futura-Medium'" font-size="26">3</text>
	<rect x="319.699" y="290.242" fill="none" width="17.202" height="23.557"/>
	<text transform="matrix(1 0 0 1 319.6987 311.6914)" fill="#303030" font-family="'Futura-Medium'" font-size="26">4</text>
	<rect x="284.5" y="323.319" fill="none" width="19.212" height="22.511"/>
	<text transform="matrix(1 0 0 1 284.5 344.7695)" fill="#303030" font-family="'Futura-Medium'" font-size="26">5</text>
	<rect x="235.552" y="336.08" fill="none" width="19.938" height="24.15"/>
	<text transform="matrix(1 0 0 1 235.5522 357.5293)" fill="#303030" font-family="'Futura-Medium'" font-size="26">6</text>
	<rect x="189.373" y="322.319" fill="none" width="19.673" height="25.003"/>
	<text transform="matrix(1 0 0 1 189.3726 343.7695)" fill="#303030" font-family="'Futura-Medium'" font-size="26">7</text>
	<rect x="151.066" y="287.539" fill="none" width="17.726" height="25.203"/>
	<text transform="matrix(1 0 0 1 151.0664 308.9883)" fill="#303030" font-family="'Futura-Medium'" font-size="26">8</text>
	<rect x="136.392" y="241.25" fill="none" width="20.696" height="22.348"/>
	<text transform="matrix(1 0 0 1 136.3916 262.6992)" fill="#303030" font-family="'Futura-Medium'" font-size="26">9</text>
	<rect x="149.066" y="191.474" fill="none" width="36.554" height="27.122"/>
	<text transform="matrix(1 0 0 1 149.0664 212.9229)" fill="#303030" font-family="'Futura-Medium'" font-size="26">10</text>
	<rect x="184.967" y="158.518" fill="none" width="36.021" height="27.13"/>
	<text transform="matrix(1 0 0 1 184.9673 179.9668)" fill="#303030" font-family="'Futura-Medium'" font-size="26">11</text>
	<rect x="225.723" y="144.514" fill="none" width="37.029" height="29.25"/>
	<text transform="matrix(1 0 0 1 225.7227 165.9639)" fill="#303030" font-family="'Futura-Medium'" font-size="26">12</text>
</g>
<path id="hours" fill="#3A3A3A" d="M242.515,270.21c-0.44,0-0.856-0.355-0.926-0.79l-3.156-19.811c-0.069-0.435-0.103-1.149-0.074-1.588
	l4.038-62.009c0.03-0.439,0.414-0.798,0.854-0.798h0.5c0.44,0,0.823,0.359,0.852,0.798l4.042,62.205
	c0.028,0.439-0.015,1.152-0.097,1.584l-3.712,19.623c-0.082,0.433-0.508,0.786-0.948,0.786H242.515z"/>
<path id="minutes" fill="#3A3A3A" d="M247.862,249.75l-2.866,24.244c-0.099,1.198-0.498,2.18-1.497,2.179c-0.999,0-1.397-0.98-1.498-2.179
			l-2.861-24.508c-0.099-1.199,3.479-93.985,3.479-93.985c0.036-1.201-0.117-2.183,0.881-2.183c0.999,0,0.847,0.982,0.882,2.183
			L247.862,249.75z"/>
<g id="seconds">
	<line fill="none" stroke="#BF4116" stroke-miterlimit="10" x1="243.5" y1="143" x2="243.5" y2="266"/>
	<circle fill="none" stroke="#BF4116" stroke-miterlimit="10" cx="243.5" cy="271" r="5"/>
	<circle fill="#BF4116" cx="243.5" cy="251" r="3.917"/>
</g>
</svg>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/snap.svg/0.2.0/snap.svg-min.js'></script>

    <script src="/FAS/js/index.js"></script>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
   
        <div id="page-wrapper">
            <form  method="post">
                <input type="hidden" id="hfimg" name="hfimg" value=""/>
            <div class="row">
                <input type="text" class="hidden" name="hf"  id="hf" value="" />
                 <div class="panel-body">
                            <div id="notsuccess" style="display: none; " class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" >&times;</button>
                                <a href="#" class="alert-link">Alert Link</a>.
                            </div>
                            <div id="notinfo" style="display: none; " class="alert alert-info alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" >&times;</button>
                                <a href="#" class="alert-link">Alert Link</a>.
                            </div>
                            <div id="notwarning" style="display: none; " class="alert alert-warning alert-dismissable">
                                 <button type="button" class="close" data-dismiss="alert" >&times;</button>
                                 <a href="#" class="alert-link">Alert Link</a>.
                            </div>
                            <div id="notdanger" style="display: none;" class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <input type="submit" name="submit" value="delete" style="object-position: right; " class="btn btn-danger" alt="delete"/>
                                <input type="button" data-dismiss="" id="dltno"  class="btn btn-warning" value="NO" />                                    
                            </div>
                        </div> 
             
                <div class="col-lg-12">
                    <h1 class="page-header">device</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
               
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            device Information
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table style="width: 100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                         
                                        <th>device</th>
                                        <th>Image</th>
                                        <th>Unite Name</th>
                                        <th>Device Name</th>
                                        <th>GPIO Number</th>
                                        <th>Description</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
  <?php     
     if($dbdis==TRUE)
    { filltable($db);}
  ?> 
                                
                         
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                            <div class="well">
<!--add row -->
   <?php
                               if($dbins){ echo "<input type='button' id='btnmodel' class='btn btn-primary' value='new Device' data-toggle='modal' data-target='#myModal'/>";}    
                              if($dbupd){   echo" <input type='button' disabled id='edt' class='btn btn-warning' alt='Edit'  value='Edit'  data-toggle='modal' data-target='#myModal'/>";}
                               if($dbdlt){ echo"  <input type='button' disabled id='dlt' class='btn btn-danger' alt='delete' name='' value='delete'/>";}
                                ?>                                     <!-- Modal -->
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                                        </div>
                                        <div class="modal-body">
                                            <!-- body -->                                                                                          
                                                 <div class="form-group">
                                                    
                                      
                                                     <div>
                                                         </br>
                                                 <label >GPIO:</label>
                                                 <?php initraspberrylist($db)?>  
                                                 <label >Unite Name:</label>
                                                 <?php initunitelist($db)?>  
                                                 <label >device Name:</label><input class="form-control "  type="text" id="txtn" name="txtn"  placeholder="device Name" />
                                                 <label >device Description:</label><input class="form-control "  type="text" id="txtd" name="txtd"  placeholder="device Description" />
                                                       
                                                         </div>
                                                     <br/>
                                                     <div id="licon" style=" border: 4px solid #859bda; border-radius: 5px; " class="">
                                                     <?php 
$directory = '../img/icon';
$scanned_directory = array_diff(scandir($directory), array('.', '..'));
foreach($scanned_directory as $x){
    echo "<img id='".$x."' onclick="."addimg('".$x."'".")"." src='/fas/img/icon/".$x."' height='50' width='50' class='icon' />";
}
              ?>
                                     
                                                         </div>
                                                      <div id="dicon" style=" border: 4px solid #859bda; border-radius: 5px;display: none; ">
                                          <img src="" id="idicon" class='onlyimg' alt="icon" />   
                                          </div >
                                                        </br>
                                                      <input id="changicon" onclick="chicon()" class="btn btn-default" type="button" style="display: none" value="chang icon"/>

                                                  </div>
                                          
                                        </div>

                                        <div class="modal-footer">
                                          <!-- <button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>--> 
                                           <input type="reset" class="btn btn-default" data-dismiss="modal" value="Close"/> 
                                           <input type="reset" class="btn btn-warning" data-dismiss="" value="reset"/>
                                        <?php
                                if($dbins){     echo "<input type='submit' class='btn btn-primary' id='msv' alt='Save' name='submit' data-dismiss='' value='Save'/>";}
                                 if($dbupd){    echo "<input type='submit' class='btn btn-primary' id='med' alt='edit' name='submit' data-dismiss='' value='update'/>";}
                                         ?>
      
                                           <!-- <button type="button" class="btn btn-primary">Save changes</button>-->
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->

                                </div>
                                <!-- /.modal-dialog -->
                                    
                            </div>
                            <!-- /.modal -->

                             

                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
                 </form>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->

    <script>
    $(document).ready(function() {
     

        $('#dataTables-example').DataTable({
            responsive: true

        });
           $("#btnmodel").click(function () {
              $("#med").hide();
              $("#msv").show();
          });
   $("#edt").click(function () {
                 $("#msv").hide();
                 $("#med").show();
                 x = $("#hf").val();
                 $("table #" + x + "> td[data-value]").each(function(){
                 switch($(this).data("value")){
                 case 'Name':
                 $("#txtn").val($(this).text()); break;
                 case 'Des':
                 $("#txtd").val($(this).text()); break;
                   }
                         
              });
              
  });
         
            $("input:radio").click(function () 
        {
                $("#hf").val($(this).val());
                $("#dlt").removeAttr("disabled");
                $("#edt").removeAttr("disabled");
        });

       $("#dlt").click(function(){not("are you sure you want to delete",'d');});
       $("#dltno").click(function(){
        $("#notdanger").hide();
        not("the record not deleted",'i');
        });
       
       <?php 

   if (isset($_POST["submit"])){
        $x= $_SESSION['msg'];
         $y=$_SESSION['typ'];
         if($x!=''){
       echo "not('$x','$y');";
        $_SESSION['msg']="";
         $_SESSION['typ']="";
   }
   }
   
      ?>  
   });
              function not(msg, st) {
              if (st == 'success') { st = 's'; }
              switch (st) {
                  case 's':
                      $("#notsuccess").slideDown("slow").append(msg); break;
                  case 'd':
                      $("#notdanger").slideDown("slow").append(msg); break;
                  case 'i':
                      $("#notinfo").slideDown("slow").append(msg); break;
                  case 'w':
                      $("#notwarning").slideDown("slow").append(msg); break;
              }
          }
    </script>
    <script>
        function addimg(x) {
            document.getElementById("hfimg").value = x;
            document.getElementById("licon").style.display = "none";
            document.getElementById("dicon").style.display = "block";
            document.getElementById("changicon").style.display = "block";
            document.getElementById("idicon").src = "/fas/img/icon/" + x;
        }
        function chicon() {
            document.getElementById("hfimg").value = "";
            document.getElementById("dicon").style.display = "none";
            document.getElementById("licon").style.display = "block";
            

        }
    </script>
<!--
 #notsuccess,#notinfo,#notwarning,#notdanger
 -->
  
</body>

</html>