<?php
   session_start();
   // Cart implementation code
   if(isset($_POST['add']))
   {
	   if(isset($_SESSION['cart']))  
	   {
		 $item_array_id=array_column($_SESSION['cart'],'item_id'); 
 		 if(!in_array($_GET['id'],$item_array_id))
		 {
			 $count=count($_SESSION['cart']);
			 $item_array= array ( 
		   'item_id' => $_GET['id'],
		   'item_name' => $_POST['hname'],
		   'item_price' => $_POST['hprice'],
		   'item_q' => $_POST['quantity']
		   );
			$_SESSION['cart'][$count]=$item_array; 
		 }
		 else
		 {
			 echo "<script>alert('Item already added')</script>";
			 echo "<script>window.location='product.php'</script>";
		 }
	   }	
       else
	   {
		   $item_array= array ( 
		   'item_id' => $_GET['id'],
		   'item_name' => $_POST['hname'],
		   'item_price' => $_POST['hprice'],
		   'item_q' => $_POST['quantity']
		   );
		   $_SESSION['cart'][0]=$item_array;
	   }		   
   }
   // Item Remove from cart
   if(isset($_GET['action']) and $_GET['action'] == 'delete')
   {
	  foreach ($_SESSION['cart'] as $keys => $values)
	  {
		  if($values['item_id'] == $_GET['id'])
		  {
			  unset($_SESSION['cart'][$keys]);
		  }
	  }		  
   }
   
   
   
   
   // Logout code
   if($_SESSION['customer_login_status']!="loged in" and ! isset($_SESSION['user_id']) )
    header("Location:../index.php");
   
   if(isset($_GET['sign']) and $_GET['sign']=="out") {
	$_SESSION['customer_login_status']="loged out";
	unset($_SESSION['user_id']);
	unset($_SESSION['cart']);
   header("Location:../index.php");    
   }
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="signup.css">
<link rel="stylesheet" type="text/css" href="style.css">
<link rel="stylesheet" type="text/css" href="table.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<style>
 body  {
  background-image: url("background.jpg");
  background-color: #cccccc;
}
</style>
</head>
<body>
<div class="container">

<div class="topnav">
  <div class="topnav">
  <a href="home.php">Home</a>
  <a href="product.php">All Products</a>
  <a href="changepass.php" style="float:right">Change Password</a>
  <a href="?sign=out" style="float:right">Logout</a>
</div>
</div>

<div class="row">

  <div class="container">

  <form action="product.php" method="post">
  <div class="row">
    <div class="col-25">
    </div>
    <div class="col-75">
	<label for="catg">Select a Category</label>
	<select name="catg">
<?php
 include("../connection.php");
 $sql="select distinct ptype from product";
 $r=mysqli_query($con,$sql);
 
 
    while($row=mysqli_fetch_array($r))
    {
        $type=$row['ptype'];
        echo "<option value='$type'>$type</option>";
    }
?>
</select>
  </div>
  </div> 
  <div class="row">
    <input type="submit" value="GO" name="go">
  </div>
  </form>
</div>
<div>

<?php
include("../connection.php");
if(isset($_POST['go']))
{
	$c=$_POST['catg'];
	
	$query="select * from product,store where product.p_id=store.p_id and product.ptype='$c'";
	$r=mysqli_query($con,$query);
	echo "<table id='customers'>";
 echo "<tr>
 <th>Product Name</th>
 <th>Product Type</th>
 <th>Brand Name</th>
 <th>Product Price</th>
 <th>Product Image</th>
 <th>Add quantity</th>
 <th>Action</th>
  </tr>";
    while($row=mysqli_fetch_array($r))
    {
		$pid=$row['p_id'];
        $image=$row['image'];
		$pname=$row['pname'];
		$type=$row['ptype'];
		$brand=$row['brandname'];
		$price=$row['sellingPrice'];
	echo "<form action='product.php?action=add&id=$pid' method='post'>";	
    echo "<tr>
    <td>$pname</td><td>$type</td><td>$brand</td><td>$price</td>
	<td><img src='../uploadedimage/$image' height='50px' width='50px'></td>
    <td><input type='text' value='1' name='quantity'>
	<input type='hidden' value='$pname' name='hname'>
	<input type='hidden' value='$price' name='hprice'>
	</td>
	<td><input type='submit' value='Add to cart' name='add'></td>
	</tr>";
	echo "</form>";
    }
	echo "</table>";
}
?>
</div>
<div>
<h3>Order Details</h3>
<table id='customers'>
<tr>
 <th>Product Name</th>
 <th>quantity</th>
 <th>Product Price</th>
 <th>Total</th>
 <th>Action</th>
</tr>
<?php
if(!empty($_SESSION['cart']))
{
	$total=0;
	foreach ($_SESSION['cart'] as $keys => $values)
	{
		echo "<tr>";
?>		
		<td><?php echo $values['item_name']; ?></td>		
		<td><?php echo$values['item_q']; ?></td>
		<td><?php echo$values['item_price']; ?></td>
		<td><?php echo number_format($values['item_q']*$values['item_price'],2); ?></td>
		<td><a href='product.php?action=delete&id=<?php echo $values['item_id']; ?>'>Remove</a></td>
	    </tr>
<?php		
		$total=$total+($values['item_q']*$values['item_price']);
	}
	echo "<tr>";
	echo "<td colspan='3' align='right'>Total</td>";
?>	
	<td><?php echo number_format($total,2); ?></td>
	<td></td>
<?php	
}
?>
</table>
<div>
<form action='product.php' method='post'>
<div class="row">
    <input type="submit" value="Submit your Order" name="corder">
</div>
</form>
<?php
// Save the orders in database
if(isset($_POST['corder']))
{
	include("../connection.php");
	$num=rand(10,1000);
	$order_id="O-".$num;
	$order_date=date("Y-m-d");
	$cid=$_SESSION['user_id'];
	$sqlorder="insert into customer_order values('$order_id','$cid','$order_date',0)";
	mysqli_query($con,$sqlorder);
	foreach ($_SESSION['cart'] as $keys => $values)
	{
		$total=0;
		$pid=$values['item_id'];
		$quantity=$values['item_q'];
		$total=$values['item_q']*$values['item_price'];
		$sql="insert into orderline values('$order_id','$pid','$quantity',$total)";
	    mysqli_query($con,$sql);
	}
	echo "your order has been submited successfully";
	unset($_SESSION['cart']);
}
?>	
</div>
</div>
<div class="row">
	
	
		<?php
			require '../connection.php';
			
			$query = mysqli_query($con, "SELECT * FROM `product`");
			while($fetch = mysqli_fetch_array($query)){ ?>
			<div class="card" style="width: 18rem;">
				<img class="card-img-top" width="150px" height="150px" src="../uploadedimage/<?php echo $fetch['image']?>" alt="Card image cap">
				<div class="card-body">
					<h5 class="card-title"><?php echo $fetch['pname']?></h5>
					<p class="card-text">Price : <strong> <?php echo number_format($fetch['bprice'])?></strong></p>
					<a href="purchase.php?p_id=<?php echo $fetch['p_id']?>" class="btn btn-warning"><span class="glyphicon glyphicon-shopping-cart"></span> Purchase</a>
				</div>
			</div>
			<?php } ?>
			
	
	<div class="modal fade" id="form_coupon" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<form action="save_coupon.php" method="POST">
				<div class="modal-content">
					<div class="modal-body">
						<div class="col-md-2"></div>
						<div class="col-md-8">
							<div class="form-group">
								<label>Coupon Code</label>
								<input type="text" class="form-control" name="coupon" id="coupon" readonly="readonly" required="required"/>
								<br />
								<button id="generate" class="btn btn-success" type="button"><span class="glyphicon glyphicon-random"></span> Generate</button>
							</div>
							<div class="form-group">
								<label>Discount</label>
								<input type="number" class="form-control" name="discount" min="10" required="required"/>
							</div>
						</div>
					</div>
					<div style="clear:both;"></div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
						<button name="save" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Save</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="modal fade" id="form_product" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<form action="save_product.php" method="POST" enctype="multipart/form-data">
				<div class="modal-content">
					<div class="modal-body">
						<div class="col-md-2"></div>
						<div class="col-md-8">
							<div class="form-group">
								<label>Product Name</label>
								<input type="text" class="form-control" name="p_name" required="required"/>
							</div>
							<div class="form-group">
								<label>Product Price</label>
								<input type="number" class="form-control" name="bprice" min="0" required="required"/>
							</div>
							<div class="form-group">
								<label>Product Image</label>
								<input type="file" class="form-control" name="image" required="required"/>
							</div>
						</div>
					</div>
					<div style="clear:both;"></div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
						<button name="save" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Save</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/bootstrap.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#generate').on('click', function(){
			$.get("get_coupon.php", function(data){
				$('#coupon').val(data);
			});
		});
	});
</script>
</body>
</html>
 

