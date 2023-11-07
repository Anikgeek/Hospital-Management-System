<?php
session_start();
error_reporting(0);
include("include/config.php");
if(isset($_POST['login']))
{
$uname=$_POST['username'];
$upassword=$_POST['password'];

$ret=mysqli_query($con,"SELECT * FROM admin WHERE username='$uname' and password='$upassword'");
$num=mysqli_fetch_array($ret);
if($num>0)
{
$_SESSION['login']=$_POST['username'];
$_SESSION['id']=$num['id'];
header("location:dashboard.php");

}
else
{
$_SESSION['errmsg']="Invalid username or password";

}
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login | Hospital Management System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="../../assets/css/login.css">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <div class="container">
    <input type="checkbox" id="check">
    <div class="login form">
      <header>Admin Login</header>
      <form action="#" method="POST">
	  <span style="color:red;"><?php echo htmlentities($_SESSION['errmsg']); ?><?php echo htmlentities($_SESSION['errmsg']="");?></span>
        <input type="text" placeholder="Enter your email" name="username" required>
        <input type="password" placeholder="Enter your password" name="password" required>
        <input type="submit" class="button" value="Login" name="login">
      </form>
    </div>
    </div>
  </div>
</body>
</html>

