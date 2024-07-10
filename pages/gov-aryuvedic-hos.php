<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Government Ayurvedic Hospitalization</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    <style>

        .body{
          background-image:url('../images/back.jpg');  
        }  
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

        
        function cal() {
            var roomChargesCost = document.getElementById('charges').value;
            

            var totalPrice = parseInt(roomChargesCost);

            document.getElementById('total').value = totalPrice;
        }
    </script>
</head>
<body>
    <div class="Header">
        <h1>Government aryuvedic Hospitalization</h1>
    </div>

    <!-- User input dates-->
    <div class="NumberOfDates">
        <label for="inputEmail3" class="col-sm-2 control-label">Number of Dates</label>
        <input type="Number" id="numberOfDates" onkeyup="room(this.value)" class="form-control" placeholder="Enter Dates">
    </div>

    
    <article class="index-table">
        <table class="table table-bordered">
            <tr>
                <td>NIC</td>
                <td><input type="text" id="nic"></td>
            </tr>
            <tr>
                <td>Room Charges</td>
                <td>Rs <input type="text" id="charges"></td>
            </tr>
            
        </table>
    </article>

    <div class="total">
        <button onclick="cal()" class="btn btn-primary" type="submit">Calculate</button>
        <label for="inputEmail3" class="col-sm-2 control-label">Total</label>
        <input type="text" class="total-price" id="total">
    </div>
</body>
</html>
