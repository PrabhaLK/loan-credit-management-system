<?php
// Include necessary files
include('../config/db.php');  // Include database configuration if needed

// Get the type from query parameter if available, default to empty string
$type = isset($_GET['type']) ? $_GET['type'] : '';
session_start()
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

        .logo-container {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 10px;
        }

        .logo {
            width: 300px;
            height: auto;
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
                const totalCost = parseFloat(calculateTotal());
                const testTotalCost = parseFloat(calculateTestTotal());
                const totalSum = totalCost + testTotalCost;
                $("#total_cost").text(totalCost.toFixed(2));
                $("#test_total_cost").text(testTotalCost.toFixed(2));
                $("#InitialCost").text(totalSum.toFixed(2));

                // Update the total bill cost in the result table
                $("#result_table tbody tr").each(function() {
                    const row = $(this);
                    row.find("#total_cost").text('Rs ' + totalCost.toFixed(2));
                    row.find("#test_total_cost").text('Rs ' + testTotalCost.toFixed(2));
                    row.find("#InitialCost").text('Rs ' + totalSum.toFixed(2));
                });
            }

            // Event listener for adding medical items
            $(".add_item_btn").click(function(e) {
                e.preventDefault();
                var lastRow = $("#show_item").find('.form-section').last();
                $(lastRow).after(`
                    <div class="form-section row">
                        <div class="col-md-8">
                            <input type="number" name="medical_price[]" class="form-control" placeholder="Add More" required>
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

            // Function to validate number inputs
            function validateNumberInput(element) {
                element.value = element.value.replace(/[^0-9.]/g, ''); // Remove any non-numeric characters
                if (element.value < 0) {
                    element.value = 0; // Ensure no negative values
                }
            }

            // Event listener for number input validation
            $(document).on('input', '.validate-number', function() {
                validateNumberInput(this);
            });

            // Apply validation on initial load for any pre-existing inputs
            $('.validate-number').each(function() {
                validateNumberInput(this);
            });
        });
    </script>
</head>

<body><?php
        include('../functions/category-functions.php');
        ?>

    <!-- NITF logo added -->
    <div class="logo-container">
        <img class="logo" src="../images/logo.png" alt="Logo">
    </div>
    <div class="container">
        <div class="row">
            <!-- Left Section for Form -->
            <div class="col-md-6 left-sec">
                <div class="Header">
                    <?php echo ($type); ?>
                    <!-- <?php echo ($usr_NIC) ?> -->
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
                                            <?php if ($SubCategory1Name == "Government Hospitalization") : ?>

                                                <!-- include('./method/gove-host-meth.php'); ?> -->
                                                <div class="form-section row">
                                                    <div class="col-md-8">
                                                        <p>Number of Dates</p>
                                                        <!-- Input for number of dates (readonly) -->
                                                        <input type="number" name="number_of_dates[]" class="form-control" placeholder="Number of Dates" required readonly>
                                                    </div>
                                                    <!-- Date Pickers for selecting date period -->
                                                    <div class="row">
                                                        <div class="col-md-6 mb-4">
                                                            <div class="md-form">
                                                                <input placeholder="Select starting date" type="date" id="startingDate" name="startingDate">
                                                                <label for="startingDate">Start Date</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-4">
                                                            <div class="md-form">
                                                                <input placeholder="Select ending date" type="date" id="endingDate" name="endingDate">
                                                                <label for="endingDate">End Date</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Section for adding medical items -->
                                                <div id="show_item">
                                                    <div class="form-section row">
                                                        <div class="col-md-8">
                                                            <p>Surgical and Medical Treatments</p>
                                                            <input type="number" name="medical_price[]" class="form-control validate-number" placeholder="Cost for surgical and medical treatments" required>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <button type="button" class="btn btn-success add_item_btn">Add More</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Section for adding test items -->
                                                <div id="show_test">
                                                    <div class="form-section row">
                                                        <div class="col-md-8">
                                                            <p>Medical tests</p>
                                                            <input type="number" name="test_price[]" class="form-control validate-number" placeholder="Enter costs for medical tests" required>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <button type="button" class="btn btn-success add_test_btn">Add More</button>
                                                        </div>
                                                    </div>
                                                </div>
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
                                                        <h4>Total Cost of Treatments: Rs <span id="total_cost">0.00</span></h4>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <h4>Total Cost of Tests: Rs <span id="test_total_cost">0.00</span></h4>
                                                    </div>
                                                    <!-- <div class="col-md-12">
                                                    <h4>Total Cost of Claim: Rs <span id="InitialCost">0.00</span></h4>
                                                </div> -->
                                                </div>
                                    </form>
                                <?php endif ?>
                                <!-- Section for adding Heart Surgery - Guarantee Bill Cost -->
                                <?php if ($SubCategory1Name == "Heart Surgery - Guarantee") : ?>
                                    <!--// include('./method/hart-meth.php'); ?> -->

                                    <div class="form-section row">
                                        <!-- Section for adding Surgery Bill Cost -->
                                        <div id="show_item">
                                            <div class="form-section row">
                                                <div class="col-md-8">
                                                    <p>Surgery Bill Cost</p>
                                                    <input type="number" name="Surgery_price[]" class="form-control" placeholder="Surgery Treatment price" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="button" class="btn btn-success add_item_btn">Add More</button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Section for adding RF Ablation cost -->
                                        <div id="show_item">
                                            <div class="form-section row">
                                                <div class="col-md-8">
                                                    <p>RF Ablation Treatments Cost</p>
                                                    <input type="number" name="RF_Ablation[]" class="form-control" placeholder="RF Ablation  Treatment price" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="button" class="btn btn-success add_item_btn">Add More</button>
                                                </div>
                                            </div>
                                        </div>
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
                                    </div>
                                    </form>
                                <?php endif ?>

                                <!-- Section for adding governemnt Ayurvedic Bill Cost -->
                                <?php if ($SubCategory1Name == "Government Ayuvedic Hospitalization") : ?>

                                    <div class="form-section row">
                                        <div class="col-md-8">
                                            <p>Number of Dates</p>

                                            <!-- Input for number of dates (readonly) -->
                                            <input type="number" name="number_of_dates[]" class="form-control" placeholder="Number of Dates" max="10" required readonly>
                                        </div>
                                        <!-- Date Pickers for selecting date period -->
                                        <div class="row">
                                            <div class="col-md-6 mb-4">
                                                <div class="md-form">
                                                    <input placeholder="Select starting date" type="date" id="startingDate" name="startingDate">
                                                    <label for="startingDate">Start Date</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <div class="md-form">
                                                    <input placeholder="Select ending date" type="date" id="endingDate" name="endingDate">
                                                    <label for="endingDate">End Date</label>
                                                </div>
                                            </div>

                                            <!-- Section for adding medical items -->
                                            <div id="show_item">
                                                <div class="form-section row">
                                                    <div class="col-md-8">
                                                        <p>Surgical and Medical Treatments</p>
                                                        <input type="number" name="medical_price[]" class="form-control" placeholder="Treatment price" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <button type="button" class="btn btn-success add_item_btn">Add More</button>
                                                    </div>
                                                </div>

                                                <!-- Section for adding test items -->
                                                <div id="show_test">
                                                    <div class="form-section row">
                                                        <div class="col-md-8">
                                                            <p>Medical tests</p>
                                                            <input type="number" name="test_price[]" class="form-control" placeholder="Test price" required>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <button type="button" class="btn btn-success add_test_btn">Add More</button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Section for adding medical items -->
                                                <div id="show_item">
                                                    <div class="form-section row">
                                                        <div class="col-md-8">
                                                            <p>Consultant Fee</p>
                                                            <input type="number" name="consultant_price[]" class="form-control" placeholder="Consultant price" required>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <button type="button" class="btn btn-success add_item_btn">Add More</button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div><!-- Submit Button -->
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
                                        </div>

                                    </div>
                                    </form>
                                <?php endif ?>
                                <!-- Section for adding Private Ayurvedic Bill Cost -->
                                <?php if ($SubCategory1Name == "Private Hospitalization") : ?>
                                    <div class="form-section row">
                                        <div class="col-md-8">
                                            <p>Number of Dates</p>

                                            <!-- Input for number of dates (readonly) -->
                                            <input type="number" name="number_of_dates[]" class="form-control" placeholder="Number of Dates" max="10" required readonly>
                                        </div>
                                        <!-- Date Pickers for selecting date period -->
                                        <div class="row">
                                            <div class="col-md-6 mb-4">
                                                <div class="md-form">
                                                    <input placeholder="Select starting date" type="date" id="startingDate" name="startingDate">
                                                    <label for="startingDate">Start Date</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <div class="md-form">
                                                    <input placeholder="Select ending date" type="date" id="endingDate" name="endingDate">
                                                    <label for="endingDate">End Date</label>
                                                </div>
                                            </div>

                                            <!-- Section for adding medical items -->
                                            <div id="show_item">
                                                <div class="form-section row">
                                                    <div class="col-md-8">
                                                        <p>Surgical and Medical Treatments</p>
                                                        <input type="number" name="medical_price[]" class="form-control" placeholder="Treatment price" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <button type="button" class="btn btn-success add_item_btn">Add More</button>
                                                    </div>
                                                </div>

                                                <!-- Section for adding test items -->
                                                <div id="show_test">
                                                    <div class="form-section row">
                                                        <div class="col-md-8">
                                                            <p>Medical tests</p>
                                                            <input type="number" name="test_price[]" class="form-control" placeholder="Test price" required>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <button type="button" class="btn btn-success add_test_btn">Add More</button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Section for adding medical items -->
                                                <div id="show_item">
                                                    <div class="form-section row">
                                                        <div class="col-md-8">
                                                            <p>Consultant Fee</p>
                                                            <input type="number" name="consultant_price[]" class="form-control" placeholder="Consultant price" required>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <button type="button" class="btn btn-success add_item_btn">Add More</button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
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
                                    </div>

                                    </form>

                                <?php endif ?>
                                <!-- Section for adding Death Bill Cost -->
                                <?php if ($SubCategory1Name == "Kidney Surgery") : ?>
                                    <!-- Section for adding test items -->
                                    <div id="show_test">
                                        <div class="form-section row">
                                            <div class="col-md-8">
                                                <p>Kidney Surgery</p>
                                                <input type="number" name="test_price[]" class="form-control validate-number" placeholder="Enter costs for Kidney Surgery Bill Cost" required>
                                            </div>
                                            <div class="col-md-4">
                                                <button type="button" class="btn btn-success add_test_btn">Add More</button>
                                            </div>
                                        </div>
                                    </div>
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


                                <?php endif ?>
                                <!-- Section for adding Death Bill Cost -->
                                <?php if ($SubCategory1Name == "Kidney Surgery - Guarantee") : ?>
                                    <!-- Section for adding test items -->
                                    <div id="show_test">
                                        <div class="form-section row">
                                            <div class="col-md-8">
                                                <p>Kidney Surgery - Guarantee</p>
                                                <input type="number" name="test_price[]" class="form-control validate-number" placeholder="Enter costs for Kidney Surgery - Guarantee Bill Cost" required>
                                            </div>
                                            <div class="col-md-4">
                                                <button type="button" class="btn btn-success add_test_btn">Add More</button>
                                            </div>
                                        </div>
                                    </div>
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
                                <?php endif ?>



                                <!-- Section for adding Death Bill Cost -->
                                <?php if ($SubCategory1Name == "Natural Death") : ?>
                                    <!-- Section for adding test items -->
                                    <div id="show_test">
                                        <div class="form-section row">
                                            <div class="col-md-8">
                                                <p>Natural Death</p>
                                                <input type="number" name="test_price[]" class="form-control validate-number" placeholder="Enter costs for Natural Death" required>
                                            </div>
                                            <div class="col-md-4">
                                                <button type="button" class="btn btn-success add_test_btn">Add More</button>
                                            </div>
                                        </div>
                                    </div>
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
                                <?php endif ?>

                                <!-- Section for adding Private Ayurvedic  Bill Cost -->
                                <?php if ($SubCategory1Name == "Private Ayuvedic Hospitalization") : ?>
                                    <div class="form-section row">
                                        <div class="col-md-8">
                                            <p>Number of Dates</p>

                                            <!-- Input for number of dates (readonly) -->
                                            <input type="number" name="number_of_dates[]" class="form-control" placeholder="Number of Dates" max="10" required readonly>
                                        </div>
                                        <!-- Date Pickers for selecting date period -->
                                        <div class="row">
                                            <div class="col-md-6 mb-4">
                                                <div class="md-form">
                                                    <input placeholder="Select starting date" type="date" id="startingDate" name="startingDate">
                                                    <label for="startingDate">Start Date</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <div class="md-form">
                                                    <input placeholder="Select ending date" type="date" id="endingDate" name="endingDate">
                                                    <label for="endingDate">End Date</label>
                                                </div>
                                            </div>

                                            <!-- Section for adding medical items -->
                                            <div id="show_item">
                                                <div class="form-section row">
                                                    <div class="col-md-8">
                                                        <p>Surgical and Medical Treatments</p>
                                                        <input type="number" name="medical_price[]" class="form-control" placeholder="Treatment price" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <button type="button" class="btn btn-success add_item_btn">Add More</button>
                                                    </div>
                                                </div>

                                                <!-- Section for adding test items -->
                                                <div id="show_test">
                                                    <div class="form-section row">
                                                        <div class="col-md-8">
                                                            <p>Medical tests</p>
                                                            <input type="number" name="test_price[]" class="form-control" placeholder="Test price" required>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <button type="button" class="btn btn-success add_test_btn">Add More</button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Section for adding medical items -->
                                                <div id="show_item">
                                                    <div class="form-section row">
                                                        <div class="col-md-8">
                                                            <p>Consultant Fee</p>
                                                            <input type="number" name="consultant_price[]" class="form-control" placeholder="Consultant price" required>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <button type="button" class="btn btn-success add_item_btn">Add More</button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
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

                                    </div>
                                    </form>
                                <?php endif ?>

                                <!-- Section for adding Cancer hospital  Bill Cost -->
                                <?php if ($SubCategory1Name == "Cancer") :
                                    // include('./method/cancer-meth.php'); 
                                ?>

                                    <form method="POST" id="add_form">

                                        <!-- Section for adding Cancer bill -->
                                        <div id="show_test">
                                            <div class="form-section row">
                                                <div class="col-md-8">
                                                    <p>Cancer Hospital Bill</p>
                                                    <input type="number" name="test_price[]" class="form-control validate-number" placeholder="Enter costs for Cancer hospital Bill" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="button" class="btn btn-success add_test_btn">Add More</button>
                                                </div>
                                            </div>
                                        </div>
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


                                <?php endif ?>

                                <!-- Section for adding knee hospital  Bill Cost -->
                                <?php if ($SubCategory1Name == "Knee") :
                                    // include('./method/cancer-meth.php'); 
                                ?>

                                    <form method="POST" id="add_form">

                                        <!-- Section for adding Knee bill -->
                                        <div id="show_test">
                                            <div class="form-section row">
                                                <div class="col-md-8">
                                                    <p>Knee Hospital Bill</p>
                                                    <input type="number" name="test_price[]" class="form-control validate-number" placeholder="Enter costs for Knee hospital Bill" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="button" class="btn btn-success add_test_btn">Add More</button>
                                                </div>
                                            </div>
                                        </div>
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

                                <?php endif ?>

                                <!-- Section for adding Accident Cost -->
                                <?php if ($SubCategory1Name == "Accident") :
                                    // include('./method/cancer-meth.php'); 
                                ?>

                                    <form method="POST" id="add_form">

                                        <!-- Section for adding Cancer bill -->
                                        <div id="show_test">
                                            <div class="form-section row">
                                                <div class="col-md-8">
                                                    <p>Accident Bill</p>
                                                    <input type="number" name="test_price[]" class="form-control validate-number" placeholder="Enter costs for Accident " required>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="button" class="btn btn-success add_test_btn">Add More</button>
                                                </div>
                                            </div>
                                        </div>
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


                                <?php endif ?>

                                <!-- Section for adding Accident Death Cost -->
                                <?php if ($SubCategory1Name == "Accidental Death") :
                                    // include('./method/cancer-meth.php'); 
                                ?>

                                    <form method="POST" id="add_form">

                                        <!-- Section for adding Cancer bill -->
                                        <div id="show_test">
                                            <div class="form-section row">
                                                <div class="col-md-8">
                                                    <p>Accidental Death Bill</p>
                                                    <input type="number" name="test_price[]" class="form-control validate-number" placeholder="Enter costs for Accidental Death" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="button" class="btn btn-success add_test_btn">Add More</button>
                                                </div>
                                            </div>
                                        </div>
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

                                <?php endif ?>

                                <!-- Section for adding Hip Cost -->
                                <?php if ($SubCategory1Name == "Hip") :
                                    // include('./method/cancer-meth.php'); 
                                ?>

                                    <form method="POST" id="add_form">

                                        <!-- Section for adding Hearing Aid bill -->
                                        <div id="show_test">
                                            <div class="form-section row">
                                                <div class="col-md-8">
                                                    <p>Hip Bill</p>
                                                    <input type="number" name="test_price[]" class="form-control validate-number" placeholder="Enter costs for Hip" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="button" class="btn btn-success add_test_btn">Add More</button>
                                                </div>
                                            </div>
                                        </div>
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

                                <?php endif ?>

                                <!-- Section for adding RF Ablation Cost -->
                                <?php if ($SubCategory1Name == "RF Ablation") :
                                    // include('./method/cancer-meth.php'); 
                                ?>

                                    <form method="POST" id="add_form">

                                        <!-- Section for adding Hearing Aid bill -->
                                        <div id="show_test">
                                            <div class="form-section row">
                                                <div class="col-md-8">
                                                    <p>RF Ablation Bill</p>
                                                    <input type="number" name="test_price[]" class="form-control validate-number" placeholder="Enter costs for RF Ablation" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="button" class="btn btn-success add_test_btn">Add More</button>
                                                </div>
                                            </div>
                                        </div>
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

                                <?php endif ?>

                                <!-- Section for adding Accident Death Cost -->
                                <?php if ($SubCategory1Name == "Hearing Aid") :
                                    // include('./method/cancer-meth.php'); 
                                ?>

                                    <form method="POST" id="add_form">

                                        <!-- Section for adding Hearing Aid bill -->
                                        <div id="show_test">
                                            <div class="form-section row">
                                                <div class="col-md-8">
                                                    <p>Hearing Aid Bill</p>
                                                    <input type="number" name="test_price[]" class="form-control validate-number" placeholder="Enter costs for Hearing Aid" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="button" class="btn btn-success add_test_btn">Add More</button>
                                                </div>
                                            </div>
                                        </div>
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

                                <?php endif ?>

                                <!-- Section for adding Cancer hospital  Bill Cost -->
                                <?php if ($SubCategory1Name == "Spectacles") :
                                    // include('./method/spectacels-meth.php');
                                ?>
                                    <form method="POST" id="add_form">
                                        <div id="show_test">
                                            <div class="form-section row">
                                                <div class="col-md-8">
                                                    <p>Sectacels Bill Cost</p>
                                                    <input type="number" name="test_price[]" class="form-control validate-number" placeholder="Enter Spectacles Bill Cost" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="button" class="btn btn-success add_test_btn">Add More</button>
                                                </div>
                                            </div>
                                        </div>
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

                                <?php endif ?>

                                <!-- Submit Button -->
                                <!-- <div class="row my-4">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary" id="add_btn">Send Details</button>
                                            </div>
                                        </div> -->
                                <!-- Total Costs Section -->
                                <!-- <div class="total-costs row">
                                            <div class="col-md-12">
                                                <h4>Total Cost of Treatments: Rs <span id="total_cost">0.00</span></h4>
                                            </div>
                                            <div class="col-md-12">
                                                <h4>Total Cost of Tests: Rs <span id="test_total_cost">0.00</span></h4>
                                            </div>
                                        </div>

                                        </form> -->

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
                                <th>Description</th>
                                <th>Maximum Limit (Should Not Exceed Than)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($result) && $result->num_rows > 0) {
                                // Output data of each row
                                while ($row = $result->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<td>' . htmlspecialchars($row['Name']) . '</td>';

                                    // Fetch user details within the same loop if needed
                                    if (isset($result_usr) && $result_usr->num_rows > 0) {
                                        // Reset the pointer of result_usr
                                        mysqli_data_seek($result_usr, 0);
                                        while ($row_usr = $result_usr->fetch_assoc()) {
                                            echo '<td>' . htmlspecialchars($row_usr['Name']) . '</td>';
                                        }
                                    } else {
                                        echo '<td>No user records found</td>';
                                    }
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="2">No records found</td></tr>';
                            }
                            ?>
                            <tr>
                                <th class="h5 "><b>Total Cost of Claim:</b></th>
                                <td class="h5 text-right"><b><span id="InitialCost"> Rs 0.00</span></b></td>
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