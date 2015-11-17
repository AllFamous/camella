<?php get_header(); ?>
<?php
include_once('includes/inside/mast-header.php');
?>
<div class="container-fluid inner-page-content">
<div class="container">
<div class="row basic-page">
<div class="col-md-12">
<!-- buttons -->
<div class="text-center projects-buttons">
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
        echo '<a href="#" class="btn btn-primary btn-lg active" data-location-id="">ALL</a>';
        foreach($categories as $key => $value){
            $name = $value->name;
            $locationId = $value->term_id;
            echo '<a href="#" class="btn btn-primary btn-lg" data-location-id="'.$locationId.'">'.strtoupper($name).'</a>';
        }
    ?>
</div>

<!-- map -->

<div class="col-md-12 map-container" id="index-properties"></div>
<div class="clearfix"></div>
<!-- listings -->
<?php
	$category = get_category(get_query_var('cat'));
	$categoryId = $category->cat_ID;
	if (!isCategoryLevel('2')){
		$slugId = $categoryId;
	} else {
		$slugId = 0;
	}
?>
<div class="well project-lists" data-page-category-id="<?php echo $slugId; ?>">
	<h2 class="selected-title">All Locations</h2>
	<div class="row">
		<?php
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
			$j=1;
			foreach($categories as $key => $value){
				$name = $value->name;
				$locationId = $value->term_id;
				?>
            		<div class="col-md-3 location-item " data-location-id="<?php echo $locationId; ?>">
            			<h4><i class="fa fa-map-marker"></i> <?php echo $name; ?></h4>
            			<ul class="fa-ul first-fa-ul">
            			<?php
            				$args = array(
	                            'parent'        => $locationId,
	                            'hierarchical'  => 0,
	                            'orderby'       => 'id',
	                            'order'         => 'ASC',
	                            'hide_empty'    => 0
                			);

                			$subCategories = get_categories($args);
                			$i=1;
                			foreach($subCategories as $keySub => $valueSub){
                				$subName = $valueSub->name;
								$subLocationId = $valueSub->term_id;
								?>
								<div class="accordion" id="accordion<?= $j."_".$i; ?>">
								
									<li class= "">
										<a href="#collapseOne<?= $j."_".$i; ?>" data-parent="#accordion<?= $j."_".$i; ?>" data-toggle="collapse" class="accordion-toggle collapsed">
										  <?php echo $subName; ?><i class="fa fa-plus"></i><i class="fa fa-minus"></i>
										</a>										
										<div class="accordion-body collapse" id="collapseOne<?= $j."_".$i; ?>">
										<?php
											$args = array(
												'posts_per_page'   => -1,
												'category'         => $subLocationId,
												'orderby'          => 'title',
												'order'            => 'DESC',
												'post_status'      => 'publish'
											);
											$locationsMain = get_posts($args);
											if(count((array)$locationsMain) >= 1){
												?>
												
												<ul class="fa-ul" >
													<?php
    												foreach($locationsMain AS $keyLoc => $valueLoc){
        												$locId = $valueLoc->ID;
        												if (checkPostDescendants($subLocationId) === false){
            												?>
            													<li>
            														
            														<strong><a href="<?php echo get_permalink($locId); ?>"><?php echo get_the_title($locId); ?></a></strong>
            													</li>
            												<?php
        												}
    												}
													?>
												</ul>
												<?php
											}
										?>

										<?php
											$args = array(
					                            'parent'        => $subLocationId,
					                            'hierarchical'  => 0,
					                            'orderby'       => 'id',
					                            'order'         => 'ASC',
					                            'hide_empty'    => 0
				                			);

				                			$subSubCategories = get_categories($args);
				                			if(count((array)$subCategories) >= 1){
				                				?>
			                					<ul class="fa-ul ">
			                						<?php
			                						$k=1;
							                			foreach($subSubCategories as $keySub => $valueSubSub){
							                				$subSubName = $valueSubSub->name;
            												$subSubLocationId = $valueSubSub->term_id;
							                				?>
							                					<li class="accordion" id="accordion<?= $j."_".$i."_".$k; ?>">
							                					<a href="#collapseOne<?= $j."_".$i."_".$k; ?>" data-parent="#accordion<?= $j."_".$i."_".$k; ?>" data-toggle="collapse" class="accordion-toggle collapsed">
																  <strong><?php echo $subSubName; ?></strong><i class="fa fa-plus"></i><i class="fa fa-minus"></i>
																</a>
			                										<div class="accordion-body collapse" id="collapseOne<?= $j."_".$i."_".$k; ?>">
		                											<?php
		                												$args = array(
		                													'posts_per_page'   => -1,
		                													'category'         => $subSubLocationId,
		                													'orderby'          => 'title',
		                													'order'            => 'DESC',
		                													'post_status'      => 'publish'
		                												);
		                												$locations = get_posts($args);
		                												if (count((array)$locations) >= 1){
		                													?>

	                														<ul class="fa-ul">
	                															<?php
				                												foreach($locations AS $keyLocLoc => $valueLocLoc){
					                												$locLocId = $valueLocLoc->ID;
					                												?>
					                													<li>					                														
					                														<strong><a href="<?php echo get_permalink($locLocId); ?>"><i class="fa-li fa fa-home"></i><?php echo get_the_title($locLocId); ?></a></strong>
					                													</li>
					                												<?php
				                												}
				                												?>
	                														</ul>
		                													<?php
		                												}
		                											?>
			                									</div></li>
							                				<?php
							                				$k++;
							                			}

			                						?>
			                					</ul>
				                				<?php
				                			}
										?></div><!-- end of iner contaer -->
									</li>
									</div>
								<?php
								$i++;
                			}
            			?>
            			</ul>
            		</div>
				<?php
				$j++;
			}
		?>
	</div>
</div>
</div>
</div>
</div>
</div>


<?php
include_once('includes/home/howtos.php');
include_once('includes/home/homeowners.php');
include_once('includes/home/largest.php');
?>

<?php get_footer(); ?>