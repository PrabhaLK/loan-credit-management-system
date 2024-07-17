<form method="POST" id="add_form">
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