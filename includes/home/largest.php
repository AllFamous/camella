    <!-- why choose section -->
    <?php
    $devs = (array) get_theme_mod( 'devs' );
    $devs = (object) array_filter( $devs );
    ?>
    <div class="container-fluid section section-whychoose" id="section-whychoose">
        <!--<div class="section-overlay grid"></div> -->
        <div class="container">
            <!-- section header -->
            <div class="row">
                <div class="col-md-12 heading">
                    <h2><?php echo $devs->heading; ?></h2>
                    <hr>
                    <p><?php echo $devs->tagline; ?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="whychoose-container owl-carousel">
                        <?php
                        global $wp_query, $post;
                        $wp_query = new WP_Query( array(
                                'post_type' => 'awards'
                        ));
                        $index = 0;
                        if( have_posts() ):
                                while( have_posts() ):
                                        the_post();
                                        
                                ?>
                                <div class="wch-<?php echo $index; ?>">
                                        <div class="key-item text-center">
                                                <div class="key-icon-container">
                                                        <div class="key-icon key-icon-lg shadow" style="padding-top: 0;">
                                                                <?php the_post_thumbnail('thumbnail'); ?>
                                                        </div>
                                                </div>
                                                <?php the_title( '<h4>', '</h4>' ); ?>
                                                <span class="whychoose-line"></span>
                                                <p><?php echo wpautop(strip_tags($post->post_content)); ?></p>
                                        </div>
                                </div>
                                <?php
                                $index++;
                                endwhile;
                        endif;
                        wp_reset_query();
                        wp_reset_postdata(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>