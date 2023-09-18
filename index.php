<?php
session_start();


if (isset($_SESSION["authenticated"]) && $_SESSION["authenticated"] === true && isset($_SESSION["permissions"]) && in_array("add", $_SESSION["permissions"])) {

include "con_db.php";
$mysql_obj = new con_db();
$mysql = $mysql_obj->GetConn();
$sql = "SELECT * FROM lecturers";
$result = $mysql->query($sql);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $mailbox_number = $_POST["mailbox_number"];
}}else{
    echo 'sign in';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #007BFF;
            color: #fff;
        }

        a {
            text-decoration: none;
            color: #007BFF;
            margin-right: 10px;
        }

        .error-message {
            color: #FF0000;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Home</h2>
    <?php
    // Check for permission and display an error message if necessary
    if (!isset($_SESSION["authenticated"]) || !isset($_SESSION["permissions"]) || !in_array("add", $_SESSION["permissions"])) {
        echo "<p class='error-message'>You do not have the necessary permission to access this page.</p>";
    } else {
        ?>
        <a href="addlect.php">Add Lecturer</a>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Mailbox Number</th>
                <th>Actions</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["phone"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["mailbox_number"]) . "</td>";
                    echo "<td><a href='editpage.php?id=" . $row["id"] . "'>Edit</a> | <a href='deletepage.php?id=" . $row["id"] . "'>Delete</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No data available</td></tr>";
            }
            ?>
        </table>
        <?php
    }
    ?>
</div>
</body>
</html>
