<form method="POST" id="add_form">

<!-- Section for adding Cancer bill -->
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