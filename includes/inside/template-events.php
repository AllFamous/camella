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
                        <p><i class="fa fa-map-marker"></i> <?php echo get_field('eventLocation') ?></p>
                        <p><?php echo nl2br($post->post_content); ?></p>

                        <!-- location -->
                        <h3 class="article-header-divider">Event Location</h3>
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

                        

                        <!-- gallery -->
                        <h3 class="article-header-divider">Event Gallery</h3>
                        <div class="gallery-container">
                            <ul class="list-inline">
                            <?php
                                $galleryImages = get_field('eventGallery');
                                foreach ($galleryImages as $key => $value) {
                                    echo '<li><a href="#" data-toggle="tooltip" data-placement="top" title="view image" data-toggle="lightbox" data-gallery="eventGallery" data-remote="'.$value['url'].'" data-title="Image" class="gallery-lightbox"><img src="'.$value['sizes']['thumbnail'].'"></a><li>';
                                }
                            ?>
                            </ul>
                        </div>

                        <a href="http://testdev.camella.com.ph/events/" class="btn btn-primary btn-lg margin-top-lg">BACK TO MAIN</a>

                    </article>
					<div class="panel panel-grey widget-container widget-latest-news no-shadow">
                        <div class="panel-heading"><h4><i class="fa fa-file-text"></i> Latest News & Articles</h4></div>
                        <div class="panel-body">

                            <?php
                                $categoryId = get_category_by_slug('news-and-articles');
                                $categoryId = $categoryId->term_id;
                                $args = array(
                                    'numberposts'       => 1,
                                    'category'          => $categoryId,
                                    'post_status'       => 'publish',
                                    'tax_query'      => array(
                                        array(
                                            'taxonomy'  => 'post_tag',
                                            'field'     => 'slug',
                                            'terms'     => sanitize_title('featured')
                                        )
                                    )                           
                                );
                                $posts = get_posts($args);

                                if ($posts){
                                    foreach ($posts as $key => $value) {
                                        $featuredImage = wp_get_attachment_url(get_post_thumbnail_id($value->ID), 'full');
                                        ?>
                                            <article class="news-latest">
                                                <a href="<?php echo get_permalink($value->ID); ?>"><img src="<?php echo $featuredImage; ?>" class="img-responsive"></a>
                                                <h2><a href="<?php echo get_permalink($value->ID); ?>"><?php echo $value->post_title; ?></a></h2>
                                                <p><?php echo wp_trim_words($value->post_content, 30, '...'); ?></p>
                                                <a href="<?php echo get_permalink($value->ID); ?>" class="btn btn-primary btn-sm">READ MORE</a>
                                            </article>
                                        <?php
                                    }
                                }

                                // rest of the articles
                                $exeptionTerm = get_term_by('slug', 'featured', 'post_tag');
                                $categoryId = get_category_by_slug('news-and-articles');
                                $categoryId = $categoryId->term_id;
                                $args = array(
                                    'tag__not_in'       => array($exeptionTerm->term_id),
                                    'numberposts'       => 3,
                                    'category'          => $categoryId,
                                    'post_status'       => 'publish'
                                );
                                $posts = get_posts($args);

                                if ($posts){
                                    echo '<h5 class="more-news"><i class="fa fa-file-text"></i> More News</h5>';
                                    foreach ($posts as $key => $value) {
                                        $featuredImage = wp_get_attachment_url(get_post_thumbnail_id($value->ID), 'full');
                                        ?>
                                            <article class="news-others">
                                                <div class="media">
                                                    <div class="media-left"><a href="<?php echo get_permalink($value->ID); ?>"><img src="<?php the_field('thumbImage', $value->ID); ?>"></a></div>
                                                    <div class="media-body">
                                                        <h5><a href="<?php echo get_permalink($value->ID); ?>"><?php echo $value->post_title; ?></a></h5>
                                                        <p><?php echo wp_trim_words($value->post_content, 20, '...'); ?></p>
                                                        <a href="<?php echo get_permalink($value->ID); ?>" class="btn btn-primary btn-xs">READ MORE</a>
                                                    </div>
                                                </div>
                                            </article>
                                        <?php
                                    }
                                }
                            ?>
                        </div>
                </div>
                </div>
                <div class="col-md-3">
                    <?php // include_once('right-column.php'); ?>
                </div> 
            </div>
        </div>
    </div>