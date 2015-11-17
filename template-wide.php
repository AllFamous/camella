<?php /* Template Name: Camella Single Columns Page */ ?>

<?php get_header(); ?>
<?php
	include_once('includes/inside/mast-header.php');
?>

    <!-- page content -->
    <?php
        if (has_post_thumbnail()) {
            ?>
            <div class="container-fluid article-hero-image">
                <?php $postFeatured = wp_get_attachment_url(get_post_thumbnail_id($post->ID)); ?>
                <img src="<?php echo $postFeatured; ?>" class="img-responsive">
            </div>
            <?php
        }
    ?>

    <div class="container-fluid inner-page-content">
        <div class="container">
            <div class="row basic-page">
                <div class="col-md-12">
                    <article class="main-article">
                        <h1><?php the_title(); ?></h1>
                        <p><?php echo nl2br($post->post_content); ?></p>
                    </article>
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