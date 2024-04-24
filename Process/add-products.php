<?php
// Include the database connection file
require_once '../Config/config.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $category_id = $_POST['category_id'];
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $product_price = $_POST['product_price'];
    
    // File upload handling
    $target_dir = "../uploads/"; // Directory where uploaded images will be stored
    $target_file = $target_dir . basename($_FILES["product_image"]["name"]); // Path of the uploaded file on the server
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION)); // File extension of the uploaded file
    
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["product_image"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
    
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    
    // Check file size
    if ($_FILES["product_image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
            // File uploaded successfully, proceed with inserting data into database
            // Prepare SQL statement to insert data into the products table
            $sql = "INSERT INTO products (category_id, product_name, product_description, product_price, product_image) VALUES (?, ?, ?, ?, ?)";
            $stmt = $connection->prepare($sql);
            
            // Bind parameters
            $stmt->bind_param("issss", $category_id, $product_name, $product_description, $product_price, $target_file);
            
            // Execute the statement
            if ($stmt->execute()) {
                // Product added successfully, redirect back to the form page
                header("Location: ../Admin/products.php");
                exit();
            } else {
                // Error occurred, handle it accordingly
                echo "Error: " . $stmt->error;
            }
    
            // Close the statement
            $stmt->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

// Close the database connection
$connection->close();
?>
