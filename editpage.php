<?php
session_start();


include "con_db.php";

$mysql_obj = new con_db();
$mysql = $mysql_obj->GetConn();

if (isset($_SESSION["authenticated"]) && $_SESSION["authenticated"] === true && isset($_SESSION["permissions"]) && in_array("edit", $_SESSION["permissions"])) {
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $mailbox_number= $_POST['mailbox_number'];

    // SQL UPDATE
    $sql = "UPDATE lecturers SET name='$name',phone='$phone',mailbox_number='$mailbox_number' WHERE id=$id";

    // تنفيذ الجملة SQL
    if ($mysql->query($sql) === TRUE) {
        // echo "Lecturer updated successfully";
        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $mysql->error;
    }


}}else{
      echo "CONNOT GET THIS PAGE";

}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Lecturer</title>
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

        h1 {
            margin-bottom: 20px;
        }

        label {
            display: block;
            text-align: right;
            margin-bottom: 10px;
        }

        input[type="text"] {
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
    <h1>Edit Lecturer</h1>
    <?php
    if (!isset($_SESSION["authenticated"]) || !isset($_SESSION["permissions"]) || !in_array("edit", $_SESSION["permissions"])) {
        echo "<p class='error-message'>You do not have the necessary permission to access this page.</p>";
    } else {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "SELECT * FROM lecturers WHERE id = $id";
            $result = $mysql->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                ?>
                <form action="editpage.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required><br>
                    <label for="phone">Phone:</label>
                    <input type="text" id="phone" name="phone" value="<?php echo $row['phone']; ?>" required><br>
                    <label for="mailbox_number">Mailbox Number:</label>
                    <input type="text" id="mailbox_number" name="mailbox_number" value="<?php echo $row['mailbox_number']; ?>" required><br>
                    <input type="submit" value="Update Lecturer">
                </form>
                <?php
            } else {
                echo "<p class='error-message'>Lecturer not found</p>";
            }
        } else {
            echo "<p class='error-message'>Invalid request</p>";
        }
    }
    ?>
</div>
</body>
</html>
