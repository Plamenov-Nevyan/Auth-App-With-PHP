<?php

require_once "config.php";

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $email = $_POST["email"];     // ---> grab the submitted data for comparing in the database
    $password = $_POST["password"];

    if(empty($email) || empty($password)){    // error handler, the empty function checks if extracted value is empty string
        header("Location: ../index.php"); // --> redirect function
        exit(); // terminates the current script entirely
    }else {
        try {
            // getting the PDO connection to MySQL in dbhandler.inc file
            require "dbhandler.inc.php";  
            // SQL query for finding the user trying to login with it's email
            $query = "SELECT * FROM users WHERE email = :email";  
            //Creating SQL named prepared statement using the query for finding user trying to login 
            $statement = $pdo->prepare($query);
            $statement->bindParam("email", $email);
            // executing the prepared statement
            $statement->execute();
            // Fetching the data of the user trying to login as associative array from the database
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            if(!empty($user)){
                if(!password_verify($password, $user["pwd"])){
                    header("Location: ../index.php");
                    die();
                }
                // setting user's id in the session so it can be used when redirected to his/her profile
                $_SESSION['userId'] = $user["id"];
                // Manually closing the database connection, to free up resources as early as possible (since it closes automatically anyway)
                $pdo = null;    
                $statement=null;
                // Redirecting to profile page and terminating the script
                header("Location: ../profile.php");
            }
            die();
        }catch(PDOException $error){
            header("Location: ../index.php?error=".$error->getMessage());
            die("Query to the database failed" . $error->getMessage());  // error handling if the query to the database fails for some reason
        };
    }
}else {
    // here the function is serving as a route guard
    header("Location: ../index.php"); // --> redirect function
};