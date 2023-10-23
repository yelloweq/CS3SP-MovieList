<?php

function dbConnect()
{
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "example";
$conn = new mysqli($dbhost, $dbuser, $dbpass,$dbname) or die("Connect failed: %s\n". $conn -> error);
return $conn;
}

function dbClose($conn)
{
$conn -> close();
}
?>