<?php
session_start();
error_reporting(0);
include("include/config.php");
if(isset($_POST['login']))
{
$puname=$_POST['username'];	
$ppwd=md5($_POST['password']);
$ret=mysqli_query($con,"SELECT * FROM users WHERE email='$puname' and password='$ppwd'");
$num=mysqli_fetch_array($ret);
if($num>0)
{
	
$_SESSION['login']=$_POST['username'];
$_SESSION['id']=$num['id'];
$pid=$num['id'];
$host=$_SERVER['HTTP_HOST'];
$uip=$_SERVER['REMOTE_ADDR'];
$status=1;
// For stroing log if user login successfull
$log=mysqli_query($con,"insert into userlog(uid,username,userip,status) values('$pid','$puname','$uip','$status')");
header("location:dashboard.php");
}
else
{
	
// For stroing log if user login unsuccessfull
$_SESSION['login']=$_POST['username'];	
$uip=$_SERVER['REMOTE_ADDR'];
$status=0;
mysqli_query($con,"insert into userlog(username,userip,status) values('$puname','$uip','$status')");
$_SESSION['errmsg']="Invalid username or password";


}
}


if(isset($_POST['signup']))
{
$fname=$_POST['full_name'];
$address=$_POST['address'];
$city=$_POST['city'];
$gender=$_POST['gender'];
$email=$_POST['email'];
$password=md5($_POST['password']);
$query=mysqli_query($con,"insert into users(fullname,address,city,gender,email,password) values('$fname','$address','$city','$gender','$email','$password')");
if($query)
{
	echo "<script>alert('Successfully Registered. You can login now');</script>";
	//header('location:user-login.php');
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
  <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <div class="container">
    <input type="checkbox" id="check">
    <div class="login form">
      <header>User Login</header>
      <form action="#" method="POST">
	  <span style="color:red;"><?php echo $_SESSION['errmsg']; ?><?php echo $_SESSION['errmsg']="";?></span>
        <input type="text" placeholder="Enter your email" name="username">
        <input type="password" placeholder="Enter your password" name="password">
        <a href="forgot-password.php">Forgot password?</a>
        <input type="submit" class="button" value="Login" name="login">
      </form>
      <div class="signup">
        <span class="signup">Don't have an account?
         <label for="check">Signup</label>
        </span>
      </div>
    </div>
    <div class="registration form">
      <header>Signup</header>
      <form action="#" method="POST">
	  <input type="text" placeholder="Enter your Full Name" name="full_name" required>
	  <input type="text" placeholder="Enter your Address" name="address" required>
	  <input type="text" placeholder="Enter your City Name" name="city" required>
        <input type="text" placeholder="Enter your email" name="email" onBlur="userAvailability()" required>
        <span id="user-availability-status1" style="font-size:12px;"></span>
        <input type="password" placeholder="Create a password" name="password" required>
        <input type="password" placeholder="Confirm your password" name="password_again" required>
		<div class="row">		
		<div class="col-6">	
		<p class="text-muted">Gender</p>
		<select class="form-select form-select-lg mb-3 text-muted" aria-label=".form-select-lg example" name="gender" required>
  <option selected>Select</option>
  <option value="male">Male</option>
  <option value="female">Female</option>
  <option value="other">Other</option>
</select>
</div>

</div>

		

								
        <input type="submit" class="button" value="Signup" name="signup">
      </form>
      <div class="signup">
        <span class="signup">Already have an account?
         <label for="check">Login</label>
        </span>
      </div>
    </div>
  </div>
  <script src="vendor/jquery/jquery.min.js"></script>
	<script>
function userAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'email='+$("#email").val(),
type: "POST",
success:function(data){
$("#user-availability-status1").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>	

</body>
</html>

	
