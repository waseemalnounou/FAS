﻿<?php 
   session_start();
   session_destroy();
   include("config.php");
   session_unset(); 
   function Redirect($url, $permanent = false)
{
    if (headers_sent() === false)
    {
        header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }

    exit();
}
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
    
      $myusername = mysqli_real_escape_string($db,$_POST['txtemail']);
      $mypassword = mysqli_real_escape_string($db,$_POST['txtpassword']); 
      
      $sql = "SELECT Id FROM user WHERE email = '$myusername' and password = '$mypassword'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $count = mysqli_num_rows($result);
      
      // If result matched $myusername and $mypassword, table row must be 1 row
		
      if($count == 1) {       
         $_SESSION['user_Id'] = $row["Id"];
      if(!empty($_POST['remember'])){
      setcookie("FAS",$row["Id"], time() + (86400 * 30), "/");
      }
         Redirect('index.php', false);
      }else {
           echo "<script type='text/javascript'>alert('no');</script>";
         $error = "Your Login Name or Password is invalid";
      }
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

    <title>Login</title>
  
    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

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
    <style>
        #row{background:inherit; background-size:cover; background-repeat:no-repeat;}
     
        #form {
            background: #5a497382;
        }
        
    </style>
</head>

<body style="background-image:url('/FAS/img/bgimg/12.jpeg');">

    <div class="container">
        <div id="row" class="row">
            <div class="col-md-4 col-md-offset-4">
                <div id="form" class="login-panel panel panel-default">
                    <div style="background: #9acd3282;" class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <form action="#" method ="post" role="form">
                            <fieldset>
                                <div class="form-group" >
                                    <input class="form-control" placeholder="E-mail" name="txtemail" required="required" type="email" value="" autofocus />
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="password" required="required" name="txtpassword" value="" type="password"  />
                                </div>
                                <div class="checkbox"  style="color:white;">
                                    <label>
                                        <input name="remember" type="checkbox"  value="Remember Me" />Remember Me
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" value="Login"  class="btn btn-lg btn-success btn-block" />
                               
                          <!--      <a class="btn btn-lg btn-info btn-sm btn-block">options</a>-->                           </fieldset>
                        </form>                                           
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
