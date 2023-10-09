
<?php include_once "connect.php";

if(isset($_SESSION['accounts'])){
    echo "<script>window.open('login.php','self')</script>";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookshop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include_once "header.php"; 
    
     $user_id = $getUser['user_id'];
     
     $order = mysqli_query($connect, "select * from orders LEFT JOIN coupon ON orders.coupon_id = coupon.c_id where user_id='$user_id' and is_ordered='0'");
     
     $myOrder = mysqli_fetch_array($order);
     
     $count_myOrder = mysqli_num_rows($order);
     
    
    ?>

    <div class="container p-5">
        <div class="row">
            <div class="col-7 mx-auto">
                <div class="card bg-success text-white">
                    <div class="card-body">
                    <h1>WOW! Order Placed SuccessFully</h1>
                    <p>Click here to see  <a href="my_order.php" class="text-light">My Order</a> Page to Know More Details</p>

                    <div class="d-flex justify-content-end">
                        <a href="my_order.php" class="btn btn-light">My Orders</a>
                    </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

   