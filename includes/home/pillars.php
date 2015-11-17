<div class="container-fluid section section-pillars" id="section-pillars">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div id="carousel-promos" class="owl-carousel shadow">
                        <?php
                        $carousel1 = (array) get_theme_mod( 'front_carousel' );
                        $carousel1 = array_filter( $carousel1 );
                        
                        foreach( $carousel1 as $carousel ):
                                if( (int) $carousel > 0 ):
                                        $image = wp_get_attachment_image_src( (int) $carousel, 'full' );
                                        ?>
                                        <div class="pillar-carousel">
                                                <a href="http://camella.com.ph" target="_blank" data-image-url="<?php echo esc_url($image[0]); ?>"></a>
                                        </div>
                                        <?php
                                endif;
                        endforeach;
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        wp_enqueue_style( 'dashicons' );
        $five_point = (array) get_theme_mod( 'five_point' );
        $five_point = (object) array_filter( $five_point );
        ?>
        <div class="container">
            <div class="row">
                <div class="col-md-12 heading">
                    <h2><?php echo $five_point->heading; ?></h2>
                    <hr>
                    <p><?php echo $five_point->tagline; ?></p>
                </div>
                <?php
                $advantage = (array) get_theme_mod( 'advantage' );
                $advantage = array_filter( $advantage );
                $icons = array(
                       'dream' => 'dashicons dashicons-admin-multisite',
                       'convenience' => 'fa-road',
                       'security' => 'fa-key',
                       'investments' => 'fa-check',
                       'affordability' => 'fa-thumbs-up' 
                );
                $animCount = 0;
                foreach( $advantage as $kind => $point ):
                        $point = (object) $point;
                        $icon = $icons[$kind];
                        $animCount = $animCount + 0.2;
                ?>
                <div class="col-md-5ths">
                        <div class="key-icon-container">
                                <div class="key-icon shadow transition">
                                        <i class="fa <?php echo $icon; ?> fa-fw"></i>
                                </div><h3><?php echo $point->title; ?></h3>
                        </div>
                        <div class="panel panel-default panel-pillars transition" data-sr="move 50px wait <?php echo $animCount; ?>s">
                                <div class="panel-body"><p><?php echo $point->desc; ?></p></div>
                                <div class="panel-footer transition">
                                        <a href="<?php echo esc_attr($point->url); ?>" target = "_blank" class="btn btn-primary btn-sm">READ MORE</a>
                                </div>
                        </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
</div>