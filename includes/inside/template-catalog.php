    <!-- page content -->
    <?php
        if (has_post_thumbnail()) {
            ?>
            <div class="container-fluid article-hero-image">
                <?php $postFeatured = wp_get_attachment_url(get_post_thumbnail_id($post->ID)); ?>
                <img src="<?php echo $postFeatured; ?>" class="img-responsive">
            </div>
            <?php
        }
    ?>

    <div class="container-fluid inner-page-content">
        <div class="container">
            <div class="row basic-page">
                <div class="col-md-9">
                    <article class="main-article">
                        <h1><?php the_title(); ?></h1>
                        <div class="properties-social">
                            <h4><?php echo get_field('contentHeader') ?></h4>
                            <p><?php echo get_field('contentSubheader') ?></p>
                        </div>
                        <p><?php echo nl2br($post->post_content); ?></p>

                        <!-- amenities -->
                        <h3 class="article-header-divider">House Features</h3>
                        <p><?php echo get_field('houseFeatures'); ?></p>

                        <!-- floor plan -->
                        <?php
                            if (get_field('floorPlanImage')){
                                ?>
                                    <h3 class="article-header-divider">Floor Plan</h3>
                                    <div class="gallery-container">
                                        <ul class="list-inline">
                                        <?php
                                            $floorPlanImage = get_field('floorPlanImage');
                                            echo '<li><a href="#" data-toggle="tooltip" data-placement="top" title="view image" data-toggle="lightbox" data-gallery="floorPlanImages" data-remote="'.$floorPlanImage.'" data-title="Image" class="gallery-lightbox"><img src="'.$floorPlanImage['url'].'" width="200px"></a><li>';
                                            
										?>
                                        </ul>
                                    </div>
                                <?php
                            }
                        ?>

                        <!-- video tour -->
                        <?php
                            if (get_field('videoTourLink')){
                                ?>
                                    <h3 class="article-header-divider">Video Tour</h3>
                                    <div class="responsive-video">
                                        <iframe src="<?php echo get_field('videoTourLink'); ?>" frameborder="0" allowfullscreen></iframe>
                                    </div>
                                <?php
                            }
                        ?>

                        <!-- gallery -->
                        <?php
                        $galleryImages = get_field('imageGallery');
                        if( is_array( $galleryImages ) || is_object( $galleryImages ) ):
                        /**
                         * Only show the gallery if there are images set.
                         **/
                        ?>
                        <h3 class="article-header-divider">Image Gallery</h3>
                        <div class="gallery-container owl-carousel">
                            <ul class="list-inline">
                                <?php
                                        foreach ($galleryImages as $key => $value) {
                                            echo '<li><a href="#" data-toggle="tooltip" data-placement="top" title="view image" data-toggle="lightbox" data-gallery="propertyGallery" data-remote="'.$value['url'].'" data-title="Image" class="gallery-lightbox"><img src="'.$value['sizes']['thumbnail'].'"></a></li>';
                                        }
                                ?>
                            </ul>
                        </div>
                        <?php endif; ?>

                        <!-- locations -->
                        <h3 class="article-header-divider">Locations</h3>
                        <div id="location-container" data-post_id="<?php the_ID(); ?>" data-nonce="<?php echo wp_create_nonce( 'get_location_properties' ); ?>"></div>
                        
                        <!-- house models -->
                        <?php
                            // get category ids
                            $categories = get_the_category($post->ID);
                            $catId = 0;
                            foreach ($categories as $key => $value) {
                                if ($value->term_id >= $catId){
                                    $catId = $value->term_id;
                                }
                            }
                            $args = array(
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'category',
                                        'field' => 'id',
                                        'terms' => $catId
                                    )
                                )
                            );
                            $query = new WP_Query($args);
                            $houseModels = $query->posts;
                        ?>
                        <h3 class="article-header-divider project-house-models" data-house-models="<?php echo $houseModels; ?>">Related House Models</h3>
                        <div id="house-model-container">
                            <div class="series-catalog-item owl-carousel">
                                <?php
                                    foreach ($houseModels as $key => $value) {
                                        if ($value->ID != $post->ID){
                                            ?>
                                            <div>
                                                <?php
                                                    $modelId = $value->ID;
                                                    $image = get_field('modelImage', $modelId);
                                                ?>
                                                <div class="panel panel-default no-shadow">
                                                    <div class="panel-heading no-padding"><a href="<?php echo get_permalink($modelId); ?>"><img src="<?php echo $image; ?>" class="img-responsive"></a></div>
                                                    <div class="panel-body"><a href="<?php echo get_permalink($modelId); ?>"><?php echo $value->post_title; ?></a></div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                ?>
                            </div>
                        </div>

                        <a href="<?php echo esc_url( add_query_arg( 'catalog_id', $modelId, home_url( '/sales-inquiries/' ) ) ); ?>" class="btn btn-primary btn-lg margin-top-lg">CONTACT AN AGENT</a>

                    </article>
                </div>
                <div class="col-md-3">
                    <?php include_once('right-column.php'); ?>
                </div> 
            </div>
        </div>
    </div>