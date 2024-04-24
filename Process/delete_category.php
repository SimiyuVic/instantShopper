<?php
require_once '../Config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['category_id'])) {
    $category_id = $_POST['category_id'];

    // SQL query to delete the category
    $query = "DELETE FROM categories WHERE category_id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param('i', $category_id);

    if ($stmt->execute()) {
        // Category deleted successfully
        // Redirect back to the page where the category was deleted from
        header('Location: ../Admin/categories.php');
        $_SESSION['category_deleted'] = "";
        exit();
    } else {
        // Error occurred while deleting the category
        echo "Error: " . $connection->error;
    }
} else {
    // If no category ID is provided, redirect back to the page
    header('Location: ../Admin/dashboard.php');
    exit();
}
?>
