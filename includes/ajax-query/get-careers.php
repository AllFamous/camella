<?php
/*********************
 * Retrieve the lists of careers
 *********************************/

global $wp_query, $post;
 
 $career = get_term_by( 'slug', 'careers', 'category' );
 $args = array(
        'post_type' => 'post',
        'tax_query' => array(
                'relation' => 'AND',
                array(
                        'taxonomy' => 'category',
                        'field' => 'term_id',
                        'terms' => (int) $career->term_id
                )
        ),
        'orderby' => 'title',
        'order' => 'ASC'
 );
 
 $wp_query = new WP_Query( $args );
 $careers = array();
 
 if( have_posts() ):
        while( have_posts() ):
                the_post();
                $careers[] = $post->post_title;
        endwhile;
 endif;
 echo json_encode( $careers );