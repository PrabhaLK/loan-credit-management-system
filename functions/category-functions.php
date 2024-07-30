<?php
include('../config/db.php');

// Ensure the type is set
if (!empty($type)) {
    // Fetch the necessary data based on the type
    $sql = "SELECT * FROM `claim_info` WHERE `SubCategory 1 Name` = '$type' OR `CategoryName`= '$type'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $ClaimID = $row['ClaimID'];
        $Name = $row['Name'];
        $Category = $row['Category'];
        $CategoryName = $row['CategoryName'];
        $SubCategory1 = $row['SubCategory 1'];
        $SubCategory1Name = $row['SubCategory 1 Name'];
        $SubCategory2 = $row['SubCategory 2'];
        $SubCategory2Name = $row['SubCategory 2 Name'];
        $PerDay = $row['PerDay'];
        $PerIncident = $row['PerIncident'];
        $PerYear = $row['PerYear'];
        $PerLife = $row['PerLife'];
        $ResetTime = $row['ResetTime'];
    } else {
        echo "<script>alert('No data found for the specified type');</script>";
    }

    // Calculate Medical Treatments charges for the hospitals
    $sql = "SELECT * FROM `claim_info` WHERE `SubCategory 1 Name` = '$type' AND `SubCategory 2 Name` = 'MedicalTreatment'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result); // Fetch the result row
        $IncidentPrice = $row['PerIncident'];
    }
    //Calculate medical treatments charges for the Hospitals.
    $sql = "SELECT * FROM `claim_info` WHERE `SubCategory 1 Name` = '$type' AND `SubCategory 2 Name` = 'MedicalTest'";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result); // Fetch the result row
        $TestIncident = $row['PerIncident'];
    }

    //calculate consultant fee charges for the hospitals. 
    $consultant = "SELECT * FROM `claim_info` WHERE `SubCategory 1 Name` = '$type' AND `SubCategory 2 Name` = 'ConsultantFee'";
    $consultant_res = mysqli_query($conn, $consultant);
    if ($consultant_res && mysqli_num_rows($consultant_res) > 0) {
        $row = mysqli_fetch_assoc($consultant_res); // Fetch the result row
        $consultantPrice = $row['PerIncident'];
    } else {
        $consultantPrice = 0;
    }

    // get the Per incident Price for One Time Items. 
    $incidentCost = "SELECT * FROM `claim_info` WHERE `SubCategory 1 Name` = '$type' AND `SubCategory 2 Name` = 'PerIncident'";
    $incident_res = mysqli_query($conn, $incidentCost);
    if ($incident_res && mysqli_num_rows($incident_res) > 0) {
        $row = mysqli_fetch_assoc($incident_res);
        $incident_cost = $row['PerIncident'];
    }

    // get the Per Life Price for One Time Items. 
    $PerLifeCost = "SELECT * FROM `claim_info` WHERE `SubCategory 1 Name` = '$type' AND `SubCategory 2 Name` = 'PerLife'";
    $PerLife_res = mysqli_query($conn, $PerLifeCost);
    if ($PerLife_res && mysqli_num_rows($PerLife_res) > 0) {
        $row = mysqli_fetch_assoc($PerLife_res);
        $per_life_cost = $row['PerLife'];
    }

    // Get user info from the database according to the session
    // $sql_usr = "SELECT * FROM `user_details` WHERE `NIC` = '{$_SESSION['nic']}'";
    // $result_usr = mysqli_query($conn, $sql_usr);
    // if ($result_usr && mysqli_num_rows($result_usr) > 0) {
    //     $row_usr = mysqli_fetch_assoc($result_usr);
    //     $usr_NIC = $row_usr['NIC'];
    //     $usr_Name = $row_usr['Name'];
    // }
    $sql = "SELECT * FROM `claim_info` WHERE `SubCategory 1 Name` = '$type' OR `CategoryName`= '$type'";
    $result = mysqli_query($conn, $sql);
}
