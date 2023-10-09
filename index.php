<?php include_once "connect.php";?>
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

    <div class=" text-white w-100" style="height: 400px; background-image:url('https://imgs.search.brave.com/whOgfdvQFedCadKmS8dLdn42D60cIAPeuBWJ2fS9qCk/rs:fit:860:0:0/g:ce/aHR0cHM6Ly93YWxs/cGFwZXJzLmNvbS9p/bWFnZXMvZmVhdHVy/ZWQvcmVhZGluZy1i/b29rLWdxcjMyNTQ3/andlZ2tuem8uanBn');">

    <div class="container d-flex flex-column justify-content-center align-items-center">
        <h1 class="mt-5">Explorer Any Books</h1>
        <form action="index.php" method="get" class="d-flex justify-content-center flex-column gap-4">
            <input type="search" name="search" class="form-control form-control-lg" size="70">
            <input type="submit" class="btn btn-dark btn-lg" name="find">
        </form>
    </div>

    </div>

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
            <div class="row">
                <?php
                if(isset($_GET['find'])){
                    $search = $_GET['search'];
                    $q = mysqli_query($connect,"select * from books JOIN categories ON books.category=categories.cat_id where title LIKE '%$search%'");

                }
               else{
                if(isset($_GET['cat_id'])){
                    $cat_id = $_GET['cat_id'];
                    $q = mysqli_query($connect,"select * from books JOIN categories ON books.category=categories.cat_id where cat_id='$cat_id'");

                }
                else{
                    $q = mysqli_query($connect,"select * from books JOIN categories ON books.category=categories.cat_id");
                }
               
               }

               $count = mysqli_num_rows($q);
               if($count < 1){
                echo "<h1 class='display-3'>NOT Found any Book</h1>";
               }
                while($data = mysqli_fetch_array($q)):
                ?>
                <div class="col-3">
                    <div class="card">
                        <img src="<?= "images/".$data['cover_image'];?>" alt="" class="w-100" style='height:300px;object-fit:cover'>
                        <div class="card-body">
                           <h2 class="h5">Rs.<?= $data['discount_price'];?>/- <del><?= $data['price'];?>/-</del></h2>
                            <h2 class="h6 text-truncate"><?= $data['title'];?></h2>
                            <span class="bg-success text-white badge"><?= $data['cat_title'];?></span>
                            <a href="view_book.php?book_id=<?= $data['id'];?>" class="btn btn-info">View</a>

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