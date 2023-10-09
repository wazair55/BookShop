<nav class="navbar navbar-expand-lg navbar-dark bg-success">
  <div class="container d-flex justify-content-between">
            <a class="navbar-brand" href="index.php">Bookshop</a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                 <span class="navbar-toggler-icon"></span>
              </button>

             
             

             
             
             
            <div class="collapse navbar-collapse" id="navbarNav">
            <form action="index.php" class="d-flex">
                <input type="search" name="search" class="form-control " placeholder="Enter any book title">
                <input type="submit" name="find" class="btn btn-danger" value="search">
              </form>
            <ul class="navbar-nav ms-auto">
            
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <?php
                if(isset($_SESSION['account'])):
                  $email =$_SESSION['account'];
                  $getUser = mysqli_query($connect, "select * from account where email='$email'");

                  $getUser = mysqli_fetch_array($getUser);

                ?>
                 <li class="nav-item active">
                    <a class="nav-link text-capitalize text-white" href="my_order.php"><?= $getUser['name'];?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cart.php">Cart</a>
                </li>
                <li class="nav-item">
                    <a class="mt-1 me-2 btn btn-danger" href="logout.php">Logout</a>
                </li>
                <?php else: ?>
                  <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Create an Account</a>
                </li>
                <?php endif;?>
        
                </ul>
            </div>
           
          </div>
        </nav>