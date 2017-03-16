<?php
 session_start();
 include('includes/configdb.php');
 if(isset($_SESSION['error']))
{
	echo '<p>'.$_SESSION['error']['Email'].'</p>';
	echo '<p>'.$_SESSION['error']['UserPassword'].'</p>';
	unset($_SESSION['error']);
}
 if(isset($_POST['submit']))
 {
 //whether the username is blank
 if($_POST['UserPassword'] == '')
 {
  $_SESSION['error']['UserPassword'] = "Password is required.";
 }
 else
 {
 if (strlen($_POST['UserPassword']) > 7)
   {
   //if it has the correct format whether the email has already exist
   $user4= $_POST['UserPassword'];
   $sql4 = "SELECT * FROM Users WHERE UserPassword = '$user4'";
   $result4 = mysqli_query($mysqli,$sql4) or die(mysqli_error());
   if (mysqli_num_rows($result4) < 1)
            {
    $_SESSION['error']['UserPassword'] = "Invalid Password";
   }
  }
  else
  {
  $_SESSION['error']['UserPassword'] = "Password must be 8 characters long";
 	}
 }
  
 //whether the email is blank
 if($_POST['Email'] == '')
 {
  $_SESSION['error']['Email'] = "E-mail is required.";
 }
 else
 {
  //whether the email format is correct
  if(preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9._-]+)+$/", $_POST['Email']))
  {
   //if it has the correct format whether the email has already exist
   $email1= $_POST['Email'];
   $sql1 = "SELECT * FROM Users WHERE Email = '$email1'";
   $result1 = mysqli_query($mysqli,$sql1) or die(mysqli_error());
   if (mysqli_num_rows($result1) < 1)
            {
    $_SESSION['error']['Email'] = "Invalid Email Address.";
   }
  }
  else
  {
   //this error will set if the email format is not correct
   $_SESSION['error']['Email'] = "Your email is not valid.";
  }
 }
 
 if(isset($_SESSION['error']))
 {
  header("Location: login.php");
  exit;
 }
 else
 {
  $Email = trim($_POST['Email']);
  $UserPassword = trim($_POST['UserPassword']);
  $query = "SELECT * FROM Users WHERE Email='$Email' AND UserPassword='$UserPassword' AND UserStatus='' AND com_code IS NULL";
  $result = mysqli_query($mysqli,$query)or die(mysqli_error());
  $num_row = mysqli_num_rows($result);
  $row=mysqli_fetch_array($result);
  if( $num_row ==1 )
         {
   $_SESSION['user_name']=$row['Username'];
   echo '<script type="text/javascript">window.location.href="member.php";</script>';
        die();
   exit;
  }
  else
         {
   echo "You must verify account before use or use admin page to login...redirecting to registration form.";
   echo "<script>setTimeout(\"window.location.href = 'index.php';\",1500);</script>";
        die();
  }
 }}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Login</title>
  <!-- jQuery -->
  <script
  src="http://code.jquery.com/jquery-3.1.1.min.js"
  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
  crossorigin="anonymous"></script>

  <!-- Bootstrap -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

  <!-- Bootstrap Validator -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.js"></script>
  <script src="http://1000hz.github.io/bootstrap-validator/dist/validator.min.js"></script>

  <link rel="stylesheet" type="text/css" href="CSS/styles.css">
</head>
<body>
    
 <div class="container">

 <form data-toggle="validator" role="form" class="form-signin" form action="login.php" method="post">
	 <legend> Pyxis Recognition Login </legend>

  <div class="form-group has-feedback">

    <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
      <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" class="form-control" name="Email" id="Email" placeholder="Email" data-error="Email address is invalid" required>
    </div>
    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
    <div class="help-block with-errors"></div>
  </div>

  <div class="form-group has-feedback">
 
    <div class="input-group">
    <span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span>
      <input type="password" class="form-control" name="UserPassword" id="UserPassword" placeholder="Password" data-minlength="8" data-error="Minimum of 8 characters" required>
    </div>
    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
    <div class="help-block with-errors"></div>
  </div>


  <div class="form-group">
    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
  </div>
</form>
</div> 




<div class="container">
	<h4 class="form-signin"><a href="recover.php">Recover Password</a></h4>
</div>


    <p><a class="pos_fixed" href="index.php"><span class="glyphicon glyphicon-pencil"></span> Register</a>
    <p><a class="pos_fixedleft" href="adminlogin.php"><span class="glyphicon glyphicon-briefcase"></span> Admin</a>

</body>

</html>






