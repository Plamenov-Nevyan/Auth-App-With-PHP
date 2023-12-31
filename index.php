<?php 
 if($_GET){
    echo $_GET['error'];
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css" >
    <link rel="stylesheet" href="css/typography.css">
    <script src="js/validators.js" type="module" defer></script>
    <title>Form Handling with PHP</title>
</head>
<body>
        <main>
            <form id="login-form" action="includes/loginformhandler.inc.php" method="post">
                <h1>Sign in to your account.</h1>
                <fieldset>
                    <label for="email">Email</label>
                    <input class="login-input" type="text" name="email" id="email" />
                    <span class="error-message" id="email-login-error"></span>
                </fieldset>
                <fieldset>
                    <label for="password">Password</label>
                    <input class="login-input" type="password" name="password" id="password" />
                    <span class="error-message" id="password-login-error"></span>
                </fieldset>
                <p>Have no account yet? <a href="./register.php">Sign up here</a></p>
                <button>Submit</button>
            </form>
        </main>
</body>
</html>