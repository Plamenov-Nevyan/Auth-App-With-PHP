<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/register.css">
    <link rel="stylesheet" href="css/typography.css">
    <script src="js/validators.js" type="module" defer></script>
    <title>Form Handling with PHP</title>
</head>
<body>
        <main>
            <form id="register-form" action="includes/registerformhandler.inc.php" method="post">
                <h1>Register a new account.</h1>
                <fieldset>
                    <label for="username">Username</label>
                    <input class="register-input" type="text" name="username" id="username" />
                    <span class="error-message" id="username-error"></span>
                </fieldset>
                <fieldset>
                    <label for="email">Email</label>
                    <input class="register-input" type="text" name="email" id="email" />
                    <span class="error-message" id="email-error"></span>
                </fieldset>
                <fieldset>
                    <label for="phone">Phone Number</label>
                    <input class="register-input" type="number" name="phone" id="phone" />
                    <span class="error-message" id="phone-error"></span>
                </fieldset>
                <fieldset>
                    <label for="password">Password</label>
                    <input class="register-input" type="password" name="password" id="password" />
                    <span class="error-message" id="password-error"></span>
                </fieldset>
                <p>Already have an account? <a href="./index.php">Sign in here</a></p>
                <button>Submit</button>
            </form>
        </main>
</body>
</html>