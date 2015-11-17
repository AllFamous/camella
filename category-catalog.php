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
?>
    <div class="container-fluid inner-page-content">
	<div class="container">
		<div class="row basic-page">
			<div class="col-md-12">
				<!-- buttons -->
				<div class="text-center catalog-buttons">
				<?php
				// get property sub category
				$categoryId = get_category_by_slug('catalog'); 
	                        $categoryId = $categoryId->term_id;
	                        $args = array(
	                            'parent'        => $categoryId,
	                            'hierarchical'  => 0,
	                            'orderby'       => 'id',
	                            'order'         => 'ASC',
	                            'hide_empty'    => 0
	                        );
	                        $categories = get_categories($args);
				
	                        foreach($categories as $key => $value){
	                            $name = $value->name;
	                            $locationId = $value->term_id;
	                            echo '<a href="#" class="btn btn-primary btn-lg2" data-catalog="'. $value->slug . '" data-catalog-id="'.$locationId.'">'.strtoupper($name).'</a>';
	                        }
	                    ?>
	                    <div class="container-catalog">
	                        <div class="series-house-item owl-carousel text-left"></div>                       
	                    </div>
	                </div>
                </div>
		<div class="location-lists">
			<h3 class="article-header-divider"><?php _e('Locations'); ?></h3>
			<div id="location-lists-container" data-nonce="<?php echo wp_create_nonce( 'get_location_properties' ); ?>"></div>
		</div>
		<!-- Generates popup gallery -->
		<script type="text/html" id="catalog-gallery-html">
			<% if( data.images ){
				var i = 0;
				_.each(data.images, function(img){  %>
					<div data-toggle="lightbox" data-gallery="houseItem<%=data.count%>" data-remote="<%=img['url']%>" data-title="<%=data.title%>"></div>
				<% i++; });
			}%>
			
		</script>
            </div>
        </div>
    </div>
<?php
	include_once('includes/home/howtos.php');
	include_once('includes/home/homeowners.php');
	include_once('includes/home/largest.php');
?>
<?php get_footer(); ?>