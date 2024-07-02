<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbName = 'insurance_As';

$conn = mysqli_connect($servername, $username, $password, $dbName);

if (mysqli_connect_errno()) {
    echo "failed to connect to the database";
    exit();
}
// echo "Connection Success";
