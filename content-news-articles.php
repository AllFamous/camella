<article class="article-list col-sm-6 col-md-4">
    <?php
        if (has_post_thumbnail()) {
            ?>
            <div class="article-hero-image">
                <?php $postFeatured = wp_get_attachment_url(get_post_thumbnail_id($post->ID)); ?>
                <a target="_blank" href="<?php the_permalink(); ?>"><img src="<?php echo $postFeatured; ?>" class="img-responsive"></a>
            </div>
            <div class="article-content">
            	<h3><a target="_blank" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            </div>
            <?php
        }
    ?>
</article>
