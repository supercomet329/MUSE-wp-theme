<?php
global $dp_options;
if (!$dp_options) $dp_options = get_design_plus_option();
?>
<?php if (is_user_logged_in()) { ?>

	<footer>
		<nav class="navbar navbar-light bg-light fixed-bottom">
			<a href="/"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/home_blue_on.png" alt="home"></a>
			<a href="<?php echo esc_url(get_tcd_membership_memberpage_url('list_order')); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/search_blue.png" alt="search"></a>
			<a href="<?php echo esc_url(get_tcd_membership_memberpage_url('post_image')); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/post_blue.png" alt="post"></a>
			<div class="notifications">
				<a href="<?php echo esc_url(get_tcd_membership_memberpage_url('notification')); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/notification_blue.png" alt="notification"></a>
				<p class="unread-count rounded-circle"><?php echo count_notice(); ?></p>
			</div>
			<div class="messages">
				<a href="<?php echo esc_url(get_tcd_membership_memberpage_url('list_message')); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/message_blue.png" alt="message"></a>
				<p class="unread-count top-left rounded-circle"><?php echo get_tcd_membership_messages_unread_number(); ?></p>
			</div>
		</nav>
	</footer>
<?php } ?>
</body>

<!-- Optional JavaScript -->
<!-- Bootstrap JS -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/bootstrap.bundle.min.js"></script>

<script src="<?php echo get_template_directory_uri(); ?>/assets/js/bootstrap.bundle.min.js"></script>
<!-- MemberShip JS -->
<script src="<?php echo get_template_directory_uri(); ?>/js/membership.js"></script>
<!-- Javascript(js/muse.js)読み込み -->
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/muse.js"></script>
<!-- Javascript(js/validate.js)読み込み -->
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/validate.js"></script>
</html>