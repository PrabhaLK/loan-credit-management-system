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
            function CalculateRoomCharges(){

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