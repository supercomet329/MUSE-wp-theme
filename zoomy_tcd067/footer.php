<?php
global $dp_options;
if (!$dp_options) $dp_options = get_design_plus_option();
?>
<?php if ( is_user_logged_in() ) { ?>
<footer class="p-b-10">
	<div class="navbar  navbar-light bg-light shadow fixed-bottom">
		<a href="normal_mode.html"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/home.png" alt="home" width="100" height="100"></a>
		<!-- <strong>Home</strong> -->
		<a href="search.html"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/search.png" alt="search" width="100" height="100"></a>
		<!-- <strong>Search</strong> -->
		<a href="post.html"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/post.png" alt="post" width="100" height="100"></a>
		<!-- <strong>Post</strong> -->
		<a href="notification.html"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/notification.png" alt="notification" width="100" height="100"></a>
		<!-- <strong>Notification</strong> -->
		<a href="message.html"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/message.png" alt="message" width="100" height="100"></a>
		<!-- <strong>Message</strong> -->
	</div>
</footer>
<?php } ?>

</body>

</html>