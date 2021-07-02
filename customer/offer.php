<?php
   session_start();
   include('../connection.php');
   if($_SESSION['customer_login_status']!="loged in" and ! isset($_SESSION['user_id']) )
   header("Location:../index.php");
   
   if(isset($_GET['sign']) and $_GET['sign']=="out") {
	$_SESSION['customer_login_status']="loged out";
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
  <link rel="stylesheet" href="type.css">
<link rel="stylesheet" type="text/css" href="style.css">
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
  .container {
    padding: 80px 120px;
  }
  .person {
    border: 10px solid transparent;
    margin-bottom: 25px;
    width: 80%;
    height: 80%;
    opacity: 0.7;
  }
  .person:hover {
    border-color: #f1f1f1;
  }
  body  {
  background-image: url("../bg.jpg");
  background-color: #cccccc;
}
cls{color: red;}
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-dark">
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
        
        <li class="active"><a href="product.php">All PRODUCT</a></li>
        <li class="active"><a href="offer.php">OFFER</a></li>
        
         
        
      </ul>
      <ul class="nav navbar-nav navbar-right">
      <li><a href="changepass.php"><span class="glyphicon glyphicon-user"></span>Change Password</a></li>
        <li><a href="?sign=out"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<section id="labels">
  <div class="container">
	<div class="row">
        <div class="col-sm-6 col-md-3">
          <div class="dl">
            <div class="brand">
                <h2>
                <li class="active"><a href="usr.php">PLATINUM</a></li>
                </h2>
            </div>
            <div class="discount alizarin">30%
                <div class="type">off</div>
            </div>
            <div class="descr">
                <strong>Mei mucius gloriatur reprimique mollis*.</strong> 
                Ad sonet perfecto antiopam mei, denique molestie ne has. 
            </div>
            <div class="ends">
                <small>* Conditions and restrictions apply.</small>
            </div>
            <div class="coupon midnight-blue">
                <a data-toggle="collapse" href="#code-1" class="open-code">Get a code</a>
                <div id="code-1" class="collapse code">
                <?php 
                $sql = "SELECT * FROM coupon where discount=30";
               
               
$query = mysqli_query($con,$sql);
 while($row = mysqli_fetch_array($query))
{ echo "$row[coupon_code]";
}
 ?>

                 
</div>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-3">
          <div  class="dl">
            <div class="brand">
                <h2>
                <li class="active"><a href="usr.php">DIAMOND</a></li>
                </h2>
            </div>
            <div class="discount emerald">
                20%
                <div class="type">
                    off
                </div>
            </div>
            <div class="descr">
                <strong>
                    Ea per iuvaret ocurreret*. 
                </strong> 
                sit ea detraxit menandri mediocritatem, in mel dicant mentitum. 
            </div>
            <div class="ends">
                <small>
                   * Conditions and restrictions apply.
                </small>
            </div>
            <div class="coupon midnight-blue">
                <a data-toggle="collapse" href="#code-2" class="open-code">Get a code</a>
                <div id="code-2" class="collapse in code">
                <?php 
                $sql = "SELECT * FROM coupon where discount=20";
               
               
$query = mysqli_query($con,$sql);
 while($row = mysqli_fetch_array($query))
{ echo "$row[coupon_code]";
}
 ?>
                </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-3">
          <div  class="dl">
            <div class="brand">
                <h2>
                
                <li class="active"><a href="user.php">GOLD</a></li>

                </h2>
            </div>
            <div class="discount peter-river">
            10%
                <div class="type">
                    off
                </div>
            </div>
            <div class="descr">
                <strong>
                     Solet consul tractatos ei pro*. 
                </strong> 
                Ei mei quot invidunt explicari, placerat percipitur intellegam.
            </div>
            <div class="ends">
                <small>
                   * Conditions and restrictions apply.
                </small>
            </div>
            <div class="coupon midnight-blue">
                <a data-toggle="collapse" href="#code-3" class="open-code">Get a code</a>
                <div id="code-3" class="collapse code">
                <?php 
                $sql = "SELECT * FROM coupon where discount=10";
               
               
$query = mysqli_query($con,$sql);
 while($row = mysqli_fetch_array($query))
{ echo "$row[coupon_code]";
}
 ?>
                </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-3">
          <div  class="dl">
            <div class="brand">
                <h2>
                <li class="active"><a href="uer.php">SILVER</a></li>
                </h2>
            </div>
            <div class="discount amethyst">
                5%
                <div class="type">
                    off
                </div>
            </div>
            <div class="descr">
                <strong>
                    Cu aliquip persius alterum duo*. 
                </strong> 
                Possit equidem disputando usu et, sea invidunt scriptorem in. 
            </div>
            <div class="ends">
                <small>
                   * Conditions and restrictions apply.
                </small>
            </div>
            <div class="coupon midnight-blue">
                <a data-toggle="collapse" href="#code-4" class="open-code">Get a code</a>
                <div id="code-4" class="collapse code">
                <?php 
                $sql = "SELECT * FROM coupon where discount=5";
               
               
$query = mysqli_query($con,$sql);
 while($row = mysqli_fetch_array($query))
{ echo "$row[coupon_code]";
}
 ?>
                </div>
            </div>
          </div>
        </div>
	</div>
  </div>
</section>

</body>
</html>
