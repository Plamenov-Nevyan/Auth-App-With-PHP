<?php

require_once "config.php";

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $action = $_POST["action"];
    if($action === 'changeUsername'){
        $currentUsername = $_POST["currentUsername"];
        $newUsername = $_POST["newUsername"];
        if(empty($currentUsername) || empty($newUsername)){
            throw new Exception("Please fill all the required fields!");
            exit;
        }else{
          try {
            require "dbhandler.inc.php";  
            $query = "SELECT * FROM users WHERE username = :currentUsername";
            $statement = $pdo->prepare($query);
            $statement->bindParam("currentUsername", $currentUsername);
            $statement->execute();
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            if(!empty($user)){
                 $updateQuery = "UPDATE users SET username = :newUsername WHERE id = :userId";
                 $updateStatement = $pdo->prepare($updateQuery);
                 $updateStatement->bindParam("newUsername", $newUsername);
                 $updateStatement->bindParam("userId", $user["id"]);
                 $updateStatement->execute(); 
                // setting user's id in the session so it can be used when redirected to his/her profile
                $_SESSION['userId'] = $user["id"];
                // Manually closing the database connection, to free up resources as early as possible (since it closes automatically anyway)
                $pdo = null;    
                $statement=null;
                // Redirecting to profile page and terminating the script
                echo 'Your username updated successfully';
                die();
            }else {
                throw new Exception("Your current username is incorrect!");
            };  
          }catch(PDOException $error){
            echo "Error: ".$error->getMessage();
            die("Query to the database failed" . $error->getMessage());  // error handling if the query to the database fails for some reason
          }
        }
    }
    if($action === 'changeEmail'){
        $currentEmail = $_POST["currentEmail"];
        $newEmail = $_POST["newEmail"];
        if(empty($currentEmail) || empty($newEmail)){
            throw new Exception("Please fill all the required fields!");
            exit;
        }else{
          try {
            require "dbhandler.inc.php";  
            $query = "SELECT * FROM users WHERE email = :currentEmail";
            $statement = $pdo->prepare($query);
            $statement->bindParam("currentEmail", $currentEmail);
            $statement->execute();
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            if(!empty($user)){
                 $updateQuery = "UPDATE users SET email = :newEmail WHERE id = :userId";
                 $updateStatement = $pdo->prepare($updateQuery);
                 $updateStatement->bindParam("newEmail", $newEmail);
                 $updateStatement->bindParam("userId", $user["id"]);
                 $updateStatement->execute(); 
                // setting user's id in the session so it can be used when redirected to his/her profile
                $_SESSION['userId'] = $user["id"];
                // Manually closing the database connection, to free up resources as early as possible (since it closes automatically anyway)
                $pdo = null;    
                $statement=null;
                // Redirecting to profile page and terminating the script
                echo 'Your email updated successfully!';
                die();
            }else {
                throw new Exception("Your current email is incorrect!");
            };
          }catch(PDOException $error){
            echo "Error:".$error->getMessage();
            die("Query to the database failed" . $error->getMessage());  // error handling if the query to the database fails for some reason
          }
        }
    }
    if($action === 'changePhone'){
        $currentPhone = $_POST["currentPhone"];
        $newPhone = $_POST["newPhone"];
        if(empty($currentPhone) || empty($newPhone)){
            throw new Exception("Please fill all the required fields!");
            exit;
        }else{
          try {
            require "dbhandler.inc.php";  
            $query = "SELECT * FROM users WHERE phone = :currentPhone";
            $statement = $pdo->prepare($query);
            $statement->bindParam("currentPhone", $currentPhone);
            $statement->execute();
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            if(!empty($user)){
                 $updateQuery = "UPDATE users SET phone = :newPhone WHERE id = :userId";
                 $updateStatement = $pdo->prepare($updateQuery);
                 $updateStatement->bindParam("newPhone", $newPhone);
                 $updateStatement->bindParam("userId", $user["id"]);
                 $updateStatement->execute(); 
                // setting user's id in the session so it can be used when redirected to his/her profile
                $_SESSION['userId'] = $user["id"];
                // Manually closing the database connection, to free up resources as early as possible (since it closes automatically anyway)
                $pdo = null;    
                $statement=null;
                // Redirecting to profile page and terminating the script
                echo "Your phone number was updated successfully!";
                die();
            }else {
                throw new Exception("Your current phone number is incorrect!");
            }  
          }catch(PDOException $error){
            echo "Error:".$error->getMessage();
            die("Query to the database failed" . $error->getMessage());  // error handling if the query to the database fails for some reason
          }
        }
    }
    if($action === 'changePassword'){
        $currentPassword = $_POST["currentPassword"];
        $newPassword = $_POST["newPassword"];
        $userId = $_SESSION["userId"];
        $hash_options = [
            'cost' => 12
        ];
        if(empty($currentPassword) || empty($newPassword)){
            throw new Exception("Please fill all the required fields!");
            exit;
        }else{
          try {
            require "dbhandler.inc.php";  
            $query = "SELECT * FROM users WHERE id = :userId";
            $statement = $pdo->prepare($query);
            $statement->bindParam("userId", $userId);
            $statement->execute();
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            if(!empty($user)){
                if(!password_verify($currentPassword, $user["pwd"])){
                    throw new Exception("Your current password is incorrect");
                    die();
                }
                 $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT, $hash_options);
                 $updateQuery = "UPDATE users SET pwd = :newPassword WHERE id = :userId";
                 $updateStatement = $pdo->prepare($updateQuery);
                 $updateStatement->bindParam("newPassword", $hashedPassword);
                 $updateStatement->bindParam("userId", $user["id"]);
                 $updateStatement->execute(); 
                // setting user's id in the session so it can be used when redirected to his/her profile
                $_SESSION['userId'] = $user["id"];
                // Manually closing the database connection, to free up resources as early as possible (since it closes automatically anyway)
                $pdo = null;    
                $statement=null;
                // Redirecting to profile page and terminating the script
                echo"Your password was updated successfully!";
                die();
            }else {
                throw new Exception("Couldn't find you in the database, please try to login and try again!");
            }  
          }catch(PDOException $error){
            echo "Error:".$error->getMessage();
            die("Query to the database failed" . $error->getMessage());  // error handling if the query to the database fails for some reason
          }
        }
    }
};