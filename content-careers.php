<article class="article-list">
    <?php
        if (has_post_thumbnail()) {
            ?>
            <div class="article-hero-image">
                <?php $postFeatured = wp_get_attachment_url(get_post_thumbnail_id($post->ID)); ?>
                <a href="<?php the_permalink(); ?>"><img src="<?php echo $postFeatured; ?>" class="img-responsive"></a>
            </div>
            <?php
        }
    ?>
    <div class="article-content">
    	<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
        <p><?php echo wp_trim_words($post->post_content, 90, '...'); ?></p>
        <a href="<?php the_permalink(); ?>" class="btn btn-primary">READ MORE</a>
    </div>
</article>
<hr class="article-divider">
