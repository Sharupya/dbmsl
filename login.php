<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="signup.css">
<link rel="stylesheet" type="text/css" href="style.css">
<style>
body  {
  background-image: url("bg.jpg");
  background-color: #cccccc;
}
</style>
</head>
<body>

<div class="header">
  <h1>Login Form</h1>
  <p>No Account? Please <a href="signup.php"> Signup</a></p> 
</div>

<div class="row">
  <div class="container">
  <form action="login.php" method="post">
  <div class="row">
    <div class="col-25">
      <label for="userid">User ID</label>
    </div>
    <div class="col-75">
      <input type="text" id="uid" name="id" placeholder="User ID...">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="password">Password</label>
    </div>
    <div class="col-75">
      <input type="password" id="pass" name="pass" placeholder="Password">
    </div>
  </div>
  <div class="row">
    <input type="submit" value="Signin" name="login">
  </div>
  </form>
</div>
</div>



</body>
</html>

<?php
include("connection.php");
if(isset($_POST['login']))
{
	$id=$_POST['id'];
	$pass=$_POST['pass'];

	$sql="select userid,password from admin where userid='$id' and password='$pass'";
  $sql1="select cus_id,password from  customer where cus_id='$id' and password='$pass'";
            $r=mysqli_query($con,$sql);
            $r1=mysqli_query($con,$sql1);
            if(mysqli_num_rows($r)>0)
            {
                $_SESSION['user_id']=$id;
                $_SESSION['admin_login_status']="loged in";
                header("Location:admin/home.php");
            }
            
            else if(mysqli_num_rows($r1)>0)
            {
              $single = mysqli_fetch_assoc($r1);
                $_SESSION['cus_id']=$single['cus_id'];
                $_SESSION['customer_login_status']="loged in";
                header("Location:customer/home.php");
            }
            else
            {
                echo "<p style='color: red;'>Incorrect UserId or Password</p>";
            }
	
}
?>