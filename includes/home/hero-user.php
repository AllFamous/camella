<?php
	if (is_user_logged_in()) {
		$current_user = wp_get_current_user();
		$logoutUrl = 'http://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
?>
<div class="fixed-login col-md-4"><div class="container">	
<div class="col-md-8 form-control_box">
<form action="<?php echo esc_attr( home_url( '/search.php') ); ?>" method="get">
<input type="text" id="tags" name="s" class="form-control" placeholder="Search">
</form>
</div>
<p>Welcome <?php echo $current_user->user_firstname; ?>!&nbsp;&nbsp;<a href="<?php echo wp_logout_url($logoutUrl); ?>"><strong>LOGOUT</strong></a></p>
</div></div>
			
		<?php
	} else {
		?>
        <div class="fixed-login"><div class="container">
                <?php if( is_home() || is_front_page() ):
                /*** Only show the social media buttons at homepage **/
                ?>
                <div class="social-buttons small social-home">
                    <ul class="no-bullets inline">
                        <?php
                        $social_links = get_theme_mod( 'camella_social_links' );
                        $social_links =  wp_parse_args( (array) $social_links, array(
                                'facebook' => '#',
                                'twitter' => '#',
                                'google-plus' => '#',
                                'pinterest' => '#',
                                'envelope' => '#'
                        ));
                        $social_links = array_filter( $social_links );
                        
                        foreach( $social_links as $social => $link_url ):
                                $link_url = $social == 'envelope' ? "mailto:{$link_url}" : $link_url;
                                $initial = substr($social, 0, 2);
                                
                                if( $social == 'facebook' ) $initial = 'fb';
                                elseif( $social == 'google-plus' ) $initial = 'gp';
                        ?>
                        <li class="text-center">
                                <a href="<?php echo esc_url( $link_url ); ?>" rel="nofollow" class="<?php echo $initial; ?>">
                                        <i class="fa fa-<?php echo $social; ?>"></i>
                                </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
            <a href="<?php echo esc_url( home_url( '/register' ) ); ?>" class="btn btn-primary">REGISTER</a> <a href="#" class="btn btn-primary user-login" id="user-login">USER LOGIN</a>
            <div class="panel panel-primary panel-login">
                <div class="panel-body">
                	<div class="login-notice"></div>
                    <h3><i class="fa fa-user"></i> User Login</h3>
                    <div class="form-group">
                        <label for="loginUsername">Username</label>
                        <input type="text" class="form-control" id="loginUsername" placeholder="username">
                    </div>
                    <div class="form-group">
                        <label for="loginUserPassword">Password</label>
                        <input type="password" class="form-control" id="loginUserPassword" placeholder="password">
                    </div>
                </div>
                <div class="panel-footer">
                    <a href="#" class="btn btn-primary" id="login-cancel">CANCEL</a> <a href="#" class="btn btn-primary" id="user-login-btn">LOGIN</a>
                </div>
            </div>
        </div></div>
		<?php
	}
?>