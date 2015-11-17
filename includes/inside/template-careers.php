    <!-- page content -->
    <?php
    
 # Put inside the loop to read all built-in functions and plugins to work
 if( have_posts() ):
        while( have_posts() ):
                the_post();
                
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
                        <p><i class="fa fa-map-marker"></i> <?php echo get_field('jobLocation') ?></p>

                        <!-- general description -->
                        <h3 class="article-header-divider">General Description</h3>
                        <div class="entry-content"><?php the_content(); ?></div>

                        <a href="http://testdev.camella.com.ph/category/careers/" class="btn btn-primary btn-lg margin-top-lg">BACK TO MAIN</a>
                        <a href="<?php echo esc_url( add_query_arg( 'career_id', $post->ID, home_url('/job-application/' ) )); ?>" class="btn btn-secondary btn-lg margin-top-lg">APPLY NOW!</a>
                    </article>
                </div>
                <div class="col-md-3">
                    <?php include_once('right-column.php'); ?>
                </div> 
            </div>
        </div>
    </div>
<?php endwhile; endif; ?>