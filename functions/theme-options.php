<?php
if( ! function_exists( 'camella_customize_scripts' ) ):
/**********
 * Add scripts and css
 *********************/
        
        function camella_customize_scripts(){
                wp_enqueue_script( 'media-js', get_template_directory_uri() . '/js/common/media.js' );
                wp_enqueue_style( 'admin-css', get_template_directory_uri() . '/css/admin-css.css' );
        }
        add_action( 'customize_controls_print_footer_scripts', 'camella_customize_scripts' );
endif;

 # Site Settings Panel
 $customizer->add_section( 'camella_settings', array(
        'title' => __('Camella Settings'),
        'description' => __('Custom settings for camella admins!')
 ));

# Social Links
 
 foreach(array(
        'facebook' => __('Facebook'),
        'twitter' => __('Twitter'),
        'google-plus' => __('Google+'),
        'pinterest' => __('Pinterest'),
        'envelope' => __('Email')
 ) as $social => $social_title ):
        $social_id = "camella_social_links[{$social}]";
        $customizer->add_setting( $social_id );
        $customizer->add_control( new WP_Customize_Control( $customizer, $social_id, array(
                'label' => $social == 'facebook' ? __('Social Links' ) : null,
                'description' => $social_title,
                'setting' => $social_id,
                'section' => 'camella_settings'
        )));
        
 endforeach;
 
 /***************
  * Custom Front Page
  *******************/
 $customizer->add_panel( 'camella_front', array(
        'title' => __('Home Page'),
        'description' => __('Front Page settings area.')
 ));
 # Fold 1: Video
 $customizer->add_section( 'camella_videos', array(
        'title' => __('FOLD 1: Video'),
        'panel' => 'camella_front'
 ));
 $customizer->add_setting( 'video_url', array(
        'default'=> get_template_directory_uri() . '/vid/video.mp4'
 ));
 $customizer->add_control(new WP_Customize_Control(
        $customizer,
        'video_url',
        array(
                'label' => __('Video URL'),
                'setting' => 'video_url',
                'section' => 'camella_videos',
                'description' => __('Enter the complete URL of the video to play.')
        )
 ));
 $customizer->add_setting( 'video_portrait', array(
        'default' => get_template_directory_uri() . '/img/common/video-frame.jpg'
 ));
 $customizer->add_control(new WP_Customize_Control(
        $customizer,
        'video_portrait',
        array(
               'label' => __('Portrait Image'),
               'setting' => 'video_portrait',
               'description' => __('Enter the complete URL of an image to use before the video is loaded.'),
               'section' => 'camella_videos'
        )
 ));
 
 # Fold 2: Carousel
 $customizer->add_section( 'camella_carousel1', array(
        'title' => __('FOLD 2: Image Carousel'),
        'panel' => 'camella_front'
 ));
 for($i=1; $i <=5; $i++):
        $carousel_id = "front_carousel[{$i}]";
        $customizer->add_setting( $carousel_id );
        $customizer->add_control(new WP_Customize_Control(
                $customizer,
                $carousel_id,
                array(
                        'label' => __('Carousel ') . $i,
                        'description' => __('Image'),
                        'setting'=> $carousel_id,
                        'section' => 'camella_carousel1',
                        'input_attrs' => array('data-width' => 258, 'data-fullsize' => 'medium', 'data-height' => 150, 'data-addimage' => 'image', 'data-title' => __('Insert Image'))
                )
        ));
 endfor;
 
 # FOLD 3: 5 Point Advantage
 $customizer->add_section( 'camella_advantage', array(
        'title' => __('FOLD 3: 5 Point Advantage'),
        'panel' => 'camella_front'
 ));
 $customizer->add_setting( 'five_point[heading]', array( 'default' => __('Camella 5 Point Advantage' ) ));
 $customizer->add_control(new WP_Customize_Control(
        $customizer,
        'five_point[heading]',
        array(
                'label' => __('Heading'),
                'setting' => 'five_point[heading]',
                'section' => 'camella_advantage'
        )
 ));
 $customizer->add_setting( 'five_point[tagline]');
 $customizer->add_control(new WP_Customize_Control(
        $customizer,
        'five_point[tagline]',
        array(
                'label' => __('Tagline'),
                'setting' => 'five_point[tagline]',
                'section' => 'camella_advantage',
                'type' => 'textarea'
        )
 ));
 
 foreach(array('dream', 'convenience', 'security', 'investments', 'affordability' ) as $point ){
        $point_id = "advantage[{$point}]";
        $customizer->add_setting( "{$point_id}[title]" );
        $customizer->add_control(new WP_Customize_Control(
                $customizer,
                "{$point_id}[title]",
                array(
                        'label' => strtoupper($point),
                        'description' => __('Title'),
                        'setting' => "{$point_id}[title]",
                        'section' => 'camella_advantage'
                )
        ));
        $customizer->add_setting( "{$point_id}[desc]" );
        $customizer->add_control(new WP_Customize_Control(
                $customizer,
                "{$point_id}[desc]",
                array(
                        'description' => __('Brief Description'),
                        'setting' => "{$point_id}[desc]",
                        'section' => 'camella_advantage',
                        'type' => 'textarea'
                )
        ));
        $customizer->add_setting( "{$point_id}[url]" );
        $customizer->add_control(new WP_Customize_Control(
                $customizer,
                "{$point_id}[url]",
                array(
                        'description' => __('Link URL'),
                        'setting' => "{$point_id}[url]",
                        'section' => 'camella_advantage'
                )
        ));
 }
 
 # FOLD 4: Master Planned
 $customizer->add_section( 'camella_plan', array(
        'title' => __('FOLD 4: Masterplanned'),
        'panel' => 'camella_front'
 ));
 $customizer->add_setting( 'masterplanned[heading]', array( 'default' => __('Masterplanned Cities' ) ));
 $customizer->add_control(new WP_Customize_Control(
        $customizer,
        'masterplanned[heading]',
        array(
                'label' => __('Heading'),
                'setting' => 'masterplanned[heading]',
                'section' => 'camella_plan'
        )
 ));
 $customizer->add_setting( 'masterplanned[tagline]');
 $customizer->add_control(new WP_Customize_Control(
        $customizer,
        'masterplanned[tagline]',
        array(
                'label' => __('Tagline'),
                'setting' => 'masterplanned[tagline]',
                'section' => 'camella_plan',
                'type' => 'textarea'
        )
 ));
 $customizer->add_setting( 'masterplanned[img]');
 $customizer->add_control(new WP_Customize_Control(
        $customizer,
        'masterplanned[img]',
        array(
                'label' => __('Image Photo'),
                'setting' => 'masterplanned[img]',
                'section' => 'camella_plan',
                'input_attrs' => array('data-addimage' => 'image', 'data-fullsize' => 'medium' )
        )
 ));
 $customizer->add_setting( 'masterplanned[desc]');
 $customizer->add_control(new WP_Customize_Control(
        $customizer,
        'masterplanned[desc]',
        array(
                'label' => __('Brief Description'),
                'setting' => 'masterplanned[desc]',
                'section' => 'camella_plan',
                'type' => 'textarea'
        )
 ));
 $customizer->add_setting( 'masterplanned[readmore]');
 $customizer->add_control(new WP_Customize_Control(
        $customizer,
        'masterplanned[readmore]',
        array(
                'label' => __('Readmore Link'),
                'setting' => 'masterplanned[readmore]',
                'section' => 'camella_plan'
        )
 ));
 
 # Fold 5 Properties
  $customizer->add_section( 'camella_props', array(
        'title' => __('FOLD 5: Our Properties'),
        'panel' => 'camella_front'
 ));
 $customizer->add_setting( 'properties[heading]', array( 'default' => __('Our Properties' ) ));
 $customizer->add_control(new WP_Customize_Control(
        $customizer,
        'properties[heading]',
        array(
                'label' => __('Heading'),
                'setting' => 'properties[heading]',
                'section' => 'camella_props'
        )
 ));
 $customizer->add_setting( 'properties[tagline]');
 $customizer->add_control(new WP_Customize_Control(
        $customizer,
        'properties[tagline]',
        array(
                'label' => __('Tagline'),
                'setting' => 'properties[tagline]',
                'section' => 'camella_props',
                'type' => 'textarea'
        )
 ));
 
 # Fold 6 Catalogs
  $customizer->add_section( 'camella_catalogs', array(
        'title' => __('FOLD 6: House Catalog'),
        'panel' => 'camella_front'
 ));
 $customizer->add_setting( 'catalog[heading]', array( 'default' => __('House Catalog' ) ));
 $customizer->add_control(new WP_Customize_Control(
        $customizer,
        'catalog[heading]',
        array(
                'label' => __('Heading'),
                'setting' => 'catalog[heading]',
                'section' => 'camella_catalogs'
        )
 ));
 $customizer->add_setting( 'catalog[tagline]');
 $customizer->add_control(new WP_Customize_Control(
        $customizer,
        'catalog[tagline]',
        array(
                'label' => __('Tagline'),
                'setting' => 'catalog[tagline]',
                'section' => 'camella_catalogs',
                'type' => 'textarea'
        )
 ));
 
 # Fold 7 Search Properties
  $customizer->add_section( 'camella_search', array(
        'title' => __('FOLD 7: Search Properties'),
        'panel' => 'camella_front'
 ));
 $customizer->add_setting( 'search[heading]', array( 'default' => __('Our Properties' ) ));
 $customizer->add_control(new WP_Customize_Control(
        $customizer,
        'search[heading]',
        array(
                'label' => __('Heading'),
                'setting' => 'search[heading]',
                'section' => 'camella_search'
        )
 ));
 $customizer->add_setting( 'search[tagline]');
 $customizer->add_control(new WP_Customize_Control(
        $customizer,
        'search[tagline]',
        array(
                'label' => __('Tagline'),
                'setting' => 'search[tagline]',
                'section' => 'camella_search',
                'type' => 'textarea'
        )
 ));
 $customizer->add_setting( 'search[admin][from]');
 $customizer->add_control(new WP_Customize_Control(
        $customizer,
        'search[admin][from]',
        array(
                'label' => __('Computation Notification'),
                'description' => __('ADMIN NOTIFICATION<br/>Set where to send notifcation email.<br><br />Mail From'),
                'setting' => 'search[admin][from]',
                'section' => 'camella_search'
        )
 ));
 $customizer->add_setting( 'search[admin][to]');
 $customizer->add_control(new WP_Customize_Control(
        $customizer,
        'search[admin][to]',
        array(
                'description' => __('Mail To'),
                'setting' => 'search[admin][to]',
                'section' => 'camella_search'
        )
 ));
 $customizer->add_setting( 'search[admin][subject]', array('default' => 'Contact Proposals') );
 $customizer->add_control(new WP_Customize_Control(
        $customizer, 
        'search[admin][subject]',
        array(
                'description' => __('Subject'),
                'setting' => 'search[admin][subject]',
                'section' => 'camella_search'
        )
 ));
 $customizer->add_setting( 'search[user][from]', array('default'=> 'Camella'));
 $customizer->add_control(new WP_Customize_Control(
        $customizer,
        'search[user][from]',
        array(
                'description' => __('USER NOTIFICATION<br><br />Mail From'),
                'setting' => 'search[user][from]',
                'section' => 'camella_search'
        )
 ));
 $customizer->add_setting( 'search[user][from_email]', array('default'=> 'marketing@camella.com.ph'));
 $customizer->add_control(new WP_Customize_Control(
        $customizer,
        'search[user][from_email]',
        array(
                'description' => __('From Email'),
                'setting' => 'search[user][from_email]',
                'section' => 'camella_search'
        )
 ));
 $customizer->add_setting( 'search[user][subject]', array('default' => 'Sample Computation') );
 $customizer->add_control(new WP_Customize_Control(
        $customizer, 
        'search[user][subject]',
        array(
                'description' => __('Subject'),
                'setting' => 'search[user][subject]',
                'section' => 'camella_search'
        )
 ));
 
 # Fold 8 Find an Agent
  $customizer->add_section( 'camella_agents', array(
        'title' => __('FOLD 8: Find an Agent'),
        'panel' => 'camella_front'
 ));
 $customizer->add_setting( 'agents[heading]', array( 'default' => __('Find an Agent' ) ));
 $customizer->add_control(new WP_Customize_Control(
        $customizer,
        'agents[heading]',
        array(
                'label' => __('Heading'),
                'setting' => 'search[heading]',
                'section' => 'camella_agents'
        )
 ));
 $customizer->add_setting( 'agents[tagline]');
 $customizer->add_control(new WP_Customize_Control(
        $customizer,
        'agents[tagline]',
        array(
                'label' => __('Tagline'),
                'setting' => 'agents[tagline]',
                'section' => 'camella_agents',
                'type' => 'textarea'
        )
 ));
 
 # Fold 9 International Sales
  $customizer->add_section( 'camella_sales', array(
        'title' => __('FOLD 9: International Sales'),
        'panel' => 'camella_front'
 ));
 $customizer->add_setting( 'sales[heading]', array( 'default' => __('International Sales' ) ));
 $customizer->add_control(new WP_Customize_Control(
        $customizer,
        'sales[heading]',
        array(
                'label' => __('Heading'),
                'setting' => 'sales[heading]',
                'section' => 'camella_sales'
        )
 ));
 $customizer->add_setting( 'sales[tagline]');
 $customizer->add_control(new WP_Customize_Control(
        $customizer,
        'sales[tagline]',
        array(
                'label' => __('Tagline'),
                'setting' => 'sales[tagline]',
                'section' => 'camella_sales',
                'type' => 'textarea'
        )
 ));
 
 # Fold 10 Guides
  $customizer->add_section( 'camella_guides', array(
        'title' => __('FOLD 10: HowTos'),
        'panel' => 'camella_front'
 ));
 $customizer->add_setting( 'guides[buying][title]', array('transport' => 'postMessage') );
 $customizer->add_control(new WP_Customize_Control(
        $customizer,
        'guides[buying][title]',
        array(
                'label' => __('Buying Guide'),
                'description' => __('Title'),
                'setting' => 'guides[buying][title]',
                'section' => 'camella_guides'
        )
 ));
 $customizer->add_setting( 'guides[buying][desc]', array('transport' => 'postMessage'));
 $customizer->add_control(new WP_Customize_Control(
        $customizer,
        'guides[buying][desc]',
        array(
                'description' => __('Description'),
                'setting' => 'guides[buying][desc]',
                'section' => 'camella_guides',
                'type' => 'textarea'
        )
 ));
 $customizer->add_setting( 'guides[buying][link]', array('transport' => 'postMessage'));
 $customizer->add_control(new WP_Customize_Control(
        $customizer,
        'guides[buying][link]',
        array(
                'description' => __('Link URL'),
                'setting' => 'guides[buying][link]',
                'section' => 'camella_guides',
        )
 ));
 $customizer->add_setting( 'guides[buying][featured]', array('transport' => 'postMessage'));
 $customizer->add_control(new WP_Customize_Control(
        $customizer,
        'guides[buying][featured]',
        array(
                'description' => __('Featured Image'),
                'setting' => 'guides[buying][featured]',
                'section' => 'camella_guides',
                'input_attrs' => array('data-addimage' => 'image', 'data-fullsize' => 'medium', 'data-width' => 256, 'data-height' => 150)
        )
 ));
 $customizer->add_setting( 'guides[selling][title]', array('transport' => 'postMessage'));
 $customizer->add_control(new WP_Customize_Control(
        $customizer,
        'guides[selling][title]',
        array(
                'label' => __('Selling Guide'),
                'description' => __('Title'),
                'setting' => 'guides[selling][title]',
                'section' => 'camella_guides'
        )
 ));
 $customizer->add_setting( 'guides[selling][desc]', array('transport' => 'postMessage'));
 $customizer->add_control(new WP_Customize_Control(
        $customizer,
        'guides[selling][desc]',
        array(
                'description' => __('Description'),
                'setting' => 'guides[selling][desc]',
                'section' => 'camella_guides',
                'type' => 'textarea'
        )
 ));
 $customizer->add_setting( 'guides[selling][link]', array('transport' => 'postMessage'));
 $customizer->add_control(new WP_Customize_Control(
        $customizer,
        'guides[selling][link]',
        array(
                'description' => __('Link URL'),
                'setting' => 'guides[selling][link]',
                'section' => 'camella_guides',
        )
 ));
 $customizer->add_setting( 'guides[selling][featured]', array('transport' => 'postMessage'));
 $customizer->add_control(new WP_Customize_Control(
        $customizer,
        'guides[selling][featured]',
        array(
                'description' => __('Featured Image'),
                'setting' => 'guides[selling][featured]',
                'section' => 'camella_guides',
                'input_attrs' => array('data-addimage' => 'image', 'data-fullsize' => 'medium', 'data-width' => 256, 'data-height' => 150)
        )
 ));

 # Fold 11 Testimonials
  $customizer->add_section( 'camella_testimony', array(
        'title' => __('FOLD 11: Testimonials'),
        'panel' => 'camella_front'
 ));
 $customizer->add_setting( 'testimony[heading]', array( 'default' => __('Testimonials' ) ));
 $customizer->add_control(new WP_Customize_Control(
        $customizer,
        'testimony[heading]',
        array(
                'label' => __('Heading'),
                'setting' => 'testimony[heading]',
                'section' => 'camella_testimony'
        )
 ));
 $customizer->add_setting( 'testimony[tagline]');
 $customizer->add_control(new WP_Customize_Control(
        $customizer,
        'testimony[tagline]',
        array(
                'label' => __('Tagline'),
                'setting' => 'testimony[tagline]',
                'section' => 'camella_testimony',
                'type' => 'textarea'
        )
 ));
 # Fold 12 News &  Articles
  $customizer->add_section( 'camella_news', array(
        'title' => __('FOLD 12: News & Articles'),
        'panel' => 'camella_front'
 ));
 $customizer->add_setting( 'news[heading]', array( 'default' => __('News & Articles' ) ));
 $customizer->add_control(new WP_Customize_Control(
        $customizer,
        'news[heading]',
        array(
                'label' => __('Heading'),
                'setting' => 'news[heading]',
                'section' => 'camella_news'
        )
 ));
 $customizer->add_setting( 'news[tagline]');
 $customizer->add_control(new WP_Customize_Control(
        $customizer,
        'news[tagline]',
        array(
                'label' => __('Tagline'),
                'setting' => 'news[tagline]',
                'section' => 'camella_news',
                'type' => 'textarea'
        )
 ));
 # Fold 13 Featured 
  $customizer->add_section( 'camella_vista', array(
        'title' => __('FOLD 13: Vista Homeowners'),
        'panel' => 'camella_front'
 ));
 $customizer->add_setting( 'vista[title]', array( 'default' => __('Vista Home' ) ));
 $customizer->add_control(new WP_Customize_Control(
        $customizer,
        'vista[title]',
        array(
                'label' => __('Title'),
                'setting' => 'vista[title]',
                'section' => 'camella_vista'
        )
 ));
 $customizer->add_setting( 'vista[desc]');
 $customizer->add_control(new WP_Customize_Control(
        $customizer,
        'vista[desc]',
        array(
                'label' => __('Brief Description'),
                'setting' => 'vista[desc]',
                'section' => 'camella_vista',
                'type' => 'textarea'
        )
 ));
 $customizer->add_setting( 'vista[link]');
 $customizer->add_control(new WP_Customize_Control(
        $customizer,
        'vista[link]',
        array(
                'label' => __('Link To'),
                'setting' => 'vista[link]',
                'section' => 'camella_vista'
        )
 ));
 $customizer->add_setting( 'vista[featured]');
 $customizer->add_control(new WP_Customize_Control(
        $customizer,
        'vista[featured]',
        array(
                'label' => __('Featured Image'),
                'setting' => 'vista[featured]',
                'section' => 'camella_vista',
                'input_attrs' => array('data-addimage' => 'image', 'data-fullsize' => 'medium', 'data-width' => 256)
        )
 ));
 
 # Fold 14 Masterplanned Developments
  $customizer->add_section( 'camella_devs', array(
        'title' => __('FOLD 14: Masterplanned City Developments'),
        'panel' => 'camella_front'
 ));
 $customizer->add_setting( 'devs[heading]', array( 'default' => __('Masterplanned City Developments' ) ));
 $customizer->add_control(new WP_Customize_Control(
        $customizer,
        'devs[heading]',
        array(
                'label' => __('Heading'),
                'setting' => 'devs[heading]',
                'section' => 'camella_devs'
        )
 ));
 $customizer->add_setting( 'devs[tagline]');
 $customizer->add_control(new WP_Customize_Control(
        $customizer,
        'devs[tagline]',
        array(
                'label' => __('Tagline'),
                'setting' => 'devs[tagline]',
                'section' => 'camella_devs',
                'type' => 'textarea'
        )
 ));


