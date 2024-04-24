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
                        A list of your registered Users
                    </h5>
                </div>
                <div class="card-body">
                    <form method="GET">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Search by username or email" name="search">
                            <button class="btn btn-outline-secondary" type="submit">Search</button>
                        </div>
                    </form>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">UserName</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">When</th>
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
                            $search = isset($_GET['search']) ? $_GET['search'] : '';
                            $searchQuery = empty($search) ? '' : "WHERE firstname LIKE '%$search%' OR lastname LIKE '%$search%' OR email LIKE '%$search%'";

                            $query = "SELECT * FROM users $searchQuery LIMIT $start, $limit";
                            $stmt = $connection->prepare($query);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($result->num_rows > 0)
                            {
                                while ($row = $result->fetch_assoc())
                                { ?>
                                    <tr>
                                    <th scope="row"><i class="fa-solid fa-chevron-right fa-lg"></i></th>
                                        <td><?php echo $row['firstname'] .' '.  $row['lastname']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><?php echo $row['phone_number']; ?></td>
                                        <td><?php echo date('Y-m-d', strtotime($row['created_at'])); ?></td>
                                        <td>
                                            <form action="">
                                                <input type="submit" value="Delete" class="btn btn-outline-danger">
                                            </form>
                                        </td>
                                    </tr>
                                <?php }
                            }
                            else 
                            {
                                echo '<tr><td colspan="6">No users found.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <?php
                    $query = "SELECT COUNT(*) AS total FROM users $searchQuery";
                    $stmt = $connection->prepare($query);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    $totalRecords = $row['total'];
                    $totalPages = ceil($totalRecords / $limit);

                    if ($totalPages > 1) {
                        echo '<ul class="pagination justify-content-center">';
                        for ($i = 1; $i <= $totalPages; $i++) {
                            echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
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
