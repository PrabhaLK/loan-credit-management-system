<?php
// Include necessary files
include('../config/db.php');  // Database configuration
session_start();

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $total_room_charges = $_POST['total_room_charges'];
    $total_treatments = $_POST['total_treatments'];
    $total_tests = $_POST['total_tests'];
    $type = $_POST['type'];
    $nic = $_SESSION['nic'];

    // Insert data into the database
    $query = "INSERT INTO temp (`nic`, `type`, total_room_charges, total_treatments, total_tests) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssddd", $nic, $type, $total_room_charges, $total_treatments, $total_tests);

    if ($stmt->execute()) {
        echo "Data inserted successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
