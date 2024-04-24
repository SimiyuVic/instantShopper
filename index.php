<?php
session_start();

//Check if user is logged in
$userLoggedIn = isset($_SESSION['user_id']) || isset($_SESSION['admin_id']);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PerdueApparel | Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" 
    integrity="sha512-mQ93GR66o7D/EVEqUp0BqL45PQa24a6LZQ2Hb4cZ2z0x0vfFSzBvKv0ATs2DSh9efIt2uc5bBO1RoQ1HhehD5g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@700&family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
  </head>
  <style>
    .navbar-nav .nav-link
    {
        color: white !important;
    }
    .navbar-brand
    {
        font-size: 29px;
        font-family: 'caveat', sans-serif;
        color: white !important;

    }
    /* Custom CSS for the hover effect */
    .card:hover 
    {
      transform: scale(1.035);
      transition: transform 0.3s ease-in-out;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
    }
  </style>
  <!-----Navbar starts here----->
  <nav class="navbar navbar-expand-lg  bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#home">PerdueApparel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" style="color: #fff; border-color: #fff;">
            <span class="navbar-toggler-icon mt-2">
                <i class="fa-solid fa-bars fa-lg"></i>
            </span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav my-3 fw-bold">
                    <?php
                     if(!$userLoggedIn)
                     { ?>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="jobs.php">Collection</a>
                        </li>
                        <li class="nav-item">
                             <a class="nav-link" href="login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">Sign Up</a>
                        </li>
                     <?php }
                     else
                     { ?>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#collection">Collection</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="cart.php">Cart</a>
                        </li>
                        <?php
                            if(isset($_SESSION['user_id']))
                            { ?>
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="user-profile.php">Profile</a>
                                </li>
                           <?php }
                           else { ?>
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="Admin/dashboard.php">Profile</a>
                                </li>
                          <?php }
                        ?>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="log-out.php">Log-Out</a>
                        </li>
                     <?php }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
    <!-----Navbar ends here----->
    <section id="home">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="display-4 mt-5">
                        You Need it , We've Got It!
                    </h3>
                    <h4 class="display-5">
                        Your One Stop Online Merchandise Shop
                    </h4>
                    <p class="lead">
                    Welcome to PerdueApparel, your destination for stylish merchandise including caps, 
                    t-shirts, and more! Explore our collection and elevate your wardrobe with quality designs 
                    that speak to your unique style.
                    </p>
                </div>
                <div class="col-md-6">
                    <img src="assets/images/shop.jpg" class="img-fluid" alt="...">
                </div>
            </div>
        </div>
    </section>
    <section id="collection">
        <div class="container mt-4">
            <div>
                <?php
                if (!isset($_SESSION['user_id'])) {
                    ?>
                    <div id="myAlert" class="alert alert-primary" role="alert" style="max-width: 500px;">
                        You have to be logged in as User to make an Order with us !
                    </div>
                    <script>
                        setTimeout(function() {
                            $('#myAlert').fadeOut('slow');
                        }, 5000); // 5000 milliseconds = 3 seconds
                    </script>
                <?php } ?>
            </div>
            <?php
                require_once 'Config/config.php';

                // Step 1: Fetch all categories
                $categoriesQuery = "SELECT * FROM categories";
                $categoriesStmt = $connection->prepare($categoriesQuery);
                $categoriesStmt->execute();
                $categoriesResult = $categoriesStmt->get_result();

                // Step 2: Display products by category
                if ($categoriesResult->num_rows > 0) {
                    while ($category = $categoriesResult->fetch_assoc()) {
                        ?>
                        <h4 class="text-warning my-4"><?php echo $category['category_name']; ?></h4>
                        <div class="row">
                            <?php
                            // Step 3: Retrieve products for the current category
                            $categoryId = $category['category_id'];
                            $productsQuery = "SELECT * FROM products WHERE category_id = ? LIMIT 4";
                            $productsStmt = $connection->prepare($productsQuery);
                            $productsStmt->bind_param("i", $categoryId);
                            $productsStmt->execute();
                            $productsResult = $productsStmt->get_result();

                            // Step 4: Display products under the current category
                            if ($productsResult->num_rows > 0) {
                                while ($product = $productsResult->fetch_assoc()) {
                                    ?>
                                    <div class="col-md-3 mb-3">
                                        <div class="card mb-4 h-80">
                                            <div class="card-body d-flex flex-column text-center">
                                                <h5 class="card-title"><?php echo $product['product_name']; ?></h5>
                                                <img src="uploads/<?php echo $product['product_image']; ?>" alt="Product Image" width="120" height="150" class="mx-auto">
                                                <p class="card-text"><?php echo $product['product_description']; ?></p>
                                                <p class="card-text fw-bold">Price: $ <?php echo $product['product_price']; ?></p>
                                                <?php
                                                    if(isset($_SESSION['user_id']))
                                                    { ?>
                                                        <form action="Process/buy-product.php" method="POST">
                                                            <input type="hidden" name ="product_id" value="<?php echo $product['product_id']; ?>">
                                                            <input type="submit" value="Send Order" name="buy_product" class="btn btn-warning">
                                                        </form>
                                                   <?php }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php }
                            } else {
                                echo "<p>Products Will be Added Soon.</p>";
                            }
                            ?>
                        </div>
                    <?php }
                } else {
                    echo "<p>New Products are yet to be Added..</p>";
                }
            ?>

        </div>
    </section>
     <!----- Footer Section starts here----->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/6fff7c638d.js" crossorigin="anonymous"></script>
    </body>
</html>  
