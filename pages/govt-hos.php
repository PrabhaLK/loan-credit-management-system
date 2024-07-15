<?php
include('../config/db.php');
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title><?php echo ($type); ?></title>
    <style>
        .left-sec {
            width: 50%;
            float: left;
        }

        .right-sec {
            width: 50%;
            float: right;
        }

        .right-up {
            height: 50%;
            padding-top: 10%;
            padding-right: 2%;
            position: inherit;
        }

        .right-down {
            background-color: green;
            height: 50%;
            padding: 0;
        }

        .Header {
            color: black;
            text-align: center;
            padding: 30px;
            text-decoration: none;
            display: inline-block;
            font-size: 36px;
        }

        .left-up {
            height: 50%;
            position: inherit;
        }

        body {
            background-image: url('../images/back.jpg');
        }

        .sub-cat {
            margin-left: 79%;
        }

        .Remove-btn {
            margin-left: 180%;
        }
    </style>
    <script>
        $(document).ready(function() {
            console.log("jquery loaded");
            alert("jquery loaded");

            function calculateTotal() {
                let total = 0;
                $("input[name='medical_price[]']").each(function() {
                    total += parseFloat($(this).val()) || 0;
                });
                $("#total_cost").text(total.toFixed(2));
                updateTable();
            }

            function calculateTestTotal() {
                let testTotal = 0;
                $("input[name='test_price[]']").each(function() {
                    testTotal += parseFloat($(this).val()) || 0;
                });
                $("#test_total_cost").text(testTotal.toFixed(2));
                updateTable();
            }

            function updateTable() {
                let totalCost = $("#total_cost").text();
                let testTotalCost = $("#test_total_cost").text();
                $("#total_cost_td").text(`Rs ${totalCost}`);
                $("#test_total_cost_td").text(`Rs ${testTotalCost}`);
            }

            $(".add_item_btn").click(function(e) {
                e.preventDefault();

                // Find the last occurrence of .row inside #show_item
                var lastRow = $("#show_item").find('.row').last();

                // Append new item after the last occurrence of .row
                $(lastRow).after(`<div class="row">
                                    <div class="col-md-7 mb-3">
                                        <input type="number" name="medical_price[]" class="form-control sub-cat" placeholder="Item_name" required>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <button type="button" class="btn btn-danger remove_item_btn Remove-btn">Remove</button>
                                    </div>
                                </div>`);
                calculateTotal();
            });

            $(".add_test_btn").click(function(e) {
                e.preventDefault();

                // Find the last occurrence of .row inside #show_test
                var lastTestRow = $("#show_test").find('.row').last();

                // Append new test item after the last occurrence of .row
                $(lastTestRow).after(`<div class="row">
                                        <div class="col-md-7 mb-3">
                                            <input type="number" name="test_price[]" class="form-control sub-cat" placeholder="Item_name" required>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <button type="button" class="btn btn-danger remove_test_btn Remove-btn">Remove</button>
                                        </div>
                                    </div>`);
                calculateTestTotal();
            });

            // Remove item functionality
            $(document).on('click', '.remove_item_btn', function(e) {
                e.preventDefault();
                $(this).closest('.row').remove();
                calculateTotal();
            });

            $(document).on('click', '.remove_test_btn', function(e) {
                e.preventDefault();
                $(this).closest('.row').remove();
                calculateTestTotal();
            });

            // Recalculate total on input change
            $(document).on('input', "input[name='medical_price[]']", function() {
                calculateTotal();
            });

            $(document).on('input', "input[name='test_price[]']", function() {
                calculateTestTotal();
            });

            // Ajax request to insert all form data
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

            // Initial calculation
            calculateTotal();
            calculateTestTotal();
        });
    </script>

</head>

<body>
    <div class="left-sec">
        <div class="Header">
            <?php echo ($type); ?>
        </div>
        <div class="left-up">
            <div class="container">
                <div class="row my-4">
                    <div class="col-lg-9 mx-auto">
                        <div class="card shadow">
                            <div class="card-header">
                                <h4> Add Items </h4>
                            </div>
                            <div class="card-body p-4">
                                <form method="POST" id="add_form">
                                    <div class="row">
                                        <p>Number of Dates</p>
                                        <div class="col-md-7 mb-3">
                                            <input type="number" style="margin-left:37%" name="number_of_dates[]" id="" class="form-control" placeholder="Item_name" required>
                                        </div>
                                    </div>
                                    <div id="show_item">
                                        <div class="row">
                                            <p>Surgical and Medical Treatments</p>
                                            <div class="col-md-7 mb-3">
                                                <input type="number" style="margin-left:1%;" name="medical_price[]" id="" class="form-control" placeholder="Item_name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <button type="button" class="btn btn-success add_item_btn">Add More</button>
                                        </div>
                                    </div>
                                    <div id="show_test">
                                        <div class="row">
                                            <p>Medical tests</p>
                                            <div class="col-md-7 mb-3">
                                                <input type="number" style="margin-left:47%" name="test_price[]" id="" class="form-control" placeholder="Item_name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <button type="button" class="btn btn-success add_test_btn">Add More</button>
                                        </div>
                                    </div>
                                    <div class="row my-auto">
                                        <button type="submit" class="btn btn-primary">Send Details</button>
                                    </div>
                                    <div class="row my-auto">
                                        <h4>Total Cost of Treatments: Rs <span id="total_cost">0.00</span></h4>
                                    </div>
                                    <div class="row my-auto">
                                        <h4>Total Cost of Tests: Rs <span id="test_total_cost">0.00</span></h4>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="right-sec">
        <div class="right-up">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="result_table">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Total Cost of Treatments</th>
                                <th>Total Cost of Tests</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>John</td>
                                <td>Doe</td>
                                <td>johndoe@example.com</td>
                                <td id="total_cost_td">Rs 0.00</td>
                                <td id="test_total_cost_td">Rs 0.00</td>
                            </tr>
                            <!-- Data will be appended here by jQuery -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- <div class="right-down">
            <h4>Right up div</h4>
        </div> -->
    </div>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7HUiUbX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.umd.min.js"></script>
</body>

</html>