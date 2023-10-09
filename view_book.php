<?php 
include_once "connect.php";



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
     <?php include_once "header.php"; ?>
    <div class="container mt-5">
       <div class="row">
          <div class="col-3">
            <div class="list-group">
                <a href="" class="list-group-item list-green-item-action active">Categories</a>
                <?php
                $q = mysqli_query($connect, "select * from categories");
                while($row = mysqli_fetch_array($q)):
                ?>
                <a href="index.php?cat_id=<?= $row['cat_id'];?>" class="list-group-item list-green-item-action">
                    <?= $row['cat_title'];?>
                </a>
                <?php endwhile; ?>
            </div>
          </div>
          <div class="col-9">
           
                <?php

                    $book_id = $_GET['book_id'];
                    $q = mysqli_query($connect,"select * from books JOIN categories ON books.category=categories.cat_id where id='$book_id'");
                    
                    $data = mysqli_fetch_array($q);
                ?>
            <div class="row">
                <div class="col-3">
                    <div class="card">
                        <img src="<?= "images/".$data['cover_image'];?>" alt="" class="w-100" style='height:300px;object-fit:cover'>
                        
                    </div>
                </div>
                <div class="col-9">
                    <table class="table">
                         <tr>
                            <th>Title</th>
                            <td><?= $data['title'];?></td>
                         </tr>
                         <tr>
                            <th>Category</th>
                            <td><?= $data['cat_title'];?></td>
                         </tr>
                         <tr>
                            <th>No_of_page</th>
                            <td><?= $data['no_of_page'];?></td>
                         </tr>
                         <tr>
                            <th>Author</th>
                            <td><?= $data['author'];?></td>
                         </tr>
                         <tr>
                            <th>Isbn</th>
                            <td><?= $data['isbn'];?></td>
                         </tr>
                         <tr>
                            <th>Price</th>
                            <th class="d-flex align-items-center gap-2">
                                <h2 class="text-danger h1">₹<?= $data['discount_price'];?></h2>
                                <del><h3 class="text-secondary h6">₹<?= $data['price'];?></h3></del>
                            </th>
                         </tr>
                    </table>
                    <div class="d-flex gap-2">
                        <a href="" class="btn btn-success btn-lg">Buy Now</a>
                        <a href="cart.php?book_id=<?= $data['id'];?>&atc=true" class="btn btn-warning btn-lg">Add to cart</a>
                    </div>
                </div>
                
            
            
            
            </div>

            <div class="row mt-5">
                <div class="card">
                    <div class="card-header">
                        <h5>Description</h5>
                    </div>
                    <div class="card-body">
                        <p><?= $data['description'];?></p>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h2 class="my-4">Related Book</h2>
                </div>
            <?php
              
                    $q = mysqli_query($connect,"select * from books JOIN categories ON books.category=categories.cat_id where id <> '$book_id'");
                
               
               

               $count = mysqli_num_rows($q);
               if($count < 1){
                echo "<h1 class='display-3'>NOT Found any Book</h1>";
               }
                while($data = mysqli_fetch_array($q)):
                ?>
                <div class="col-2">
                    <div class="card">
                        <img src="<?= "images/".$data['cover_image'];?>" alt="" class="w-100" style='height:150px;object-fit:cover'>
                        <div class="card-body">
                           
                            <h2 class="h6 text-truncate"><?= $data['title'];?></h2>
                            
                            <a href="view_book.php?book_id=<?= $data['id'];?>" class="btn btn-info btn-sm">View</a>

                        </div>
                    </div>
                </div>
                <?php endwhile;?>

            </div>
          

          </div>
       </div>
    </div>
</body>
</html>

