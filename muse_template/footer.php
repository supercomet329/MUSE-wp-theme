<?php
global $dp_options;
if (!$dp_options) $dp_options = get_design_plus_option();
?>
<?php if (is_user_logged_in()) { ?>
	<footer>
		<nav class="navbar navbar-light bg-light fixed-bottom">
			<a href="/"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/home_blue_on.png" alt="home"></a>
			<a href="<?php echo esc_url(get_tcd_membership_memberpage_url('post_search')); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/search_blue.png" alt="search"></a>
			<a href="<?php echo esc_url(get_tcd_membership_memberpage_url('post_image')); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/post_blue.png" alt="post"></a>
			<div class="notifications">
				<a href="<?php echo esc_url(get_tcd_membership_memberpage_url('notification')); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/notification_blue.png" alt="notification"></a>
				<?php if (count_notice() > 0) { ?>
					<p class="unread-count rounded-circle"><?php echo count_notice(); ?></p>
				<?php } ?>
			</div>
			<div class="messages">
				<a href="<?php echo esc_url(get_tcd_membership_memberpage_url('list_message')); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/message_blue.png" alt="message"></a>
				<?php if (count_non_read_thread() > 0) { ?>
					<p class="unread-count top-left rounded-circle"><?php echo count_non_read_thread(); ?></p>
				<?php } ?>
			</div>
		</nav>
	</footer>
<?php } ?>
</body>
<?php if (is_user_logged_in()) { ?>
	<footer>
		<nav class="navbar navbar-light bg-light fixed-bottom">
			<a href="/"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/home_blue_on.png" alt="home"></a>
			<a href="<?php echo esc_url(get_tcd_membership_memberpage_url('post_search')); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/search_blue.png" alt="search"></a>
			<a href="<?php echo esc_url(get_tcd_membership_memberpage_url('post_image')); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/post_blue.png" alt="post"></a>
			<div class="notifications">
				<a href="<?php echo esc_url(get_tcd_membership_memberpage_url('notification')); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/notification_blue.png" alt="notification"></a>
				<?php if (count_notice() > 0) { ?>
					<p class="unread-count rounded-circle"><?php echo count_notice(); ?></p>
				<?php } ?>
			</div>
			<div class="messages">
				<a href="<?php echo esc_url(get_tcd_membership_memberpage_url('list_message')); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/message_blue.png" alt="message"></a>
				<?php if (count_non_read_thread() > 0) { ?>
					<p class="unread-count top-left rounded-circle"><?php echo count_non_read_thread(); ?></p>
				<?php } ?>
			</div>
		</nav>
	</footer>
<?php } ?>
</div>
<div class="PC-right">
	<div class="search_main">
		<div class="search_box">
			<form action="<?php echo get_tcd_membership_memberpage_url('post_search'); ?>" method="POST">
				<input name="search" type="text" placeholder="キーワード検索">
				<input type="hidden" name="f" value="A" />
			</form>
		</div>
	</div>

	<div class="trande-art-area">
		<span class="trande-art-area-title">トレンドアート</span>
		<?php /**
		 // TODO: トレンドアートの取得ルールが決まったら対応
		<div class="trande-art-area-in">
			<ul class="tweet-area">
				<li class="d-flex align-items-start">
					<a href="./profile.html">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_64747350_M.jpg" class="rounded-circle profile-icon-trande">
					</a>
					<div class="text-area-trande">
						<a href="./profile.html">
							<span>投稿者名</span><br>
						</a>
					</div>
				</li>
			</ul>
			<a href="post_img_comment.html"><img class="img-fluid mx-auto" src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_85053177_M.jpg" /></a>
			<div class="trande-art-area-price">￥00,000</div>
		</div>

		<div class="trande-art-area-in">
			<ul class="tweet-area">
				<li class="d-flex align-items-start">
					<a href="./profile.html">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_64747350_M.jpg" class="rounded-circle profile-icon-trande">
					</a>
					<div class="text-area-trande">
						<a href="./profile.html">
							<span>投稿者名</span><br>
						</a>
					</div>
				</li>
			</ul>
			<a href="post_img_comment.html"><img class="img-fluid mx-auto" src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_85053177_M.jpg" /></a>
			<div class="trande-art-area-price">￥00,000</div>
		</div>
		*/ ?>
	</div>
</div>
</div>
</body>
<!-- Optional JavaScript -->
<!-- Bootstrap JS -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/bootstrap.bundle.min.js"></script>
<!-- MemberShip JS -->
<script src="<?php echo get_template_directory_uri(); ?>/js/membership.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/muse.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/validate.js"></script>

</html>