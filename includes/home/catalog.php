    <!-- house catalog section -->
    <?php
    $catalog = (array) get_theme_mod( 'catalog', array( 'heading' => 'House Catalog' ) );
    $catalog = array_filter( $catalog );
    $catalog = (object) $catalog;
    ?>
    <div class="container-fluid section section-catalog" id="section-catalog">
        <div class="container">
            <div class="row">
                <div class="col-md-12 heading">
                    <h2><?php echo $catalog->heading; ?></h2>
                    <hr>
                    <p><?php echo $catalog->tagline; ?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center catalog-groups">
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
                            echo '<a href="#" data-catalog="'. $value->slug . '" class="btn btn-default btn-lg2" data-catalog-id="'.$locationId.'">'.strtoupper($name).'</a>';
                        }
                    ?>
                    <div class="container-catalog">
                        <div class="series-house-item"></div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>