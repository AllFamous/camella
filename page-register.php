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
                        <div class="panel panel-grey no-shadow" id="registration-form">
                            <div class="panel-heading">
                                <h4><i class="fa fa-user"></i> Registration Form</h4>
                            </div>
                            <div class="panel-body">
                                <div class="register-notice"></div>
                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <label for="regUsername" class="col-sm-2 control-label">Username</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="regUsername" placeholder="username">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="regEmailAddress" class="col-sm-2 control-label">Email Address</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" id="regEmailAddress" placeholder="email address">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="regFirstName" class="col-sm-2 control-label">First Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="regFirstName" placeholder="first name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="regLastName" class="col-sm-2 control-label">Last Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="regLastName" placeholder="last name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="regState" class="col-sm-2 control-label">State/Province</label>
                                        <div class="col-sm-10">
                                                    <select id="regState" data-phils="state" data-cityid="#regCity"></select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="regCity" class="col-sm-2 control-label">City/Municipality</label>
                                        <div class="col-sm-10">
                                            <select id="regCity" data-phils="cities">
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="regUserType" class="col-sm-2 control-label">User Type</label>
                                        <div class="col-sm-10">
                                            <?php
                                                $restricted = array('administrator', 'author', 'contributor', 'editor', 'subscriber');
                                                global $wp_roles;

                                                $all_roles = $wp_roles->roles;
                                                $siteRoles = apply_filters('editable_roles', $all_roles);
                                                echo '<select id="regUserType"><option></option>';
                                                foreach($siteRoles AS $key => $value){
                                                    if (!in_array($key, $restricted) == 1){
                                                        echo '<option value="'.$key.'">'.$value['name'].'</option>';
                                                    }
                                                }
                                                echo '</select>';
                                            ?>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="panel-footer text-right">
                                <button type="button" class="btn btn-secondary btn-lg" id="register-submit">SUBMIT</button>
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