<?php
// Load database connection
include_once '../config/db.php';

$national_id = $_POST['nic'];
$password = $_POST['pass'];

$sql = "SELECT * FROM user_details WHERE NIC = ? AND password = ?";
$stmt = $conn->prepare($sql);

// Bind parameters
$stmt->bind_param('ss', $national_id, $password);

// Execute query
$stmt->execute();

// Get result
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    // Login successful
    echo "Login successful!";
    // Redirect user to dashboard or perform other actions
} else {
    // Login failed
    header("Location: login.php");
}


// Close statement and connection
$stmt->close();
$conn->close();
?>