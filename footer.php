	<!-- footer section -->
    <div class="container-fluid section section-footer" id="section-footer">
        <div class="row footer-main hidden-xs">
            <div class="container">
                <div class="row">
                    <div class="col-sm-3 footer-main-brand">
                        <div class="footer-main-header">ABOUT</div>
						
                        <a href="./about-us" target="_blank"><img src="http://testdev.camella.com.ph/wp-content/uploads/2015/07/logo-camella-white-350x93.png"  class="img-responsive"></a>
						
                        <p><strong>All That You Need is Here!</strong><br />
                        Camella, the flagship brand of Vista Land & Lifescapes Inc., that delivers excellent service by providing beautiful, high-quality homes for the affordable and mid-income segment of the market.</p>
                    </div>
                    <div class="col-sm-3 footer-main-links">
                        <div class="footer-main-header">LINKS</div>
                        <div class="row">
                            <?php
                                $options = array(
                                    'container'         => false,
                                    'theme_location'    => 'footerMenu',
                                    'walker'            => new simple_walker,
                                    'items_wrap'        => '%3$s'
                                );
                                wp_nav_menu($options);
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-3 footer-main-social">
                        <div class="footer-main-header">FOLLOW US</div>
                        <div class="social-buttons text-center small">
                            <ul class="no-bullets inline">
                                <?php
                                    $templateUrl = get_template_directory_uri();
                                    $jsonFile = json_decode(file_get_contents($templateUrl.'/data/footer-social-links.json'), true);
                                    foreach($jsonFile as $key => $value){
                                        $icon = $value['icon'];
                                        $class = $value['class'];
                                        $name = $value['name'];
                                        $url = $value['url'];
                                        echo '<li><a target="_blank" href="'.$url.'" class="'.$class.'" title="'.$name.'" rel="nofollow" target="_blank"><i class="fa '.$icon.'"></i></a></li>';
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-3 footer-main-subscribe">
                        <div class="footer-main-header">SUBSCRIBE</div>
                        <form>
                            <div class="form-group">
                                <label for="subscribeEmai">Email Address</label>
                                <input type="email" class="form-control" id="subscribeEmai" placeholder="email address">
                            </div>
                             <div class="form-group">
                                <button type="button" class="btn btn-primary" id="footer-subscribe">SUBSCRIBE</button>
                            </div>
                        </form>
                        <div class="subscribe-form-alerts"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row footer-logos">
            <div class="container">
                <div class="row text-center">
                    <div class="col-md-12">
                        <?php
                            $templateUrl = get_template_directory_uri();
                            $jsonFile = json_decode(file_get_contents($templateUrl.'/data/footer-company-links.json'), true);
                            foreach($jsonFile as $key => $value){
                                $name = $value['name'];
                                $url = $value['url'];
                                echo '<a target="_blank" href="'.$url.'" title="'.$name.'" rel="nofollow" target="_blank">'.$name.'</a>';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">© Copyright <?php echo date('Y'); ?>. Camella - A Vista Land Company.&nbsp;&nbsp;&nbsp;<a href="<?php echo get_template_directory_uri(); ?>/privacy-policy/" target="_blank">PRIVACY POLICY</a> | <a href="<?php echo get_template_directory_uri(); ?>/terms-conditions/" target="_blank">TERMS & CONDITIONS</a></div>
                    <div class="col-sm-6 hidden-xs text-right"></div>
                </div>
            </div>
        </div>
    </div>

	<!-- scripts start -->
	<?php wp_footer(); ?>
    <?php
        if (is_home() || is_front_page()){
            echo '<script type="text/javascript" src="'.get_template_directory_uri().'/js/common/'.$post->post_name.'.js"></script>';
        } else if (is_category() || is_single()) {
            $category = get_the_category();
            $categorySlug;
            foreach($category AS $key => $value){
                if ($value->category_parent == 0){
                    $categorySlug = $value->slug;
                }
            }
            echo '<script type="text/javascript" src="'.get_template_directory_uri().'/js/common/'.$categorySlug.'.js"></script>';
        } else if (is_page()){
            echo '<script type="text/javascript" src="'.get_template_directory_uri().'/js/common/page.js"></script>';
            $pageSlug = $post->post_name;
            $customJsFile = TEMPLATEPATH.'/js/common/page-'.$pageSlug.'.js';
            if (file_exists($customJsFile)){
                echo '<script type="text/javascript" src="'.get_template_directory_uri().'/js/common/page-'.$pageSlug.'.js"></script>';
            }
        }
    ?>
    <!-- scripts end -->
</body>
</html>