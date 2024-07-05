<?php
include('../config/db.php');

if(isset($_POST['submit'])){
    $date = $_POST['numberOfDates'];
    $Rcharges = $_POST['charges'];
    $SMTratment = $_POST['treatment'];
    $MTreatment = $_POST['medicalT'];

    // Escape and sanitize input variables (recommended)
    $date = mysqli_real_escape_string($conn, $date);
    $Rcharges = mysqli_real_escape_string($conn, $Rcharges);
    $SMTratment = mysqli_real_escape_string($conn, $SMTratment);
    $MTreatment = mysqli_real_escape_string($conn, $MTreatment);

    // SQL query with backticks around table name and proper variable names
    $query = "INSERT INTO `user-claim-bills` (Dates,RoomCharges, MTest, SMTratment) VALUES ('$date','$Rcharges', '$MTreatment', '$SMTratment')";

    // Execute the query
    $result = mysqli_query($conn, $query);

    // Check if query executed successfully
    if($result){
        echo "<script>alert('Data Inserted Successfully');</script>";
    } else {
        echo "<script>alert('There is an error');</script>";
    }
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Government Hospitalization</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    <style>
        .Header {
            color: black;
            text-align: center;
            padding: 15px;
            text-decoration: none;
            display: inline-block;
            font-size: 36px;
        }

        .NumberOfDates, .userIncident, .userMedicalTest {
            padding: 15px;
        }

        .index-table {
            padding-left: 100px;
            padding-right: 100px;
        }

        .total-price {
            padding-left: 60px;
            padding-right: 60px;
        }
    </style>

    <script>
        function room(value) {
            var roomCharges;
            roomCharges = value * 3000;

            // Validate room charges not exceeding 30000
            if (roomCharges > 30000) {
                alert('Room charges cannot exceed Rs. 30,000. Please enter a valid number of dates.');
                // Reset the input value to prevent exceeding the limit
                document.getElementById('numberOfDates').value = Math.floor(30000 / 3000);
                roomCharges = 30000;
            }

            document.getElementById('charges').value = roomCharges;
        }

        
                function incident(value) {
            // Validate surgical & medical treatment charges not exceeding 80000
            if (value > 80000) {
                alert('Surgical & Medical Treatment charges cannot exceed Rs. 80,000. Please enter a valid amount.');
                document.getElementById('treatment').value = 80000; // Set the value to 80000
            } else {
                document.getElementById('treatment').value = value;
            }
        }


       

        function test(value){
            // validation Medical Test charges not exceeding  40000

            if (value >40000){
                alert('Medical Test charges cannot exceed Rs. 40,000. Please enter a valid amount.');
                document.getElementById('medicalT').value = 40000; // Set the value to 40000
            }else{
                document.getElementById('medicalT').value = value;
            }
        }


        function cal() {
            var roomChargesCost = document.getElementById('charges').value;
            var treatmentCost = document.getElementById('treatment').value;
            var medicalTestCost = document.getElementById('medicalT').value;

            var totalPrice = parseInt(roomChargesCost) + parseInt(treatmentCost) + parseInt(medicalTestCost);

            document.getElementById('total').value = totalPrice;
        }
    </script>
</head>
<body>
    <div class="Header">
        <h1>Government Hospitalization</h1>
    </div>
    <form method="POST">
    <!-- User input dates-->
     
    <div class="NumberOfDates">
        <label for="inputEmail3" class="col-sm-2 control-label">Number of Dates</label>
        <input type="Number" id="numberOfDates" name ="numberOfDates" onkeyup="room(this.value)" class="form-control" placeholder="Enter Dates">
    </div>

    <!-- User input Incident Charges-->
    
    <div class="userIncident">
    <label for="inputEmail3" class="col-sm-2 control-label">Surgical & Medical Treatment</label>
    <input type="Number" class="form-control" onkeyup="incident(this.value)" placeholder="Enter Incident Charges">
</div>


    <!-- User input Medical Test Charges-->
    <div class="userMedicalTest">
        <label for="inputEmail3" class="col-sm-2 control-label">Medical Test</label>
        <input type="Number" class="form-control" onkeyup="test(this.value)" placeholder="Enter Test Charges">
    </div>

    <article class="index-table">
        
        <table class="table table-bordered">
            <tr>
                <td>NIC</td>
                <td><input type="text" id="nic"></td>
            </tr>
            
                <tr>
                    <td>Room Charges</td>
                    <td>Rs <input type="text" id="charges" name="charges"></td>
                </tr>
                <tr>
                    <td>Surgical & Medical Treatment</td>
                    <td>Rs <input type="text" id="treatment" name="treatment"></td>
                </tr>
                <tr>
                    <td>Medical Test</td>
                    <td>Rs <input type="text" id="medicalT" name="medicalT"></td>
                </tr>
                
            
        </table>
        
    </article>

    <div class="total">
        <button onclick="cal()" class="btn btn-primary" type="button">Calculate</button>
        <button type="Submit" name="submit" class="btn btn-primary">Insert </button>
        <label for="inputEmail3" class="col-sm-2 control-label">Total</label>
        <input type="text" class="total-price" id="total">

       
    </div>
    </form>
    
</body>
</html>
