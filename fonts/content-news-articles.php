<article class="article-list col-sm-6 col-md-4">
    <?php
        if (has_post_thumbnail()) {
            ?>
            <div class="article-hero-image">
                <?php
                    $featured_id = get_post_thumbnail_id($post->ID); 
                    $postFeatured = wp_get_attachment_image_src( (int) $featured_id, 'property_image' ); ?>
                <a target="_blank" href="<?php the_permalink(); ?>"><img src="<?php echo $postFeatured; ?>" class="img-responsive"></a>
            </div>
            <div class="article-content">
            	<h3><a target="_blank" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            </div>
            <?php
        }
    ?>
</article>
