<form method="POST" id="add_form">                                            
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