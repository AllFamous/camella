    <!-- properties section -->
    <?php
    $props = (array) get_theme_mod( 'search', array( 'heading' => 'Our Properties' ) );
    $props = (object) array_filter( $props );
    ?>
    <div class="container-fluid section section-properties" id="section-properties">
        <div class="container">
            <!-- section header -->
            <div class="row">
                <div class="col-md-12 heading">
                    <h2><?php echo $props->heading; ?></h2>
                    <hr>
                    <p><?php echo $props->tagline; ?></p>
                </div>
            </div>

            <!-- refine list -->
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary panel-refine">
                        <div class="panel-body">
                            <h3>Search Property</h3>
                            <div class="row">
                                <div class="col-md-5ths">
                                    <div class="form-group">
                                        <label for="refine-island-group">Select island group</label>
                                        <select id="refine-island-group" class="select-lg">
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5ths">
                                    <div class="form-group">
                                        <label for="refine-province">Select region/province</label>
                                        <select id="refine-province" class="select-lg">
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5ths">
                                    <div class="form-group">
                                        <label for="refine-city">Select city</label>
                                        <select id="refine-city" class="select-lg">
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5ths">
                                    <div class="form-group">
                                        <label for="refine-price">Select price</label>
                                        <select id="refine-price" class="select-lg">
                                            <option></option>
                                            <option value="1" data-low="0" data-high="1000000">1M and Below</option>
                                            <option value="2" data-low="1000000.01" data-high="2000000">1M to 2M</option>
                                            <option value="3" data-low="2000000.01" data-high="3000000">2M to 3M</option>
                                            <option value="4" data-low="3000000.01" data-high="4000000">3M to 4M</option>
                                            <option value="5" data-low="4000000.01" data-high="5000000">4M to 5M</option>
                                            <option value="6" data-low="5000000.01" data-high="10000000">5M and Up</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5ths">
                                    <div class="form-group">
                                        <label for="refine-bedrooms">Number of bedrooms</label>
                                        <select id="refine-bedrooms" class="select-lg">
                                            <option></option>
                                            <option value="0">Any</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="properties-refine-alerts"></div>
                        </div>
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-md-8">
                                    <button type="button" class="btn btn-primary" id="properties-lot-only"><i class="fa fa-times fa-lg"></i> SHOW LOT ONLY</button>
                                </div>
                                <div class="col-md-4 text-right">
                                    <button type="button" class="btn btn-primary btn-lg" id="properties-reset">RESET</button>
                                    <button type="button" class="btn btn-primary btn-lg" id="properties-refine">FIND PROPERTY</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- properties list -->
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div id="properties-list-container" data-nonce="<?php echo wp_create_nonce('refine_search_results'); ?>"></div>
                        <!-- modal sample -->
                        <div class="modal fade" id="computationModal" tabindex="-1" role="dialog" aria-labelledby="computationModal" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"></h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>This sample computation is for display purposes only. This does not guarantee any finality on the property's price. Consult a Camella Sales Agent for exact pricing.</p>
                                        <div class="sample-compute-alert"></div>
                                        <div id="sampleComputationContent">
                                            <h4>House Model</h4>
                                            <section>
                                                <div class="form-group">
                                                    <label for="compute-loan-type">Select House Model</label>
                                                    <div class="house-model-selection"></div>
                                                </div>
                                            </section>
                                            <h4>LOAN TYPE</h4>
                                            <section>
                                                <p>The Total Contract Price for <span class="model-title"></span> is <strong class="text-green"></strong> based on a <span class="area"></span> square foot floor area. Select your preferred loan type below then click <strong>NEXT</strong>.</p>
                                                <div class="form-group">
                                                    <label for="compute-loan-type">Select Loan Type</label>
                                                    <select id="compute-loan-type" class="select-lg exception">
                                                        <option></option>
                                                        <option value="2">Bank Financing</option>
                                                    </select>
                                                </div>
                                            </section>
                                            <h4>DOWNPAYMENT</h4>
                                            <section>
                                                <div class="form-group">
                                                    <label for="compute-down-payment">Select Downpayment</label>
                                                    <select id="compute-down-payment" class="select-lg exception">
                                                        <option></option>
                                                        <option value="15">15%</option>
                                                        <option value="20">20%</option>
                                                        <option value="25">25%</option>
                                                        <option value="30">30%</option>
                                                        <option value="35">35%</option>
                                                        <option value="40">40%</option>
                                                        <option value="45">45%</option>
                                                        <option value="50">50%</option>
                                                    </select>
                                                </div>
                                            </section>
                                            <h4>TERMS</h4>
                                            <section>
                                                <div class="form-group">
                                                    <label for="compute-terms">Select Terms</label>
                                                    <select id="compute-terms" class="select-lg exception">
                                                        <option></option>
                                                        <option value="5">5 Years</option>
                                                        <option value="10">10 Years</option>
                                                        <option value="15">15 Years</option>
                                                        <option value="20">20 Years</option>
                                                        <option value="25">25 Years</option>
                                                    </select>
                                                </div>
                                            </section>
                                            <h4>DOWNLOAD</h4>
                                            <section>
                                                <p>Your sample computation is now ready. Please enter your information below and we will email the document immediately.</p>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="sr-only" for="compute-full-name">Full Name</label>
                                                            <input type="text" class="form-control" id="compute-full-name" placeholder="full name">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="sr-only" for="compute-email-address">Email Address</label>
                                                            <input type="email" class="form-control" id="compute-email-address" placeholder="email address">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="g-recaptcha" data-sitekey="6Lf7Dg4TAAAAAItYlyBb7QqJYLbipXMmL5lLTg50"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                                        <a class="btn btn-primary btn-model-details" href="">VIEW MODEL DETAILS</a>
                                    </div>
                                    <iframe id="compute-iframe" src="" width="1" height="1"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- pagination -->
            <div class="properties-pagination-container"></div>
<?php
/*******
 * Email Details use in Sample Computation
 * The settings for below are defaults and are subject to be change at Customizer-> Home Page -> Fold 7
 *****************************************/
 $email_details = (array) get_theme_mod( 'search', array(
        'admin' => array(
                'from' => 'Camella',
                'to' => 'marketing@camella.com.ph',
                'subject' => 'Contact Proposals'
        ),
        'user' => array(
                'from' => 'Camella',
                'from_email' => 'info@camella.com.ph',
                'subject' => 'Sample Computation'
        )
 ));
 $email_details = array_filter( $email_details );
?>
<script type="text/javascript">
window.CamellaEmail = <?php echo json_encode($email_details); ?>;
</script>
            <!-- calculator section -->
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary panel-refine">
                        <div class="panel-body">
                            <h3>Loan Calculator</h3>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="computePrice">Total Price</label>
                                        <input type="text" class="form-control" id="computePrice" placeholder="0.00">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="computeType">Select loan type</label>
                                        <select id="computeType" class="select-lg">
                                            <option></option>
                                            <option value="2">Bank Financing</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="computeDownpayment">Select downpayment</label>
                                        <select id="computeDownpayment" class="select-lg">
                                            <option></option>
                                            <option value="10">10%</option>
                                            <option value="15">15%</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="computeTerms">Select payment terms</label>
                                        <select id="computeTerms" class="select-lg">
                                            <option></option>
                                            <option value="5">5 Years</option>
                                            <option value="10">10 Years</option>
											<option value="10">15 Years</option>
											<option value="10">25 Years</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="calculator-alerts"></div>
                        </div>
                        <div class="panel-footer text-right">
                            <p class="pull-left">Disclaimer: All computations appearing herein are for sample computation only and are not official.</p> 
			    <p class="pull-left"> Terms are subject to change without prior notice.</p>
                            <button type="button" class="btn btn-primary btn-lg calculator-reset">RESET</button> <button type="button" class="btn btn-primary btn-lg calculator-calculate">CALCULATE</button>
                        </div>
                    </div>
                    <div class="panel panel-primary calculator-result">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p>Total Contract Price</p>
                                    <h3 class="compute-contract-price"></h3>
                                </div>
                                <div class="col-sm-3">
                                    <p>Downpayment (<span class="compute-dp-rate"></span>%)</p>
                                    <h3 class="compute-downpayment"></h3>
                                </div><div class="col-sm-3">
                                    <p>Reservation Fee</p>
                                    <h3 class="compute-reservation"></h3>
                                </div>
                                <div class="col-sm-3">
                                    <p>Monthly downpayment (14 Months)</p>
                                    <h3 class="compute-dp-monthly"></h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p>Loanable Amount</p>
                                    <h3 class="compute-loan-amount"></h3>
                                </div>
                                <div class="col-sm-3">
                                    <p>Loanable Percent</p>
                                    <h3 class="compute-loan-percent"></h3>
                                </div>
                                <div class="col-sm-3">
                                    <p>Payment Terms</p>
                                    <h3 class="compute-loan-terms"></h3>
                                </div>
                                <div class="col-sm-3">
                                   <!-- <p>Monthly Payment</p> -->
				    <p>Monthly Amortization @ 8% Interest Rate (14 months)</p>
                                    <h3 class="strong compute-loan-payment"></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>