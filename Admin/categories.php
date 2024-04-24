<?php include 'header.php'; ?>
<div class="container my-4">
    <div class="row">
        <div class="col-md-3">
        <?php
            if(isset($_SESSION['category']))
            { 
                ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Hurray !</strong> Category Added
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php 
                    unset($_SESSION['category']);
            }
        ?>
        <?php
            if(isset($_SESSION['category_deleted']))
            { 
                ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Hello !</strong> A category Deleted !
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php 
                    unset($_SESSION['category_deleted']);
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
                    <h5>Add A category</h5>
                </div>
                <!--form for adding a category -->
                <div class="card-body">
                    <form action="../Process/categories.php" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text"  name="category_name" class="form-control" placeholder=" e.g Top Picks" required>
                                    <label for="floatingInput">Category Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text"  name="category_description" class="form-control" placeholder=" e.g Most selected" required>
                                    <label for="floatingInput">Description</label>
                                </div>
                            </div>
                        </div>
                        <input type="submit" name="add_category" value="Add Category" class="btn btn-outline-primary">
                    </form>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <!-- Search form -->
                    <form method="GET">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Search by category" name="search_category">
                            <button class="btn btn-outline-secondary" type="submit">Search</button>
                        </div>
                    </form>
                    <!-- Table for displaying categories -->
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Category</th>
                                <th scope="col">Description</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require_once '../Config/config.php';
                            // Pagination variables
                            $limit = 10; // Number of records per page
                            $page = isset($_GET['page']) ? $_GET['page'] : 1;
                            $start = ($page - 1) * $limit;
                            
                            // Search query
                            $search_category = isset($_GET['search_category']) ? $_GET['search_category'] : '';
                            $searchQuery = empty($search_category) ? '' : " WHERE category_name LIKE '%$search_category%'";
                            
                            // SQL query for fetching categories
                            $query = "SELECT * FROM categories $searchQuery LIMIT $start, $limit";
                            $stmt = $connection->prepare($query);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <th scope="row"><i class="fa-solid fa-chevron-right fa-lg"></i></th>
                                        <td><?php echo $row['category_name']; ?></td>
                                        <td><?php echo $row['category_description']; ?></td>
                                        <td>
                                            <form action="../Process/delete_category.php" method="POST">
                                                <input type="hidden" name="category_id" value="<?php echo $row['category_id']; ?>">
                                                <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php }
                            } else {
                                // No result found
                                echo '<tr><td colspan="4">No categories found.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                    
                    <!-- Pagination -->
                    <?php
                    // Count total records
                    $query = "SELECT COUNT(*) AS total FROM categories $searchQuery";
                    $stmt = $connection->prepare($query);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    $totalRecords = $row['total'];
                    $totalPages = ceil($totalRecords / $limit);

                    // Display pagination
                    if ($totalPages > 1) {
                        echo '<ul class="pagination justify-content-center">';
                        for ($i = 1; $i <= $totalPages; $i++) {
                            echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '&search_category=' . urlencode($search_category) . '">' . $i . '</a></li>';
                        }
                        echo '</ul>';
                    }
                    ?>
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
