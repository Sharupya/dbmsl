<?php
   session_start();
   include ('../connection.php');
   if($_SESSION['customer_login_status']!="loged in" and ! isset($_SESSION['user_id']) )
    header("Location:../index.php");
   
   if(isset($_GET['sign']) and $_GET['sign']=="out") {
	$_SESSION['customer_login_status']="loged out";
	unset($_SESSION['user_id']);
   header("Location:../index.php");    
   }
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
		


	</head>
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
        <li class="active"><a href="home.php">Home</a></li>
        
        <li class="active"><a href="product.php">All Product</a></li>
        
        
         
        
      </ul>
      <ul class="nav navbar-nav navbar-right">
      <li><a href="product.php.php"><span class="btn btn-bg-danger"></span>Back</a></li>
        <li><a href="?sign=out"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
<body>

	<div class="col-md-3"></div>
	<div class="col-md-6 well">
		
		
		
		<br />
		
		<?php
			require '../connection.php';
			$query = mysqli_query($con, "SELECT * FROM `product` WHERE `p_id` = '$_REQUEST[p_id]'");
			$fetch = mysqli_fetch_array($query);
		?>
		<div class="col-md-2"></div>
		<div class="col-md-8">
		<form method='post'>
			<img src="../uploadedimage/<?php echo $fetch['image']?>" width="100%" height="300px"/>
			<center><h3><?php echo $fetch['pname']?></h3></center>
			<center><h4><strong>Price:</strong><?php echo number_format($fetch['bprice'])?></h4></center>
			<div class="form-group">
				<h4 class="text-warning">*Optional</h4>
				<label>Coupon Code</label>
				<input class="form-control" type="text" id="coupon"/>
				<input type="hidden" name="price" value="<?php echo $fetch['bprice']?>" id="price"/>
				<br style="clear:both;"/>
				<button class="btn btn-primary" id="activate">Activate Code</button>
				<br style="clear:both;"/>
				<label>Quantity</label>
				<input class="form-control" type="number" name="qty"/>
				<div id="result"></div>
			</div>
			<div class="form-group">
				<label>Total Price</label>
				<input class="form-control" type="number" value="<?php echo $fetch['bprice']?>" id="total" readonly="readonly" lang="en-150"/>
			</div>
			
			<div>

<div class="row">
    <input type="submit" value="Submit your Order" name="corder">
</div>
</form>
<?php
// Save the orders in database
if(isset($_POST['corder']))
{
	
	$num=rand(10,1000);
	$order_id="O-".$num;
	$order_date=date("Y-m-d");
	$cus_id=$_SESSION['cus_id'];
	$qty = $_POST['qty'];
	$total = $_POST['qty']*$_POST['price'];
	$sqlorder="insert into customer_order values('$order_id','$cus_id','$_REQUEST[p_id]', '$qty','$total','$order_date',0)";
	mysqli_query($con,$sqlorder);
	// foreach ($_SESSION['cart'] as $keys => $values)
	// {
	// 	$total=0;
	// 	$pid=$values['item_id'];
	// 	$quantity=$values['item_q'];
	// 	$total=$values['item_q']*$values['item_price'];
	// 	$sql="insert into orderline values('$order_id','$p_id','$quantity',$total)";
	//     mysqli_query($con,$sql);
	// }
	echo "your order has been submited successfully";
	unset($_SESSION['cart']);
}
?>	
</div>
			</div>
		</div>
	</div>
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/bootstrap.js"></script>
<script>
	$(document).ready(function(){
		$('#activate').on('click', function(){
			var coupon = $('#coupon').val();
			var price = $('#price').val();
			if(coupon == ""){
				alert("Please enter a coupon code!");
			}else{
				$.post('get_discount.php', {coupon: coupon, price: price}, function(data){
					if(data == "error"){
						alert("Invalid Coupon Code!");
						$('#total').val(price);
						$('#result').html('');
					}else{
						var json = JSON.parse(data);
						$('#result').html("<h4 class='pull-right text-danger'>"+json.discount+"% Off</h4>");
						$('#total').val(json.price);
					}
				});
			}
		});
	});
</script>


</body>
<div class="Reviews">
        
            <h5>Customer Reviews</h5>
                <div class="review mb-4 bg-dark text-light p-3 rounded">
                <?php
                    if(isset($_POST['submitRev'])){
                        if($login==true){
                            $star=$_POST['rating'];
                            $review=($_POST['reviewText']);
                            $date= date("Y-m-d");
                            mysqli_query($con,"insert into reviews(`user_id`,`rating`,`reviewDetails`,`date`,`p_id`) values($user_id,$star,'$review','$date',$p_id)") or die(mysqli_error($con));
                            echo "<script>window.open(window.location.href,'_self')</script>";
                        }else{
                            echo "<script>alert('Please login to Review');</script>";
                        }
                    }
                ?>
                <form method="POST">
                    <div class="form-group">
                        <label for="review">Write a Review:</label>
                        <textarea class="form-control bg-light" rows="5" id="comment" maxlength="200" name="reviewText" placeholder="Write a review (max length 200 characters.)" required></textarea>
                    </div>
                    <div class="down d-flex justify-content-between align-items-bottom">
                    <div class="form-group">
                            <label for="star-rating">Rate the product:</label>

                            <div id="stars-existing" class="starrr text-warning" data-rating='4'></div>  
                            <script src="js/star-rating.js"></script>
                            <input type="number" value="4" id="rating" name="rating" style="display:none;">
                            
                    </div>
                    <button type="submit" name="submitRev" class="btn btn-warning p-2">Submit Review</button>
                    </div>
                    
                </form>
                
                </div>

                
                <h5>Reviews <small class="text-secondary"><?php echo $qp['reviewsNo'];?> Reviews</small></h5>
                <?php
                    $qu=mysqli_query($con,"SELECT b.*, a.name FROM reviews AS b INNER JOIN customer as a ON (b.user_id=a.id) where b.p_id=$p_id order by id desc limit 5") or die(mysqli_error($con));
                    while($qp=mysqli_fetch_assoc($qu)){

                ?>
                <div class="review mb-2">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between"><b><?php echo $qp['name'];?></b>
                            <span class="stars">
                            <?php 
                                for($i=1;$i<=5;$i++){
                            ?>
                                <li class="fa fa-star<?php if($i>$qp['rating']) echo '-o';?>"></li>
                                <?php } ?>
                            </span>
                            <small class="text-muted"><?php echo $qp['date'];?></small>
                        </div>
                        <div class="card-body"><?php echo $qp['reviewDetails'];?></div>
                    </div>
                </div>
                    <?php } ?>
                
                <br>
                <a href="moreReviews.php"> More Reviews</a>


        </div>
        <div class="overall-rating mt-4">
            <h5>Overall Rating of Product</h5>
            <div class="card bg-dark">
                <div class="card-body text-center">
                    <span class="stars text-warning">
                            <?php 
                                for($i=1;$i<=5;$i++){
                            ?>
                                <li class="fa fa-star<?php if($i>(round($q['rating']))) echo '-o';?>"></li>
                                <?php } ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
     </div>
</section>
</div>
</html>