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
<link rel="stylesheet" type="text/css" href="../table.css">
<style>
body  {
  background-image: url("../2.jpg");
  background-color: #cccccc;
}
</style>
</head>
<body>

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
      <li><a href="changepass.php"><span class="glyphicon glyphicon-user"></span>Change Password</a></li>
        <li><a href="?sign=out"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
      </ul>
    </div>
  </div>
</nav>


<div class="row">

  <div class="container">
  
  <div class="row">
    <form action="store.php" method="post">
	<input type="submit" value="Show Product" name="show">
	</form>
	<?php
 include("../connection.php");
 if(isset($_POST['show']))
 {
 $sql="select * from product";
 $r=mysqli_query($con,$sql);
 echo "<table id='customers'>";
 echo "<tr>
 <th>Product ID</th>
 <th>Product Name</th>
 <th>Product Type</th>
 <th>Brand Name</th>
 <th>Buying Price</th>
  </tr>";
    while($row=mysqli_fetch_array($r))
    {
        $id=$row['p_id'];
		$pname=$row['pname'];
		$type=$row['ptype'];
		$brand=$row['brandname'];
		$price=$row['bprice'];
    echo "<tr>
    <td>$id</td><td>$pname</td><td>$type</td><td>$brand</td><td>$price</td>
    </tr>";
    }
	echo "</table>";
 }
?>
  </div>
  <form action="store.php" method="post">
  <div class="row">
  <hr/>
  <h2 align='center'>Store New Product Information</h2>
    <div class="col-25">
      <label for="name">Product ID</label>
    </div>
    <div class="col-75">
	<select name="pid">
<?php
 include("../connection.php");
 $sql="select p_id from product";
 $r=mysqli_query($con,$sql);
 
 
    while($row=mysqli_fetch_array($r))
    {
        $id=$row['p_id'];
        echo "<option value='$id'>$id</option>";
    }
 
 
 
?>
</select>
    </div>
  </div>
  
  
  <div class="row">
    <div class="col-25">
      <label for="quantity">Quantity</label>
    </div>
    <div class="col-75">
      <input type="text" id="quantity" name="quantity" placeholder="quantity..">
	  </div>
  </div>
  
  <div class="row">
    <div class="col-25">
      <label for="sprice">Selling Price</label>
    </div>
    <div class="col-75">
      <input type="text" id="sprice" name="sprice" placeholder="Selling Price..">
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
	$quantity=$_POST['quantity'];
	$sprice=$_POST['sprice'];
	
	$query="insert into store values('$pid',$sprice,$quantity)";
	if(mysqli_query($con,$query))
	{
		echo "Successfully inserted!";
    }
	else
	{
		echo "error!".mysqli_error($con);
	}
}
?>