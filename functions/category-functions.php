<?php
include('../config/db.php');
include('../config/headers.php');

// Ensure the type is set
if (!empty($type)) {

    // Fetch the necessary data based on the type
    $sql = "SELECT * FROM `claim_info` WHERE `SubCategory 1 Name` = '$type' OR `CategoryName` = '$type'";
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
    // Fetch limits for subcategories
    $sql_hospitalization = "SELECT PerYear FROM `claim_info` WHERE `CategoryName` = 'Hospitalization'";
    $result_hospitalization = mysqli_query($conn, $sql_hospitalization);
    if ($result_hospitalization && mysqli_num_rows($result_hospitalization) > 0) {
        $row_hospitalization = mysqli_fetch_assoc($result_hospitalization);
        $PerYear = $row_hospitalization['PerYear'];
    }

    $sql_ayurvedic = "SELECT PerYear FROM `claim_info` WHERE `CategoryName` = '$CategoryName' AND `SubCategory 1 Name` = 'Private Ayuvedic Hospitalization'";
    $result_ayurvedic = mysqli_query($conn, $sql_ayurvedic);
    if ($result_ayurvedic && mysqli_num_rows($result_ayurvedic) > 0) {
        $row_ayurvedic = mysqli_fetch_assoc($result_ayurvedic);
        $AyurvedicLimit = $row_ayurvedic['PerYear'];
    } else {
        $AyurvedicLimit = 0; // Default limit if not found in the database
    }

    // Calculate Medical Treatments charges for the hospitals
    $sql = "SELECT * FROM `claim_info` WHERE `SubCategory 1 Name` = '$type' AND `SubCategory 2 Name` = 'MedicalTreatment'";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result); // Fetch the result row
        $IncidentPrice = $row['PerIncident'];
    }

    // Calculate medical treatments charges for the Hospitals
    $sql = "SELECT * FROM `claim_info` WHERE `SubCategory 1 Name` = '$type' AND `SubCategory 2 Name` = 'MedicalTest'";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result); // Fetch the result row
        $TestIncident = $row['PerIncident'];
    }

    // Calculate consultant fee charges for the hospitals
    $consultant = "SELECT * FROM `claim_info` WHERE `SubCategory 1 Name` = '$type' AND `SubCategory 2 Name` = 'ConsultantFee'";
    $consultant_res = mysqli_query($conn, $consultant);
    if ($consultant_res && mysqli_num_rows($consultant_res) > 0) {
        $row = mysqli_fetch_assoc($consultant_res); // Fetch the result row
        $consultantPrice = $row['PerIncident'];
    } else {
        $consultantPrice = 0;
    }

    // Get the Per incident Price for One Time Items
    $incidentCost = "SELECT * FROM `claim_info` WHERE `SubCategory 1 Name` = '$type' AND `SubCategory 2 Name` = 'PerIncident'";
    $incident_res = mysqli_query($conn, $incidentCost);
    if ($incident_res && mysqli_num_rows($incident_res) > 0) {
        $row = mysqli_fetch_assoc($incident_res);
        $incident_cost = $row['PerIncident'];
    }

    // Get the Per Life Price for One Time Items
    $PerLifeCost = "SELECT * FROM `claim_info` WHERE `SubCategory 1 Name` = '$type' AND `SubCategory 2 Name` = 'PerLife'";
    $PerLife_res = mysqli_query($conn, $PerLifeCost);
    if ($PerLife_res && mysqli_num_rows($PerLife_res) > 0) {
        $row = mysqli_fetch_assoc($PerLife_res);
        $per_life_cost = $row['PerLife'];
    }

    // Get user info from the database according to the session
    $sql_usr = "SELECT * FROM `user_details` WHERE `NIC` = '{$_SESSION['claimholder_nic']}'";
    $result_usr = mysqli_query($conn, $sql_usr);
    if ($result_usr && mysqli_num_rows($result_usr) > 0) {
        $row_usr = mysqli_fetch_assoc($result_usr);
        $usr_NIC = $row_usr['NIC'];
        $usr_Name = $row_usr['Name'];
    }

    // Get Approved Previous claim Details for the current year
    // Initialize variables for claim amounts
    $previous_claim_amount = 0;
    $previous_ayurvedic_claim_amount = 0;
    $currentYear = date('Y');
    $currentBalance = 0;

    if ($CategoryName === 'Hospitalization') {
        // Calculate the total approved claims for Hospitalization within the current year
        $previous_claims = "SELECT `total_cost`, `claim_date` FROM `user-claims` WHERE `nic` = '$usr_NIC' AND `category` = '$CategoryName' AND `Claim_Status` = 'Approved'";
        $previous_claims_result = mysqli_query($conn, $previous_claims);
        if ($previous_claims_result && mysqli_num_rows($previous_claims_result) > 0) {
            while ($row = mysqli_fetch_assoc($previous_claims_result)) {
                $claimYear = date('Y', strtotime($row['claim_date']));
                if ($claimYear == $currentYear) {
                    $previous_claim_amount += $row['total_cost'];
                }
            }
        }

        // Fetch approved claims for Ayurvedic Hospitalization within the current year

        $sql_ayurvedic_claims = "SELECT `total_cost`, `claim_date` FROM `user-claims` WHERE `nic` = '$usr_NIC' AND `type` ='Private Ayuvedic Hospitalization' AND `Claim_Status` = 'Approved'";
        $res_ayurvedic_claims = mysqli_query($conn, $sql_ayurvedic_claims);
        if ($res_ayurvedic_claims && mysqli_num_rows($res_ayurvedic_claims) > 0) {
            while ($row = mysqli_fetch_assoc($res_ayurvedic_claims)) {
                $claimYear = date('Y', strtotime($row['claim_date']));
                if ($claimYear == $currentYear) {
                    $previous_ayurvedic_claim_amount += $row['total_cost'];
                }
            }
        }
        if ($type == 'Private Ayuvedic Hospitalization') {
            $currentBalance = min(
                $AyurvedicLimit - $previous_ayurvedic_claim_amount,
                $PerYear - $previous_claim_amount
            );
        } else {
            $currentBalance = $PerYear - $previous_claim_amount;
        }
    } elseif ($CategoryName == 'Spectacles') {
        // Calculate the total approved claims for Spectacles within the last 3 years
        $threeYearsAgo = date('Y-m-d', strtotime('-3 years'));
        $previous_claims = "SELECT `total_cost`, `claim_date` FROM `user-claims` WHERE `nic` = '$usr_NIC' AND `category` = '$CategoryName' AND `Claim_Status` = 'Approved'";
        $previous_claims_result = mysqli_query($conn, $previous_claims);
        if ($previous_claims_result && mysqli_num_rows($previous_claims_result) > 0) {
            while ($row = mysqli_fetch_assoc($previous_claims_result)) {
                $claimDate = date('Y-m-d', strtotime($row['claim_date']));
                if ($claimDate >= $threeYearsAgo) {
                    $previous_claim_amount += $row['total_cost'];
                } else {
                    echo "<script>alert('No data found for the specified type');</script>.$claimDate __ $threeYearsAgo";
                }
            }
        }
        // Query to fetch the claimed amount for "Spectacles"
        $sql_spectacle_claims = "SELECT total_cost FROM `user-claims` WHERE `nic` = '$usr_NIC' AND `category` = 'Spectacles' AND `Claim_Status` = 'Approved' AND  `claim_date` >= '$threeYearsAgo'";
        $result_spectacles = mysqli_query($conn, $sql_spectacle_claims);

        if ($result_spectacles && mysqli_num_rows($result_spectacles) > 0) {
            $row_spec = mysqli_fetch_assoc($result_spectacles);
            $claimedAmount = $row_spec['total_cost'];
        }
    } else {
        // For other categories, calculate the total approved claims without any yearly or periodic limit
        $previous_claims = "SELECT `total_cost` FROM `user-claims` WHERE `nic` = '$usr_NIC' AND `category` = '$CategoryName' AND `Claim_Status` = 'Approved'";
        $previous_claims_result = mysqli_query($conn, $previous_claims);
        if ($previous_claims_result && mysqli_num_rows($previous_claims_result) > 0) {
            while ($row = mysqli_fetch_assoc($previous_claims_result)) {
                $previous_claim_amount += $row['total_cost'];
            }
        }
        $currentBalance = $PerLife - $previous_claim_amount;
        if ($currentBalance == 0) {
            $currentBalance = $PerLife;
        }
    }
    $sql_childbirthClaimsCount = "SELECT COUNT(*) as claim_count FROM `user-claims` WHERE `NIC` = ? AND `category` = 'Child Birth' AND `Claim_Status` = 'Approved'";
    $stmt = $conn->prepare($sql_childbirthClaimsCount);
    $stmt->bind_param("i", $usr_NIC);
    $stmt->execute();
    $childBirthClaimsCount_result = $stmt->get_result();
    $row = $childBirthClaimsCount_result->fetch_assoc();
    $claimCount = $row['claim_count'];

    // Check if the claim count is greater than or equal to 2
    if ($CategoryName == "Child Birth" && $claimCount >= 2) {
        // Store the error message in the session for use in the HTML/JavaScript
        $_SESSION['childbirth_error'] = "You have exceeded the maximum allowed claims for Childbirth. You cannot submit more than 2 claims.";
    } else {
        // If under the limit, proceed as normal
        unset($_SESSION['childbirth_error']);
    }

    // Close the statement
    $stmt->close();

    $sql = "SELECT * FROM `claim_info` WHERE `SubCategory 1 Name` = '$type' OR `CategoryName`= '$type'";
    $result = mysqli_query($conn, $sql);

    //  sql query for selecting drodown menu items 
    $query_select = "SELECT id, claim_description FROM claim_description";
    $result_select = mysqli_query($conn, $query_select);

    // Check if the query was successful
    if (!$result_select) {
        die("Query Failed: " . mysqli_error($conn));
    }
}
