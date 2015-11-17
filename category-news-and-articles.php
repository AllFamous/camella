<?php get_header(); ?>
<?php
	include_once('includes/inside/mast-header.php');
?>
    <div class="container-fluid inner-page-content">
        <div class="container">
            <div class="row basic-page">
                <div class="col-md-12">

                	<?php $my_query = new WP_Query( 'category_name=news-and-articles&posts_per_page=1' );
						while ( $my_query->have_posts() ) : $my_query->the_post();
						$do_not_duplicate = $post->ID; ?>
							<article class="article-featured">
							    <?php
							        if (has_post_thumbnail()) {
							            ?>
							            <h1><a target="_blank" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
							            <div class="article-hero-image">
							                <?php $postFeatured = wp_get_attachment_url(get_post_thumbnail_id($post->ID)); ?>
							                <a target="_blank" href="<?php the_permalink(); ?>"><img src="<?php echo $postFeatured; ?>" class="img-responsive"></a>
							            </div>
							            <div class="article-content">
							                <p><?php echo wp_trim_words($post->post_content, 90, '...'); ?></p>
							                <a target="_blank" href="<?php the_permalink(); ?>" class="btn btn-primary">READ MORE</a>
							            </div>
							            <?php
							        }
							    ?>
							</article>
							<hr class="article-divider">
					<?php endwhile; ?>

					<?php if (have_posts()) : ?>
						<?php
						while (have_posts()) : the_post(); if ( $post->ID == $do_not_duplicate ) continue;
							get_template_part('content-news-articles', get_post_format());
						endwhile;
						echo '<div style="clear: both;"></div>';
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
            </div>
        </div>
    </div>
<?php
	include_once('includes/home/howtos.php');
	include_once('includes/home/homeowners.php');
	include_once('includes/home/largest.php');
?>
<?php get_footer(); ?>