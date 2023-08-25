<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/register.css">
    <title>Form Handling with PHP</title>
</head>
<body>
        <main>
            <form action="includes/registerformhandler.inc.php" method="post">
                <h1>Register a new account.</h1>
                <fieldset>
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" />
                </fieldset>
                <fieldset>
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" />
                </fieldset>
                <fieldset>
                    <label for="phone">Phone Number</label>
                    <input type="number" name="phone" id="phone" />
                </fieldset>
                <fieldset>
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" />
                </fieldset>
                <p>Already have an account? <a href="./index.php">Sign in here</a></p>
                <button>Submit</button>
            </form>
        </main>
</body>
</html>