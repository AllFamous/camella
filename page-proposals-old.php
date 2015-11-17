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
                <div class="col-md-9">
                    <article class="main-article">
                        <h1><?php the_title(); ?></h1>
                        <p><?php echo nl2br($post->post_content); ?></p>
                        <div class="panel panel-grey no-shadow">
                            <div class="panel-heading">
                                <h4><i class="fa fa-file-text"></i> Project Presentation Form</h4>
                            </div>
                            <div class="panel-body">
                                <div class="proposals-notice"></div>
                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <label for="firstName" class="col-sm-2 control-label">First Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="firstName" placeholder="first name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="middleName" class="col-sm-2 control-label">Middle Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="middleName" placeholder="middle name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="lastName" class="col-sm-2 control-label">Last Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="lastName" placeholder="last name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="completeAddress" class="col-sm-2 control-label">Complete Address</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" id="completeAddress" placeholder="complete address">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="telNumber" class="col-sm-2 control-label">Tel Number</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" id="telNumber" placeholder="telephone number">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="mobileNumber" class="col-sm-2 control-label">Mobile Number</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" id="mobileNumber" placeholder="mobile number">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="emailAddress" class="col-sm-2 control-label">Email Address</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="emailAddress" placeholder="email address">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="message" class="col-sm-2 control-label">Message</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="message" placeholder="message"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label"></label>
                                        <div class="col-sm-10">
                                            <div class="g-recaptcha" data-sitekey="6Lf7Dg4TAAAAAItYlyBb7QqJYLbipXMmL5lLTg50"></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="panel-footer text-right">
                                <button type="button" class="btn btn-secondary btn-lg" id="proposals-submit">SUBMIT</button>
                            </div>
                        </div>
                    </article>
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