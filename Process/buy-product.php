<?php
session_start();

require_once '../Config/config.php';

if (isset($_POST['buy_product'])) {
    $product_id = $_POST['product_id'];
    
    // Check if the product has already been bought by the user
    $query = "SELECT * FROM orders WHERE product_id = ? AND user_id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("ii", $product_id, $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Product already exists in orders for the user
        $_SESSION['order_exists'] = "";
        header('location: ../user-profile.php');
        exit(); // Exit to prevent further execution
    }

    // Proceed with inserting the order if it doesn't exist
    $query = "INSERT INTO orders (product_id, user_id) VALUES (?, ?)";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("ii", $product_id, $_SESSION['user_id']);

    if ($stmt->execute()) {
        $_SESSION['register_success'] = "Order placed successfully.";
        header('location: ../user-profile.php');
    } else {
        $_SESSION['order_failed'] = "Failed to place order.";
        header('location: ../user-profile.php');
    }
} else {
    $_SESSION['error_statement'] = "Error: Invalid request.";
    header('location: ../user-profile.php');
}

?>