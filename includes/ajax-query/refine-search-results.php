<?php
/**
 * This file contains code that produces the refine search results.
 **/

 global $wp_query, $post;
 
 $location_id = (int) $_REQUEST['categoryId'];
 $min_price = (int) $_REQUEST['priceLow'];
 $max_price = (int) $_REQUEST['priceHigh'];
 $bedrooms = (int) $_REQUEST['bedrooms'];
 $is_featured = isset($_REQUEST['featured'] );
 $is_random = isset($_REQUEST['random']);
 $paged = (int) get_query_var( 'page' );
  
 # Get properties base on the selected location
 
 $location_args = array(
        'post_type' => 'post',
        'tax_query' => array(
                'relation' => 'AND',
                array(
                        'taxonomy' => 'category',
                        'field' => 'term_id',
                        'terms' => $location_id
                )
        ),
        'posts_per_page' => -1
 );
 
 # Check if the request only requires featured
 if( $is_featured ):
 
        $location = get_term_by( 'slug', 'locations', 'category' );
        $location_args['tax_query'] = array(
                'relation' => 'AND',
                array(
                        'taxonomy' => 'category',
                        'field' => 'term_id',
                        'terms' => array( $location->term_id ),
                        'compare' => 'IN'
                )
        );
        
        $location_args['meta_query'] = array(
                'relation' => 'OR',
                array(
                        'key' => 'modelFeaturedMostViewed',
                        'value' => '',
                        'compare' => '!='
                ),
                array(
                        'key' => 'modelFeaturedMostPopular',
                        'value' => '',
                        'compare' => '!='
                ),
                array(
                        'key' => 'modelFeaturedBestDeal',
                        'value' => '',
                        'compare' => '!='
                )
        );
        
 # Check if it is random query
 elseif( $is_random ):
        $location = get_term_by( 'slug', 'locations', 'category' );
        
        $location_args = array(
                'post_type' => 'post',
                'tax_query' => array(
                        'relation' => 'AND',
                        array(
                                'taxonomy' => 'category',
                                'fields' => 'term_id',
                                'terms' => array( (int) $location->term_id),
                                'compare' => 'IN'
                        )
                ),
                'orderby' => 'random',
                'posts_per_page' => 6,
                'paged' => $paged
        );
 endif;
 
 $wp_query = new WP_Query( $location_args );
 $model_queries = array();
 $results = array();
 $catalog = get_term_by( 'slug', 'catalog', 'category' );
 $catalog_id = $catalog->term_id;
 
 if( have_posts() ):
        while( have_posts() ):
                the_post();
                $modelhouses = (array) get_post_meta( $post->ID, 'houseModels', true );
                $modelhouses = array_filter( $modelhouses );
                $gallery = (array) get_post_meta( $post->ID, 'imageGallery', true );
                
                foreach( $gallery as $pos => $gallery_id ){
                        $img = wp_get_attachment_image_src( (int) $gallery_id, 'full' );
                        
                        if( count( $img ) > 0 ){
                                $gallery[$pos] = $img[0];
                        }
                        else {
                                unset( $gallery[$pos] );
                        }
                }
                $gallery = array_filter($gallery);
                
                if( count( $modelhouses ) > 0 ):
                        $model_queries[$post->ID] = (array) $modelhouses;
                        $featured_id = get_post_thumbnail_id();
                        $featured_image = wp_get_attachment_image_src( (int) $featured_id, 'property_image' );
                        $full_image = wp_get_attachment_image_src( (int) $featured_id, 'full' );
                        
                        $results[$post->ID] = array(
                                'ID' => $post->ID,
                                'title' => $post->post_title,
                                'location' => get_post_meta( $post->ID, 'locationText', true ),
                                'featuredImage' => count( $featured_image ) > 0 ? $featured_image[0] : '',
                                'fullImage' => count( $full_image ) > 0 ? $full_image[0] : '',
                                'gallery' => $gallery,
                                'permalink' => get_permalink($post->ID)
                        );
                        
                        # Get house models
                        $model_query = array(
                                'post_type' => 'post',
                                'tax_query' => array(
                                        'relation' => 'AND',
                                        array(
                                                'taxonomy' => 'category',
                                                'field' => 'term_id',
                                                'terms' => (array) $modelhouses,
                                                'compare' => 'IN'
                                        )
                                ),
                                'posts_per_page' => -1,
                        );
                        
                        if( $min_price > 0 && $max_price > 0 ){
                                $model_query['meta_query'] = array(
                                        'relation' => 'AND',
                                        array(
                                                'key' => 'modelPriceLow',
                                                'value' => (int) $min_price,
                                                'compare' => '>='
                                        ),
                                        array(
                                                'key' => 'modelPriceHigh',
                                                'value' => (int) $max_price,
                                                'compare' => '<='
                                        )
                                );
                        }
                        
                        $models = get_posts( $model_query );
                        if( $models && count( $models ) > 0 ):
                                $models_array = array();
                                
                                foreach( $models as $model ):
                                        $data = get_fields( $model->ID );
                                        
                                        # Remove not needed datas
                                        if( is_array( $data ) ){
                                                unset( $data['houseFeatures'], $data['imageGallery'], $data['floorPlanImage'], $data['contentHeader'] );
                                        }
                                        $model_array = array(
                                                'title' => $model->post_title,
                                                'permalink' => get_permalink( $model->ID ),
                                                'data' => $data
                                        );
                                        $models_array[$model->ID] = $model_array;
                                endforeach;
                                $results[$post->ID]['houseModels'] = $models_array;
                        else:
                                # Remove location
                                unset( $results[$post->ID] );
                        endif;
                endif;
        endwhile;
 endif;
 
 $results['found_posts'] = $wp_query->found_posts;
 
 echo json_encode( $results );
 