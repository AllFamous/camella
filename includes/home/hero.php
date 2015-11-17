    <!-- hero section -->
    <div class="homepage-hero-module">
        <div class="video-container">
            <div class="content-container">
                <?php include_once('hero-user.php') ?>
                <nav class="navbar navbar-default center">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#top-nav">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div class="collapse navbar-collapse" id="top-nav">
                            <?php
                                $options = array(
                                    'container'         => false,
                                    'menu_class'        => 'nav navbar-nav',
                                    'theme_location'    => 'primaryHeroMenu',
                                    'walker'            => new custom_walker_nav_menu()
                                );
                                wp_nav_menu($options);
                            ?>
                        </div>
                    </div>
                </nav>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center hero-section">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/common/logo-camella-green.png">
                            <h1>Beautiful. Convenient. Secure.</h1>
                            <h2>Camella Masterplanned Cities. All that you need is here.</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero-footer">
                <div class="container-fluid">
                    <form class="container">
                        <div class="row">
                            <div class="hero-notice"></div>
                            <div class="col-md-5ths">
							
<style type="text/css">
a.bestdeal {

text-decoration: none;
color: white;
}
</style>
							
                                <a href="#ourpropertiesCamella" class="bestdeal"><button type="button" class="btn btn-secondary btn-lg btn-deals btn-block">BEST DEALS</button></a>
                            </div>
                            <div class="col-md-5ths">
                                <div class="form-group location-container">
                                    <label for="range">Select location</label>
                                    <select id="hero-location" class="select-lg exception">
                                        <option></option>
                                    </select>
                                    <div class="panel hero-panel-map">
                                        <div class="panel-body no-padding" id="hero-locations-map"></div>
                                        <div class="arrow-down"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5ths">
                                <div class="form-group type-container">
                                    <label for="hero-property">Areas/Location</label>
                                    <select id="hero-property" class="select-lg exception">
                                        <option></option>
                                    </select>
                                    <div class="panel hero-panel-properties">
                                        <div class="panel-body" id="hero-properties"></div>
                                        <div class="arrow-down"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5ths">
                                <div class="form-group range-container">
                                    <label for="hero-range">Select price range</label>
                                    <select id="hero-range" class="select-lg exception">
                                        <option></option>
                                        <option value="1" data-low="0" data-high="1000000">Less than 1M</option>
                                        <option value="2" data-low="1000000.01" data-high="2000000">1M - 2M</option>
                                        <option value="3" data-low="2000000.01" data-high="3000000">2M - 3M</option>
                                        <option value="4" data-low="3000000.01" data-high="4000000">3M - 4M</option>
                                        <option value="5" data-low="4000000.01" data-high="5000000">4M - 5M</option>
                                        <option value="6" data-low="5000000.01" data-high="10000000">5M and up</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5ths">
                                <button type="button" class="btn btn-primary btn-lg btn-search btn-block" id="heroSearch"><i class="fa fa-search"></i> SEARCH</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="filter"></div>
            <?php
            $video_portrait = get_theme_mod( 'video_portrait', get_template_directory_uri() . '/img/common/video-frame.jpg' );
            $video_url = get_theme_mod( 'video_url', get_template_directory_uri() . '/vid/video.mp4');
            $video_type = basename($video_url);
            $video_type = substr($video_type, strrpos($video_type, ".")+1);
            ?>
            <video autoplay loop muted class="fillWidth" poster="<?php echo esc_url($video_portrait); ?>">
                <source src="<?php echo esc_url($video_url); ?>" type="video/<?php echo $video_type; ?>">
                Your browser does not support the video tag. I suggest you upgrade your browser.
            </video>
        </div>
    </div>