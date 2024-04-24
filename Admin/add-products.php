<?php include 'header.php'; ?>
<div class="container my-4">
    <div class="row">
        <div class="col-md-3">
        <?php
            if(isset($_SESSION['product']))
            { 
                ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Hurray !</strong> Product Added
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php 
                    unset($_SESSION['product']);
            }
        ?>
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
                    <h5>Add New Products</h5>
                </div>
                <div class="card-body">
                    <form action="../Process/add-products.php" method="POST" enctype="multipart/form-data">
                        <div class="row ">
                            <div class="col-md-6">
                                    <p class="text-primary fw-bold">Choose Category</p>
                                    <select name="category_id" class="form-control mb-3">
                                        <?php
                                        require_once '../Config/config.php';
                                        $sql = "SELECT * FROM categories";
                                        $stmt = $connection->prepare($sql);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                            if($result->num_rows > 0)
                                            {
                                                while ($row = $result->fetch_assoc())
                                                {
                                                    echo '<option value="' . $row["category_id"] . '">' . $row["category_name"] . '</option>';
                                                }
                                            }
                                            else
                                            {

                                            }
                                        ?>
                                    </select>
                                <div class="form-floating mb-3">
                                    <input type="text" name="product_name" class="form-control" placeholder="Product Name" required>
                                    <label for="floatingInput">Product Name</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" name="product_description" placeholder="describe your product" id="floatingTextarea" style="height: 130px;" required></textarea>
                                    <label for="floatingTextarea">A Description of your Product . . .</label>
                                </div>
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="product_price" id="product_price" placeholder="Enter Price" oninput="formatSalary(this)">
                                    <label for="floatingInput">Price</label>
                                    <script>
                                        function formatSalary(input) {
                                            // Remove non-numeric characters
                                            let value = input.value.replace(/[^0-9]/g, '');

                                            // Add commas every three digits from the right
                                            value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');

                                            // Set the formatted value back to the input
                                            input.value = value;
                                        }
                                    </script>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="image" class="form-label fw-bold">Product Image</label>
                                    <input class="form-control" name="product_image" type="file" required>
                                </div>
                            </div>
                        </div>
                        <input type="submit" name="add_product" value="Add Product" class="btn btn-outline-primary">
                    </form>
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