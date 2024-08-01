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
        $row = mysqli_fetch_assoc($result);
        $IncidentPrice = $row['PerIncident'];
    }

    // Calculate medical tests charges
    $sql = "SELECT * FROM `claim_info` WHERE `SubCategory 1 Name` = '$type' AND `SubCategory 2 Name` = 'MedicalTest'";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $TestIncident = $row['PerIncident'];
    }

    // Calculate consultant fee charges
    $consultant = "SELECT * FROM `claim_info` WHERE `SubCategory 1 Name` = '$type' AND `SubCategory 2 Name` = 'ConsultantFee'";
    $consultant_res = mysqli_query($conn, $consultant);
    if ($consultant_res && mysqli_num_rows($consultant_res) > 0) {
        $row = mysqli_fetch_assoc($consultant_res);
        $consultantPrice = $row['PerIncident'];
    } else {
        $consultantPrice = 0;
    }

    // Get the Per Incident Price
    $incidentCost = "SELECT * FROM `claim_info` WHERE `SubCategory 1 Name` = '$type' AND `SubCategory 2 Name` = 'PerIncident'";
    $incident_res = mysqli_query($conn, $incidentCost);
    if ($incident_res && mysqli_num_rows($incident_res) > 0) {
        $row = mysqli_fetch_assoc($incident_res);
        $incident_cost = $row['PerIncident'];
    }

    // Get the Per Life Price
    $PerLifeCost = "SELECT * FROM `claim_info` WHERE `SubCategory 1 Name` = '$type' AND `SubCategory 2 Name` = 'PerLife'";
    $PerLife_res = mysqli_query($conn, $PerLifeCost);
    if ($PerLife_res && mysqli_num_rows($PerLife_res) > 0) {
        $row = mysqli_fetch_assoc($PerLife_res);
        $per_life_cost = $row['PerLife'];
    }

    // Get user info from the database according to the session
    $sql_usr = "SELECT * FROM `user_details` WHERE `NIC` = '{$_SESSION['nic']}'";
    $result_usr = mysqli_query($conn, $sql_usr);
    if ($result_usr && mysqli_num_rows($result_usr) > 0) {
        $row_usr = mysqli_fetch_assoc($result_usr);
        $usr_NIC = $row_usr['NIC'];
        $usr_Name = $row_usr['Name'];
    }

    // Get the limit based on the conditions
    $sql_limit = "
        SELECT uc.*, 
            CASE 
                WHEN ci.`CategoryName` = 'Hospitalization' AND `SubCategory 1 Name` = 'Government Aryuvedic Hospitalization' THEN 200000 
                WHEN ci.`CategoryName` = 'Hospitalization' THEN 350000 
                ELSE NULL 
            END AS `limit`
        FROM `user-claims` uc
        JOIN `claim_info` ci 
            ON uc.`type` = ci.`SubCategory 1 Name` OR uc.`type` = ci.`CategoryName`
        WHERE ci.`CategoryName` = 'Hospitalization'
        AND uc.`nic` = '$usr_NIC';
    ";

    $result_limit = mysqli_query($conn, $sql_limit);
    if ($result_limit && mysqli_num_rows($result_limit) > 0) {
        $row_limit = mysqli_fetch_assoc($result_limit);
        $limit = $row_limit['limit'];
    } else {
        $limit = null;
    }

    // Get Approved Previous claim Details
    $previous_claims = "SELECT * FROM `user-claims` WHERE `nic` = '$usr_NIC' AND `type` = '$type' AND `Claim_Status` = 'Approved'";
    $previous_claims_result = mysqli_query($conn, $previous_claims);

    $previous_claim_amount = 0;

    if ($previous_claims_result && mysqli_num_rows($previous_claims_result) > 0) {
        while ($row = mysqli_fetch_assoc($previous_claims_result)) {
            $previous_claim_amount += $row['total_cost'];
        }
    } else {
        $previous_claim_amount = 0;
    }

    // Compare the previous claims amount with the limit
    if ($limit !== null && $previous_claim_amount > $limit) {
        echo "<script>alert('The previous claims amount exceeds the limit of $limit');</script>";
    }
}
