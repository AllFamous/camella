<?php get_header(); ?>
<?php
	include_once('includes/inside/mast-header.php');
?>
    <div class="container-fluid inner-page-content">
        <div class="container">
            <div class="row basic-page">
                <div class="col-md-9">

				
<?php
$s=get_search_query();
$args = array(
's' =>$s
);
$the_query = new WP_Query( $args );
if ($the_query->have_posts() ) {
        _e("<h2 style='font-weight:bold;color:#000'>Search Results for: ".get_query_var('s')."</h2>");
        while ( $the_query->have_posts() ) {
           $the_query->the_post();
                 ?>
                    <li>
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </li>
                 <?php
        }
    }else{
?>
        <h2 style='font-weight:bold;color:#000'>Nothing Found</h2>
        <div class="alert alert-info">
          <p>Sorry, but nothing matched your search criteria. Please try again with some different keywords.</p>
        </div>
<?php } ?>



						
                </div>
                <div class="col-md-3">
                    <?php include_once('includes/inside/right-column.php'); ?>
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






