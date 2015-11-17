    <!-- masterplanned communities section -->
    <?php
    $masterplanned = (array) get_theme_mod( 'masterplanned' );
    $masterplanned = array_filter( $masterplanned );
    $masterplanned = (object) $masterplanned;
    ?>
    <div class="container-fluid section section-masterplanned" id="section-masterplanned">
        <div class="container">
            <div class="row">
                <div class="col-md-12 heading">
                    <h2><?php echo $masterplanned->heading; ?></h2>
                    <hr>
                    <p><?php echo $masterplanned->tagline; ?></p>
                    <?php
                    if( (int) $masterplanned->img > 0 ):
                        $img = wp_get_attachment_image_src( (int) $masterplanned->img, 'full' );
                        ?>
                        <img src="<?php echo esc_url($img[0]); ?>" class="img-responsive" />
                    <?php endif; ?>
                    <p><?php echo $masterplanned->desc; ?></p>
                    <a href="<?php echo esc_attr($masterplanned->readmore); ?>">
                        <button type="button" class="btn btn-primary btn-lg calculator-calculate">Read More</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
	
	