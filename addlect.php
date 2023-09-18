<?php
session_start();



include "con_db.php";

$mysql_obj = new con_db();
$mysql = $mysql_obj->GetConn();

if (isset($_SESSION["authenticated"]) && $_SESSION["authenticated"] === true && isset($_SESSION["permissions"]) && in_array("add", $_SESSION["permissions"])) {
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $mailbox_number = $_POST["mailbox_number"];

    $sql = "INSERT INTO lecturers (name,phone,mailbox_number) VALUES ('$name', '$phone','$mailbox_number')";
    if ($mysql->query($sql) === TRUE) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $mysql->error;
    }
}
}else{
     echo "CONNOT GET THIS PAGE";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Lecturer</title>
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

        input[type="text"],
        input[type="number"] {
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
    <h2>Add Lecturer</h2>
    <?php
    // Check for permission and display an error message if necessary
    if (!isset($_SESSION["authenticated"]) || !isset($_SESSION["permissions"]) || !in_array("add", $_SESSION["permissions"])) {
        echo "<p class='error-message'>You do not have the necessary permission to access this page.</p>";
    } else {
        ?>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="name">Name:</label>
            <input type="text" name="name" required>
            <br>
            <label for="phone">Phone:</label>
            <input type="number" name="phone" required>
            <br>
            <label for="mailbox_number">Mailbox Number:</label>
            <input type="text" name="mailbox_number">
            <br>
            <input type="submit" value="Submit">
        </form>
        <?php
    }
    ?>
</div>
</body>
</html>
