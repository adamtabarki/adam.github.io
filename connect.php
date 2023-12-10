<?php 
$host="localhost";
$username="root";
$password="";
$db="gift";

$connection=mysqli_connect($host,$username,$password,$db);
if (!$connection) {
    die("Error: " . mysqli_error($connection));
}






?>