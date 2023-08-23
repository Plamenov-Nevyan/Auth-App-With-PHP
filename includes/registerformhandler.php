<?php

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $username = htmlspecialchars($_POST["username"]);
    $email = htmlspecialchars($_POST["email"]);     // ---> grab the submitted data and sanitize it preventing XSS attacks
    $phone = htmlspecialchars($_POST["phone"]);
    $password = htmlspecialchars($_POST["password"]);

    if(empty($username) || empty($email) || empty($phone) || empty($password)){    // error handler, the empty function checks if extracted value is empty string
        header("Location: ../index.php"); // --> redirect function
        exit(); // terminates the current script entirely
    };

    // TO DO

    header("Location: ../index.php"); // --> redirect function
}else {
    // here the function is serving as a route guard
    header("Location: ../index.php"); // --> redirect function
};