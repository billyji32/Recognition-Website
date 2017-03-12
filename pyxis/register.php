<?php
session_start();
include 'includes/configdb-procedural.php';
if(isset($_POST['submit']))
{
 //whether the username is blank
 if($_POST['Username'] == '')
 {
  $_SESSION['error']['Username'] = "User Name is required.";
 }
 else if (strlen($_POST['Username']) < 4)
 {
  $_SESSION['error']['Username'] = "User Name must be at least 4 characters.";
 }
 
  //whether the firstname is blank
 if($_POST['Username'] == '')
 {
  $_SESSION['error']['FName'] = "User Name is required.";
 }
 else if (strlen($_POST['FName']) < 4)
 {
  $_SESSION['error']['FName'] = "User Name must be at least 4 characters.";
 }
 
  //whether the lastname is blank
 if($_POST['Username'] == '')
 {
  $_SESSION['error']['LName'] = "User Name is required.";
 }
 else if (strlen($_POST['LName']) < 4)
 {
  $_SESSION['error']['LName'] = "User Name must be at least 4 characters.";
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
   $email= $_POST['Email'];
   $sql1 = "SELECT * FROM Users WHERE Email = '$Email'";
   $result1 = mysqli_query($mysqli,$sql1) or die(mysqli_error());
   if (mysqli_num_rows($result1) > 0)
            {
    $_SESSION['error']['Email'] = "This Email is already used.";
   }
  }
  else
  {
   //this error will set if the email format is not correct
   $_SESSION['error']['Email'] = "Your email is not valid.";
  }
 }
 //whether the password is blank
 if($_POST['UserPassword'] == '')
 {
  $_SESSION['error']['UserPassword'] = "Password is required.";
 }
 else if(strlen($_POST['UserPassword']) < 8)
 {
  $_SESSION['error']['UserPassword'] = "Password must be at least 8 characters.";
 }
 
 if(isset($_SESSION['error']))
 {
  header("Location: index.php");
  exit;
 }
 else
 {
  $Username = trim(strtolower($_POST['Username']));
  $FName = trim(strtolower($_POST['FName']));
  $LName = trim(strtolower($_POST['LName']));
  $Email = trim(strtolower($_POST['Email']));
  $UserPassword = trim($_POST['UserPassword']);
  $com_code = md5(uniqid(rand()));

  $sql2 = "INSERT INTO Users (Username, FName, LName, Email, UserPassword, com_code) VALUES ('$Username', '$FName', '$LName', '$Email', '$UserPassword', '$com_code')";
  $result2 = mysqli_query($mysqli,$sql2) or die(mysqli_error());

  if($result2)
  {
   $to = $email;
   $subject = "Confirmation from Pyxis Recogntion $Username";
   $header = "Pyxis Group: Confirmation from Pyxis Recognition";
   $message = "Please click the link below to verify and activate your account. ";
   $message .= "http://web.engr.oregonstate.edu/~channa/pyxis/confirm.php?passkey=$com_code";

   $sentmail = mail($to,$subject,$message,$header);

   if($sentmail)
            {
   echo "Your Confirmation link Has Been Sent To Your Email Address...redirecting to login.";
   echo '<script type="text/javascript">window.location.href="login.php";</script>';
        die();
   }
   else
         {
    echo "Cannot send Confirmation link to your e-mail address";
   }
  }
 }
}
?>