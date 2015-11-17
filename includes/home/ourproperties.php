<?php
 $props = get_theme_mod( 'properties' );
 $props = array_filter( $props );
 $props = (object) $props;
 ?>
<div class="container-fluid section section-ourproperties" id="section-ourproperties">
        <div class="container">
                <div class="row">
                    <div class="col-md-12 heading">
                        <h2><?php echo $props->heading; ?></h2>
                        <hr>
                        <p><?php echo $props->tagline; ?></p>
                    </div>
                </div>
                <div class="row">
                <?php
                # Most Viewed
                query_posts('meta_key=post_views_count&orderby=rand&numberposts=1&category_name=camella-series&posts_per_page=1');
                
                if (have_posts()) :
                        while (have_posts()) : the_post(); ?>
                                <div class="col-md-4 key-item international-item best-item move 10px">
                                        <div class="panel panel-primary">
                                                <div class="panel-body text-center">
                                                        <div class="key-icon-container">
                                                                <?php $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
                                                                <div class="best-image shadow" style="background-image: url('<?php echo $feat_image ?>');"></div>
                                                        </div> 
                                                        <h4><?php the_title(); ?></h4>                                        
                                                </div>
                                                <div class="panel-footer no-padding"><center>
                                                        <a target="_blank" href="<?php the_permalink(); ?>" class="btn"><font color="white">MOST VIEWED</font></a>
                                                </center></div>
                                        </div>
                                </div>
                        <?php endwhile;
                endif;
                wp_reset_query();
                wp_reset_postdata();
                
                # Most Popular
                query_posts('meta_key=post_views_count&orderby=rand&numberposts=1&category_name=camella-series&posts_per_page=1');
                if (have_posts()) :
                        while (have_posts()) : the_post(); ?>
                                <div class="col-md-4 key-item international-item move best-item 10px">
                                        <div class="panel panel-primary">
                                                <div class="panel-body text-center">
                                                        <div class="key-icon-container">
                                                                <?php $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
                                                                <div class="best-image shadow" style="background-image: url('<?php echo $feat_image ?>');"></div>
                                                        </div> 
                                                        <h4><?php the_title(); ?></h4>
                                                </div>
                                                <div class="panel-footer no-padding"><center>
                                                        <a target="_blank" href="<?php the_permalink(); ?>" class="btn"><font color="white">MOST POPULAR MODEL</font></a>
                                                </center></div>
                                        </div>
                                </div>
                <?php
                endwhile; endif;
                wp_reset_query();
                wp_reset_postdata();
                
                # Best seller
                query_posts('orderby=rand&numberposts=1&category_name=camella-series&posts_per_page=1');
                if (have_posts()) :
                        while (have_posts()) : the_post(); ?>
                        <div class="col-md-4 key-item international-item best-item move 10px">
                                <div class="panel panel-primary">
                                        <div class="panel-body text-center">
                                                <div class="key-icon-container">
                                                <?php $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
                                                <div class="best-image shadow" style="background-image: url('<?php echo $feat_image ?>');"></div>
                                        </div> 
                                        <h4><?php the_title(); ?></h4></div>
                                        <div class="panel-footer no-padding"><center>
                                        <a target="_blank" href="<?php the_permalink(); ?>" class="btn"><font color="white">BEST SELLER</font></a>
                                        </center></div>
                        </div></div>
                <?php
                        endwhile; endif;
                        wp_reset_query();
                        wp_reset_postdata();
                ?>
                </div>
                <div class="row">
                        <div class="col-md-12 text-center communities-groups">
                            <?php
                                // get property sub category
                                $categoryId = get_category_by_slug('locations'); 
                                $categoryId = $categoryId->term_id;
        
                                $args = array(
                                    'parent'        => $categoryId,
                                    'hierarchical'  => 0,
                                    'orderby'       => 'id',
                                    'order'         => 'ASC',
                                    'hide_empty'    => 0
                                );
                                $categories = get_categories($args);
                                echo '<a href="#" class="btn btn-default btn-lg2 active" data-location-id="">ALL</a>';
                                foreach($categories as $key => $value){
                                    $name = $value->name;
                                    $locationId = $value->term_id;
                                    echo '<a href="#" class="btn btn-default btn-lg2" data-location-id="'.$locationId.'">'.strtoupper($name).'</a>';
                                }
                            ?>
                        </div>
                        <div class="col-md-12 map-container active" id="index-properties"></div>
                </div>
        </div>
</div>