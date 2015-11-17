<?php
/* Template Name: Camella Two Columns Page */ 

 if( isset($_REQUEST['nonce']) && wp_verify_nonce( $_REQUEST['nonce'], 'get_careers' ) ):
 /****
  * Retrieve the list of careers and output it in json format.
  **************************************************************/
        get_template_part( 'includes/ajax-query/get-careers' ); exit;
        
 endif;
 
 get_header(); 

	include_once('includes/inside/mast-header.php');
        
 /**
  * Most posts built-in functions will not work if not inside the loop!
  **/
 
 if( have_posts() ):
        while( have_posts() ): the_post(); ?>

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
                        <h1 class="hidden"><?php the_title(); ?></h1>
                        <div class="entry-content"><?php the_content(); ?></div>
                    </article>
                </div>
                <div class="col-md-3">
                    <?php include_once('includes/inside/right-column.php'); ?>
                </div> 
            </div>
        </div>
    </div>


<?php
  endwhile; endif; // End loop
  
	include_once('includes/home/howtos.php');
	include_once('includes/home/homeowners.php');
	include_once('includes/home/largest.php');
        
        # include template-scripts to show random-properties and inquiry form if submitted
        get_template_part( 'includes/home/template-script' );
        wp_enqueue_script( 'random-properties', get_template_directory_uri() . '/js/common/random-properties.js' );
        wp_localize_script( 'random-properties', 'camella_js', array(
                'nonce' => wp_create_nonce( 'refine_search_results' ),
                'home' => home_url()
        ));
        
 get_footer(); ?>