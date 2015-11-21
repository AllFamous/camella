<form action="<?php echo esc_attr( home_url( '/search.php') ); ?>" method="get">
<input type="text" id="tags" name="s" placeholder="Search">
</form>

<hr />

<h4><i class="fa fa-facebook fa-fw"></i> Facebook Feed</h4>
<?php echo do_shortcode( '[custom-facebook-feed]' ); ?>

<hr />

<h4><i class="fa fa-twitter fa-fw"></i> Twitter Feed</a></h4>
<a class="twitter-timeline"  href="https://twitter.com/CamellaOfficial" data-widget-id="666529647891353600">Tweets by @CamellaOfficial</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>