<?php
session_start();

include "con_db.php";
$mysql_obj = new con_db();
$mysql = $mysql_obj->GetConn();
//xss
$id =htmlspecialchars( $_GET["id"]);
if (isset($_SESSION["authenticated"]) && $_SESSION["authenticated"] === true && isset($_SESSION["permissions"]) && in_array("delete", $_SESSION["permissions"])) {
$sql = "DELETE FROM lecturers WHERE id = $id";
if ($mysql->query($sql) === TRUE) {
    header("Location: index.php");
    exit;
} else {
    echo "Error deleting record: " . $mysql->error;
    $mysql->close();
}}else{
    echo "CONNOT GET THIS PAGE";
}

?>