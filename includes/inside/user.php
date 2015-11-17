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
            <a href="register" class="btn btn-primary">REGISTER</a> <a href="#" class="btn btn-primary" id="user-login">USER LOGIN</a>
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