<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbName = 'insurance_as';

$conn = mysqli_connect($servername, $username, $password, $dbName);

if ($conn->connect_error) {
    die("Connection failed " . $dbConnector->connect_error);
}

// echo "Connection Success";
