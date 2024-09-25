<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nic'])) {
    $nic = $_POST['nic'];

    // Create a session variable for the NIC
    $_SESSION['nic'] = $nic;

    // Return a success response
    echo json_encode(['status' => 'success']);
} else {
    // Return an error response
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
