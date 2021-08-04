<?php
/* init page */ error_reporting(0);
try{
include("config.php");
 $UID=$_SESSION['user_Id'];
 $dbdis=FALSE;
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
 $sql = "SELECT  rr.id,Role_Name from roleresources rr inner join Role ro ON rr.Role_Id=ro.id INNER join  resources re ON rr.Resoources_Id=re.Id      inner JOIN authorities a ON a.RR_Id=rr.Id where re.Resources_Name='sensor' and a.User_ID=".$_SESSION['user_Id'];
 $result = mysqli_query($db, $sql);
 $count = mysqli_num_rows($result);  
    if ($count > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) { 
          switch($row["Role_Name"]){
              case 'open page':
              $openpage=TRUE;
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
/*  end init page */
/* load page*/
    function  filltable($db){                      
    if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
else
{
 $sql = "SELECT * FROM user";
 $result = mysqli_query($db, $sql);
 $count = mysqli_num_rows($result);  
    if ($count > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
    if($row["Gender"]==1){$g='male';}else{$g='female';} 
    if($row['Img']==""){$img="/FAS/img/user/user.jpg";}else{$img=$row['Img'];}   
        echo "<tr id='".$row["Id"]."' ><td>" . "<input type='radio'  class='btn btn-warning btn-lg btn-block' name='selectedrow' " . "value='".$row["Id"]."'/>". "</td><td>"."<img src='" .$img."' alt='user img' width='50' height='50' >". "</td><td data-value='email' >". $row["email"]. "</td><td data-value='fn' >".  $row["First_Name"]. "</td><td data-value='ln'>" . $row["Last_Name"]. "</td><td data-value='birthday'>" .  $row["Birthday"]. "</td><td data-value='gender'>". $g."</td></tr>";
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
    // ADD User
if(isset($_POST['submit'])){ 
if($_POST['submit']=='Save'){
if(isset($_POST['txtfn'])&&isset($_POST['txtln'])&&isset($_POST['birthday'])&isset($_POST['gender'])&&isset($_POST['txtemail'])){
if($_POST["txtpw1"]==$_POST["txtpw2"]){
     $sql = "INSERT INTO user(First_Name,Last_Name,password,email,Birthday,Gender)
    VALUES('".$_POST["txtfn"]."','".$_POST["txtln"]."','".$_POST["txtpw1"]."','".$_POST["txtemail"]."','".$_POST["birthday"]."','".$_POST["gender"]."')";
if (mysqli_query($db, $sql)) {
     $_SESSION["msg"] ="new user is added";
     $_SESSION["typ"] ='s'; 
} else {
     $_SESSION["msg"] ="err:user not added";
     $_SESSION["typ"] ='w';
}
  }else{
     $_SESSION["msg"] ="password dose not match";
     $_SESSION["typ"] ='w';
  }
    }     /* end add user */ /*delete user*/
      }elseif($_POST['submit']=='delete'){
       $id= $_POST["hf"];
       $sql = "DELETE FROM user WHERE id=$id";

if (mysqli_query($db, $sql)) {
   
     $_SESSION["msg"] ="deleted";
     $_SESSION["typ"] ='s';
    
} else {
     $_SESSION["msg"] ="not deleted";
     $_SESSION["typ"] ='w';
}

      } /* end delete user */ /*edit user*/
      elseif($_POST['submit']=='update'){
           $id= $_POST["hf"];
         if(isset($_POST['txtfn'])&&isset($_POST['txtln'])&&isset($_POST['birthday'])&isset($_POST['gender'])&&isset($_POST['txtemail'])){
     $sql = "UPDATE user SET  First_Name='".$_POST["txtfn"]."',Last_Name='".$_POST["txtln"]."',email='".$_POST["txtemail"]."',Birthday='".$_POST["birthday"]."',Gender='".$_POST["gender"]."' where Id='$id'";

if (mysqli_query($db, $sql)) {
    
      $_SESSION["msg"] ="user information is updated";
      $_SESSION["typ"] ='s';
} else {
      $_SESSION["msg"] ="err:user not update";
      $_SESSION["typ"] ='w';
            }
         } 
      }/*end edit user*/
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

    <title>users</title>

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
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="login.php"><i class="fa fa-sign-out fa-fw"></i> Logout
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
                            <a href="tables.html"><i class="fa fa-table fa-fw"></i>Profile</a>
                        </li>
                       
                        <li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i>Facility Structure<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="Unite.php">Unite</a>
                                </li>
                                <li>
                                    <a href="Device.php">Device</a>
                                </li>
                                <li>
                                    <a href="Port.php">Port</a>
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
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
   
        <div id="page-wrapper">
            <form  method="post">
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
                    <h1 class="page-header">Users</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
               
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Users Information
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table style="width: 100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                         
                                        <th>User</th>
                                         <th>image</th>
                                        <th>email</th>
                                        <th>First Name</th>
                                        <th>Last name</th>
                                        <th>Birth Day</th>
                                        <th>Gender</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
  <?php     
    if($dbdis){filltable($db);}
  ?> 
                                
                         
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                            <div class="well">
<!--add row -->
                                  <input type="button" id="btnmodel" class="btn btn-primary" value="new user" data-toggle="modal" data-target="#myModal">    
                                  <input type="button" disabled id="edt" class="btn btn-warning" alt="Edit"  value="Edit"  data-toggle="modal" data-target="#myModal"/>
                                  <input type="button" disabled id="dlt" class="btn btn-danger" alt="delete" name="" value="delete"/>
                                     <!-- Modal -->
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
                                                 <label >First Name:</label><input class="form-control "  type="text" id="txtfn" name="txtfn"  placeholder="First name" />
                                                 <label >Last Name:</label><input class="form-control"  type="text" id="txtln" name="txtln" placeholder="Last name" />
                                                 <label id="lbpw1" >password:</label><input class="form-control" type="password" id="txtpw1" name="txtpw1" placeholder="Last name" />
                                                 <label id="lbpw2" >repeat password:</label><input class="form-control" id="txtpw2" type="password" name="txtpw2" placeholder="Last name" />
                                                 <label class="col-4">Email:</label><input class="form-control " id="txtemail" type="email" name="txtemail" placeholder="First name" />                                              
                                                 <label >Birth day:</label><input class="form-control col-8" type="date" id="birthday" name="birthday" placeholder="Birth Day" />
                                                 <label >Gender</label>
                                                 <select class="form-control "  name="gender">
                                                 <option value="1" id="om">Male</option>
                                                 <option value="0" id="of">Female</option>
                                                 </select>    
                                                  </div>
                                          
                                        </div>

                                        <div class="modal-footer">
                                          <!-- <button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>--> 
                                           <input type="reset" class="btn btn-default" data-dismiss="modal" value="Close"/> 
                                           <input type="reset" class="btn btn-warning" data-dismiss="" value="reset"/>
                                           <input type="submit" class="btn btn-primary" id="msv" alt="Save" name="submit" data-dismiss="" value="Save"/>
                                           <input type="submit" class="btn btn-primary" id="med" alt="edit" name="submit" data-dismiss="" value="update"/>
      
                                           <!-- <button type="button" class="btn btn-primary">Save changes</button>-->
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->

                                </div>
                                <!-- /.modal-dialog -->
                                    
                            </div>
                            <!-- /.modal -->
                               
 <?php

?>
                             

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
              $("#txtpw1").show();$("#lbpw1").show();
              $("#txtpw2").show();$("#lbpw2").show();
          });
   $("#edt").click(function () {
                 $("#txtpw1").hide();$("#lbpw1").hide();
                 $("#txtpw2").hide();$("#lbpw2").hide();
                 $("#msv").hide();
                 $("#med").show();
                 x = $("#hf").val();
                 $("table #" + x + "> td[data-value]").each(function(){
                 switch($(this).data("value")){
                 case 'fn':
                 $("#txtfn").val($(this).text()); break;
                 case 'ln':
                 $("#txtln").val($(this).text()); break;
                 case 'email':
                 $("#txtemail").val($(this).text()); break;
                 case 'birthday':
                 $("#birthday").val($(this).text()); break;
                 case 'gender':
                 if($(this).text()=='male'){ 
        $("option[value=1]").attr('selected','selected');
        $("option[value=0]").removeAttr('selected');
        }else{ 
        $("option[value=0]").attr('selected','selected');
        $("option[value=1]").removeAttr('selected');
        }
                 break;
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
<!--
 #notsuccess,#notinfo,#notwarning,#notdanger
 -->
  
</body>

</html>