<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");

  include("config.php");
  $display=FALSE;
 // include("csokit.php");
  error_reporting(0);
     function Redirect($url, $permanent = false)
{
    if (headers_sent() === false)
    {
        header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }

    exit();
}
   if(!isset($_SESSION['user_Id'])){
       if(!isset($_COOKIE['FAS']))
       { Redirect('login.php', false);}
       else {$_SESSION['user_Id']=$_COOKIE['FAS'];
       $UID=$_SESSION['user_Id'];}
   }else{
          $UID=$_SESSION['user_Id'];
   }
    global $uniteinfo;
     if($UID==NULL || $UID==''){
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
      }else {
         /* if user not exist*/
      }
   }
   function authorities($db)
   {                    
    if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
else
{   
 $sql = "SELECT  rr.id,Role_Name from roleresources rr inner join Role ro ON rr.Role_Id=ro.id INNER join  resources re ON rr.Resoources_Id=re.Id      inner JOIN authorities a ON a.RR_Id=rr.Id where re.Resources_Name='DASHBOARD' and a.User_ID=".$_SESSION['user_Id'];
 $result = mysqli_query($db, $sql);
 $count = mysqli_num_rows($result);  
    if ($count > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) { 
          switch($row["Role_Name"]){
              case 'delete data':
              break;
              case 'insert data':
              break;
              case 'open page':
              $openpage=TRUE;
              break;
              case 'update data':
              break;
              case 'display data':
              $GLOBALS["display"]=TRUE;
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
      function  initunite($db){                      
    if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
else
{   
 $i=array('0'=>"unite");
 $sql = "SELECT Id,Name FROM unite";
 $result = mysqli_query($db, $sql);
 $count = mysqli_num_rows($result);  
    if ($count > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $inner='';
        $inner =array($row['Id']=>$row['Name']);
        $i= $i+$inner;           
    }
    $GLOBALS['uniteinfo']=$i;
  }
else
{
    echo "0 results";
    }
  }
}
if($display)initunite($db);
function  initmessenger($db){                      
    if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
else
{
 $sql = "SELECT Id,First_Name,Last_Name,Img from user where Id!=". $GLOBALS['UID'];
 $result = mysqli_query($db, $sql);
 $count = mysqli_num_rows($result);  
    if ($count > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
    if($row['Img']==""){$img="/FAS/img/user/user.jpg";}else{$img=$row['Img'];} 
    echo  " <li><button id='".$row["Id"]."' onclick='"."openchat(".$row["Id"].",".$GLOBALS['UID'].")'"." class='btn btn-outline btn-primary btn-sm btn-block'> <img  src='$img' class='msimg' width='30' height='30' alt='user'/>".$row["First_Name"]." ".$row["Last_Name"].  "</button></li>";
    }
  }
else
{
    echo "0 results";
    }
  }
}
function initchat($UID,$RID)
{
    if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
else
{
    if($UID<>NULL&&$RID<>NULL){
 $sql = "SELECT * from message where H_ID=(select ID from head_ms where First_User=". $GLOBALS['UID']."and Second_User='$RID'";
 $result = mysqli_query($db, $sql);
 $count = mysqli_num_rows($result);  
    if ($count > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
    if($row['Img']==""){$img="/FAS/img/user/user.jpg";}else{$img=$row['Img'];} 
    echo  " <li><button id='".$row["Id"]."' class='btn btn-outline btn-primary btn-sm btn-block'> <img  src='$img' class='msimg' width='30' height='30' alt='user'/>".$row["First_Name"]." ".$row["Last_Name"].  "</button></li>";
    }
    }else{  echo "no messages founded";}
 }
else
{
    echo "no user founded";
    }
  }    

}
function initunitelist($db)
{ $initlist=array();
  $initlist= $GLOBALS['uniteinfo'] ;
  foreach($initlist as $Id => $Name ){
         if($Id==0){continue;}
       
 $sql = "SELECT COUNT(*) as c from Device where Unite_Id=$Id";
 $result = mysqli_query($db, $sql);
 $count = mysqli_num_rows($result); 
 if($count==1) {
    while($row = mysqli_fetch_assoc($result)) {
$DC=$row['c'];
   
   echo  " <a href='#' id='".$Id."' class='list-group-item'><i class='fa fa-windows fa-fw'></i> ".$Name."  <span class='pull-right text-muted small'><em>$DC Device</em></span></a>";     
    }  
  }
}
}
function initdevicelist($db)
{
  $sql = "SELECT * from Device";
 $result = mysqli_query($db, $sql);
 $count = mysqli_num_rows($result);  
    if ($count > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
    echo  "<input  type='button' onclick=append('".$row['Name']."')"." class='form-control' id='".$row["Unite_Id"]."' value='".$row["Name"]."' />"; 
    }
    }else{  echo "no messages founded";}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>home</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        pre { overflow: hidden;
              border: none;
              color: #fff;  
              font-size: 15px;
              width: 100%;
        }
       
   #humd > pre{
        background: inherit;
        }
        #tmpr >pre{
           background: inherit;
        }
       #Chat {
    right: 10%;
    bottom: 0px;
    position: fixed;
    width: 300px;
    height: auto;
    margin-bottom: 0px;
        }
        .userimg {
            border-radius: 50%;
            margin-top:0px ;
            margin-bottom:0px;
                margin-right:25px;
                margin-left: 25px;   
            border:#808080 soild 2px;
        }
         .msimg {
            border-radius: 50%;
            margin-top:0px ;
            margin-bottom:0px;
                margin-right:10px;
                margin-left: 0px;  
                padding-left:0px; 
                padding-right:0px; 
            border:#337ab7 solid 1px;
            
        }
        .cp{
            display: none;
        }
        .chat-container {
            overflow-y: auto;
        }
        svg{
            width: 250px;
            height: 250px;
  display: block;
  margin: auto;
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

            <ul   class="nav navbar-top-links navbar-right">
                <li  class="dropdown">
                    <a onclick="showmsg(<?php echo $_SESSION['user_Id']; ?>,1)" class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul  id="msglistul" style="overflow:auto;height:500px;" class="dropdown-menu dropdown-messages">
               
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
                <!-- /.dropdown -->
          
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-comment fa-fw"></i> New Comment
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> Message Sent
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-tasks fa-fw"></i> New Task
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
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
                        <li><a href="logout.php" onclick="delete_cookie('FAS');"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
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
                            <a href="#"><i class="fa glyphicon-envelope fa-fw"></i>messenger<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                            <?php
/*
initMessenger
*/

initmessenger($db);
?>
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
            <!-- <form action="#" method="post">-->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                   
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                     <img src="\FAS\img\icon\015-snowflake.png" width="100" height="100" alt="humidity sensor" >
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge" id="humd"></div>
                                    <div>humidity</div>
                                </div>
                            </div>
                        </div>
                        <a >
                            <div class="panel-footer" onclick="getH()">
                                <span class="pull-left">Refresh</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                   <img src="\FAS\img\icon\thermometer.png" width="100" height="100" alt="thermometer" >
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge" id="tmpr"></div>
                                    <div>temperature</div>
                                </div>
                            </div>
                        </div>
                        <a>
                            <div class="panel-footer" onclick="getT()">
                                <span class="pull-left">Refresh</span>
                                <span class="pull-right">
                                    <i class="fa fa-arrow-circle-right"></i>
                                </span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                   
                               <img src="\FAS\img\icon\057-leak.png" width="100" height="100" alt="gas sensor" >
                               
                                   
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge" id="gas">0</div>
                                    <div>gas sensor</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">Refresh</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                     <img src="\FAS\img\icon\056-sensor.png" width="100" height="100" alt="fier sensor" >
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge" id="fier" >0</div>
                                    <div>fier sensor</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">Refresh</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div id="divcontent" class="col-lg-8">
                <?php 
if($display){
$i=& $GLOBALS['uniteinfo'];
echo "<div class='panel panel-default' ><div class='panel-heading'><h4>control panel</h4></div><div class='panel-body'><div id='controlpanel'>";
 echo "<p>plases chose a unte from unite list >></p>";
 foreach($i as $x => $x_value) {
    if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
    
}
else
{   
    if($x=='0'){continue;}
 $sql = "SELECT Img,d.Name,d.Description,GPIO_Number,GPIO_Number,address,Type from device d inner join GPIO p ON d.GPIO_id=p.Id inner join raspberry r ON p.raspberry_id=r.Id where status!=0 and Unite_Id=". $x;
 $result = mysqli_query($db, $sql);
 $count = mysqli_num_rows($result);
    if ($count > 0) {
        
    // output data of each row
     echo "<div class='panel panel-default cp' id='".$x."'><div class='panel-heading'><h4>".$x_value."</h4></div><div class='panel-body'><div>";
    while($row = mysqli_fetch_assoc($result)) {
         $range= "<lable id='outrange'></Lable>%<input type='range' class='form-control-range' id='myRange' value='0' min='0' max='100'  name='".$row["GPIO_Number"]."'  /> <br>";  
         $btn="<input type='button' onclick=onoff('".$row["address"]."','1','".$row["GPIO_Number"]."')"." class='btn btn-outline btn-primary btn-sm btn-block' id='".$row["GPIO_Number"]."' value='ON'  name='".$row["GPIO_Number"]."' /> <br>";
         $btn2="<input type='button' onclick=onoff('".$row["address"]."','0','".$row["GPIO_Number"]."')"." class='btn btn-outline btn-primary btn-sm btn-block' id='".$row["GPIO_Number"]."' value='OFF'  name='".$row["GPIO_Number"]."' /> <br>";

         if($row['Type']==2){$inpt=$range;}else{$inpt=$btn."</br>".$btn2;}
        if($result<>NULL)
   { echo  "  <fieldset class=''><legend><img src='".$row["Img"]."' width='25' height='25' alrt='device img' />"."  ".$row["Name"].":"."   ".$row["Description"]."</legend>".$inpt."</fieldset>";     }                           
    }echo "</div></div></div>";
  }
else
{
    echo "<div class='panel panel-default cp' id='".$x."'><div class='panel-heading'><h4>".$x_value."</h4></div><div class='panel-body'><div>";
    echo "<fieldset class=''><legend>No Device added to ".$x_value."</legend>";
    echo "  <a class='btn btn-outline btn-primary btn-sm btn-block' herf='Device.php'>add Device</a></fieldset>";
    echo "</div></div></div>";
    }
    
  }
 }
 echo "</div></div></div>";
} 
 ?>
                
                </div>
                <!-- /.col-lg-8 -->
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-th fa-fw"></i> Unites
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="ULI" class="list-group">
                               <?php
/*fell the unite*/
if($display)
 initunitelist($db);
?>
                                
                            </div>
                            <!-- /.list-group -->
                            <a href="#" id="allunite" class="btn btn-default btn-block">Click All unites</a>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                
           
                    <div id="Chat" style="display:none" class=" chat-panel panel panel-default">
                        <div id="ch" class="panel-heading">
                            <i class="fa fa-comments fa-fw"></i> Chat
                            <div class="btn-group pull-right">
                                <button id="chatclose" type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div id="cb" style="">
                        <div id="msgbodysc"  class="panel-body chat-container">
                            <div id="msgcontent"  class="chat">
                               <?php 
                      if($display)
                           initdevicelist($db);
                           
                              ?>
                                <input type="button" class="form-control" value="can you please turn on" onclick="append('can you please turn on')"/>
                                 <input type="button" class="form-control" value="can you please turn off" onclick="append('can you please turn off')"/>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-footer">
                            <div class="input-group">
                                <input id="btn-input" type="text" class="form-control input-sm" style="" autocomplete="off"  placeholder="Type your message here..." />
                                <span class="input-group-btn">
                                    <input type="button" value="send" id="btn-chat" onclick="sendmsg()" class="btn btn-warning btn-sm"/>
                                </span>
                            </div>
                        </div>
                        <!-- /.panel-footer -->
                        </div>
                    </div>
                    <!-- /.panel .chat-panel -->
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
                 <input type="hidden" id="hfu" name="hfu" value="" />
                 <!-- </form>--> 
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
        $(document).ready(function () {
            $("#btn-chat").click(function () {
                  $("#btn-input").val('');
            });
            $("#btn-input").keyup(function (event) {
                if (event.keyCode == 13) {
                    $("#btn-chat").click();
                  
                }
            });

            $("#chatclose").click(function () {
                $("#Chat").css("display", "none");

            });
            $("#ch").click(function () {
                $("#cb").slideToggle("slow");
            });
            i = $("#ULI > a").click(function () {
                $("#controlpanel>p").hide();
                $("#controlpanel > #" + $(this).attr('id')).slideToggle(2000);
            });

            $("#allunite").click(function () {
                $("#controlpanel>p").hide();
                $("#controlpanel > div").slideToggle(3000);
            });
        });
        var slider = document.getElementById("myRange");
        var output = document.getElementById("outrange");
        output.innerHTML = slider.value; // Display the default slider value

        // Update the current slider value (each time you drag the slider handle)
        slider.oninput = function () {
            output.innerHTML = this.value;
        } 

</script>
    <script>
     
        S = ''; T = '';
        messages = document.getElementById('msgbodysc');
        function showmsg(s, t) {

            m = document.getElementById("msglistul");
            if (s == null) {
                alert(2);
                return;
            }

            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else { // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    m.innerHTML = this.responseText;
                }
            }
            xmlhttp.open("GET", "showmsg.php?s=" + s + "&c=" + t, true);
            xmlhttp.send();
        }
        function getT() {
        m = document.getElementById("tmpr");
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
                } else { // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    m.innerHTML = this.responseText;
                }
            }
            xmlhttp.open("GET", "http://192.168.1.102/HT.php?s=1", true);
            xmlhttp.send();
        }
                    
                 function getH() {
        m = document.getElementById("humd");
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
                } else { // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    m.innerHTML = this.responseText;
                }
            }
            xmlhttp.open("GET", "http://192.168.1.100/HT.php?s=2", true);
            xmlhttp.send();
        }
        function sendmsg() {
            if (S != '' && T != '') {
                x = document.getElementById("btn-input");
                if (x.value == "") {
                    return;
                }

                if (window.XMLHttpRequest) {

                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else { // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }

                xmlhttp.open("GET", "sendmsg.php?m=" + x.value + "&s=" + S + "&t=" + T, true);
                xmlhttp.send();

            }
        }
       
       
        function onoff(Adress, Action, GPIO) {
            if (Adress != '' && GPIO != '' && Action != '') {
                if (window.XMLHttpRequest) {

                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else { // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.open("GET", "http://" + Adress + "/on.php?a=" + Action + "&g=" + GPIO, true);
                xmlhttp.send();

            }
            else { return; }
        }
        /*    function openchat2(str, S) {
        if (str == "" & S == "") {

        document.getElementById("msgcontent").innerHTML = "";
        return;
        }
        if (isclose) { return; }
        if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
        } else { // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
        document.getElementById("msgcontent").innerHTML = this.responseText;
        }
        }
        xmlhttp.open("GET", "test2.php?q=" + str + "&r=" + S, true);
        xmlhttp.send();

        shouldScroll = messages.scrollTop + messages.clientHeight === messages.scrollHeight;
        if (!shouldScroll) {
        scrollToBottom();
        }
        if (!isclose) {

        // setInterval(openchat2(str, S), 6000);
        }
        }




        function scrollToBottom() {
        messages.scrollTop = messages.scrollHeight;
        }

        */
        function openchat(t, s) {    //catch the id of sender and reciver
            var chatbox = document.getElementById("Chat");
            chatbox.style.display = 'block';
            this.S = s;
            this.T = t;
        }
        function sleep(milliseconds) {
            var start = new Date().getTime();
            for (var i = 0; i < 1e7; i++) {
                if ((new Date().getTime() - start) > milliseconds) {
                    break;
                }
            }
        }
        function append(x) {
            var m = document.getElementById("btn-input");
            m.value = m.value + " " + x;
        }
        var delete_cookie = function (name) {
            document.cookie = name + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
        };
     
</script>
</body>

</html>
