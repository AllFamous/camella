
    <!-- inner page header section -->
    <div class="container-fluid inner-header">
        <?php include_once('user.php') ?>
        <div class="section-overlay primary grid"></div>
        <nav class="navbar navbar-default center">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#top-nav">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
				
                <div class="visible-xs brand-small"><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/img/common/logo-camella-green.png" width="180px"></a></div>
                <div class="collapse navbar-collapse" id="top-nav">
                    <div class="hidden-lg hidden-xs brand-top"><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/img/common/logo-camella-green.png" width="180px"></a></div>
                    <?php
                        $options = array(
                            'container'         => false,
                            'menu_class'        => 'nav navbar-nav inner',
                            'theme_location'    => 'primaryMenu',
                            'walker'            => new custom_walker_nav_menu()
                        );
                        wp_nav_menu($options);
                    ?>
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="col-md-12 text-right page-title-crumbs">
                <div class="page-title">
                    <?php
                        $title;
                        if (is_category()){
                            $category = get_query_var('cat');
                            $category = get_category($category);
                            $title = $category->name;
                        } else if (is_page()) {
                            $title = get_the_title();
                        } else if (is_single()) {
                            $title = get_the_title();
                        } else if (is_404()) {
                            $title = '404';
                        }
                    ?>
                    <h2><?php echo $title; ?></h2>
                </div>
                <div class="social-buttons small">
                    <?php echo do_shortcode('[shareaholic app="share_buttons" id="19049963"]'); ?>
                </div>
                <div class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
                    <?php
                        if(function_exists('bcn_display')) {
                            bcn_display();
                        }
                    ?>
                </div>
            </div>
        </div>
        <?php
            if (is_category('news-and-articles')){
                $category = get_category(get_query_var('cat'));
                $categoryId = $category->cat_ID;
                $args = array(
                    'child_of'                 => $categoryId,
                    'orderby'                  => 'name',
                    'taxonomy'                 => 'category',
                    'hide_empty'               => 0
                );
                $categories = get_categories($args); 
                ?>
                <div class="container">
                    <div class="col-md-12 page-sub-nav">
                        <ul class="nav nav-pills">
                            <?php
                                foreach($categories AS $key => $value){
                                    $categoryName = $value->name;
                                    $categoryId = $value->cat_ID;
                                    ?>
                                        <li role="presentation"><a href="<?php echo get_category_link($categoryId); ?>"><?php echo strtoupper($categoryName); ?></a></li>
                                    <?php
                                }
                            ?>
                            <!--
                            <li role="presentation"><a href="#">FEATURES</a></li>
                            <li role="presentation" class="active"><a href="#">COMMUNITIES</a></li>
                            <li role="presentation"><a href="#">LIFESTYLE</a></li>
                            <li role="presentation"><a href="#">EVENTS & CULTURE</a></li>
                            <li role="presentation"><a href="#">HEALTH & WELLNESS</a></li>
                            <li role="presentation"><a href="#">HOMEMAKING</a></li>
                            <li role="presentation"><a href="#">REAL ESTATE</a></li>
                            -->
                        </ul>
                    </div>
                </div>
                <?php
            }
        ?>
    </div>