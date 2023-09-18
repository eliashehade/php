<?php

class con_db
{
    private $conn;

    function __construct(){
        include "database.php";
        $this->conn=new mysqli($db_host, $db_user, $db_pass, $db_schema);
    }
    function GetConn(){
        return $this->conn;
    }
}