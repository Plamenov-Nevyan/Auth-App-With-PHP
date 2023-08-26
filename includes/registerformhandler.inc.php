<?php

require_once "config.php";

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $username = $_POST["username"];
    $email = $_POST["email"];     // ---> grab the submitted data
    $phone = $_POST["phone"];
    $password = $_POST["password"];
   $hash_options = [
        'cost' => 12
    ]; 

    if(empty($username) || empty($email) || empty($phone) || empty($password)){    // error handler, the empty function checks if extracted value is empty string
        header("Location: ../register.php?error=Please%20fill%20all%20the@20required%20fields!"); // --> redirect function
        exit(); // terminates the current script entirely
    }else {
        try {
            // getting the PDO connection to MySQL in dbhandler.inc file
            require "dbhandler.inc.php";  

            // SQL query for inserting a newly registered user in the database, values will be passed during it's execution
            $query = "INSERT INTO users (username, email, phone, pwd) VALUES (?, ?, ?, ?);";  

            //Creating SQL unnamed prepared statement using the query for registration
            $statement = $pdo->prepare($query);

            // hash the submitted user password using BCRYPT algorithm and setting cost to 12 for better defence against brute force attacks
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT, $hash_options);

            // executing the prepared statement and passing the received form data as values 
            $statement->execute([$username,$email,$phone,$hashedPassword]);

            // Getting the newly registered user id, to be sent to the profile page through session
            $userId=$pdo->lastInsertId();
            $_SESSION['userId'] = $userId;

            // Manually closing the database connection, to free up resources as early as possible (since it closes automatically anyway)
            $pdo = null;    
            $statement=null;

            // Redirecting to profile page and terminating the script
            header("Location: ../profile.php");
            die();
        }catch(PDOException $error){
            die("Query to the database failed" . $error->getMessage());  // error handling if the query to the database fails for some reason
        };
    }
}else {
    // here the function is serving as a route guard
    header("Location: ../index.php"); // --> redirect function
};