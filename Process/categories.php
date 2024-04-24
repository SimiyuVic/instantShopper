<?php

session_start();

require_once '../Config/config.php';

if(isset($_POST['add_category']))
{
    $category_name = $_POST['category_name'];
    $category_description = $_POST['category_description'];

    // Check if category name is not empty
    if(empty($category_name)) {
        $_SESSION['error'] = "Category name cannot be empty.";
        header('location: ../Admin/categories.php');
        exit(); // Stop further execution
    }

    $query = "INSERT INTO categories (category_name, category_description) VALUES (?, ?)";
    $stmt = $connection->prepare($query);
    if($stmt)
    {
        $stmt->bind_param("ss", $category_name, $category_description);
        if($stmt->execute())
        {
            $_SESSION['category'] = "";
            header('location: ../Admin/categories.php');
            exit(); // Stop further execution
        }
        else
        {
            $_SESSION['error'] = "Failed to add category.";
            header('location: ../Admin/categories.php');
            exit(); // Stop further execution
        }
    }
    else 
    {
        $_SESSION['error'] = "Database error: Failed to prepare statement.";
        header('location: ../Admin/categories.php');
        exit(); // Stop further execution
    }
}

?>
