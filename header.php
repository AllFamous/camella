<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/camella.png" />
    <script src='https://www.google.com/recaptcha/api.js'></script>
<script type="text/javascript">

  var gaq = gaq || [];
  _gaq.push(['_setAccount', 'UA-35496433-1']);
  _gaq.push(['_setDomainName', 'camella.com.ph']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? '/web/20150607165315/https://ssl' : '/web/20150607165315/http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>   
	<?php
        if (is_front_page()){
            echo '<title>Camella</title>';
        } else {
            $title = get_the_title();
            echo '<title>Camella - '.$title.'</title>';
        }
    ?>
    <?php wp_head(); ?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body id="top" <?php body_class(); ?> data-admin-url="<?php echo admin_url(); ?>" data-theme-url="<?php echo get_template_directory_uri(); ?>" data-page-url="http://<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?>">

    <!-- fixed back to top -->
    <?php
        // add inner class for exception
      //  $innerClass;
      //  if (is_home() || is_front_page()){
      //      $innerClass = '';
       // } else {
       //     $innerClass = ' inner';
      //  }
    ?>
    

    <!-- fixed homeowners -->
    <div href="#" class="fixed-homeowners">
        <div class="homeowners-container">
            <a href="#" class="user-login" id="user-login">I'm a Homeowner</a>
        </div>
    </div>

    <!-- fixed nav -->
    <div class="container-fluid fixed-nav transition">
        <div class="container">
            <?php
                $options = array(
                    'container'         => false,
                    'menu_class'        => 'nav navbar-nav',
                    'theme_location'    => 'primaryMenu',
                    'walker'            => new custom_walker_nav_menu()
                );
                wp_nav_menu($options);
            ?>
        </div>
    </div>