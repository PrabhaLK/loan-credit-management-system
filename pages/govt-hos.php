<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include('../config/db.php');  // Include database configuration if needed
    $type = isset($_GET['type']) ? $_GET['type'] : '';
    session_start();
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
</head>

<body>
    <?php

    include('../functions/category-functions.php');
    ?>
    <script>
        $(document).ready(function() {
            // Variables
            const perDayRoomCharge = parseFloat(<?php echo isset($PerDay) ? $PerDay : 'null'; ?>);
            const incidentCostLimit = parseFloat(<?php echo isset($incident_cost) ? $incident_cost : 3000; ?>); // Changed variable name to be more descriptive
            const maxRoomCharge = parseFloat(<?php echo isset($PerIncident) ? $PerIncident : 'null'; ?>);
            const maxMedicalCharges = parseFloat(<?php echo isset($IncidentPrice) ? $IncidentPrice : 'null'; ?>);
            const maxTestCharges = parseFloat(<?php echo isset($TestIncident) ? $TestIncident : 'null'; ?>);
            const maxConsultantFees = parseFloat(<?php echo isset($consultantPrice) ? $consultantPrice : 'null'; ?>);

            // Function to calculate days between two dates
            function calculateDaysBetweenDates(startDate, endDate) {
                const oneDay = 24 * 60 * 60 * 1000;
                const firstDate = new Date(startDate);
                const secondDate = new Date(endDate);
                return Math.round(Math.abs((secondDate - firstDate) / oneDay));
            }

            // Function to calculate total medical cost
            function calculateTotal() {
                let total = 0;
                $("input[name='medical_price[]']").each(function() {
                    total += parseFloat($(this).val()) || 0;
                });
                return total.toFixed(2);
            }

            // Function to calculate total test cost
            function calculateTestTotal() {
                let testTotal = 0;
                $("input[name='test_price[]']").each(function() {
                    testTotal += parseFloat($(this).val()) || 0;
                });
                return testTotal.toFixed(2);
            }

            // Function to calculate total consultant fees
            function calculateConsultantFee() {
                let consultantTotal = 0;
                $("input[name='consultant_price[]']").each(function() {
                    consultantTotal += parseFloat($(this).val()) || 0;
                });
                return consultantTotal.toFixed(2);
            }

            // Function to calculate total incident costs
            function calculateIncidentTotal() { // Changed function name to be more descriptive
                let incidentTotal = 0;
                $("input[name='oneTimeIncident[]']").each(function() {
                    incidentTotal += parseFloat($(this).val()) || 0;
                });
                return incidentTotal.toFixed(2);
            }

            // Function to calculate room charges
            function calculateRoomCharges(numberOfDays) {
                const charges = numberOfDays * perDayRoomCharge;
                return charges.toFixed(2);
            }

            // Function to validate room charges
            function validateRoomCharges(roomCharges) {
                if (roomCharges > maxRoomCharge) {
                    Swal.fire({
                        title: "Room Charges Limit Exceeded",
                        text: "Room charges cannot be more than Rs " + maxRoomCharge.toFixed(2) + ". Please adjust the dates.",
                        icon: "error"
                    });
                    $("#startingDate, #endingDate").val('');
                    $("input[name='number_of_dates[]']").val('');
                    return false;
                }
                return true;
            }

            // Function to validate medical charges
            function validateMedicalCharges(totalMedicalCost) {
                if (totalMedicalCost > maxMedicalCharges) {
                    Swal.fire({
                        title: "Medical Charges Limit Exceeded",
                        text: "Total cost for medical treatments cannot exceed Rs " + maxMedicalCharges.toFixed(2),
                        icon: "error"
                    });
                    $("input[name='medical_price[]']").val('');
                    return false;
                }
                return true;
            }

            // Function to validate test charges
            function validateTestCharges(totalTestCost) {
                if (totalTestCost > maxTestCharges) {
                    Swal.fire({
                        title: "Test Charges Limit Exceeded",
                        text: "Total cost for medical tests cannot exceed Rs " + maxTestCharges.toFixed(2),
                        icon: "error"
                    });
                    $("input[name='test_price[]']").val('');
                    return false;
                }
                return true;
            }

            // Function to validate consultant fees
            function validateConsultantFees(totalConsultantCost) {
                if (totalConsultantCost > maxConsultantFees) {
                    Swal.fire({
                        title: "Consultant Fees Limit Exceeded",
                        text: "Total cost for consultant fees cannot exceed Rs " + maxConsultantFees.toFixed(2),
                        icon: "error"
                    });
                    $("input[name='consultant_price[]']").val('');
                    return false;
                }
                return true;
            }

            // Function to validate incident charges
            function validateIncidentCharges(totalIncidentCost) { // Changed function name to be more descriptive
                if (totalIncidentCost > incidentCostLimit) { // Changed variable name to match the new one
                    Swal.fire({
                        title: "Incident Charge Limit Exceeded",
                        text: "Total cost for incidents cannot exceed Rs " + incidentCostLimit.toFixed(2), // Changed variable name to match the new one
                        icon: "error"
                    });
                    $("input[name='oneTimeIncident[]']").val('');
                    return false;
                }
                return true;
            }

            // Function to update the totals in the table
            function updateTable() {
                const totalCost = parseFloat(calculateTotal());
                const testTotalCost = parseFloat(calculateTestTotal());
                const consultantTotalCost = parseFloat(calculateConsultantFee());
                const totalIncidentCost = parseFloat(calculateIncidentTotal()); // Changed function call to match the new one
                const numberOfDays = parseInt($("input[name='number_of_dates[]']").val(), 10) || 0;
                const roomCharges = parseFloat(calculateRoomCharges(numberOfDays));
                const totalSum = totalCost + testTotalCost + consultantTotalCost + roomCharges + totalIncidentCost; // Added totalIncidentCost to the sum

                // Log values to debug
                console.log("Total Cost:", totalCost);
                console.log("Test Total Cost:", testTotalCost);
                console.log("Consultant Fee:", consultantTotalCost);
                console.log("Room Charges:", roomCharges);
                console.log("Total Incident Cost:", totalIncidentCost); // New log for incident cost
                console.log("Total Sum:", totalSum);

                // Validate and update costs
                if (validateMedicalCharges(totalCost) && validateTestCharges(testTotalCost) && validateConsultantFees(consultantTotalCost) && validateIncidentCharges(totalIncidentCost)) { // Added validateIncidentCharges to the condition
                    $("#total_cost").text(totalCost.toFixed(2));
                    $("#incident_cost").text(totalIncidentCost.toFixed(2)); // New update for incident cost
                    $("#test_total_cost").text(testTotalCost.toFixed(2));
                    $("#consultant_total_cost").text(consultantTotalCost.toFixed(2));
                    $("#room_charges").text(roomCharges.toFixed(2));
                    $("#InitialCost").text(totalSum.toFixed(2));

                    $("input[name='total_room_charges']").val(roomCharges);
                    $("input[name='total_treatments']").val(totalCost);
                    $("input[name='total_tests']").val(testTotalCost);
                    $("input[name='total_consultant_fees']").val(consultantTotalCost);
                    $("input[name='total_incident_cost']").val(totalIncidentCost); // New input field for incident cost
                } else {
                    console.error("One or more values exceed the allowed limits.");
                }
            }

            // Event listener for date change
            $("#startingDate, #endingDate").on('change', function() {
                const startDate = $("#startingDate").val();
                const endDate = $("#endingDate").val();

                if (startDate && endDate) {
                    const start = new Date(startDate);
                    const end = new Date(endDate);

                    if (start > end) {
                        Swal.fire({
                            title: "Start Date cannot be ahead of end date.",
                            text: "Please check the date setup again.",
                            icon: "error"
                        });
                        $("#startingDate, #endingDate").val('');
                        $("input[name='number_of_dates[]']").val('');
                        return;
                    }

                    const numberOfDays = calculateDaysBetweenDates(startDate, endDate);
                    const roomCharges = parseFloat(calculateRoomCharges(numberOfDays));

                    if (!validateRoomCharges(roomCharges)) {
                        return;
                    }

                    $("input[name='number_of_dates[]']").val(numberOfDays);
                    updateTable();
                }
            });

            // Add new medical treatment item
            $(".add_item_btn").click(function(e) {
                e.preventDefault();
                $("#show_item").append(`
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

            // Add new medical test item
            $(".add_test_btn").click(function(e) {
                e.preventDefault();
                $("#show_test").append(`
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

            // Add new consultant item
            $(".add_consultant_btn").click(function(e) {
                e.preventDefault();
                $("#show_consultant").append(`
            <div class="form-section row">
                <div class="col-md-8">
                    <input type="number" name="consultant_price[]" class="form-control" placeholder="Consultant price" required>
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-danger remove_consultant_btn">Remove</button>
                </div>
            </div>`);
                updateTable();
            });

            // Add new incident item (NEW)
            $(".add_incident_btn").click(function(e) {
                e.preventDefault();
                $("#show_incident").append(`
            <div class="form-section row">
                <div class="col-md-8">
                    <input type="number" name="oneTimeIncident[]" class="form-control" placeholder="Incident cost" required>
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-danger remove_incident_btn">Remove</button>
                </div>
            </div>`);
                updateTable();
            });

            // Remove medical treatment item
            $(document).on('click', '.remove_item_btn', function(e) {
                e.preventDefault();
                $(this).closest('.form-section').remove();
                updateTable();
            });

            // Remove medical test item
            $(document).on('click', '.remove_test_btn', function(e) {
                e.preventDefault();
                $(this).closest('.form-section').remove();
                updateTable();
            });

            // Remove consultant item
            $(document).on('click', '.remove_consultant_btn', function(e) {
                e.preventDefault();
                $(this).closest('.form-section').remove();
                updateTable();
            });

            // Remove incident item (NEW)
            $(document).on('click', '.remove_incident_btn', function(e) {
                e.preventDefault();
                $(this).closest('.form-section').remove();
                updateTable();
            });

            // Update totals on input change
            $(document).on('input', "input[name='medical_price[]']", function() {
                updateTable();
            });

            $(document).on('input', "input[name='test_price[]']", function() {
                updateTable();
            });

            $(document).on('input', "input[name='consultant_price[]']", function() {
                updateTable();
            });

            // Update totals on incident input change (NEW)
            $(document).on('input', "input[name='oneTimeIncident[]']", function() {
                updateTable();
            });

            // Form submission
            $("#add_form").submit(function(e) {
                e.preventDefault();
                $("#add_btn").val('Adding....');
                const numberOfDates = parseInt($("input[name='number_of_dates[]']").val(), 10) || 0;
                const totalMedicalCost = parseFloat(calculateTotal());
                const totalIncidentCost = parseFloat(calculateIncidentTotal()); // Changed function call to match the new one
                const totalTestCost = parseFloat(calculateTestTotal());
                const totalConsultantCost = parseFloat(calculateConsultantFee());
                const roomCharges = parseFloat(calculateRoomCharges(numberOfDates));
                const totalSum = totalMedicalCost + totalTestCost + totalConsultantCost + roomCharges + totalIncidentCost; // Added totalIncidentCost to the sum

                // Log values to debug
                console.log("Submit - Number of Dates:", numberOfDates);
                console.log("Submit - Total Medical Cost:", totalMedicalCost);
                console.log("Submit - Total Incident Cost:", totalIncidentCost); // New log for incident cost
                console.log("Submit - Total Test Cost:", totalTestCost);
                console.log("Submit - Total Consultant Cost:", totalConsultantCost);
                console.log("Submit - Room Charges:", roomCharges);
                console.log("Submit - Total Sum:", totalSum);

                if (validateMedicalCharges(totalMedicalCost) && validateTestCharges(totalTestCost) && validateConsultantFees(totalConsultantCost) && validateIncidentCharges(totalIncidentCost)) { // Added validateIncidentCharges to the condition
                    $("input[name='total_room_charges']").val(roomCharges);
                    $("input[name='total_treatments']").val(totalMedicalCost);
                    $("input[name='total_tests']").val(totalTestCost);
                    $("input[name='total_consultant_fees']").val(totalConsultantCost);
                    $("input[name='total_incident_cost']").val(totalIncidentCost); // New field for incident cost

                    const requestData = {
                        number_of_dates: numberOfDates,
                        total_medical_cost: totalMedicalCost.toFixed(2),
                        total_incident_cost: totalIncidentCost.toFixed(2), // Added incident cost to requestData
                        consultant_Fees: totalConsultantCost.toFixed(2),
                        total_test_cost: totalTestCost.toFixed(2),
                        room_charges: roomCharges.toFixed(2),
                        total_sum: totalSum.toFixed(2),
                        type: '<?php echo $type; ?>',
                        nic: '<?php echo $_SESSION['nic']; ?>'
                    };

                    console.log("AJAX request data:", requestData);

                    $.ajax({
                        url: '../functions/ClaimSubmit.php',
                        method: 'post',
                        data: requestData,
                        success: function(response) {
                            console.log("Response:", response);
                            $("#add_btn").val('Send Details');
                            Swal.fire({
                                title: 'Data has Been Added.',
                                icon: "success",
                                toast: true,
                                timer: 3000,
                                position: 'top-right',
                                timerProgressBar: true,
                                showConfirmButton: false
                            });
                            // setTimeout(function() {
                            //     // window.location.reload();
                            // }, 4000); // Reloads page after the data entry.
                        }
                    });
                } else {
                    console.error("One or more values exceed the allowed limits.");
                    Swal.fire({
                        title: 'Data insert Failed.',
                        icon: "error",
                        toast: true,
                        timer: 3000,
                        position: 'top-right',
                        timerProgressBar: true,
                        showConfirmButton: false
                    });
                    $("#add_btn").val('Send Details');
                }
            });

            // Initial update to set the values
            updateTable();
        });
    </script>


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
                                            <!-- Hidden Inputs for Form Data -->
                                            <input type="hidden" name="total_room_charges">
                                            <input type="hidden" name="total_treatments">
                                            <input type="hidden" name="total_tests">
                                            <!-- Section for adding government host method -->
                                            <?php if ($SubCategory1Name == "Government Hospitalization") : ?>
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
                                                        <h4>Total Room Charges: Rs <span id="room_charges">0.00</span></h4>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <h4>Total Cost of Treatments: Rs <span id="total_cost">0.00</span></h4>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <h4>Total Cost of Tests: Rs <span id="test_total_cost">0.00</span></h4>
                                                    </div>
                                                </div>
                                    </form>
                                <?php endif ?>
                                <!-- section for adding Private Hospitalization start -->
                                <?php if ($SubCategory1Name == "Private Hospitalization") : ?>
                                    <div class="form-section row">
                                        <div class="col-md-8">
                                            <p>Number of Dates</p>
                                            <input type="number" name="number_of_dates[]" class="form-control" placeholder="Number of Dates" max="10" required readonly>
                                        </div>
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
                                            </div>
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
                                            <div id="show_consultant">
                                                <div class="form-section row">
                                                    <div class="col-md-8">
                                                        <p>Consultant Fee</p>
                                                        <input type="number" name="consultant_price[]" class="form-control" placeholder="Consultant price" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <button type="button" class="btn btn-success add_consultant_btn">Add More</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row my-4">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary" id="add_btn">Send Details</button>
                                            </div>
                                        </div>
                                        <div class="total-costs row">
                                            <div class="col-md-12">
                                                <h4>Total Cost of Treatments: Rs <span id="total_cost">0.00</span></h4>
                                            </div>
                                            <div class="col-md-12">
                                                <h4>Total Cost of Tests: Rs <span id="test_total_cost">0.00</span></h4>
                                            </div>
                                            <div class="col-md-12">
                                                <h4>Total Consultant Fees: Rs <span id="consultant_total_cost">0.00</span></h4>
                                            </div>
                                            <div class="col-md-12">
                                                <h4>Total Room Charges: Rs <span id="room_charges">0.00</span></h4>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <!-- section for adding Private Hospitalization end -->

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
                                            <div class="col-md-12">
                                                <h4>Total Consultant Fees: Rs <span id="consultant_total_cost">0.00</span></h4>
                                            </div>
                                            <div class="col-md-12">
                                                <h4>Total Room Charges: Rs <span id="room_charges">0.00</span></h4>
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                <?php endif ?>

                                <!-- section for adding heart surgery dependant start  -->
                                <!-- Section for adding Hip Cost -->
                                <?php if ($SubCategory1Name == "Heart Surgery - Depenadant") :
                                ?>

                                    <form method="POST" id="add_form">

                                        <!-- Section for adding Hearing Aid bill -->
                                        <div id="show_test">
                                            <div class="form-section row">
                                                <div class="col-md-8">
                                                    <p>Costs for heart surgery: Dependant</p>
                                                    <input type="number" name="oneTimeIncident[]" class="form-control validate-number" placeholder="Enter costs here" required>
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
                                    </form>
                                <?php endif ?>
                                <!-- section for adding heart surgery dependant end  -->

                                <!-- Section for adding Heart Surgery - Guarantee Bill Cost -->
                                <?php if ($SubCategory1Name == "Heart Surgery - Guarantee") : ?>
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
                                            <h4>Total Room Charges: Rs <span id="room_charges">0.00</span></h4>
                                        </div>
                                    </div>
                                    </form>
                                <?php endif ?>
                                <!-- Section for adding Private Ayurvedic Bill Cost -->
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
                                <th>Maximum Limit Per Incident (Should Not Exceed Than)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($result) && $result->num_rows > 0) {
                                // Output data of each row
                                while ($row = $result->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<td>' . htmlspecialchars($row['Name']) . '</td>';
                                    echo '<td class=" text-right">' . htmlspecialchars($row['PerIncident']) . '.00' . '</td>';

                                    //     // Fetch user details within the same loop if needed
                                    //     if (isset($resultLimit) && $resultLimit->num_rows > 0) {
                                    //         // Reset the pointer of result_usr
                                    //         mysqli_data_seek($resultLimit, 0);
                                    //         while ($row_incident = $resultLimit->fetch_assoc()) {
                                    //             echo '<td>' . htmlspecialchars($PerIncidentLimit) . '</td>';
                                    //         }
                                    //     } else {
                                    //         echo '<td>No user records found</td>';
                                    //     }
                                    //     echo '</tr>';
                                    // }
                                    // } else {
                                    //     echo '<tr><td colspan="2">No records found</td></tr>';
                                }
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