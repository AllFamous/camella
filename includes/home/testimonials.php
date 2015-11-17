    <!-- testimonials section -->
    <div class="container-fluid section section-testimonials" id="section-testimonials">
        <div class="container">
            <!-- section header -->
            <div class="row">
                <div class="col-md-12 heading">
                    <h2>Testimonials</h2>
                    <hr>
                    <p>Hear it straight from our homeowners how Camella brought them to their dreams.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="carousel-testimonials" class="owl-carousel">
                        <?php
                            $templateUrl = get_template_directory_uri();
                            $jsonFile = json_decode(file_get_contents($templateUrl.'/data/home-testimonials.json'), true);
                            foreach($jsonFile as $key => $value){
                                $type = $value['type'];
                                $profileImage = $value['profileImage'];
                                $testimonial = $value['testimonial'];
                                $name = $value['name'];
                                $title = $value['title'];
                                $videoEmbedCode = $value['videoEmbedCode'];

                                if ($type == 'text'){
                                    echo '<div class="testimonial-item"><div class="row"><div class="col-md-8 col-md-offset-2"><div class="media testimonial-item"><div class="media-left">';
                                    echo '<img src="'.$profileImage.'"></div><div class="media-body"><div class="quote-top">“</div><div class="quote-bottom">”</div><div class="arrow-top"></div>';
                                    echo '<p>'.$testimonial.'</p><cite>'.$name.', '.$title.'</cite></div></div></div></div></div>';
                                } else {
                                    echo '<div class="testimonial-item"><div class="row"><div class="col-md-6"><div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="'.$videoEmbedCode.'"></iframe></div></div>';
                                    echo '<div class="col-md-6"><div class="media testimonial-item"><div class="media-left">';
                                    echo '<img src="'.$profileImage.'"></div><div class="media-body"><div class="quote-top">“</div><div class="quote-bottom">”</div><div class="arrow-top"></div>';
                                    echo '<p>'.$testimonial.'</p><cite>'.$name.', '.$title.'</cite>';
                                    echo '</div></div></div></div></div>';
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>