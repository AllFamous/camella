<?php
if( isset( $_REQUEST['nonce']) && wp_verify_nonce( $_REQUEST['nonce'], 'get_location_properties') ):
/**
 * Retrieve property locations where current catalog model exists!
 **/
	get_template_part( 'includes/ajax-query/get-location-properties' );
	exit;
endif;
	get_header(); 

	include_once('includes/inside/mast-header.php');

	// check and direct to template
	$category = get_the_category();
	$categorySlug;
	foreach($category as $key => $value){
		if ($value->category_parent == 0){
			$categorySlug = $value->slug;
		}
	}
	switch($categorySlug){
		case 'locations':
			include_once('includes/inside/template-locations.php');
			break;
		case 'catalog':
			include_once('includes/inside/template-catalog.php');
			break;
		case 'careers':
			include_once('includes/inside/template-careers.php');
			break;
		case 'events':
			include_once('includes/inside/template-events.php');
			break;
		case 'news-and-articles':
			include_once('includes/inside/template-news-and-articles.php');
			break;
	}
	
	include_once('includes/home/howtos.php');
	include_once('includes/home/homeowners.php');
	include_once('includes/home/largest.php');
?>
<?php get_footer(); ?>