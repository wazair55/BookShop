
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

            <?php

            if($count_myOrder > 0):

                $myOrderId = $myOrder['order_id'];
                $myOrderItems = mysqli_query($connect, "select * from order_items JOIN books ON order_items.book_id = books.id where order_id='$myOrderId'");

                 $count_order_items = mysqli_num_rows($myOrderItems);

                 if($count_order_items):
           

            ?>

            <div class="col-9">
                <h1>My Cart (<?= $count_order_items;?>)</h1>
                <div class="row">
                    <?php

                    $total_amount =  $total_discount_amount = 0;

                    while($order_item = mysqli_fetch_array($myOrderItems)):

                       $price = $order_item['qty'] * $order_item['price'];
                       $discount_price = $order_item['qty'] * $order_item['discount_price'];
                    ?>
                    <div class="col-12 mb-2">
                        <div class="card">
                           <div class="card-body">
                           <div class="row">
                                <div class="col-2">
                                    <img src="images/<?= $order_item['cover_image'];?>" alt="" class="w-100">
                                </div>
                                <div class="col-10">
                                    <h2 class="h6 text-truncate"><?= $order_item['title'];?></h2>
                                    <h6>
                                        <span class="text-success">₹<?= $order_item['discount_price'];?> </span>
                                    <del class="text-muted small">₹<?= $order_item['price'];?></del>
                                </h6>

                                   <div class="d-flex justify-content-between">
                                   <div class="d-flex">
                                        <a href="cart.php?book_id=<?= $order_item['id'];?>&dfc=true" class="btn btn-danger">-</a>
                                        <span class="btn "><?= $order_item['qty'];?></span>
                                        <a href="cart.php?book_id=<?= $order_item['id'];?>&atc=true" class="btn btn-success">+</a>
                                    </div>
                                    <a href="cart.php?delete_item=<?= $order_item['oi_id'];?>" class="btn btn-dark"><img width="30" height="30" src="https://img.icons8.com/plasticine/100/000000/filled-trash.png" alt="filled-trash"/></a>
                                   </div>
                                </div>
                            </div>
                           </div>
                        </div>
                    </div>
                    
                    <?php 

                       $total_amount += $price;
                       $total_discount_amount += $discount_price;
                
                endwhile;?>
                </div>
            </div>

            <div class="col-3">
                <h2>Price Break</h2>
                <div class="list-group">
                    <span class="list-group-item list-group-item-action d-flex justify-content-between bg-dark text-white">
                        <span>Total Amount</span>
                        <span><?= $total_amount;?>/-</span>
                    </span>
                    <span class="list-group-item list-group-item-action d-flex justify-content-between bg-success text-white">
                        <span>Total Discount</span>
                        <span><?= $amount_before_tax = $total_amount - $total_discount_amount;?>/-</span>
                    </span>
                    <span class="list-group-item list-group-item-action d-flex justify-content-between ">
                        <span>Total TAX (GST)</span>
                        <span><?= $tax = $total_discount_amount * 0.18;?>/-</span>
                    </span>
                   <?php

                   if($myOrder['coupon_id']):

                   ?>
                    <span class="list-group-item list-group-item-action  bg-warning ">
                      <div class="d-flex justify-content-between">
                        <span>Coupon Discount</span>
                        <span><?= $coupon_amount = $myOrder['coupon_amount'];?></span>
                      </div>
                      <div class="bg-white px-2 py-1 rounded text-sm text-center">
                        <small>Coupon applied - <?= $myOrder['coupon_code'];?>
                        <a href="cart.php?remove_coupon=<?= $myOrder['order_id'];?>" class="text-decoration-none text-danger">X</a>

                        </small>

                      </div>
                    </span>
                    <?php endif;?>
                    <span class="list-group-item list-group-item-action d-flex justify-content-between bg-danger text-white ">
                        <h5>Payable Amount</h5>
                        <h5><?php
                          $total_payable_amount = $total_discount_amount + $tax;

                          if($myOrder['coupon_id']){
                            echo $total_payable_amount - $coupon_amount;
                          }
                          else{
                            echo $total_payable_amount;
                          }


                         ?>/-</h5>
                    </span>
                </div>
                <div class="d-flex mt-5 justify-content-between">
                    <a href="" class="btn btn-dark btn-lg">Go back</a>
                    <a href="checkout.php" class="btn btn-primary btn-lg">Checkout</a>
                </div>

                <?php

                   if(!$myOrder['coupon_id']):
                ?>

                <div class="mt-3">
                    <form action="" method="post" class="d-flex mt-5">
                        <input type="text" placeholder="Enter coupen code" name="code" class="form_control">
                        <input type="submit" class="btn btn-dark" name="apply" value="Apply">
                    </form>
                </div>
                <?php endif;?>
            </div>
            <?php endif; else:?>
                <div class="col-12">
                    <div class="card">
                    <div class="card-body">
                    <h2>Sorry your cart is empty...</h2>
                    <a href="index.php" class="btn btn-dark">Shop Now</a>
                    </div>
                    </div>
                </div>

            
            <?php   endif;?>
        </div>
    </div>

     <?php



     if(isset($_GET['book_id']) && isset($_GET['atc'])){

     if(!isset($_SESSION['account'])){
        echo "<script>window.open('login.php','_self')</script>";
     }

    
     $book_id = $_GET['book_id'];

     $user_id = $getUser['user_id'];

     $check_order = mysqli_query($connect, "select * from orders where user_id='$user_id' and is_ordered='0'");
     $count_check_order = mysqli_num_rows($check_order);

     if($count_check_order < 1){
        $create_order = mysqli_query($connect, "insert into orders (user_id) value ('$user_id')");
        $create_order_id = mysqli_insert_id($connect);

        $create_order_item = mysqli_query($connect, "insert into order_items (order_id, book_id) value ('$created_order_id','$book_id')");

        

     }
     else{
        $current_order = mysqli_fetch_array($check_order);
        
        $current_order_id = $current_order['order_id'];

        $check_order_item = mysqli_query($connect, "select * from order_items where order_id='$current_order_id' and book_id='$book_id'");

        $current_order_item = mysqli_fetch_array($check_order_item);
        $count_current_order_item = mysqli_num_rows($check_order_item);

        if($current_order_item > 0){
            $current_order_item_id = $current_order_item['oi_id'];
           // $current_order_id_items_table = $current_order_item['order_id'];
            $query_for_qty_update = mysqli_query($connect, "update order_items set qty=qty+1 where oi_id='$current_order_item_id'");

        }
        else{
            $create_order_item = mysqli_query($connect, "insert into order_items (order_id, book_id) value ('$current_order_id','$book_id')");
        }


    }


    echo "<script>window.open('cart.php','_self')</script>";
 
 
}


if(isset($_GET['book_id']) && isset($_GET['dfc'])){

    if(!isset($_SESSION['account'])){
        echo "<script>window.open('login.php','_self')</script>";
    }

    
    $book_id = $_GET['book_id'];

    $user_id = $getUser['user_id'];

    $check_order = mysqli_query($connect, "select * from orders where user_id='$user_id' and is_ordered='0'");
    $count_check_order = mysqli_num_rows($check_order);

   
        $current_order = mysqli_fetch_array($check_order);
        
        $current_order_id = $current_order['order_id'];

        $check_order_item = mysqli_query($connect, "select * from order_items where order_id='$current_order_id' and book_id='$book_id'");

        $current_order_item = mysqli_fetch_array($check_order_item);
        $count_current_order_item = mysqli_num_rows($check_order_item);

        if($current_order_item > 0){
            $current_order_item_id = $current_order_item['oi_id'];
           // $current_order_id_items_table = $current_order_item['order_id'];

           $qty = $current_order_item['qty'];

             if($qty == 1){

                $delete_query_for_order_item = mysqli_query($connect, "delete from order_items  where oi_id='$current_order_item_id'");

             }
             else{
                $query_for_qty_update = mysqli_query($connect, "update order_items set qty=qty-1 where oi_id='$current_order_item_id'");
             }

            

        }
        
    


    echo "<script>window.open('cart.php','_self')</script>";
}

    //add coupon logic

    if(isset($_POST['apply'])){
        $code = $_POST['code'];

        $callingCoupon = mysqli_query($connect, "select * from coupon where coupon_code='$code'");

        $getCoupon = mysqli_fetch_array($callingCoupon);

        $countCoupon = mysqli_num_rows($callingCoupon);

        if($countCoupon > 0){
            $coupon_id = $getCoupon['c_id'];
            $updateOrder = mysqli_query($connect, "update orders SET coupon_id='$coupon_id' where order_id='$myOrderId'");

            echo "<script>window.open('cart.php','_self')</script>";

        }
        else{
            echo "<script>alert('invalid coupon code')</script>";
        }

       // $amount = $getCoupon['coupon_amount'];
    }


    if(isset($_GET['delete_item'])){
        $item_id = $_GET['delete_item'];

        $queryForDeleteItem = mysqli_query($connect, "delete from order_items where oi_id='$item_id'");

        if($queryForDeleteItem){
            echo "<script>window.open('cart.php','_self')</script>";
        }
        else{
        echo "<script>alert('failed to delete')</script>";
        }
 
    }

    if(isset($_GET['remove_coupon'])){
        $id = $_GET['remove_coupon'];

        $queryForRemoveCoupon = mysqli_query($connect, "update orders SET coupon_id='NULL' where order_id='$id'");

        if($queryForRemoveCoupon){
            echo "<script>window.open('cart.php','_self')</script>";
        }
        else{
        echo "<script>alert('failed to remove coupon')</script>";
        }
 
    }
