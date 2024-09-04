<?php
session_start(); // Start the session to use session variables
include '../config/db.php'; // Ensure the path is correct

// Debugging: Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    error_log('POST request received'); // Log when POST is received
    $nic = $_POST['nic'];

    // Query to check if the NIC exists
    $query = "SELECT Name FROM user_details WHERE NIC = ?";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        error_log('Error preparing statement: ' . $conn->error);
        echo json_encode(['status' => 'error', 'message' => 'Database error']);
        exit;
    }

    $stmt->bind_param("s", $nic);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($username);
        $stmt->fetch();

        // Store the NIC in a session variable
        $_SESSION['claimholder_nic'] = $nic;

        echo json_encode([
            'status' => 'success',
            'username' => $username
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'NIC not found'
        ]);
    }
    $stmt->close();
    $conn->close();
} else {
    // Debugging: Log if the method is not POST
    error_log('Request method is not POST, it is: ' . $_SERVER['REQUEST_METHOD']);
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>