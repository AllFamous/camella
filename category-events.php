<?php get_header(); ?>
<?php
	include_once('includes/inside/mast-header.php');
?>
    <div class="container-fluid inner-page-content">
        <div class="container">
            <div class="row basic-page">
                <div class="col-md-9">

					<?php if (have_posts()) : ?>
						<?php
						while (have_posts()) : the_post();
							get_template_part('content-events', get_post_format());
						endwhile;
						the_posts_pagination(array(
							'prev_text'          => __('Previous Page', 'camellatheme'),
							'next_text'          => __('Next Page', 'camellatheme'),
							'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( '', 'camellatheme' ) . ' </span>',
							'screen_reader_text' => ''
						) );
					else :
						get_template_part('content', 'none');
					endif;
					?>
                </div>
                <div class="col-md-3">
                    <?php include_once('includes/inside/right-column.php'); ?>
                </div> 
            </div>
        </div>
    </div>
<?php
	include_once('includes/home/howtos.php');
	include_once('includes/home/homeowners.php');
	include_once('includes/home/largest.php');
?>
<?php get_footer(); ?>