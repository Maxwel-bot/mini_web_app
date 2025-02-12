<?php
$hostname="localhost";
$username="root";
$password="";
$dbname="account";
$connection=mysqli_connect($hostname,$username,$password,$dbname);
if ($connection->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>