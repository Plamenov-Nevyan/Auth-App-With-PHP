<?php

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $username = $_POST["username"];
    $email = $_POST["email"];     // ---> grab the submitted data
    $phone = $_POST["phone"];
    $password = $_POST["password"];

    if(empty($username) || empty($email) || empty($phone) || empty($password)){    // error handler, the empty function checks if extracted value is empty string
        try {
            // getting the PDO connection to MySQL in dbhandler.inc file
            require "dbhandler.inc.php";  
            // SQL query for inserting a newly registered user in the database, values will be passed during it's execution
            $query = "INSERT INTO users (username, email, phone, pwd) VALUES (?, ?, ?, ?);";  
            //Creating SQL prepared statement using the query for registration
            $statement = $pdo->prepare($query);
            // executing the prepared statement and passing the received form data as values 
            $statement->execute([$username,$email,$phone,$password]);
            // Manually closing the database connection, to free up resources as early as possible (since it closes automatically anyway)
            $pdo = null;    
            $statement=null;

            die();
        }catch(PDOException $error){
            die("Query to the database failed" . $error->getMessage());  // error handling if the query to the database fails for some reason
        };
        
        header("Location: ../index.php"); // --> redirect function
        exit(); // terminates the current script entirely
    };

    // TO DO

    header("Location: ../index.php"); // --> redirect function
}else {
    // here the function is serving as a route guard
    header("Location: ../index.php"); // --> redirect function
};