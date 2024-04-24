<?php include 'header.php'; ?>
<div class="container my-4">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <?php
                        //Getting the current hour
                            $currentHour = date('G');
                        //Greeting based on time of the day.
                        if($currentHour >= 5 && $currentHour < 12)
                        {
                            $greeting = "Good Morning";
                        }
                        else if($currentHour >=12 && $currentHour < 17)
                        {
                            $greeting = "Good Afternoon";
                        }
                        else 
                        {
                            $greeting = "Good Evening";
                        }
                        ?>
                        <h5><?php echo $greeting . ', <i>' . $_SESSION['username'] . '</i>'; ?></h5>
                </div>
                <?php include 'side-bar.html'; ?>
            </div>
        </div>
        <div class="div.col-12 col-md-9">
            <div class="card">
                <div class="card-header">
                    <h5 class="text-center">
                        This is how you have been Fairing 
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-6 mb-3">
                            <div class="card shadow">
                                <div class="card-body">
                                    <h5>Registered Users</h5>
                                    <div class="row">
                                        <div class="col-6">
                                            <h5 class="text-primary">
                                                <i class="fa-solid fa-users fa-lg"></i>
                                            </h5>
                                        </div>
                                        <div class="col-6 text-center">
                                            <h3>
                                                <?php
                                                    @require_once '../Config/config.php';
                                                    $stmt = $connection->prepare("SELECT COUNT(*) as total_users FROM users");
                                                    $stmt->execute();
                                                    $result = $stmt->get_result();
                                                    if($result->num_rows > 0)
                                                    {
                                                        $row = $result->fetch_assoc();
                                                        $totalUsers = $row['total_users'];
                                                        echo $totalUsers;
                                                    } 
                                                    else 
                                                    {
                                                        echo "No Users found";
                                                    }
                                                ?>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card shadow">
                                <div class="card-body">
                                    <h5>Products</h5>
                                    <div class="row">
                                        <div class="col-6">
                                            <h5 class="text-primary">
                                                <i class="fas fa-layer-group fa-xl"></i>
                                            </h5>
                                        </div>
                                        <div class="col-6 text-center">
                                            <h3>
                                                <?php
                                                    @require_once '../Config/config.php';
                                                    $stmt = $connection->prepare("SELECT COUNT(*) as total_orders FROM orders");
                                                    $stmt->execute();
                                                    $result = $stmt->get_result();
                                                    if($result->num_rows > 0)
                                                    {
                                                        $row = $result->fetch_assoc();
                                                        $totalOrders = $row['total_orders'];
                                                        echo $totalOrders;
                                                    } 
                                                    else 
                                                    {
                                                        echo "No Products found";
                                                    }
                                                ?>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="card shadow">
                                <div class="card-body">
                                    <h5>Orders Received</h5>
                                    <div class="row">
                                        <div class="col-6">
                                            <h5 class="text-primary">
                                                <i class="fa-solid fa-list-ol fa-lg"></i>
                                            </h5>
                                        </div>
                                        <div class="col-6 text-center">
                                            <h3>
                                                <?php
                                                    @require_once '../Config/config.php';
                                                    $stmt = $connection->prepare("SELECT COUNT(*) as total_orders FROM orders");
                                                    $stmt->execute();
                                                    $result = $stmt->get_result();
                                                    if($result->num_rows > 0)
                                                    {
                                                        $row = $result->fetch_assoc();
                                                        $totalProducts = $row['total_orders'];
                                                        echo $totalProducts;
                                                    } 
                                                    else 
                                                    {
                                                        echo "No Orderd found";
                                                    }
                                                ?>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!----- Footer Section starts here----->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/6fff7c638d.js" crossorigin="anonymous"></script>
    </body>
</html>