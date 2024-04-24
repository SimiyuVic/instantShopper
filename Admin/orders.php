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
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h5 class="text-center">
                        Orders Received
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">User Name</th>
                            <th scope="col">Products</th>
                            <th scope="col">Price</th>
                            <th scope="col">Image</th>
                            <th scope="col">Date</th>
                            <th scope="col">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                            <?php
                                @require_once '../Config/config.php';
                                $query = "SELECT u.firstname, u.lastname, p.product_name,p.product_price, p.product_image, o.created_at
                                FROM orders o
                                INNER JOIN users u ON o.user_id = u.user_id
                                INNER JOIN products p ON o.product_id = p.product_id";
                                $stmt = $connection->prepare($query);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                if ($result->num_rows > 0)
                                {
                                    while ($row = $result->fetch_assoc())
                                    { ?>
                                        <tr>
                                            <th scope="row"><i class="fa-solid fa-chevron-right fa-lg"></i></th>
                                            <td>
                                                <?php echo $row['firstname'] .' '. $row['lastname']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['product_name']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['product_price']; ?>
                                            </td>
                                            <td>
                                                <img src="../uploads/<?php echo $row['product_image']; ?>" alt="Product Image" width="100" height="100">
                                            </td>
                                            <td>
                                                <?php echo date('Y-m-d', strtotime($row['created_at'])); ?>
                                            </td>
                                            <td>
                                                <form action="">
                                                    <input type="submit" value="Delete" class="btn btn-outline-danger">
                                                </form>
                                            </td>
                                        </tr>
                                   <?php }
                                }
                            ?>
                        </tbody
                    </table>
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