<?php
/**
 * Front Page
 * Template Name: Front Page
 **/

 global $wp_query;
 $wp_query->is_home = 1;
 
 /*******
  * Get the refine search results via ajax query
  **********************************************/
 
 if( isset( $_REQUEST['nonce'] ) && wp_verify_nonce( $_REQUEST['nonce'], 'refine_search_results' ) ):
	get_template_part( 'includes/ajax-query/refine-search-results' );
	exit;
 endif;
 
 get_header();
 
 get_template_part( 'includes/home/hero' );
 get_template_part( 'includes/home/pillars' );
 get_template_part( 'includes/home/masterplanned' );
 get_template_part( 'includes/home/ourproperties' );
 get_template_part( 'includes/home/catalog' );
 get_template_part( 'includes/home/properties' );
 get_template_part( 'includes/home/agents' );
 get_template_part( 'includes/home/howtos' );
 get_template_part( 'includes/home/newsarticles' );
 
 #== Include template-scripts.php
 get_template_part( 'includes/home/template-script' );
 
 get_footer(); ?>