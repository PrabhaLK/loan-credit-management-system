<?php
// Include necessary files
include('../config/db.php');  // Include database configuration if needed
// Include category functions if needed

// Get the type from query parameter if available, default to empty string
$type = isset($_GET['type']) ? $_GET['type'] : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.min.css" rel="stylesheet" />
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title><?php echo ($type); ?></title>
    <style>
        body {
            background-image: url('../images/back.jpg');
        }

        .Header {
            color: black;
            text-align: center;
            padding: 30px;
            font-size: 36px;
        }

        .form-section {
            margin-bottom: 20px;
        }

        .form-section p {
            margin: 0;
        }

        .form-section input {
            margin-top: 5px;
        }

        .total-costs {
            margin-top: 20px;
        }

        .right-sec {
            padding-top: 10%;
            padding-right: 2%;
        }

        .table-responsive {
            max-height: 50vh;
            overflow-y: auto;
        }
    </style>
    <script>
        $(document).ready(function() {
            // Function to calculate days between two dates
            function calculateDaysBetweenDates(startDate, endDate) {
                const oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds
                const firstDate = new Date(startDate);
                const secondDate = new Date(endDate);

                const diffDays = Math.round(Math.abs((firstDate - secondDate) / oneDay));
                return diffDays;
            }



             // Calculate room charges
        

            // Function to calculate total medical costs
            function calculateTotal() {
                let total = 0;
                $("input[name='medical_price[]']").each(function() {
                    total += parseFloat($(this).val()) || 0;
                });
                return total.toFixed(2);
            }

            // Function to calculate total test costs
            function calculateTestTotal() {
                let testTotal = 0;
                $("input[name='test_price[]']").each(function() {
                    testTotal += parseFloat($(this).val()) || 0;
                });
                return testTotal.toFixed(2);
            }

            // Event listener for date changes
            $("#startingDate, #endingDate").on('change', function() {
                const startDate = $("#startingDate").val();
                const endDate = $("#endingDate").val();

                // Validate if start date is ahead of end date
                if (startDate && endDate) {
                    const start = new Date(startDate);
                    const end = new Date(endDate);

                    if (start > end) {
                        Swal.fire({
                            title: "Start Date cannot be ahead of end date.",
                            text: "Please Check Date setup again.",
                            icon: "error"
                        });
                        $("#startingDate, #endingDate").val('');
                        $("input[name='number_of_dates[]']").val('');
                        return;
                    }

                    const numberOfDays = calculateDaysBetweenDates(startDate, endDate);
                    $("input[name='number_of_dates[]']").val(numberOfDays);

                    
                }
            });

            // Initial setup for existing dates if any
            const startDate = $("#startingDate").val();
            const endDate = $("#endingDate").val();
            if (startDate && endDate) {
                const numberOfDays = calculateDaysBetweenDates(startDate, endDate);
                $("input[name='number_of_dates[]']").val(numberOfDays);
            }

            // Function to update the total costs in the table
            function updateTable() {
                const totalCost = calculateTotal();
                const testTotalCost = calculateTestTotal();
                $("#total_cost_td").text(`Rs ${totalCost}`);
                $("#test_total_cost_td").text(`Rs ${testTotalCost}`);
            }

            // Event listener for adding medical items
            $(".add_item_btn").click(function(e) {
                e.preventDefault();
                var lastRow = $("#show_item").find('.form-section').last();
                $(lastRow).after(`
                    <div class="form-section row">
                        <div class="col-md-8">
                            <input type="number" name="medical_price[]" class="form-control" placeholder="Item price" required>
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-danger remove_item_btn">Remove</button>
                        </div>
                    </div>`);
                updateTable();
            });

            // Event listener for adding test items
            $(".add_test_btn").click(function(e) {
                e.preventDefault();
                var lastTestRow = $("#show_test").find('.form-section').last();
                $(lastTestRow).after(`
                    <div class="form-section row">
                        <div class="col-md-8">
                            <input type="number" name="test_price[]" class="form-control" placeholder="Test price" required>
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-danger remove_test_btn">Remove</button>
                        </div>
                    </div>`);
                updateTable();
            });

            // Event listener for removing medical items
            $(document).on('click', '.remove_item_btn', function(e) {
                e.preventDefault();
                $(this).closest('.form-section').remove();
                updateTable();
            });

            // Event listener for removing test items
            $(document).on('click', '.remove_test_btn', function(e) {
                e.preventDefault();
                $(this).closest('.form-section').remove();
                updateTable();
            });

            // Event listener for input change in medical prices
            $(document).on('input', "input[name='medical_price[]']", function() {
                updateTable();
            });

            // Event listener for input change in test prices
            $(document).on('input', "input[name='test_price[]']", function() {
                updateTable();
            });

            // Event listener for form submission
            $("#add_form").submit(function(e) {
                e.preventDefault();
                $("#add_btn").val('Adding....');
                $.ajax({
                    url: '../functions/sample.php',
                    method: 'post',
                    data: $(this).serialize(),
                    success: function(response) {
                        console.log(response);
                    }
                });
            });

            // Initial calculation of totals on page load
            updateTable();
        });
    </script>
</head>

<body><?php
        include('../functions/category-functions.php');


        
        ?>
    <div class="container">
        <div class="row">
            <!-- Left Section for Form -->
            <div class="col-md-6 left-sec">
                <div class="Header">
                    <?php echo ($type); ?>
                </div>
                <div class="left-up">
                    <div class="container">
                        <div class="row my-4">
                            <div class="col-lg-12 mx-auto">
                                <div class="card shadow">
                                    <div class="card-header">
                                        <h4> Add Items </h4>
                                    </div>
                                <form method="POST" id="add_form">
                                    <div class="card-body p-4">
                                        <!-- Section for adding govenment host method-->
                                        <?php if ($SubCategory1Name == "Government Hospitalization") : 
                                             include('./method/gove-host-meth.php');?>
                                        <?php endif ?>



                                        <!-- Section for adding Heart Surgery - Guarantee Bill Cost -->
                                        <?php if ($SubCategory1Name == "Heart Surgery - Guarantee") :  
                                            include('./method/hart-meth.php');?>
                                        <?php endif ?> 


                                        <!-- Section for adding governemnt Ayurvedic Bill Cost -->
                                        <?php if ($SubCategory1Name == "Government Ayuvedic Hospitalization") :  
                                            include('./method/gov-ayur-meth.php');?>
                                        <?php endif ?> 

                                                
                                              

                                             


                                           
                                            
                                            <!-- Submit Button -->
                                            <div class="row my-4">
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-primary" id="add_btn">Send Details</button>
                                                </div>
                                            </div>
                                            <!-- Total Costs Section -->
                                            <div class="total-costs row">
                                                <div class="col-md-12">
                                                    <h4>Total Cost of Treatments: Rs <span id="total_cost">0.00</span></h4>
                                                </div>
                                                <div class="col-md-12">
                                                    <h4>Total Cost of Tests: Rs <span id="test_total_cost">0.00</span></h4>
                                                </div>
                                            </div>
                                            </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Right Section for Displaying Results -->
            <div class="col-md-6 right-sec">


            <!-- Display Current Date                                -->
            <div>
            <b>The date : <?php echo date("m/d/y"); ?></b>
            </div>                               
            
            

            
                <div class="card">
                    <div class="table-responsive">
                        <!-- Table for displaying results -->
                        <table class="table table-bordered table-striped" id="result_table">
                            <thead>
                                <tr>
                                    
                                    <th>Discription</th>
                                    <th>Total Bill Cost</th>
                                
                                    <th>Total Cost of Room Charges</th>
                                    <th>Total Cost of Treatments</th>
                                    <th>Total Cost of Tests</th>
                                </tr>    
                            </thead>
                            <tbody>
                                <tr>
                                    <!-- Sample row for displaying data -->
                                    <td>John</td>
                                    <td>Doe</td>
                                    <td>johndoe@example.com</td>
                                    <td id="total_cost_td">Rs 0.00</td>
                                    <td id="test_total_cost_td">Rs 0.00</td>
                                </tr>
                                <!-- Data will be dynamically appended here by jQuery -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS, Popper.js, MDB UI Kit, and SweetAlert2 CDN Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7HUiUbX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.umd.min.js"></script>
    <!-- SweetAlert2 Notification Framework Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>