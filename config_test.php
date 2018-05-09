<?php
$hostname='localhost';
$username='demode29';
$password='c1f9035f';
$dbname='matches';

// create connection
$conn = mysqli_connect($hostname, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

?>