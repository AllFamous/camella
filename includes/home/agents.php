    <!-- find agent section -->
    <?php
    $agents = (array) get_theme_mod( 'agents' );
    $agents = (object) array_filter( $agents );
    ?>
    <div class="container-fluid section section-findagent" id="section-findagent">
        <div class="container">
            <!-- section header -->
            <div class="row">
                <div class="col-md-12 heading">
                    <h2><?php echo $agents->heading; ?></h2>
                    <hr>
                    <p><?php echo $agents->tagline; ?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="panel panel-primary panel-search">
                        <div class="panel-body">
                            <h3>Find an Agent</h3>
                            <form>
                                <div class="form-group">
                                    <label for="agentName">By Agent's Name</label>
                                    <input type="text" pattern="[A-Za-z]" class="form-control" id="agentName" placeholder="agent name">
                                </div>
                                <div class="form-group">
                                    <label for="agentCountry">By Country</label>
                                    <select id="agentCountry" class="select-lg">
                                        <option></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="agentRegion">By Region/Location</label>
                                    <select id="agentRegion" class="select-lg">
                                        <option></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="agentProject">By Project/Community</label>
                                    <select id="agentProject" class="select-lg">
                                        <option></option>
                                    </select>
                                </div>
                            </form>
                            <div class="agent-alerts"></div>
                        </div>
                        <div class="panel-footer text-right">
                            <button type="button" class="btn btn-primary">CLEAR</button> <button type="button" class="btn btn-primary" id="filter-agent">SEARCH</button>
                        </div>
                    </div>
                    <!--
                    <div class="panel panel-secondary panel-login">
                        <div class="panel-body">
                            <h3>Agent Login</h3>
                            <form>
                                <div class="form-group">
                                    <label for="agentEmail">Email Address</label>
                                    <input type="email" class="form-control" id="agentEmail" placeholder="email address">
                                </div>
                                <div class="form-group">
                                    <label for="agentPassword">Password</label>
                                    <input type="password" class="form-control" id="agentPassword" placeholder="password">
                                </div>
                            </form>
                        </div>
                        <div class="panel-footer text-right">
                            <button type="submit" class="btn btn-secondary">LOGIN</button>
                        </div>
                    </div>
                    -->
                </div>
                <div class="col-md-9">
                    <div class="row" id="agents-list-container"></div>
                    <!-- pagination -->
                   
					<div class="agents-pagination-container"></div>
					
					
                </div>
                <!-- modal sample -->
                <div class="modal fade" id="agentModal" tabindex="-1" role="dialog" aria-labelledby="agentModal" aria-hidden="true" data-agent="">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Send Message</h4>
                            </div>
                            <div class="modal-body">
							<?php echo FrmFormsController::show_form(6, $key = '', $title=true, $description=true); ?>
                                <!-- <p>Fill-up the form below to send your question or inquires to <span class="contact-agent-name"></span>.</p>
                                <div class="well">
                                    <form>
                                        <div class="form-group">
                                            <label for="agentContactFullName">Full Name</label>
                                            <input type="text" class="form-control" id="agentContactFullName" placeholder="full name">
                                        </div>
                                        <div class="form-group">
                                            <label for="agentContactEmailAddress">Email Address</label>
                                            <input type="email" class="form-control" id="agentContactEmailAddress" placeholder="email address">
                                        </div>
                                        <div class="form-group">
                                            <label for="agentContactNumber">Contact Number</label>
                                            <input type="email" class="form-control" id="agentContactNumber" placeholder="contact number">
                                        </div>
                                        <div class="form-group">
                                            <label for="agentContactMessage">Message</label>
                                            <textarea class="form-control" id="agentContactMessage" placeholder="your message"></textarea>
                                        </div>
                                    </form>
                                    <div class="agent-contact-alerts"></div>
                                </div> -->
                            </div>
                            <div class="modal-footer text-right">
                                <!-- <button type="button" class="btn btn-primary" id="contactAgentSubmit">SUBMIT</button> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- international section -->
            <?php
            $sales = (array) get_theme_mod( 'sales' );
            $sales = (object) array_filter( $sales );
            ?>
            <div class="row row-international-section">
                <div class="col-md-12 heading sub-heading">
                    <h2><?php echo $sales->heading; ?></h2>
                    <hr>
                    <p><?php echo $sales->tagline; ?></p>
                </div>
                <div class="col-md-12"><div class="row">
                        <div class="international-sales owl-carousel">
                        <?php
                        global $wp_query, $post;
                        $wp_query = new WP_Query( array( 'post_type' => 'international', 'orderby' => 'menu_order', 'order' => 'ASC' ) );
                        
                        if( have_posts() ):
                                $animCount = 0;
                                while( have_posts() ):
                                        the_post();
                                        $animCount = $animCount + 0.2;
                                        $field = (array) get_fields( get_the_ID() );
                                        $field = (object) array_filter( $field );
                                        $title = $field->country;
                                        $icon = '';
                                        if( (int) $field->flag > 0 ){
                                                $flag = wp_get_attachment_image_src( (int) $field->flag, 'medium' );
                                                $icon = $flag[0];
                                        }
                                ?>
                                <div class="col-sm-12 item-<?php echo strtolower(str_replace(' ', '-', $title )); ?> text-center key-item international-item move 50px wait <?php echo $animCount; ?>s">
                                        <div class="panel panel-primary">
                                                <div class="panel-body text-center">
                                                        <div class="key-icon-container">
                                                                <div class="key-icon shadow" style="background-image: url(<?php echo $icon; ?>);"></div>
                                                        </div>
                                                        <h4><?php echo $title; ?></h4>
                                                        <div class="panel-footer no-padding">
                                                                <a href="#" class="btn btn-primary btn-block international-send-message" data-email-address="<?php echo $field->email_address; ?>" data-toggle="modal" data-target="#agentModal"><i class="fa fa-envelope"></i> SEND MESSAGE</a>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                                <?php
                                endwhile;
                        endif;
                        /*
                            $templateUrl = get_template_directory_uri();
                            $jsonFile = json_decode(file_get_contents($templateUrl.'/data/home-international-contacts.json'), true);
                            $animCount = 0;
                            foreach($jsonFile as $key => $value){
                                $icon = $value['icon'];
                                $title = $value['countryName'];
                                $number = $value['contactNumber'];
                                $email = $value['emailAddress'];
                                $animCount = $animCount + 0.2;
                                
                                echo '<div class="col-sm-12 item-'. strtolower(str_replace(' ', '-', $title )) .' text-center key-item international-item move 50px wait '.$animCount.'s"><div class="panel panel-primary"><div class="panel-body text-center">';
                                echo '<div class="key-icon-container"><div class="key-icon shadow" style="background-image: url('.$icon.');"></div></div><h4>'.$title.'</h4></div>';
                                echo '<div class="panel-footer no-padding"><a href="#" class="btn btn-primary btn-block international-send-message" data-email-address="'.$email.'" data-toggle="modal" data-target="#agentModal"><i class="fa fa-envelope"></i> SEND MESSAGE</a></div></div></div>';
                                 
							}
			*/
							
                        ?>
                        </div>
                </div></div>
            </div>
        </div>
    </div>