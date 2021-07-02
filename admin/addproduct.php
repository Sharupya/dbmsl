<?php
   session_start();
   if($_SESSION['admin_login_status']!="loged in" and ! isset($_SESSION['user_id']) )
    header("Location:../index.php");
   
   if(isset($_GET['sign']) and $_GET['sign']=="out") {
	$_SESSION['admin_login_status']="loged out";
	unset($_SESSION['user_id']);
   header("Location:../index.php");    
   }
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="index.css">
<link rel="stylesheet" type="text/css" href="../signup.css">
<link rel="stylesheet" type="text/css" href="../style.css">

</head>
<body>

<style>
 body  {

  background-color: #404040;

}
</style>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="../index.php">PHOTO ZONE</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="../index.php">Home</a></li>
        
        <li class="active"><a href="addproduct.php">ADD PRODUCT</a></li>
        <li class="active"><a href="store.php">STORE</a></li>
         
        <li><a href="corder.php">customer order</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
      <li class="btn btn-primary btn-block"><a href="changepass.php"><span class="glyphicon glyphicon-user"></span>Change Password</a></li>
        <li class="btn btn-danger btn-block"><a href="?sign=out"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
      </ul>
    </div>
  </div>
</nav>


</div>

<div  class="row">

<h2 class="text-center text-light"> Add New Product </h2>
  <div class="container">
  <form action="addproduct.php" method="post" enctype="multipart/form-data">
  <div class="row">
    <div class="col-25">
      <label for="name">Product ID</label>
    </div>
    <div class="col-75">
      <input type="text" id="pid" name="pid" placeholder="product id..">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="email">Product Name</label>
    </div>
    <div class="col-75">
      <input type="text" id="pname" name="pname" placeholder="product name..">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="country">Product Type</label>
    </div>
    <div class="col-75">
      <select id="ptype" name="ptype">
        <option value="urban">urban</option>
        <option value="street">Street</option>
        <option value="wildlife">wildlife</option>
      </select>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="bname">Brand Name</label>
    </div>
    <div class="col-75">
      <input type="text" id="bname" name="bname" placeholder="Brand name..">
	  </div>
  </div>
  
  <div class="row">
    <div class="col-25">
      <label for="bprice">Buying Price</label>
    </div>
    <div class="col-75">
      <input type="text" id="bprice" name="bprice" placeholder="Buying Price..">
    </div>
  </div>
  
  <div class="row">
    <div class="col-25">
      <label for="image">Product Image</label>
    </div>
    <div class="col-75">
      <input type="file" id="image" name="pic">
	  </div>
  </div>
  
  <div class="row">
    <input type="submit" value="Add" name="submit">
  </div>
  </form>
</div>
</div>



</body>
</html>

<?php
include("../connection.php");
if(isset($_POST['submit']))
{
	$pid=$_POST['pid'];
	$pname=$_POST['pname'];
	$ptype=$_POST['ptype'];
	$bname=$_POST['bname'];
	$bprice=$_POST['bprice'];
	
	//image upload code
	$ext= explode(".",$_FILES['pic']['name']);
    $c=count($ext);
    $ext=$ext[$c-1];
    $date=date("D:M:Y");
    $time=date("h:i:s");
    $image_name=md5($date.$time.$pid);
    $image=$image_name.".".$ext;
	 
	
	
	$query="insert into product values('$pid','$pname','$ptype','$bname',$bprice,'$image')";
	if(mysqli_query($con,$query))
	{
		echo "Successfully inserted!";
		if($image !=null){
	                move_uploaded_file($_FILES['pic']['tmp_name'],"../uploadedimage/$image");
                    }
    }
	else
	{
		echo "error!".mysqli_error($con);
	}
}
?>