    <!-- strip section - homeowner -->
    <?php
    $vista = (array) get_theme_mod( 'vista' );
    $vista = (object) array_filter( $vista );
    $img = 'http://www.camella.com.ph/wp-content/themes/camella/img/content/strip-homeowners.jpg';
    if( (int) $vista->featured > 0 ){
        $imgs = wp_get_attachment_image_src( (int) $vista->featured, 'full' );
        $img = $imgs[0];
    }
    ?>
    <div class="container-fluid section-strip section-homeowners" id="section-homeowners" style="background-image: url(<?php echo $img; ?>);">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-4 strip-content"> 
                    <h2><?php echo $vista->title; ?></h2>
                    <p><?php echo $vista->desc; ?></p>
                    <a href="<?php echo esc_attr($vista->link); ?>" target="_blank" class="btn btn-secondary btn-lg">REGISTER WITH US</a>
                </div>
            </div>
        </div>
    </div>