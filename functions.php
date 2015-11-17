<?php
	function tempalteResources(){
		// header css and scripts
		wp_enqueue_style('style', get_stylesheet_uri());
		wp_enqueue_style('fonts', 'http://fonts.googleapis.com/css?family=Roboto+Slab:300,700,400|Roboto:300,400,700,300italic,400italic,700italic', '', '1.0', false);
		wp_enqueue_style('fontawesome', get_template_directory_uri().'/css/fontawesome.css', '', '1.0', false);
		wp_enqueue_style('select2', get_template_directory_uri().'/css/select2.css', '', '1.0', false);
		wp_enqueue_style('bootstrap', get_template_directory_uri().'/css/bootstrap.css', '', '1.0', false);
		wp_enqueue_style('carousel', get_template_directory_uri().'/css/carousel.css', '', '1.0', false);
		wp_enqueue_style('carousel-camella', get_template_directory_uri().'/css/carousel-camella.css', '', '1.0', false);
		wp_enqueue_style('scrollpane', get_template_directory_uri().'/css/scrollpane.css', '', '1.0', false);
		wp_enqueue_style('lightbox', get_template_directory_uri().'/css/lightbox.css', '', '1.0', false);
		wp_enqueue_style('steps', get_template_directory_uri().'/css/steps.css', '', '1.0', false);
		wp_enqueue_style('custom', get_template_directory_uri().'/css/custom.css', '', '1.0', false);
		wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js', '', '1.0', false);
		wp_enqueue_script('google-maps', 'https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places', '', '1.0', false);
		wp_enqueue_script('recaptcha', 'https://www.google.com/recaptcha/api.js', '', '1.0', false);

		// footer scripts		/** == Include underscore **/
		wp_enqueue_script( 'underscore' );
		
		wp_enqueue_script('bootstrap', get_template_directory_uri().'/js/bootstrap.min.js', '', '1.0', true);
		wp_enqueue_script('select2', get_template_directory_uri().'/js/select2.js', '', '1.0', true);
		wp_enqueue_script('carousel', get_template_directory_uri().'/js/carousel.js', '', '1.0', true);
		wp_enqueue_script('scrollpane', get_template_directory_uri().'/js/scrollpane.js', '', '1.0', true);
		wp_enqueue_script('mousewheel', get_template_directory_uri().'/js/mousewheel.js', '', '1.0', true);
		wp_enqueue_script('scrollreveal', get_template_directory_uri().'/js/scrollreveal.js', '', '1.0', true);
		wp_enqueue_script('lightbox', get_template_directory_uri().'/js/lightbox.js', '', '1.0', true);
		wp_enqueue_script('steps', get_template_directory_uri().'/js/steps.js', '', '1.0', true);
		wp_enqueue_script('easing', get_template_directory_uri().'/js/easing.js', '', '1.0', true);
		wp_enqueue_script('parallax', get_template_directory_uri().'/js/parallax.js', '', '1.0', true);
		wp_enqueue_script('currency', get_template_directory_uri().'/js/formatcurrency.js', '', '1.0', true);
		wp_enqueue_script('functions', get_template_directory_uri().'/js/common/functions.js', '', '1.0', true);
		wp_enqueue_script('initialize', get_template_directory_uri().'/js/common/initialize.js', '', '1.0', true);
		
		# Set selected house catalog
		$catalog = null;
		if( isset( $_REQUEST['catalog_id']) && (int) $_REQUEST['catalog_id'] > 0 ):
			$catalog_id = (int) $_REQUEST['catalog_id'];
			$catalog = array( $catalog_id => get_the_title( $catalog_id ) );
		endif;
		
		# Set selected inquiry type
		$inquiry_type = null;
		if( isset( $_REQUEST['inquiry_type'] ) && !empty( $_REQUEST['inquiry_type'] ) ):
			$inquiry_type = urldecode($_REQUEST['inquiry_type']);
		endif;
		
		# Set selected career id
		$career_id = null;
		if( isset( $_REQUEST['career_id'] ) && (int) $_REQUEST['career_id'] > 0 ):
			$career_id = (int) $_REQUEST['career_id'];
			$career_id = array( $career_id => get_the_title( $career_id ) );
		endif;
		
		wp_localize_script( 'initialize', 'Camella', array(
			'ajaxurl' => admin_url( '/admin-ajax.php' ),
			'catalog' => $catalog,
			'inquiry_type' => $inquiry_type,
			'career' => $career_id,
			'career_nonce' => wp_create_nonce( 'get_careers' )
		));
	}
	add_action('wp_enqueue_scripts', 'tempalteResources');

	// remove auto br tags
	remove_filter( 'the_content', 'wpautop' );
	remove_filter( 'the_excerpt', 'wpautop' );

	// hide admin bar on user login
	add_filter('show_admin_bar', '__return_false');

	//add Fav icon
	
# Set supports, etc
function camella_theme_setup(){
	// navigation menus
	register_nav_menus(array(
		'primaryHeroMenu'		=> __('Primary Hero Menu'),
		'primaryMenu'			=> __('Primary Menu'),
		'footerMenu'			=> __('Footer Menu')
	));
}
add_action( 'after_setup_theme', 'camella_theme_setup' );

function url(){
    $pu = parse_url($_SERVER['REQUEST_URI']);
    return $pu["scheme"] . "://" . $pu["host"];
}
	
	// add logo
	add_filter('wp_nav_menu_items', 'custom_logo_location', 10, 2);
	function custom_logo_location ($items, $args) {
	    if (is_front_page() && $args->theme_location == 'primaryMenu') {
	        $items .= '<li class="fixed-brand"><a href="http://www.camella.com.ph/"><img src="'.get_template_directory_uri().'/img/common/logo-camella-green.png" width="200px"></a></li>';
	    } else {
	    	$items .= '<li class="brand"><a href="http://www.camella.com.ph/"><img src="'.get_template_directory_uri().'/img/common/logo-camella-green.png" width="180px"></a></li>';
	    }
	    return $items;
	}

	// add submenu class
	class custom_walker_nav_menu extends Walker_Nav_Menu {
		function start_lvl(&$output, $depth = 0, $args = array()) {
			$indent = str_repeat("\t", $depth);
			$output .= "\n$indent<ul class=\"level-".$depth." dropdown-menu\">\n";
		}
	}

	// footer menu walker
	class simple_walker extends Walker {
    	public function walk($elements, $max_depth){
        	$list = array();
	        foreach ($elements as $item){
				$list[] = "<a href='$item->url'>$item->title</a>";
	        }
	        return join("\n", $list);
		}
    }

	// activate featured image
	if (function_exists('add_theme_support')){
		add_theme_support('post-thumbnails');
	}

	ini_set('memory_limit', '64M');

	// custom login script
	add_action('wp_ajax_nopriv_user-login', 'userLogin');
	add_action('wp_ajax_user-login', 'userLogin');

	function userLogin(){
	    $info['user_login'] = $_REQUEST['loginUsername'];
	    $info['user_password'] = $_REQUEST['loginUserPassword'];
	    $info['remember'] = true;

	    $user_signon = wp_signon( $info, false );
	    if (is_wp_error($user_signon)){
	        echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.')));
	    } else {
	        echo json_encode(array('loggedin'=>true, 'message'=>__('Login successful, please wait. Redirecting...')));
	    }
	    die();
	}

	// generate pdf
	# require(get_template_directory().'/functions/pdf/fpdf.php');

	// advanced custom fields custom taxonomy field
	add_filter('acf/fields/taxonomy/wp_list_categories', 'catalogTaxonomyArgs', 10, 2);
	function catalogTaxonomyArgs($args, $field){
		$categoryId = get_category_by_slug('catalog'); 
        $categoryId = $categoryId->term_id;
		$args['child_of'] = $categoryId;
	    return $args;
	}

	// update custom field value
	add_action('wp_ajax_nopriv_update-user-status', 'updateUserStatus');
	add_action('wp_ajax_update-user-status', 'updateUserStatus' );
	function updateUserStatus($statusId) {
		acf_update_value();
	}

	// force subcategory to use category template
	add_filter( 'category_template', 'new_subcategory_hierarchy' );
	function new_subcategory_hierarchy() {	
		$category = get_queried_object();
		$parent_id = $category->category_parent;

		$templates = array();
		if ( $parent_id == 0 ) {
			// Use default values from get_category_template()
			$templates[] = "category-{$category->slug}.php";
			$templates[] = "category-{$category->term_id}.php";
			$templates[] = 'category.php';		
		} else {
			// Create replacement $templates array
			$parent = get_category($parent_id);

			// Current first
			$templates[] = "category-{$category->slug}.php";
			$templates[] = "category-{$category->term_id}.php";

			// Parent second
			$templates[] = "category-{$parent->slug}.php";
			$templates[] = "category-{$parent->term_id}.php";
			$templates[] = 'category.php';	
		}
		return locate_template($templates);
	}

	// Tests if any of a post's assigned categories are descendants of target categories
    function checkPostDescendants($cats, $_post = null){
        foreach ((array)$cats AS $cat){
            // get_term_children() accepts integer ID only
            $descendants = get_term_children((int)$cat, 'category');
            if ($descendants || in_category($descendants, $_post)){
                return true;
            }
        }
        return false;
    }

	// get category level
	function isCategoryLevel($depth){
		$current_category = get_query_var('cat');
		$my_category = get_categories('hide_empty=0&include='.$current_category);
		$cat_depth=0;

		if ($my_category[0]->category_parent == 0){
	 		$cat_depth = 0;
	 	} else {
	 		while( $my_category[0]->category_parent != 0 ) {
	  			$my_category = get_categories('hide_empty=0&include='.$my_category[0]->category_parent);
	  			$cat_depth++;
	  		}
	  	}
	  	if ($cat_depth == intval($depth)) { return true; }
	  	return null;
	}

	// get projects
	add_action('wp_ajax_nopriv_get-projects', 'getProjects');
	add_action('wp_ajax_get-projects', 'getProjects');

	function getProjects(){
		$catId = $_REQUEST['catId'];
		if ($catId == ''){
    		$defCatId = get_category_by_slug('locations'); 
            $catId = $defCatId->term_id;
    	}
		$args = array(
			'cat' 				=> $catId,
			'posts_per_page' 	=> -1,
			'orderby'			=> 'post_title',
			'order' 			=> 'ASC',
			'post_status'      	=> 'publish'
	    );
	    $posts = get_posts($args);
	    $posts = json_decode(json_encode($posts), TRUE);
	    foreach($posts AS $key => $value){
	    	// get custom fiels
	    	$postId = $value['ID'];
	    	$customFields = get_fields($postId);
	    	$customFields = json_decode(json_encode($customFields), TRUE);
	    	$posts[$key]['custom_field'] = $customFields;
	    	$posts[$key]['featured_image'] = get_the_post_thumbnail($value['ID'], 'medium');
	    	$posts[$key]['property_permalink'] = get_permalink($value['ID']);
			$args = array('orderby' => 'cat_ID');
			$categories = wp_get_post_terms($value['ID'], 'category', $args);
			$count = 1;
			foreach($categories AS $keyCat => $valueCat){
				if ($count == 3){
					$posts[$key]['category_id'] = $valueCat->term_id;
					$posts[$key]['category_name'] = $valueCat->name;
				}
				$count++;
			}
    	}
	    $posts = json_encode($posts, TRUE);
		echo $posts;
		wp_reset_postdata();
		die();
	}

	// get catalog
	add_action('wp_ajax_nopriv_get-catalog', 'getCatalog');
	add_action('wp_ajax_get-catalog', 'getCatalog');

	function getCatalog(){
		$catalogId = $_REQUEST['catalogId'];
		$args = array(
			'cat' 				=> $catalogId,
			'posts_per_page' 	=> -1,
			'order' 			=> 'DESC',
			'post_status'      	=> 'publish'
	    );
		$posts = get_posts($args);
	    $posts = json_decode(json_encode($posts), TRUE);
	    foreach ($posts AS $key => $value){
	    	$postId = $value['ID'];
	    	$customFields = get_fields($postId);
		
		# Process image gallery
		$image_gallery = get_post_meta( $post_id, 'imageGallery', true );
		if( is_array( $image_gallery ) && count( $image_gallery ) > 0 ):
			$image_gallery = array_filter( $image_gallery );
			$images = array();
			
			foreach( $image_gallery as $image_id ):
				$img = wp_get_attachment_image_src( (int) $image_id, 'full' );
				
				if( $img && count( $img ) > 0 ):
					$images[] = $img[0];
				endif;
			endforeach;
			$images = array_filter( $images );
			//$customFields['imageGallery'] = $images;
		endif;
		
	    	$customFields = json_decode(json_encode($customFields), TRUE);
	    	$posts[$key]['custom_field'] = $customFields;
	    	$posts[$key]['featured_image'] = get_the_post_thumbnail($value['ID'], 'large');
	    	$posts[$key]['model_permalink'] = get_permalink($value['ID']);
	    }
	    $posts = json_encode($posts, TRUE);
	    echo $posts;
		wp_reset_postdata();
		die();
	}

	// select functions
	// island groups
	add_action('wp_ajax_nopriv_get-islandgroups', 'getIslandGroups');
	add_action('wp_ajax_get-islandgroups', 'getIslandGroups');

	function getIslandGroups(){
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
	    $categories = json_encode($categories, TRUE);
		echo $categories;
		wp_reset_postdata();
		die();
	}

	add_action('wp_ajax_nopriv_get-region-province', 'getRegionProvince');
	add_action('wp_ajax_get-region-province', 'getRegionProvince');

	function getRegionProvince(){
		$islandGroupId = $_REQUEST['islandGroupId'];
		if ($islandGroupId == ''){
			$categoryId = get_category_by_slug('locations'); 
        	$islandGroupId = $categoryId->term_id;
		}
		$args = array(
            'parent'        => $islandGroupId,
            'hierarchical'  => 0,
            'orderby'       => 'id',
            'order'         => 'ASC',
            'hide_empty'    => 0
	    );
	    $subCategories = get_categories($args);
	    $subCategories = json_decode(json_encode($subCategories), TRUE);
	    foreach($subCategories AS $key => $value){
	    	$argsSub = array(
	            'parent'        => $value['cat_ID'],
	            'hierarchical'  => 0,
	            'orderby'       => 'id',
	            'order'         => 'ASC',
	            'hide_empty'    => 0
		    );
		    $itemSub = get_categories($argsSub);
		    
		    /**== Add permalink to each sub-categories **/
		    if( ! is_wp_error( $itemSub )  && count( $itemSub ) > 0 ):
			foreach( $itemSub as $index => $sub ){
				$link = get_term_link( (int) $sub->term_id, 'category' );
				$sub->permalink = $link;
				$itemSub[$index] = $sub;
			}
		    endif;
		    
		    $subCategories[$key]['sub_categories'] = $itemSub;
	    }
	    $subCategories = json_encode($subCategories, TRUE);
		echo $subCategories;
		wp_reset_postdata();
		die();
	}

	add_action('wp_ajax_nopriv_get-city', 'getCity');
	add_action('wp_ajax_get-city', 'getCity');
	
	function getCity(){
		$regionProvinceId = $_REQUEST['regionProvinceId'];
		if ($regionProvinceId == ''){
			$categoryId = get_category_by_slug('locations'); 
        	$regionProvinceId = $categoryId->term_id;
		}
		$args = array(
            'parent'        => $regionProvinceId,
            'hierarchical'  => 0,
            'orderby'       => 'id',
            'order'         => 'ASC',
            'hide_empty'    => 0
	    );
	    $subCategories = get_categories($args);
	    $subCategories = json_decode(json_encode($subCategories), TRUE);
	    foreach($subCategories AS $key => $value){
	    	$argsSub = array(
	            'parent'        => $value['cat_ID'],
	            'hierarchical'  => 0,
	            'orderby'       => 'id',
	            'order'         => 'ASC',
	            'hide_empty'    => 0
		    );
		    $itemSub = get_categories($argsSub);
		    $itemSub = json_decode(json_encode($itemSub), TRUE);
	    	foreach($itemSub AS $keyCategory => $valueCategory){
		    	$ancestors = get_ancestors($valueCategory['cat_ID'], 'category');
                $directParentId = $ancestors[0];
                $itemSub[$keyCategory]['direct_parent_id'] = $directParentId;
		    }
		    $subCategories[$key]['sub_categories'] = $itemSub;
	    }
	    foreach($subCategories AS $key => $value){
		    foreach($value['sub_categories'] AS $keySub => $valueSub){
		    	$argsSub = array(
		            'parent'        => $valueSub['cat_ID'],
		            'hierarchical'  => 0,
		            'orderby'       => 'id',
		            'order'         => 'ASC',
		            'hide_empty'    => 0
			    );
			    $itemSubSub = get_categories($argsSub);
			    $itemSubSub = json_decode(json_encode($itemSubSub), TRUE);
			    foreach($itemSubSub AS $keySubCategory => $valueSubCategory){
			    	$ancestors = get_ancestors($valueSubCategory['cat_ID'], 'category');
	                $directParentId = $ancestors[0];
	                $itemSubSub[$keySubCategory]['direct_parent_id'] = $directParentId;
			    }
		    	$subCategories[$key]['sub_categories'][$keySub]['sub_categories'] = $itemSubSub;
		    }
	    }
	    $subCategories = json_encode($subCategories, TRUE);
		echo $subCategories;
		wp_reset_postdata();
		die();
	}

	// countries
	add_action('wp_ajax_nopriv_get-countries', 'getCountries');
	add_action('wp_ajax_get-countries', 'getCountries');

	function getCountries(){
        $categoryId = get_category_by_slug('countries'); 
        $categoryId = $categoryId->term_id;
		$args = array(
            'parent'        => $categoryId,
            'hierarchical'  => 0,
            'orderby'       => 'title',
            'order'         => 'ASC',
            'hide_empty'    => 0
	    );
	    $categories = get_categories($args);
	    $categories = json_encode($categories, TRUE);
		echo $categories;
		wp_reset_postdata();
		die();
	}

	add_action('wp_ajax_nopriv_get-properties', 'getProperties');
	add_action('wp_ajax_get-properties', 'getProperties');

	function getProperties(){
		$categoryId = $_REQUEST['categoryId'];

		if ($categoryId == ''){
			$defCatId = get_category_by_slug('locations'); 
	    	$formCategoryId = $defCatId->term_id;
		} else {
			$formCategoryId = $categoryId;
		}
		
		$args = array(
			'category'		=> $formCategoryId,
			'post_type'		=> 'post',
			'post_status'	=> 'publish'
	    );

		$postsProjects = get_posts($args);
		$postsProjects = json_decode(json_encode($postsProjects), TRUE);

	    $posts = array();
	    foreach($postsProjects AS $key => $value){
			$args = array('orderby' => 'cat_ID');
			$categories = wp_get_post_terms($value['ID'], 'category', $args);
			$count = 1;
			foreach($categories AS $keyCat => $valueCat){
				if ($count == 3){
					$locationId = $valueCat->term_id;
					$locationName = $valueCat->name;
				}
				$count++;
			}
			$item = array(
	    		'projectFeaturedImage'	=> wp_get_attachment_image_src(get_post_thumbnail_id($value['ID']), 'thumbnail'),
	    		'projectPermalink'		=> get_permalink($value['ID']),
	    		'projectData'			=> get_post($value['ID']),
	    		'projectCustom'			=> get_fields($value['ID']),
	    		'projectLocationId'		=> $locationId,
	    		'projectLocationname'	=> $locationName
	    	);
	    	array_push($posts, $item);
	    }
	
	    $posts = json_encode($posts, TRUE);
		echo $posts;
		wp_reset_query();
		die();
	}

	// get agents
	add_action('wp_ajax_nopriv_get-agents', 'getAgents');
	add_action('wp_ajax_get-agents', 'getAgents');

	function getAgents(){
		$type = $_REQUEST['type'];
		$agentName = $_REQUEST['agentName'];
		$agentCountry = $_REQUEST['agentCountry'];
		$agentLocation = $_REQUEST['agentLocation'];
		$projectAssigned = $_REQUEST['projectAssigned'];
		$agents = array();

		$categoryId = get_category_by_slug('agents');
		$categoryId = $categoryId->term_id;
		if ($type == 0){
			$args = array(
    			'posts_per_page' 	=> -1,
    			'category'			=> $categoryId,
    			'post_status'		=> 'publish',
    			'orderby'			=> 'title',
    			'order'				=> 'ASC'
		    );
		} else {
			$args = array(
    			'posts_per_page' 	=> -1,
    			'category'			=> $categoryId,
    			'post_status'		=> 'publish',
    			'orderby'			=> 'title',
    			'order'				=> 'ASC',
    			'meta_query'		=> array(
					'relation'		=> 'AND'
				)
		    );
		    if ($agentName != ''){
		    	$customArg = array(
		    		'relation' => 'OR',
		    		array(
						'key'		=> 'firstName',
						'value'		=> $agentName,
						'compare'	=> 'LIKE'
		    		),
		    		array(
						'key'		=> 'lastName',
						'value'		=> $agentName,
						'compare'	=> 'LIKE'
		    		)
		    	);
		    	array_push($args['meta_query'], $customArg);
		    }
		    if ($agentCountry != ''){
		    	$customArg = array(
					'key'		=> 'agentCountry',
					'value'		=> $agentCountry,
					'compare'	=> '=='
		    	);
		    	array_push($args['meta_query'], $customArg);
		    }
		    if ($agentLocation != ''){
		    	$customArg = array(
					'key'		=> 'agentLocation',
					'value'		=> $agentLocation,
					'compare'	=> '=='
		    	);
		    	array_push($args['meta_query'], $customArg);
		    }
		    if ($projectAssigned != ''){
		    	$customArg = array(
					'key'		=> 'projectsCoverage',
					'value'		=> $projectAssigned,
					'compare'	=> 'LIKE'
		    	);
		    	array_push($args['meta_query'], $customArg);
		    }
		}
	    $agentsResult = get_posts($args);
    	$agentsResult = json_decode(json_encode($agentsResult), TRUE);

    	foreach ($agentsResult as $key => $value){
    		$customFields = get_fields($value['ID']);
    		$assignedProjects = array();
    		$assignedProjectsArr = $customFields['projectsCoverage'];
    		$assignedProjectsArr = explode(',', $assignedProjectsArr);
    		foreach($assignedProjectsArr AS $keyProjects => $valueProjects){
    			array_push($assignedProjects, get_post($valueProjects));
    		}
		
    		$item = array(
    			'agentData'				=> $value,
			    'agentFeaturedImage'	=> wp_get_attachment_image_src(get_post_thumbnail_id($value['ID']), 'large'),
    			'agentCustom'			=> $customFields,
    			'agentCountry'			=> get_category($customFields['agentCountry']),
    			'agentLocation'			=> get_category($customFields['agentLocation']),
    			'assignedProjects'		=> $assignedProjects,
			'redirect_link' 		=> home_url( '/sales-inquiries' )
    		);
    		array_push($agents, $item);
    	}

	    $agents = json_encode($agents, TRUE);
		echo $agents;
		wp_reset_query();
		die();
	}

	// get send email
	add_action('wp_ajax_nopriv_send-email', 'sendEmail');
	add_action('wp_ajax_send-email', 'sendEmail');

	function sendEmail(){
		$template = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html> <head> <meta http-equiv="Content-Type" content="text/html;UTF-8"/> </head> <style type="text/css">@import url(https://fonts.googleapis.com/css?family=Roboto:400,700);</style> <body style="margin: 0px; background-color: #F4F3F4; font-family: Roboto, Helvetica, Arial, sans-serif; font-size:12px; font-weight: 400" text="#444444" bgcolor="#F4F3F4" link="#21759B" alink="#21759B" vlink="#21759B" marginheight="0" topmargin="0" marginwidth="0" leftmargin="0"> <table border="0" width="100%" cellspacing="0" cellpadding="0" bgcolor="#F4F3F4"> <tbody> <tr> <td style="padding: 15px;"><center> <table width="750" cellspacing="0" cellpadding="0" align="center" bgcolor="#ffffff"> <tbody> <tr> <td align="left"> <div style="border: solid 1px #d9d9d9;"> <table id="header" style="line-height: 1.6; font-size: 12px; font-family: Helvetica, Arial, sans-serif; border: solid 1px #FFFFFF; color: #444;" border="0" width="100%" cellspacing="0" cellpadding="0" bgcolor="#ffffff"> <tbody> <tr> <td style="color: #ffffff;" colspan="2" valign="bottom" height="30">.</td></tr><tr> <td style="line-height: 32px; padding-left: 30px;" valign="baseline"><span style="font-size: 32px;"> <a style="text-decoration: none;" href="%blog_url%" target="_blank"> <img src="http://testdev.camella.com.ph/wp-content/themes/camella/img/common/logo-camella-green.png" alt="" width="200px"/> </a> </span></td><td style="padding-right: 30px;" align="right" valign="baseline"><span style="font-size: 14px; color: #777777;">Beautiful. Convenient. Secure.</span></td></tr></tbody> </table> <table id="content" style="margin-top: 15px; margin-right: 30px; margin-left: 30px; color: #444; line-height: 1.6; font-size: 12px; font-family: Roboto, Arial, sans-serif;" border="0" width="690" cellspacing="0" cellpadding="0" bgcolor="#ffffff"> <tbody> <tr> <td style="border-top: solid 1px #d9d9d9;" colspan="2"> <div style="padding: 15px 0;">%content%</div></td></tr></tbody> </table> <table id="footer" style="line-height: 1.5; font-size: 12px; font-family: Roboto, Arial, sans-serif; margin-right: 30px; margin-left: 30px;" border="0" width="690" cellspacing="0" cellpadding="0" bgcolor="#ffffff"> <tbody> <tr style="font-size: 11px; color: #999999;"> <td style="border-top: solid 1px #d9d9d9;"> <div>For any general inquiries, please contact <a href="mailto:info@camella.com.ph">info@camella.com.ph</a></div><br/><br/></td></tr></tbody> </table> </div></td></tr></tbody> </table> </center></td></tr></tbody> </table> </body></html>';
		$formDetails = $_REQUEST['formDetails'];

		// start composing mail
		date_default_timezone_set('Asia/Manila');

		$toEmailAddress = $formDetails['emailDetails']['toEmailAddress'];
		$toFullName = $formDetails['emailDetails']['toFullName'];
		$fromEmailAddress = $formDetails['emailDetails']['fromEmailAddress'];
		$fromFullName = $formDetails['emailDetails']['fromFullName'];
		$emailSubject = $formDetails['emailDetails']['emailSubject'];

		// start email template
		switch ($formDetails['emailDetails']['emailType']) {
			case 'data':
				$body .= '<p style="margin-top:0;font-size:14px;color:#777777">Hi '.$formDetails['emailDetails']['toFullName'].',</p>';
				$body .= '<p style="margin-top:0;font-size:14px;color:#777777">'.$formDetails['emailDetails']['emailBodyHeader'].'</p>';
				$body .= '<table cellpadding="0" cellspacing="0" border="0" width="100%"><tbody>';
				foreach ($formDetails['emailContent'] as $key => $value) {
					$body .= '<tr><td style="margin-top:0;font-size:14px;color:#777777" width="160">'.$value[0].'</td><td style="margin-top:0;font-size:14px;color:#777777;font-weight:700">'.$value[1].'</td></tr>';
				}
				$body .= '</tbody></table><br><br>';
				break;
		}

		$body = str_replace('%content%', $body, $template);

		$headers[] = 'Content-Type: text/html; charset=UTF-8';
		$headers[] = 'From: '.$fromFullName.' <'.$fromEmailAddress.'>';

		$result = wp_mail( $toEmailAddress, $emailSubject, $body, $headers );

	    $result = json_encode($result, TRUE);
		echo $result;
		wp_reset_postdata();
		die();

	}

	function getLoanType($type){
		switch ($type) {
			case 1:
				return 'In-House Financing';
				break;
			case 2:
				return 'Bank Financing';
				break;
		}
	}

	function getDownPayment($downpayment){
		return $downpayment.'%';
	}

	function getTerms($terms){
		$months = $terms * 12;
		return $terms.' Years ('.$months.' Months)' ;
	}

	function convertToPrice($amount){
		return 'PHP '.number_format($amount, 2, '.', ',');
	}

	function computeComputationPMT($ratePerPeriod, $numberOfPayments, $presentValue, $futureValue, $type){
		if ($ratePerPeriod != 0.0){
			// interest rate exists
			$q = pow(1 + $ratePerPeriod, $numberOfPayments);
			return ($ratePerPeriod * ($futureValue + ($q * $presentValue))) / ((-1 + $q) * (1 + $ratePerPeriod * ($type)));
		} else if ($numberOfPayments != 0.0){
			// No interest rate, but number of payments exists
			return ($futureValue + $presentValue) / $numberOfPayments;
		}
		return 0;
	}

	function getReservationFee($contractPrice){
		switch (true) {
			case $contractPrice <= 1500000:
				return 10000;
				break;
			case $contractPrice >= 1500000.01 && $contractPrice <= 1999999.99:
				return 15000;
				break;
			case $contractPrice >= 2000000.00 && $contractPrice <= 2999999.99:
				return 20000;
				break;
			case $contractPrice >= 3000000.00 && $contractPrice <= 3999999.99:
				return 30000;
				break;
			case $contractPrice >= 4000000.00:
				return 40000;
				break;
		}
	}

	// subscribe to mailing list
	add_action('wp_ajax_nopriv_user-subscribe', 'userSubscribe');
	add_action('wp_ajax_user-subscribe', 'userSubscribe');

	require(get_template_directory().'/functions/mailchimp/Mailchimp.php');

	function userSubscribe(){
		$formDetails = $_REQUEST['formDetails'];
		$userEmail = $formDetails['subscribeEmail'];
		
		$api_key = '2b9d521c86de7f2ae79618eaffd95947-us10';
		$list_id = 'cd7b3dcefe';

		$Mailchimp = new Mailchimp($api_key);
		$Mailchimp_Lists = new Mailchimp_Lists($Mailchimp);

		
		$subscriber = $Mailchimp_Lists->subscribe($list_id, array('email' => htmlentities($userEmail)));
		if (!empty($subscriber['leid'])){
			$result = 1;
		} else {
		    $result = 0;
		}
		$result = json_encode($result, TRUE);
		echo $result;
		die();
	}

	// post views tracker
	function getPostViews($postID){
	    $count_key = 'post_views_count';
	    $count = get_post_meta($postID, $count_key, true);
	    if($count==''){
	        delete_post_meta($postID, $count_key);
	        add_post_meta($postID, $count_key, '0');
	        return "0 View";
	    }
	    return $count.' Views';
	}

	function setPostViews($postID) {
	    $count_key = 'post_views_count';
	    $count = get_post_meta($postID, $count_key, true);
	    if($count==''){
	        $count = 0;
	        delete_post_meta($postID, $count_key);
	        add_post_meta($postID, $count_key, '0');
	    }else{
	        $count++;
	        update_post_meta($postID, $count_key, $count);
	    }
	}

	// Add it to a column in WP-Admin
	add_filter('manage_posts_columns', 'posts_column_views');
	add_action('manage_posts_custom_column', 'posts_custom_column_views', 5, 2);
	
	function posts_column_views($defaults){
	    $defaults['post_views'] = __('Views');
	    return $defaults;
	}
	
	function posts_custom_column_views($column_name, $id){
		if($column_name === 'post_views'){
	        echo getPostViews(get_the_ID());
	    }
	}

	// remove issues with prefetching adding extra views
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

	// register user
	add_action('wp_ajax_nopriv_register-user', 'registerUser');
	add_action('wp_ajax_register-user', 'registerUser');

	function registerUser(){
		$regUsername = $_REQUEST['regUsername'];
		$regFirstName = $_REQUEST['regFirstName'];
		$regLastName = $_REQUEST['regLastName'];
		$regEmailAddress = $_REQUEST['regEmailAddress'];
		$regUserType = $_REQUEST['regUserType'];
		$region = $_REQUEST['region'];
		$city = $_REQUEST['city'];

		$userId = username_exists($regUsername);
		
		if (!$userId && email_exists($regEmailAddress) == false){
			$randomPassword = wp_generate_password($length = 12, $include_standard_special_chars = false);
			$userId = wp_create_user($regUsername, $randomPassword, $regEmailAddress);
			$newUserObject = new WP_User($userId);
			$newUserObject->set_role($regUserType);
			$updateUserId = wp_update_user(array('ID' => $userId, 'first_name' => $regFirstName, 'last_name' => $regLastName));

			update_user_meta( $userId, 'region', $region);
			update_user_meta( $userId, 'city', $city);
			
			//need to update status here
			
			// Send notifications to both admin and newly registered user
			wp_new_user_notification( $userId, null, 'both' );
			
			$result = '1';
		} else {
			$result = '2';
		}
	    $result = json_encode($result, TRUE);
		echo $result;
		wp_reset_postdata();
		die();
	}

 if( ! function_exists( 'camella_options' ) ):
 /**
  * Include camella theme options
  **/
	function camella_options( $customizer ){
		require_once dirname(__FILE__) . '/functions/theme-options.php';
	}
	add_action( 'customize_register', 'camella_options' );
 endif;
 
 if( ! function_exists( 'camella_setup' ) ):
 /**
  * Sets supports etc.
  **/
	function camella_setup(){
		# Properties @search
		add_image_size( 'property_image', 672, 472, true );
	}
	add_action( 'after_setup_theme', 'camella_setup' );
 endif;
 
 if( ! function_exists( 'camella_locations' ) ):
 /**
  * Retrieve the lists of regions/cities/municipalities
  **/
	function camella_locations(){
		$locations = file_get_contents( dirname(__FILE__) . "/data/locations.json" );
		echo $locations;
		exit;
	}
	add_action( 'wp_ajax_get_country_locations', 'camella_locations' );
	add_action( 'wp_ajax_nopriv_get_country_locations', 'camella_locations' );
 endif;
 
 if( ! function_exists( 'camella_pdf_generator' ) ):
	function camella_pdf_generator(){
		require(get_template_directory().'/functions/pdf/fpdf.php');
	}
	add_action( 'wp_ajax_download_pdf', 'camella_pdf_generator' );
	add_action( 'wp_ajax_nopriv_download_pdf', 'camella_pdf_generator' );
 endif;
 
 if( ! function_exists( 'naked_ajax_get_attachment' ) ):
/**********
 * Supports the custom media view
 ********************************/
        function naked_ajax_get_attachment(){
                $req = $_REQUEST;
                $img_id = $req['id'];
                $width = isset($req['width']) ? $req['width'] : 150;
                $height = isset( $req['height'] ) ? $req['height'] : 150;
                $size = array( $width, $height);
                
                if( isset( $req['fullsize']) && !empty( $req['fullsize']) ) $size = $req['fullsize'];
                
                $image = wp_get_attachment_image_src( $img_id, $size );
                
                if( empty( $image ) ){
                        $image = array(
                                get_template_directory_uri() . '/images/bg-profile.png',
                                $width,
                                $height
                        );
                }
                
                echo json_encode( $image );
                exit;
        }
        add_action( 'wp_ajax_get_image', 'naked_ajax_get_attachment' );
        add_action( 'wp_ajax_nopriv_get_image', 'naked_ajax_get_attachment' );
endif;

if( !function_exists( 'camella_testimonials' ) ):
/********
 * Add Testimonials post type
 ****************************/

	function camella_testimonials(){
		register_post_type( 'international', array(
			'public' => false,
			'show_ui' => true,
			'labels' => array(
				'menu_name' => __('International Sales'),
				'name' => __('International Sales'),
				'add_new_item' => __('New Country'),
				'edit_item' => __('Edit Country'),
				'search_items' => __('Search')
			),
			'menu_icon' => 'dashicons-location-alt',
			'supports' => array('slug', 'page-attributes')
		));
		register_post_type( 'testimonials', array(
			'public' => false,
			'show_ui' => true,
			'labels' => array(
				'menu_name' => __('Testimonials'),
				'name' => __('Testimonial'),
				'singular_name' => __('Testimonial'),
				'add_new_item' => __('New Testimony'),
				'edit_item' => __('Edit Testimony'),
				'search_items' => __('Search Testimonials')
			),
			'menu_icon' => 'dashicons-format-chat',
			'supports' => array('slug')
		));
		register_post_type( 'awards', array(
			'public' => false,
			'show_ui' => true,
			'labels' => array(
				'menu_name' => __('Awards'),
				'name' => __('Awards and Recognition'),
				'singular_name' => __('Awards'),
				'add_new_item' => __('New Recognition'),
				'edit_item' => __('Edit Recognition'),
				'search_items' => __('Search Awards and Recognition')
			),
			'menu_icon' => 'dashicons-id',
			'supports' => array('title', 'editor', 'thumbnail')
		));
		flush_rewrite_rules();
	}
	add_action( 'init', 'camella_testimonials' );
	
	function camella_testimonial_columns($columns){
		$columns['title'] = __('Testimony From');
		add_filter( 'the_title', 'camella_testimony_title' );
		return $columns;
	}
	add_filter( 'manage_testimonials_posts_columns', 'camella_testimonial_columns' );
	
	function camella_testimony_title($title){
		
		if( is_admin() && get_post_type() == 'testimonials' ){
			return get_field( 'from', get_the_ID() );
		}
		if( is_admin() && get_post_type() == 'international' ){
			return get_field( 'country', get_the_ID() );
		}
		return $title;
	}
	
	function camella_sales_columns($columns){
		$columns['title'] = __('Country Name');
		add_filter( 'the_title', 'camella_testimony_title' );
		return $columns;
	}
	add_filter( 'manage_international_posts_columns', 'camella_sales_columns' );
	
	function camella_reorder( $query ){
		if( is_admin() ){
			$post_type = $query->get( 'post_type' );
			if( $post_type == 'international' ){
				$query->set( 'orderby', 'menu_order' );
				$query->set( 'order', 'ASC' );
			}
		}
		return $query;
	}
	add_filter( 'parse_query', 'camella_reorder' );
endif;

if( ! function_exists( 'camella_properties_hierarchy' ) ):
/************
 * Retrieve properties
 *********************/
	function camella_properties_hierarchy(){
		get_template_part( 'includes/ajax-query/properties-hierarchy' );
		exit;
	}
	add_action( 'wp_ajax_get_hierarchy', 'camella_properties_hierarchy' );
	add_action( 'wp_ajax_nopriv_get_hierarchy', 'camella_properties_hierarchy' );
endif;

 if( ! is_admin() ):
 /******
  * Include useful functions for front area
  ******************************************/
  get_template_part( 'init' );
 endif;
?>
