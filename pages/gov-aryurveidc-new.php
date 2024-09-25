<?php
include('../config/db.php');

// Get the type from the URL parameter
$type = isset($_GET['type']) ? $_GET['type'] : '';

// Include the category functions once to fetch necessary data
include('../functions/category-functions.php');

if (isset($_POST['submit'])) {
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
    $query = "INSERT INTO `user-claim-bills` (Dates, RoomCharges, MTest, SMTratment) VALUES ('$date','$Rcharges', '$MTreatment', '$SMTratment')";

    // Execute the query
    $result = mysqli_query($conn, $query);

    // Check if query executed successfully
    if ($result) {
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
    <title>title</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    <style>
        .Header {
            color: black;
            text-align: center;
            padding: 30px;
            text-decoration: none;
            display: inline-block;
            font-size: 36px;
        }

        .NumberOfDates,
        .userIncident,
        .userMedicalTest {
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

        .total {
            padding-left: 60px;
            padding-right: 60px;
            padding: 25px;
        }

        body {
            background-image: url('../images/back.jpg');
        }
    </style>
    <script>
        function room(value) {
            var roomCharges;
            roomCharges = value * <?php echo ($PerDay); ?>;
            // Validate room charges not exceeding 30000
            if (roomCharges > <?php echo ($PerIncident); ?>) {
                alert('Room charges cannot exceed Rs. <?php echo ($PerIncident); ?>.00 Please enter a valid number of dates.');
                // Reset the input value to prevent exceeding the limit
                document.getElementById('numberOfDates').value = Math.floor(<?php echo ($PerIncident); ?> / <?php echo ($PerDay); ?>);
                roomCharges = <?php echo ($PerIncident); ?>;
            }
            document.getElementById('charges').value = roomCharges;
        }

        function incident(value) {
            // Validate surgical & medical treatment charges not exceeding incident Price
            if (value > <?php echo ($IncidentPrice); ?>) {
                alert('Surgical & Medical Treatment charges cannot exceed Rs.  <?php echo ($IncidentPrice); ?>. Please enter a valid amount.');
                document.getElementById('treatment').value = <?php echo ($IncidentPrice); ?>;
            } else {
                document.getElementById('treatment').value = value;
            }
        }

        function test(value) {
            // validation Medical Test charges not exceeding test Incident Price
            if (value > <?php echo ($TestIncident); ?>) {
                alert('Medical Test charges cannot exceed Rs. <?php echo ($TestIncident); ?>.00 Please enter a valid amount.');
                document.getElementById('medicalT').value = <?php echo ($TestIncident); ?>; // Set the value to 40000
            } else {
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
        <?php echo ($type); ?>
    </div>
    <form method="POST">
        <!-- User input dates-->
        <div class="NumberOfDates">
            <label for="numberOfDates" class="col-sm-2 control-label">Number of Dates</label>
            <input type="Number" id="numberOfDates" style="width: 250px;" name="numberOfDates" onkeyup="room(this.value)" class="form-control" placeholder="Enter Dates">
        </div>
        <!-- User input Incident Charges-->
        <div class="userIncident">
            <label for="treatment" class="col-sm-2 control-label">Surgical & Medical Treatment</label>
            <input type="Number" class="form-control" style="width: 250px;" onkeyup="incident(this.value)" placeholder="Enter Incident Charges">
        </div>
        <!-- User input Medical Test Charges-->
        <div class="userMedicalTest">
            <label for="medicalT" class="col-sm-2 control-label">Medical Test</label>
            <input type="Number" class="form-control" style="width: 250px;" onkeyup="test(this.value)" placeholder="Enter Test Charges">
        </div>
        <article class="index-table">
            <table class="table table-bordered">
                <tr>
                    <td>NIC</td>
                    <td><input type="text" id="nic" name="nic"></td>
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
            <button type="Submit" name="submit" class="btn btn-success">Insert</button>
            <div>
                <label for="total" class="total">Total</label>
                <input type="text" class="total-price" id="total" name="total">
            </div>
        </div>
    </form>
</body>

</html>