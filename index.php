<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css" >
    <link rel="stylesheet" href="css/typography.css">
    <title>Form Handling with PHP</title>
</head>
<body>
        <main>
            <form action="includes/loginformhandler.inc.php" method="post">
                <h1>Sign in to your account.</h1>
                <fieldset>
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" />
                </fieldset>
                <fieldset>
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" />
                </fieldset>
                <p>Have no account yet? <a href="./register.php">Sign up here</a></p>
                <button>Submit</button>
            </form>
        </main>
</body>
</html>