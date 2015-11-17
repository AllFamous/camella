<?php
/**
 * Retrieve properties location hierarchy base on the given post_id
 **/

 //if( (!isset( $_REQUEST['post_id']) || (int) $_REQUEST['post_id'] == 0 )
  //  || ( ! isset( $_REQUEST['category_id'] ) || (int) $_REQUEST['category_id'] == 0 ) ) return; // Bail early if no ID set!
 
 global $wp_query, $post, $wpdb;
 $location_id = get_term_by( 'slug', 'locations', 'category' );
 $category_id = isset( $_REQUEST['category_id'] ) ? (int) $_REQUEST['category_id'] : null;
 
 # Term boundaries
 if( isset( $_REQUEST['post_id']) && (int) $_REQUEST['post_id'] > 0 ):
 
 $boundaries = wp_get_object_terms( (int) $_REQUEST['post_id'], 'category' );
 $args = array( 'post_type' => 'post', 'meta_key' => 'houseModels', 'meta_compare' => 'LIKE', 'posts_per_page' => -1 );
  
 if( ! is_wp_error( $boundaries ) ):
        
        # Get catalog id
        $catalog_id = get_term_by( 'slug', 'catalog', 'category' );
        
        if( ! is_wp_error( $catalog_id ) ):
                $catalog_id = $catalog_id->term_id;
               
                # Assumes each item assigns only 1 series
                foreach( $boundaries as $boundary ):
                        if( $boundary->parent == $catalog_id ):
                                $series_id = $boundary->term_id;
                                $args['meta_value'] = $series_id;
                        endif;
                endforeach;
        endif;
 endif;
 
 $args['tax_query'] = array(
        'relation' => 'AND',
        array(
                'taxonomy' => 'category',
                'field' => 'slug',
                'terms' => 'locations'
        )
 );
 
 else:
        $args = array(
                'post_type'  => 'post',
                'posts_per_page' => -1,
                'meta_key' => 'houseModels'
        );
 endif;
 
 $wp_query = new WP_Query( $args );

 $metro_manila = get_term_by( 'slug', 'metro-manila', 'category' );
 $luzon = get_term_by( 'slug', 'luzon', 'category' );
 $visayas = get_term_by( 'slug', 'visayas', 'category' );
 $mindanao = get_term_by( 'slug', 'mindanao', 'category' );
 $hierarchy = array(
        $metro_manila->name => array(),
        $luzon->name => array(),
        $visayas->name => array(),
        $mindanao->name => array()
 );
 
 if( have_posts() ):
        while( have_posts() ):
                the_post();
                
                # House Models
                $models = (array) get_post_meta( $post->ID, 'houseModels', true );
                $models = array_filter($models);
                
                # Get island group
                $island = wp_get_object_terms( $post->ID, 'category', array( 'parent' => $location_id->term_id ) );
                $island = $island[0];
                
                if( ! isset( $hierarchy[$island->name] ) ){
                        $hierarchy[$island->name] = array();
                }
                
                # Get region/province
                $region = wp_get_object_terms( $post->ID, 'category', array( 'parent' => $island->term_id ) );
        
                if( $island->name && ! is_wp_error( $region ) ):
                        $region = $region[0];
                        
                        if( ! isset( $hierarchy[$island->name][$region->name] )):
                                $hierarchy[$island->name][$region->name] = array();
                        endif;
                        
                        # Get city
                        $city = wp_get_object_terms( $post->ID, 'category', array( 'parent' => $region->term_id ) );
                        
                        if( ! is_wp_error( $city ) ):
                                $city = $city[0];
                                
                                if( !isset( $hierarchy[$island->name][$region->name][$city->name] )):
                                        $hierarchy[$island->name][$region->name][$city->name] = array();
                                endif;
                                
                                $hierarchy[$island->name][$region->name][$city->name][$post->ID] = get_post();
                                
                                if( $category_id && !in_array($category_id, $models) ):
                                        unset( $hierarchy[$island->name][$region->name][$city->name][$post->ID]);
                                endif;
                               // $hierarchy[$island->name][$region->name][$city->name] = array_filter($hierarchy[$island->name][$region->name][$city->name]);
                        else:
                                $hierarchy[$island->name][$region->name][$post->ID] = get_post();
                                if( $category_id && !in_array($category_id, $models) ):
                                        unset( $hierarchy[$island->name][$region->name][$post->ID]);
                                endif;
                        endif;
                       // $hierarchy[$island->name][$region->name] = array_filter($hierarchy[$island->name][$region->name]);
                endif;
        endwhile;
 endif;
 
 $hierarchy = array_filter( $hierarchy );
 
 if( count( $hierarchy ) ): ?>
        <div class="row">
        
        <?php foreach( $hierarchy as $island => $regions ):
                $regions = array_filter( $regions );
                if( count( $regions ) > 0 ): ?>
                <div class="col-md-3 location-item">
                        <h4><i class="fa fa-map-marker"></i> <?php echo $island; ?></h4>
                        <ul class="fa-ul">
                                <?php foreach( $regions as $region => $cities ):
                                        $cities = array_filter( $cities );
                                        if( count( $cities ) > 0 ): ?>
                                                <li>
                                                        <i class="fa fa-angle-right"></i>
                                                        <strong><?php echo $region; ?></strong>
                                                        <ul class="fa-ul">
                                                                <?php foreach( $cities as $city => $properties ):
                                                                        $properties = is_object( $properties ) ? $properties : array_filter( $properties ); ?>
                                                                <li>
                                                                        <?php if( (int) $city > 0 ): ?>
                                                                                <i class="fa fa-home"></i>
                                                                                <strong>
                                                                                        <a href="<?php echo esc_attr( get_permalink( $city ) ); ?>"><?php echo $properties->post_title; ?></a>
                                                                                </strong>
                                                                        <?php else: ?>
                                                                                <?php if( !empty( $city ) ): ?>
                                                                                <i class="fa fa-angle-right"></i>
                                                                                <strong><?php echo $city; ?></strong>
                                                                                <?php endif; if( count( $properties ) > 0 ): ?>
                                                                                <ul class="fa-ul">
                                                                                        <?php foreach( $properties as $property ): ?>
                                                                                                <li>
                                                                                                        <i class="fa fa-home"></i>
                                                                                                        <strong>
                                                                                                                <a href="<?php echo esc_attr(get_permalink($property->ID) ); ?>"><?php echo $property->post_title; ?></a>
                                                                                                        </strong>
                                                                                                </li>
                                                                                        <?php endforeach; ?>
                                                                                </ul>
                                                                                <?php endif; ?>
                                                                        <?php endif; ?>
                                                                </li>
                                                                <?php endforeach; ?>
                                                        </ul>
                                                </li>
                                        <?php endif;
                                endforeach; ?>
                        </ul>
                        <?php endif; ?>
                </div>
        <?php endforeach; ?>
        
        <p class="clear clearfix"></p>
        </div>
        <?php
 endif;
?>
