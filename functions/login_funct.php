<?php
// Load database connection
include_once '../config/db.php';

session_start();
$national_id = $_POST['nic'];
$password = $_POST['pass'];

// SQL query to fetch user details based on NIC and password
$sql = "SELECT * FROM user_details WHERE NIC = ? AND password = ?";
$stmt = $conn->prepare($sql);

// Bind parameters
$stmt->bind_param('ss', $national_id, $password);

// Execute query
$stmt->execute();

// Get result
$result = $stmt->get_result();

// Check if there is exactly one row returned
if ($result->num_rows == 1) {
    // Login successful
    $row = $result->fetch_assoc();
    $_SESSION["nic"] = $national_id;
    $_SESSION['username'] = $row['Name'];
    $_SESSION['userType'] = $row['userType'];

    // Redirect user based on userType
    if ($row["userType"] == "user") {
        header("Location: ../pages/index_new.php");
        exit();
    } elseif ($row["userType"] == "admin") {
        header("Location: ../pages/claim-table.php");
        exit();
    }
} else {
    // Login failed: Redirect to login page with error message
    $_SESSION['login_error'] = "Incorrect NIC or password. Please try again.";
    header("Location: ../login.php");
    exit();
}

// Close statement and connection
$stmt->close();
$conn->close();
