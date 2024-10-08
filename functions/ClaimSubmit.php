<?php
// Include necessary files
include('../config/db.php');  // Database configuration
session_start();

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Log POST data for debugging
    error_log("POST Data: " . print_r($_POST, true));

    // Retrieve POST data safely
    $numberOfDates = isset($_POST['number_of_dates']) ? $_POST['number_of_dates'] : null;
    $totalMedicalCost = isset($_POST['total_medical_cost']) ? $_POST['total_medical_cost'] : null;
    $totalConsultantFees = isset($_POST['consultant_Fees']) ? $_POST['consultant_Fees'] : null;
    $totalTestCost = isset($_POST['total_test_cost']) ? $_POST['total_test_cost'] : null;
    $roomCharges = isset($_POST['room_charges']) ? $_POST['room_charges'] : null;
    $totalIncidentCost = isset($_POST['total_incident_cost']) ? $_POST['total_incident_cost'] : null; // New field
    $totalSum = isset($_POST['total_sum']) ? $_POST['total_sum'] : null;

    // Retrieve additional data from session or POST
    $nic = isset($_SESSION['nic']) ? $_SESSION['nic'] : null;
    $type = isset($_POST['type']) ? $_POST['type'] : null;

    $sql_select_category = "SELECT `CategoryName` FROM claim_info WHERE `SubCategory 1 Name` = '$type'";
    $sql_select_category_result = mysqli_query($conn, $sql_select_category);
    if ($sql_select_category_result) {
        $row = mysqli_fetch_assoc($sql_select_category_result);
        $category_name = $row['CategoryName'];
    }

    // Check for null values and handle appropriately
    if (is_null($numberOfDates) || is_null($totalMedicalCost) || is_null($totalTestCost) || is_null($roomCharges) || is_null($totalSum) || is_null($totalIncidentCost) || is_null($nic) || is_null($type) || is_null($category_name)) {
        error_log("Missing data: " . print_r([
            'numberOfDates' => $numberOfDates,
            'totalMedicalCost' => $totalMedicalCost,
            'totalTestCost' => $totalTestCost,
            'roomCharges' => $roomCharges,
            'totalIncidentCost' => $totalIncidentCost, // New field
            'totalSum' => $totalSum,
            'nic' => $nic,
            'type' => $type,
            'category' => $category_name
        ], true));
        die("Missing data");
    }

    // Sanitize input data
    $numberOfDates = intval($numberOfDates);
    $totalMedicalCost = floatval($totalMedicalCost);
    $totalConsultantFees = floatval($totalConsultantFees);
    $totalTestCost = floatval($totalTestCost);
    $roomCharges = floatval($roomCharges);
    $totalIncidentCost = floatval($totalIncidentCost); // New field
    $totalSum = floatval($totalSum);

    // Log sanitized data
    error_log("Sanitized Data: " . print_r([
        'numberOfDates' => $numberOfDates,
        'totalMedicalCost' => $totalMedicalCost,
        'totalConsultantFees' => $totalConsultantFees,
        'totalTestCost' => $totalTestCost,
        'roomCharges' => $roomCharges,
        'totalIncidentCost' => $totalIncidentCost, // New field
        'totalSum' => $totalSum,
        'nic' => $nic,
        'type' => $type,
        'category' => $category_name
    ], true));

    // Insert data into the database
    $query = "INSERT INTO `user-claims` (`nic`, `category`, `type`, `total_room_charges`, `total_treatments`, `consultant_fee`, `total_tests`, `IncidentPrice`, `total_cost`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        error_log("Prepare failed: " . $conn->error);
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sssdddddd", $nic, $category_name, $type, $roomCharges, $totalMedicalCost, $totalConsultantFees, $totalTestCost, $totalIncidentCost, $totalSum);

    if ($stmt->execute()) {
        echo "Data inserted successfully";
    } else {
        error_log("Execute failed: " . $stmt->error);
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
