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
                        <p><i class="fa fa-map-marker"></i> <?php echo get_field('locationText') ?></p>
                        <div class="properties-social">
                            <h4><?php echo get_field('contentHeader') ?></h4>
                            <p><?php echo get_field('contentSubheader') ?></p>
                        </div>
                        <p><?php echo nl2br($post->post_content); ?></p>

                        <!-- amenities -->
                        <h3 class="article-header-divider">Amenities</h3>
                        <p><?php echo get_field('projectAmenities'); ?></p>

                        <!-- gallery -->
                        <h3 class="article-header-divider">Image Gallery</h3>
                        <div class="gallery-container">
                            <ul class="list-inline">
                            <?php
                                $galleryImages = get_field('imageGallery');                                
                                foreach ($galleryImages as $key => $value) {
                                    echo '<li><a href="#" data-toggle="tooltip" data-placement="top" title="view image" data-toggle="lightbox" data-gallery="propertyGallery" data-remote="'.$value['url'].'" data-title="Image" class="gallery-lightbox"><img src="'.$value['sizes']['thumbnail'].'"></a><li>';
                                }
                            ?>
                            </ul>
                        </div>

                        <!-- house models -->
                        <?php
                            $houseModels = get_field('houseModels');
                            $houseModelException = get_field('houseModelExceptions');
                            $houseModelException = explode(',', $houseModelException);
                        ?>
                        <h3 class="article-header-divider project-house-models" data-house-models="<?php echo $houseModels; ?>">House Models</h3>
                        <div id="house-model-container">
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <?php
                                    foreach($houseModels AS $key => $value){
                                        ?>
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="seriesOne">
                                                <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#content<?php echo $key; ?>" aria-expanded="true" aria-controls="contentOne"><?php echo get_cat_name($value); ?> </a></h4>
                                            </div>
                                            <div id="content<?php echo $key; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="series<?php echo $key; ?>">
                                                <div class="panel-body">
                                                    <div class="series-house-item owl-carousel">                                        
                                                    <?php
                                                        $args = array(
                                                            'numberposts'       => -1,
                                                            'category'          => $value,
                                                            'post_status'       => 'publish'
                                                        );
                                                        $posts = get_posts($args);
                                                        if ($posts){
                                                            foreach ($posts as $keyCatalog => $valueCatalog) {
                                                                if (!in_array($valueCatalog->post_name, $houseModelException)){
                                                                    $modelImage = get_field('modelImage', $valueCatalog->ID);
                                                                    ?>
                                                                        <div>
                                                                            <div class="panel panel-default no-shadow">
                                                                                <div class="panel-heading no-padding"><a href="<?php echo get_permalink($valueCatalog->ID); ?>"><img src="<?php echo $modelImage; ?>"></a></div>
                                                                                <div class="panel-body"><a href="<?php echo get_permalink($valueCatalog->ID); ?>"><?php echo $valueCatalog->post_title; ?></a></div>
                                                                            </div>
                                                                        </div>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                ?>
                            </div>
                        </div>

                        <!-- map -->
                        <h3 class="article-header-divider">How To Get There</h3>
                        <input id="pac-input" class="controls" type="text" placeholder="enter starting location">
                        <div id="type-selector" class="controls">
                            <input type="radio" name="type" id="changetype-all" checked="checked">
                            <label for="changetype-all">All</label>

                            <input type="radio" name="type" id="changetype-establishment">
                            <label for="changetype-establishment">Establishments</label>

                            <input type="radio" name="type" id="changetype-address">
                            <label for="changetype-address">Addresses</label>

                            <input type="radio" name="type" id="changetype-geocode">
                            <label for="changetype-geocode">Geocodes</label>
                        </div>
                        <button class="btn btn-primary" id="directions-button" data-start-lat="" data-start-long="">GET DIRECTIONS</button>
                        <div id="map-inside" data-long="<?php echo get_field('locationLong'); ?>" data-lat="<?php echo get_field('locationLat'); ?>"></div>

                        <!-- landmarks -->
                        <h3 class="article-header-divider">Landmarks</h3>
                        <p><?php echo get_field('projectLandmarks'); ?></p>

                        <a href="<?php echo esc_attr( home_url( '/sales-inquiries' ) ); ?>" class="btn btn-primary btn-lg margin-top-lg">CONTACT AN AGENT</a>
                    </article>
                </div>
                <div class="col-md-3">
                    <?php include_once('right-column.php'); ?>
                </div> 
            </div>
        </div>
    </div>
