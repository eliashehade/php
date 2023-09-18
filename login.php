<?php
session_start();

// Function to generate a random CSRF token
function generateCSRFToken() {
    return uniqid("",true);
}

if (!isset($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = generateCSRFToken();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate the CSRF token
    if (isset($_POST["csrf_token"]) && $_POST["csrf_token"] === $_SESSION["csrf_token"]) {
        // CSRF token is valid
        if ($_POST["password"] === "AAA") {
            $_SESSION["authenticated"] = true;
            $_SESSION["permissions"] = array("add", "edit", "delete");
            header("Location: index.php");
            exit;
        } else {
            $error_message = "connot login";
        }
    } else {
        // CSRF token is invalid
        $error_message = "CSRF  invalid!"; // Display an error message for CSRF attack
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 400px;
            margin: 100px auto;
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 5px;
        }

        h2 {
            margin-bottom: 20px;
        }

        label {
            display: block;
            text-align: right;
            margin-bottom: 10px;
        }

        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .error-message {
            color: #FF0000;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Login to the System</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <br>
        <!-- Include the CSRF token as a hidden field -->
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION["csrf_token"]; ?>">
        <input type="submit" value="Login">
    </form>

    <?php
    if (isset($error_message)) {
        echo "<p class='error-message'>$error_message</p>";
    }
    ?>
</div>
</body>
</html>

