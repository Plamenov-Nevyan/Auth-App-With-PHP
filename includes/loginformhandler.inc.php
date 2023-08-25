<?php

session_start();

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $email = $_POST["email"];     // ---> grab the submitted data and sanitize it preventing XSS attacks
    $password = $_POST["password"];

    if(empty($email) || empty($password)){    // error handler, the empty function checks if extracted value is empty string
        header("Location: ../index.php"); // --> redirect function
        exit(); // terminates the current script entirely
    }else {
        try {
            // getting the PDO connection to MySQL in dbhandler.inc file
            require "dbhandler.inc.php";  
            // SQL query for inserting a newly registered user in the database, values will be passed during it's execution
            $query = "SELECT * FROM users WHERE email = :email";  
            //Creating SQL prepared statement using the query for registration
            $statement = $pdo->prepare($query);
            $statement->bindParam("email", $email);
            // executing the prepared statement and passing the received form data as values 
            $statement->execute();
            // Getting the newly registered user id, to be sent to the profile page through session
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            echo $user;
            if(!empty($user)){
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