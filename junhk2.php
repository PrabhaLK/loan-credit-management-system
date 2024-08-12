get my whole code;
Can you implent This Thing on the code ; 
While Calclulating The Previous Cal Amount, Get The Approved Previous Cal  Amount (total) Which was past Year ( In  a Year Range ) Which is approved, 
and, Which is under, which belongs to the correspomnding id and the if the Category of the Claim-info belongs to Hospitalization, Get The Calculation Within a Year , and if the Category is Equal to 
Spectacles then Calcluate the claim for past 3 years which has been approved.   

Use The Script and the Category-function.php as needed. 

The Whole code for Category-functions.php has been refered as follows. 
<?php
include('../config/db.php');


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
    $sql_usr = "SELECT * FROM `user_details` WHERE `NIC` = '{$_SESSION['nic']}'";
    $result_usr = mysqli_query($conn, $sql_usr);
    if ($result_usr && mysqli_num_rows($result_usr) > 0) {
        $row_usr = mysqli_fetch_assoc($result_usr);
        $usr_NIC = $row_usr['NIC'];
        $usr_Name = $row_usr['Name'];
    }

    // Get Approved Previous claim Details
    $previous_claim_amount = 0;
    $previous_ayurvedic_claim_amount = 0;

    $sql_ayurvedic_claims = "SELECT `total_cost`  FROM `user-claims` WHERE `nic` = '$usr_NIC' AND `type` ='Private Ayuvedic Hospitalization'AND `Claim_Status` = 'Approved'";
    $res_ayurvedic_claims = mysqli_query($conn, $sql_ayurvedic_claims);
    if ($res_ayurvedic_claims && mysqli_num_rows($res_ayurvedic_claims) > 0) {
        while ($row = mysqli_fetch_assoc($res_ayurvedic_claims)) {
            $previous_ayurvedic_claim_amount += $row['total_cost'];
        }
    }
    $previous_claims = "SELECT * FROM `user-claims` WHERE `nic` = '$usr_NIC' AND `category` = '$CategoryName' AND `Claim_Status` = 'Approved'";
    $previous_claims_result = mysqli_query($conn, $previous_claims);

    if ($previous_claims_result && mysqli_num_rows($previous_claims_result) > 0) {
        while ($row = mysqli_fetch_assoc($previous_claims_result)) {
            $ClaimSubtype = $row['type'];
            $previous_claim_amount += $row['total_cost'];
        }
    }
    $sql = "SELECT * FROM `claim_info` WHERE `SubCategory 1 Name` = '$type' OR `CategoryName`= '$type'";
    $result = mysqli_query($conn, $sql);

    //Function to get the current year
    function getCurrentYear()
    {
        $currentYear = date('Y');
        return $currentYear;

    }
    function handleClaim($nic, $type, ){

    }
}
