    <!-- news section -->
    <?php
    $news = (array) get_theme_mod( 'news' );
    $news = (object) array_filter( $news );
    ?>
    <div class="container-fluid section section-news" id="section-news">
        <!--<div class="section-overlay darken grid"></div>-->
        <div class="container">
            <!-- section header -->
            <div class="row">
                <div class="col-md-12 heading">
                    <h2><?php echo $news->heading; ?></h2>
                    <hr>
                    <p><?php echo $news->tagline; ?></p>
                </div>
            </div>
            <!-- main section -->
            <div class="row">
                <div class="col-md-9">
                    <div class="row">
                        <?php
                            $categoryId = get_category_by_slug('news-and-articles');
                            $categoryId = $categoryId->term_id;
                            $args = array(
                                'numberposts'       => 1,
                                'category'          => $categoryId,
                                'post_status'       => 'publish',
                                'tax_query'      => array(
                                    array(
                                        'taxonomy'  => 'post_tag',
                                        'field'     => 'slug',
                                        'terms'     => sanitize_title('featured')
                                    )
                                )                           
                            );
                            
                           $posts = get_posts($args);

                            if ($posts){
                                foreach ($posts as $key => $value) {
                                        print_r($value);
                                    $featuredImage = wp_get_attachment_url(get_post_thumbnail_id( (int) $value->ID), 'full');
                                    ?>
                                    <div class="col-md-12">
                                        <div class="panel panel-default news-item">
                                            <div class="panel-heading no-padding">
                                                <div class="img-overlay">
                                                    <div class="img-buttons">
                                                        <ul class="no-bullets inline">
                                                            <li><a href="#" data-toggle="tooltip" data-placement="top" title="view image" data-toggle="lightbox" data-remote="<?php echo $featuredImage; ?>" class="gallery-lightbox"><i class="fa fa-file-image-o"></i></a></li>
                                                            <li><a href="<?php echo get_permalink($value->ID); ?>" data-toggle="tooltip" data-placement="top" title="view article"><i class="fa fa-eye"></i></a></li>
                                                        </ul>
                                                        <div class="social-buttons">
                                                            <ul class="no-bullets inline">
                                                                <li class="text-center"><a href="http://www.shareaholic.com/api/share/?v=1&apitype=1&apikey=8943b7fd64cd8b1770ff5affa9a9437b&service=5&link=<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?>" class="fb"><i class="fa fa-facebook"></i></a></li>
                                                                <li class="text-center"><a href="http://www.shareaholic.com/api/share/?v=1&apitype=1&apikey=8943b7fd64cd8b1770ff5affa9a9437b&service=7&link=<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?>" class="tw"><i class="fa fa-twitter"></i></a></li>
                                                                <li class="text-center"><a href="http://www.shareaholic.com/api/share/?v=1&apitype=1&apikey=8943b7fd64cd8b1770ff5affa9a9437b&service=304&link=<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?>" class="gp"><i class="fa fa-google-plus"></i></a></li>
                                                                <li class="text-center"><a href="http://www.shareaholic.com/api/share/?v=1&apitype=1&apikey=8943b7fd64cd8b1770ff5affa9a9437b&service=309&link=<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?>" class="pi"><i class="fa fa-pinterest"></i></a></li>
                                                                <li class="text-center"><a href="http://www.shareaholic.com/api/share/?v=1&apitype=1&apikey=8943b7fd64cd8b1770ff5affa9a9437b&service=88&link=<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?>" class="li"><i class="fa fa-linkedin"></i></a></li>
                                                                <li class="text-center"><a href="http://www.shareaholic.com/api/share/?v=1&apitype=1&apikey=8943b7fd64cd8b1770ff5affa9a9437b&service=313&link=<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?>" class="em"><i class="fa fa-envelope"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <img src="<?php echo $featuredImage; ?>" class="img-responsive transition">
                                            </div>
                                            <div class="panel-body">
                                                <ul class="no-bullets inline list-tags">
                                                    <?php
                                                        $categories = get_the_category($value->ID);
                                                        foreach ($categories AS $keyCat => $valueCat) {
                                                            if ($valueCat->parent != 0){
                                                                $categoryLink = get_category_link($valueCat->cat_ID);
                                                                echo '<li><a target="_blank" href="'.$categoryLink.'">'.strtoupper($valueCat->name).'</a></li>';
                                                            }
                                                        }
                                                    ?>
                                                </ul>
                                                <h3><a target="_blank" href="<?php echo get_permalink($value->ID); ?>"><?php echo $value->post_title; ?></a></h3>
                                                <p><?php echo wp_trim_words($value->post_content, 70, '...'); ?></p>
                                                <a target="_blank" href="<?php echo get_permalink($value->ID); ?>" class="btn btn-primary btn-sm">READ MORE</a>
                                            </div>
                                            <div class="panel-footer">
                                                <span><i class="fa fa-calendar fa-fw"></i> <?php echo strtoupper(get_the_date('M d, Y', $value->ID)); ?></span>
                                                <span class="pull-right"><i class="fa fa-comment fa-fw"></i> <?php echo get_comments_number( $value->ID ); ?> COMMENTS</span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }

                            // rest of the articles
                            $exeptionTerm = get_term_by('slug', 'featured', 'post_tag');
                            $categoryId = get_category_by_slug('news-and-articles');
                            $categoryId = $categoryId->term_id;
                            $args = array(
                                'tag__not_in'       => array($exeptionTerm->term_id),
                                'numberposts'       => 2,
                                'category'          => $categoryId,
                                'post_status'       => 'publish'
                            );
                            $posts = get_posts($args);

                            if ($posts){
                                foreach ($posts as $key => $value) {
                                    $featuredImage = wp_get_attachment_url(get_post_thumbnail_id( (int) $value->ID), 'full');
                                    ?>
                                    <div class="col-sm-6">
                                        <div class="panel panel-default news-item">
                                            <div class="panel-heading no-padding">
                                                <div class="img-overlay">
                                                    <div class="img-buttons">
                                                        <ul class="no-bullets inline">
                                                            <li><a href="#" data-toggle="tooltip" data-placement="top" title="view image" data-toggle="lightbox" data-remote="<?php the_field('thumbImage', $value->ID); ?>" class="gallery-lightbox"><i class="fa fa-file-image-o"></i></a></li>
                                                            <li><a target="_blank" href="<?php echo get_permalink($value->ID); ?>" data-toggle="tooltip" data-placement="top" title="view article"><i class="fa fa-eye"></i></a></li>
                                                        </ul>
                                                        <div class="social-buttons">
                                                            <ul class="no-bullets inline">
                                                                <li class="text-center"><a href="http://www.shareaholic.com/api/share/?v=1&apitype=1&apikey=8943b7fd64cd8b1770ff5affa9a9437b&service=5&link=<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?>" class="fb"><i class="fa fa-facebook"></i></a></li>
                                                                <li class="text-center"><a href="http://www.shareaholic.com/api/share/?v=1&apitype=1&apikey=8943b7fd64cd8b1770ff5affa9a9437b&service=7&link=<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?>" class="tw"><i class="fa fa-twitter"></i></a></li>
                                                                <li class="text-center"><a href="http://www.shareaholic.com/api/share/?v=1&apitype=1&apikey=8943b7fd64cd8b1770ff5affa9a9437b&service=304&link=<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?>" class="gp"><i class="fa fa-google-plus"></i></a></li>
                                                                <li class="text-center"><a href="http://www.shareaholic.com/api/share/?v=1&apitype=1&apikey=8943b7fd64cd8b1770ff5affa9a9437b&service=309&link=<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?>" class="pi"><i class="fa fa-pinterest"></i></a></li>
                                                                <li class="text-center"><a href="http://www.shareaholic.com/api/share/?v=1&apitype=1&apikey=8943b7fd64cd8b1770ff5affa9a9437b&service=88&link=<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?>" class="li"><i class="fa fa-linkedin"></i></a></li>
                                                                <li class="text-center"><a href="http://www.shareaholic.com/api/share/?v=1&apitype=1&apikey=8943b7fd64cd8b1770ff5affa9a9437b&service=313&link=<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?>" class="em"><i class="fa fa-envelope"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <img src="<?php echo $featuredImage; ?>" class="img-responsive transition">
                                            </div>
                                            <div class="panel-body">
                                                <ul class="no-bullets inline list-tags">
                                                    <?php
                                                        $categories = get_the_category($value->ID);
                                                        foreach ($categories AS $keyCat => $valueCat) {
                                                            if ($valueCat->parent != 0){
                                                                $categoryLink = get_category_link($valueCat->cat_ID);
                                                                echo '<li><a href="'.$categoryLink.'">'.strtoupper($valueCat->name).'</a></li>';
                                                            }
                                                        }
                                                    ?>
                                                </ul>
                                                <h3><a target="_blank" href="<?php echo get_permalink($value->ID); ?>"><?php echo $value->post_title; ?></a></h3>
                                                <p><?php echo wp_trim_words($value->post_content, 30, '...'); ?></p>
                                                <a target="_blank" href="<?php echo get_permalink($value->ID); ?>" class="btn btn-primary btn-sm">READ MORE</a>
                                            </div>
                                            <div class="panel-footer">
                                                <span><i class="fa fa-calendar fa-fw"></i> <?php echo strtoupper(get_the_date('M d, Y', $value->ID)); ?></span>
                                                <span class="pull-right"><i class="fa fa-comment fa-fw"></i> 8 COMMENTS</span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        ?>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <a target="_blank" href="category/news-and-articles/" class="btn btn-primary btn-lg"><i class="fa fa-file-text fa-fw"></i> MORE NEWS & ARTICLES</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel-group panel-social-feeds" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div class="panel-heading no-padding" role="tab" id="headingCa">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#contentCa" aria-expanded="false" aria-controls="contentCa"><i class="fa fa-calendar fa-fw"></i> Upcoming Events</a>
                                </h4>
                            </div>
                            <div id="contentCa" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingCa">
                                <div id="event-carousel" class="panel-body">
                                    <?php
                                        $categoryId = get_category_by_slug('events');
                                        $categoryId = $categoryId->term_id;
                                        $args = array(
                                            'numberposts'       => 3,
                                            'category'          => $categoryId,
                                            'post_status'       => 'publish'                     
                                        );
                                        $posts = get_posts($args);
                                        if ($posts){
                                            foreach ($posts as $key => $value) {
                                                ?>
                                                <div class="media calendar-item carousel">
                                                    <div class="media-left">
                                                        <div class="calendar-date">
                                                            <?php
                                                                $startDate = get_field('eventStartDate', $value->ID);
                                                                $formatOutDay = date('d', strtotime($startDate));
                                                                $formatOutMonth = date('M', strtotime($startDate));
                                                            ?>
                                                            <div class="calendar-day"><?php echo $formatOutDay; ?></div>
                                                            <div class="calendar-month"><?php echo strtoupper($formatOutMonth); ?></div>
                                                        </div>
                                                    </div>
                                                    <div class="media-body">
                                                        <h5 class="media-heading"><a href="<?php echo get_permalink($value->ID); ?>"><?php echo $value->post_title; ?></a></h5>
                                                        <a target="_blank" href="<?php echo get_permalink($value->ID); ?>" class="btn btn-primary btn-sm">VIEW EVENT</a>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading no-padding" role="tab" id="headingFb">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#contentFb" aria-expanded="true" aria-controls="contentFb"><i class="fa fa-facebook fa-fw"></i> Facebook Feed</a>
                                </h4>
                            </div>
                            <div id="contentFb" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingFb">
                                <div class="social-carousel">
                                    <div class="panel-body">
                                        <div class="media">
                                            <div class="media-left">
                                                <a href="#"><img class="media-object" src="<?php echo get_template_directory_uri(); ?>/img/common/social-camella-logo.jpg" width="50px" alt="Camella (Official)"></a>
                                            </div>
                                            <div class="media-body">
                                                <h5 class="media-heading">Camella (Official)</h5>
                                                Camella invites you to the Grand Launch of our Camella Cerritos CDO tomorrow, May 30 at the 10th floor of Mallberry Suites, Cagayan De Oro.
                                            </div>
                                        </div>
                                        <a href="#" class="btn btn-primary btn-sm btn-block"><i class="fa fa-facebook fa-fw"></i> LIKE US ON FACEBOOK</a>
                                    </div>
                                    <div class="panel-body">
                                        <div class="media">
                                            <div class="media-left">
                                                <a href="#"><img class="media-object" src="<?php echo get_template_directory_uri(); ?>/img/common/social-camella-logo.jpg" width="50px" alt="Camella (Official)"></a>
                                            </div>
                                            <div class="media-body">
                                                <h5 class="media-heading">Camella (Official)</h5>
                                                Camella Opens in the Industrial Port City of Calabarzon
                                            </div>
                                        </div>
                                        <a href="#" class="btn btn-primary btn-sm btn-block"><i class="fa fa-facebook fa-fw"></i> LIKE US ON FACEBOOK</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading no-padding" role="tab" id="headingTw">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#contentTw" aria-expanded="false" aria-controls="contentTw"><i class="fa fa-twitter fa-fw"></i> Twitter Feed</a>
                                </h4>
                            </div>
                            <div id="contentTw" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTw">
                                <div class="social-carousel">
                                    <div class="panel-body">
                                        <div class="media">
                                            <div class="media-left">
                                                <a href="#"><img class="media-object" src="<?php echo get_template_directory_uri(); ?>/img/common/social-camella-logo.jpg" width="50px" alt="Camella (Official)"></a>
                                            </div>
                                            <div class="media-body">
                                                <h5 class="media-heading">Camella (Official)</h5>
                                                Camella Unveils its Third Jewel in Isabela <a href="#">t.co/2913idnq</a>
                                            </div>
                                        </div>
                                        <a href="#" class="btn btn-primary btn-sm btn-block"><i class="fa fa-twitter fa-fw"></i> FOLLOW US ON TWITTER</a>
                                    </div>
                                    <div class="panel-body">
                                        <div class="media">
                                            <div class="media-left">
                                                <a href="#"><img class="media-object" src="<?php echo get_template_directory_uri(); ?>/img/common/social-camella-logo.jpg" width="50px" alt="Camella (Official)"></a>
                                            </div>
                                            <div class="media-body">
                                                <h5 class="media-heading">Camella (Official)</h5>
                                                Camella Introduces Two New Projects in Isabela, Batangas City. <a href="#">t.co/2913idnq</a>
                                            </div>
                                        </div>
                                        <a href="#" class="btn btn-primary btn-sm btn-block"><i class="fa fa-twitter fa-fw"></i> FOLLOW US ON TWITTER</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading no-padding" role="tab" id="headingIg">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#contentIg" aria-expanded="false" aria-controls="contentIg"><i class="fa fa-instagram fa-fw"></i> Instagram Feed</a>
                                </h4>
                            </div>
                            <div id="contentIg" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingIg">
                                <div class="panel-body">
                                    <div class="media">
                                        <a href="#" class="thumbnail thumbnail-inline"><img src="<?php echo get_template_directory_uri(); ?>/img/content/insta-01.jpg" width="50px"></a>
                                        <a href="#" class="thumbnail thumbnail-inline"><img src="<?php echo get_template_directory_uri(); ?>/img/content/insta-02.jpg" width="50px"></a>
                                        <a href="#" class="thumbnail thumbnail-inline"><img src="<?php echo get_template_directory_uri(); ?>/img/content/insta-03.jpg" width="50px"></a>
                                        <a href="#" class="thumbnail thumbnail-inline"><img src="<?php echo get_template_directory_uri(); ?>/img/content/insta-04.jpg" width="50px"></a>
                                        <a href="#" class="thumbnail thumbnail-inline"><img src="<?php echo get_template_directory_uri(); ?>/img/content/insta-05.jpg" width="50px"></a>
                                        <a href="#" class="thumbnail thumbnail-inline"><img src="<?php echo get_template_directory_uri(); ?>/img/content/insta-06.jpg" width="50px"></a>
                                        <a href="#" class="thumbnail thumbnail-inline"><img src="<?php echo get_template_directory_uri(); ?>/img/content/insta-01.jpg" width="50px"></a>
                                        <a href="#" class="thumbnail thumbnail-inline"><img src="<?php echo get_template_directory_uri(); ?>/img/content/insta-02.jpg" width="50px"></a>
                                    </div>
                                    <a href="#" class="btn btn-primary btn-sm btn-block"><i class="fa fa-instagram fa-fw"></i> FOLLOW US ON INSTAGRAM</a>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading no-padding" role="tab" id="headingCareers">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#contentCareers" aria-expanded="true" aria-controls="contentCareers"><i class="fa fa-user fa-fw"></i> Careers</a>
                                </h4>
                            </div>
                            <div id="contentCareers" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingCareers">
                                <div class="social-carousel">
                                    <?php
                                        $categoryId = get_category_by_slug('careers');
                                        $categoryId = $categoryId->term_id;
                                        $args = array(
                                            'numberposts'       => 5,
                                            'category'          => $categoryId,
                                            'post_status'       => 'publish'                     
                                        );
                                        $posts = get_posts($args);
                                        if ($posts){
                                            foreach ($posts as $key => $value) {
                                                ?>
                                                    <div class="panel-body <?php echo $categoryId; ?>">
                                                        <div class="media calendar-item">
                                                            <div class="media-body">
                                                                <h5 class="media-heading"><a href="<?php echo get_permalink($value->ID); ?>"><?php echo $value->post_title; ?></a></h5>
                                                                <p><?php echo wp_trim_words($value->post_content, 20, '...'); ?></p>
                                                                <a target="_blank" href="<?php echo get_permalink($value->ID); ?>" class="btn btn-primary btn-sm">VIEW JOB DETAILS</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                    echo '<li><a href="'.$url.'" class="'.$class.'" title="'.$name.'" rel="nofollow" target="_blank"><i class="fa '.$icon.'"></i></a></li>';
                                }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>