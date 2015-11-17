    <!-- strip section - how tos -->
    <?php
    $guides = (array) get_theme_mod( 'guides' );
    $guides = array_filter( $guides );
    ?>
    <div class="container-fluid section-strip section-howtos">
        <div class="container">
            <div class="row">
                <?php foreach( $guides as $guide ): $guide = (object) array_filter( $guide ); ?>
                <div class="col-md-6">
                        <div class="media">
                                <div class="media-left">
                                        <?php if( (int) $guide->featured > 0 ):
                                                $img = wp_get_attachment_image_src( (int) $guide->featured ); ?>
                                                <img src="<?php echo esc_url($img[0]); ?>" />
                                        <?php endif; ?>
                                </div>
                                <div class="media-body">
                                        <h4><i class="fa fa-file-text fa-fw"></i> <?php echo $guide->title; ?></h4>
                                        <p><?php echo $guide->desc; ?></p>
                                        <a href="<?php echo esc_attr($guide->link); ?>" class="btn btn-tertiary btn-sm">CLICK HERE FOR MORE</a>
                                </div>
                        </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    
        <!-- testimonials section -->
        <?php
        $testi = (array) get_theme_mod( 'testimony' );
        $testi = (object) array_filter( $testi );
        ?>
    <div class="container-fluid section section-testimonials" id="section-testimonials">
        <div class="container">
            <!-- section header -->
            <div class="row">
                <div class="col-md-12 heading">
                    <h2><?php echo $testi->heading; ?></h2>
                    <hr>
                    <p><?php echo $testi->tagline; ?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="carousel-testimonials" class="owl-carousel">
                        <?php
                        global $wp_query, $post;
                        $wp_query = new WP_Query( array( 'post_type' => 'testimonials' ) );
                        
                        if( have_posts() ):
                                while( have_posts() ):
                                        the_post();
                                        $field = (object) get_fields(get_the_ID() );
                                        $img = '';
                                        if( (int) $field->photo > 0 ):
                                                $img = wp_get_attachment_image_src( (int) $field->photo, 'full' );
                                                $img = $img[0];
                                        endif;
                                        ?>
                                        
                                        <div class="testimonial-item">
                                                <div class="row">
                                                        <div class="col-md-8 col-md-offset-2">
                                                                <div class="media testimonial-item">
                                                                        <div class="media-left">
                                                                                <img src="<?php echo $img; ?>">
                                                                        </div>
                                                                        <div class="media-body">
                                                                                <div class="quote-top">“</div>
                                                                                <div class="quote-bottom">”</div>
                                                                                <div class="arrow-top"></div>
                                                                                <p><?php echo wpautop(strip_tags($field->testimony)); ?></p>
                                                                                <cite><?php echo $field->from; ?></cite>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                </div>
                                        </div>
                                        <?php
                                endwhile;
                        endif;
                        wp_reset_query();
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>