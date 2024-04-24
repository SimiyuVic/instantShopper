<?php
    session_start();

    // Check if the form is submitted and the delete button is clicked
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
        // Handle the delete action
        // Include your database connection file
        require_once 'Config/config.php';

        // Retrieve the order ID to delete
        $order_id = $_POST['order_id'];

        // Prepare the SQL statement to delete the order
        $query = "DELETE FROM orders WHERE order_id = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("i", $order_id);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to the same page after deleting the order
            header("Location: {$_SERVER['PHP_SELF']}");
            exit();
        } else {
            // Handle error
            echo "Error deleting order: " . $connection->error;
        }

        // Close statement and connection
        $stmt->close();
        $connection->close();
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-mQ93GR66o7D/EVEqUp0BqL45PQa24a6LZQ2Hb4cZ2z0x0vfFSzBvKv0ATs2DSh9efIt2uc5bBO1RoQ1HhehD5g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@700&family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <style>
        .navbar-nav .nav-link {
            color: white !important;
        }

        .navbar-brand {
            font-size: 29px;
            font-family: 'caveat', sans-serif;
            color: white !important;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">PerdueApparel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" style="color: #fff; border-color: #fff;">
                <span class="navbar-toggler-icon mt-2">
                    <i class="fa-solid fa-bars fa-lg"></i>
                </span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav my-3 fw-bold">
                    <li>
                        <a class="nav-link active" aria-current="page" href="log-out.php">Log-Out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->

    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row">
            <!-- User Profile Card -->
            <?php
            require_once 'Config/config.php';

            $sql = "SELECT firstname, lastname, email, phone_number FROM users WHERE user_id = ?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("i", $_SESSION['user_id']);
            $stmt->execute();
            $result = $stmt->get_result();

            if (!$result) {
                die("Error executing the query: " . mysqli_error($connection));
            } else {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>This is what we have on you !</h5>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="text-center">Edit your Profile</h5>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-body bg-light">
                                    <h5><i class="fa-solid fa-user fa-lg me-3 my-3"></i><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></h5>
                                    <h5><i class="fa-solid fa-envelope fa-lg me-3 my-3"></i><?php echo $row['email']; ?></h5>
                                    <h5><i class="fa-solid fa-phone fa-lg me-3 my-3"></i><?php echo $row['phone_number']; ?></h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card-body">
                                    <form action="Process/update-user.php" method="POST">
                                        <div class="form-floating mb-3">
                                            <input type="text" name="firstname" class="form-control" placeholder="First Name" value="<?php echo $row['firstname']; ?>" required>
                                            <label for="floatingInput">First Name</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" name="lastname" class="form-control" placeholder="Last Name" value="<?php echo $row['lastname']; ?>" required>
                                            <label for="floatingInput">Last Name</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $row['email']; ?>" readonly>
                                            <label for="floatingInput">Email</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" name="phone_number" class="form-control" placeholder="Phone Number" value="<?php echo $row['phone_number']; ?>" required>
                                            <label for="floatingInput">Phone Number</label>
                                        </div>
                                        <input type="submit" value="Edit Profile" name="update" class="btn btn-warning">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
            <!-- End User Profile Card -->
        </div>

        <!-- Orders Section -->
        <div class="row mt-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="text-center">Your Orders</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Product</th>
                                <th scope="col">Image</th>
                                <th scope="col">Price</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT o.*, p.product_name, p.product_image, p.product_price
                                FROM orders o 
                                INNER JOIN products p ON o.product_id = p.product_id 
                                WHERE o.user_id = ?";
                            $stmt = $connection->prepare($query);
                            $stmt->bind_param("i", $_SESSION['user_id']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <th scope="row"><i class="fa-solid fa-chevron-right fa-lg"></i></th>
                                        <td>
                                            <?php echo $row['product_name']; ?>
                                        </td>
                                        <td>
                                            <img src="uploads/<?php echo $row['product_image']; ?>" alt="Product Image" width="100" height="100">
                                        </td>
                                        <td class="fw-bold">
                                            $. <?php echo $row['product_price']; ?>
                                        </td>
                                        <td>
                                            <form action="" method="POST">
                                                <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                                                <input type="submit" name="delete" value="Delete" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this order?')">
                                            </form>
                                        </td>
                                    </tr>
                                <?php }
                            } else {
                                // No orders found
                                echo '<tr><td colspan="4">No Orders found.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- End Orders Section -->
    </div>
    <!-- End Main Content -->

    <!-- JavaScript libraries and scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
