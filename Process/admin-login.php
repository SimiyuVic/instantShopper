<?php

session_start();

@require_once '../Config/config.php';

if(isset($_POST['login']))
{
    //Getting the User inputs
    $email = $_POST['email'];
    $password = $_POST['password'];

    //Check if the user inputs are empty
    if(empty($email) || empty($password))
    {
        $_SESSION['empty_details'] = "";
        header('location: ../Admin/index.php');
    }
    else 
    {
        //Prepare sql statement to check login details.
        $stmt = $connection->prepare("SELECT admin_id, username, password FROM admin WHERE email = ?");
        $stmt->bind_param("s", $email);

        //Execute the statement
        $stmt->execute();

        //Bind Results
        $stmt->bind_result($admin_id, $username, $hashed_password);

        //Fetch Results
        $stmt->fetch();

        //Verify password
        if(password_verify($password, $hashed_password))
        {
            //Correct password, set sessions variables and redirect to login
            $_SESSION['admin_id'] = $admin_id;
            $_SESSION['username'] = $username;

            header('location: ../Admin/dashboard.php');
            $_SESSION['login_success'] = "";
            exit();
        }
        else //Incorrect password
        {
            $_SESSION['wrong_details'] = "";
            header('location: ../Admin/index.php');
            exit();
        }

        //Good practice
        $stmt->close();
        $connection->close();
    }
}

?>