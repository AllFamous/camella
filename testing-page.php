<?php
/*************
 * Retrieve properties hierarchy
 *******************************/

global $wp_query;

 $locations = get_term_by( 'slug', 'locations', 'category' );
 $metro_manila = get_term_by( 'slug', 'metro-manila', 'category' );
 $luzon = get_term_by( 'slug', 'luzon', 'category' );
 $visayas = get_term_by( 'slug', 'visayas', 'category' );
 $mindanao = get_term_by( 'slug', 'mindanao', 'category' );
 
 function getPropertyList($location){
        global $wp_query;
        
        $args = array(
                'tax_query' => array(
                        array(
                                'taxonomy' => 'category',
                                'field' => 'term_id',
                                'terms' => $location->term_id
                        )
                ),
                'post_type' => 'post',
                'fields' => 'ids'
        );
        
        $wp_query = new WP_Query( $args );
        $lists = array();
        
        if( have_posts() ){
                while( have_posts() ){
                        the_post();
                        $lists[get_the_ID()] = array(
                                'name' => get_the_title(),
                                'link' => get_permalink()
                        );
                }
        }
        return $lists;
 }
 
 $listing = array(
        'Metro Manila' => getPropertyList( $metro_manila ),
        'Luzon' => getPropertyList( $luzon ),
        'Visayas' => getPropertyList( $visayas ),
        'Mindanao' => getPropertyList( $mindanao )
 );
 echo json_encode( $listing );