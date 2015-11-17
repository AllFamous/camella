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
        // set post views
        $postId = get_the_ID();
        setPostViews($postId);
    ?>

    <div class="container-fluid inner-page-content">
        <div class="container">
            <div class="row basic-page">
                <div class="col-md-9">
                    <article class="main-article">
                        <h1><?php the_title(); ?></h1>
                        <div class="article-meta pull-left">
                            <div class="meta-title">SHARE</div>
                            <div class="social-buttons small">
                                <ul class="no-bullets inline">
                                    <li class="text-center"><a href="http://www.shareaholic.com/api/share/?v=1&apitype=1&apikey=8943b7fd64cd8b1770ff5affa9a9437b&service=5&link=<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?>" class="fb"><i class="fa fa-facebook"></i></a></li>
                                    <li class="text-center"><a href="http://www.shareaholic.com/api/share/?v=1&apitype=1&apikey=8943b7fd64cd8b1770ff5affa9a9437b&service=7&link=<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?>" class="tw"><i class="fa fa-twitter"></i></a></li>
                                    <li class="text-center"><a href="http://www.shareaholic.com/api/share/?v=1&apitype=1&apikey=8943b7fd64cd8b1770ff5affa9a9437b&service=304&link=<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?>" class="gp"><i class="fa fa-google-plus"></i></a></li>
                                    <li class="text-center"><a href="http://www.shareaholic.com/api/share/?v=1&apitype=1&apikey=8943b7fd64cd8b1770ff5affa9a9437b&service=309&link=<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?>" class="pi"><i class="fa fa-pinterest"></i></a></li>
                                    <li class="text-center transition"><a href="#" class="pl social-more"><i class="fa fa-plus"></i></a></li>
                                    <li class="text-center hide transition"><a href="http://www.shareaholic.com/api/share/?v=1&apitype=1&apikey=8943b7fd64cd8b1770ff5affa9a9437b&service=88&link=<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?>" class="li"><i class="fa fa-linkedin"></i></a></li>
                                    <li class="text-center hide transition"><a href="http://www.shareaholic.com/api/share/?v=1&apitype=1&apikey=8943b7fd64cd8b1770ff5affa9a9437b&service=313&link=<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?>" class="em"><i class="fa fa-envelope"></i></a></li>
                                </ul>
                            </div>
                            <div class="meta-title">DETAILS</div>
                            <ul class="fa-ul meta-details">
                                <li><i class="fa-li fa fa-calendar"></i> <?php echo get_the_date('M d, Y', $postId); ?></li>
                                <li><i class="fa-li fa fa-file"></i> <?php echo getPostViews($postId); ?></li>
                            </ul>
                            <div class="meta-title">TAGS</div>
                            <ul class="no-bullets inline list-tags">
                                <?php
                                    $tags = get_the_tags($postId);
                                    foreach($tags AS $keyTag => $valueTag){
                                        $tagLink = '#';
                                        $tagLink = get_tag_link($valueTag->term_id);
                                        echo '<li><a href="'.$tagLink.'">'.strtoupper($valueTag->name).'</a></li>';
                                    }
                                ?>
                            </ul>
                        </div>
                        <p><?php echo nl2br($post->post_content); ?></p>

                        <a href="http://testdev.camella.com.ph/news-and-articles/" class="btn btn-primary btn-lg margin-top-lg">BACK TO MAIN</a>
						<br>
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
                    </article>
                </div>
                <div class="col-md-3">
                    <?php // include_once('right-column.php'); ?>
                </div> 
            </div>
        </div>
    </div>