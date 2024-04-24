<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the 'update' button is clicked
    if (isset($_POST['update'])) {
        // Include your database connection file
        require_once '../Config/config.php';

        // Retrieve form data
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $phone_number = $_POST['phone_number'];

        // Get the user ID from the session
        $user_id = $_SESSION['user_id'];

        // Prepare the SQL statement to update user details
        $query = "UPDATE users SET firstname = ?, lastname = ?, phone_number = ? WHERE user_id = ?";
        $stmt = $connection->prepare($query);

        // Bind parameters
        $stmt->bind_param("sssi", $firstname, $lastname, $phone_number, $user_id);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to profile page or display success message
            header("Location: ../user-profile.php"); // Change to your profile page URL
            exit();
        } else {
            // Handle error
            echo "Error: " . $connection->error;
        }

        // Close statement and connection
        $stmt->close();
        $connection->close();
    }
}
?>
