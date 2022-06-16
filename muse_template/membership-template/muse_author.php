<?php
global $dp_options;
if (!$dp_options) $dp_options = get_design_plus_option();

$user_id = $tcd_membership_vars['user_id'];
$user = get_userdata($user_id);

$profileImageData = get_user_meta($user_id, 'profile_image', true);
$profile_image = get_template_directory_uri() . '/assets/img/icon/non_profile_image.png';
if (!empty($profileImageData)) {
	$profile_image = $profileImageData;
}

$headerImageData = get_user_meta($user_id, 'header_image', true);
$header_image = get_template_directory_uri() . '/assets/img/add_image360-250.png';
if (!empty($headerImageData)) {
	$header_image = $headerImageData;
}

$last_name = '';
$lastNameData = get_user_meta($user_id, 'last_name', true);
if (!empty($lastNameData)) {
	$last_name = $lastNameData;
}

$description = '';
$descriptionData = get_user_meta($user_id, 'description', true);
if (!empty($lastNameData)) {
	$description = $descriptionData;
}

$area = '';
$areaData = get_user_meta($user_id, 'area', true);
if (!empty($areaData)) {
	$area = $areaData;
}

$birthday = '';
$birthdayData = get_user_meta($user_id, 'birthday', true);
if (!empty($birthdayData)) {
	$birthday = $birthdayData;
}

$arrayCount = get_author_list_totals($user_id);

// 発注の一覧を取得
$listPost = muse_list_post($user_id);

// テンプレート指定
$chunk_list_post = array_chunk($listPost, 3);
$list_post = $chunk_list_post;

$listLike  = muse_list_like($user->ID);
$chunk_list_like = array_chunk($listLike, 3);
$list_like = $chunk_list_like;

get_header();
?>
<div class="cover-area">
	<img src="<?php echo esc_attr($header_image); ?>" class="img-fluid cover-image" id="cover_image">
</div>
<div class="container profile-area">
	<div class="icon">
		<img src="<?php echo esc_attr($profile_image); ?>" class="ml-1 rounded-circle profile_icon" id="profile_icon">
		<?php if ((int)$user_id === get_current_user_id()) { ?>
			<a href="<?php echo esc_url(get_tcd_membership_memberpage_url('request')); ?>"><button class="btn rounded-pill btn-outline-primary outline-btn btn-sm request-btn">　作品依頼　</button></a>
			<a href="<?php echo esc_url(get_tcd_membership_memberpage_url('edit_profile')); ?>"><button class="btn rounded-pill btn-outline-primary outline-btn btn-sm edit-btn">　編集　</button></a>
		<?php }
		/** endif */ ?>
	</div>
	<div class="mt-2 ml-2 row">
		<div class="col-5 font-weight-bold">
			<?php echo esc_attr($last_name); ?>
			<br>
			<span class="screen_id">
				<?php echo esc_attr($user->data->display_name); ?>
			</span>
		</div>
		<div class="col-7 text-center">
			<?php if ((int)$user_id === get_current_user_id()) { ?>
				<a href="<?php echo esc_url(get_tcd_membership_memberpage_url('follows')); ?>">
				<?php }
			/** endif */ ?>
				<span class="follow">フォロー<br>
					<span>
						<?php echo number_format($arrayCount['following']['total']); ?>
					</span>
				</span>
				<?php if ((int)$user_id === get_current_user_id()) { ?>
				</a>
			<?php }
				/** endif */ ?>
			<?php if ((int)$user_id === get_current_user_id()) { ?>
				<a href="<?php echo esc_url(get_tcd_membership_memberpage_url('followers')); ?>">
				<?php }
			/** endif */ ?>

				<span class="follower">
					フォロワー<br>
					<span><?php echo number_format($arrayCount['follower']['total']); ?></span>
				</span>
				<?php if ((int)$user_id === get_current_user_id()) { ?>

				</a>
			<?php }
				/** endif */ ?>

		</div>
		<?php if ((int)$user_id !== get_current_user_id()) { ?>
			<div class="col-7"></div>
			<div class="col-5 d-block btn-area text-right pl-0 my-auto">
				<?php if (is_following($user_id)) { ?>
					<a href="#" id="follow_button" data-user-id="<?php echo esc_attr($user_id); ?>" class="js-toggle-follow btn btn-primary rounded-pill btn-sm text-white btn-lg main-color">フォロー中</a>
				<?php } else { ?>
					<a href="#" id="follow_button" data-user-id="<?php echo esc_attr($user_id); ?>" class="js-toggle-follow btn rounded-pill btn-outline-primary outline-btn btn-sm">フォローする</a>
				<?php }
				/** endif */ ?>
			</div>
		<?php }
		/** endif */ ?>

		<div class="mt-3 col-12">
			<?php echo nl2br(esc_attr($description)); ?>
		</div>
		<div class="col-6 my-3">
			<?php echo esc_attr($area); ?>
		</div>
		<div class="col-6 my-3 text-right">
			<?php if (!empty($user->data->user_url)) { ?>
				<a href="<?php echo esc_attr($user->data->user_url); ?>" target="_blank">
					<?php echo esc_attr($user->data->user_url); ?>
				</a>
			<?php }
			/** endif */ ?>
		</div>
	</div>
	<div class="favorite-area my-2 py-1">
		<div class="row d-flex justify-content-around">
			<img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/profile_mypost.png" id="mypost_icon" alt="profile_mypost" class="selected-icon">
			<img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/profile_favorite.png" id="favorite_icon" alt="profile_favorite">
		</div>
	</div>
</div>
<!-- 投稿した画像 -->
<div class="py-1" id="mypost_list">
	<?php foreach ($list_post as $array_post) { ?>
		<div class="content">
			<?php foreach ($array_post as $onePost) { ?>
				<div class="content-item shadow d-flex align-items-center justify-content-center px-1">
					<img class="image-list" src="<?php echo $onePost->main_image; ?>">
				</div>
			<?php }
			/** endforeach */ ?>

		</div>
	<?php }
	/** endforeach */ ?>
</div>

<!-- いいねした画像一覧 -->
<div class="d-none py-1" id="favorite_list">
	<?php foreach ($list_like as $array_like) { ?>
		<div class="content">
			<?php foreach ($array_like as $one_like) { ?>
				<div class="content-item shadow d-flex align-items-center justify-content-center px-1">
					<img class="image-list" src="<?php echo $one_like->meta_value; ?>">
				</div>
			<?php }
			/** endforeach */ ?>
		</div>
	<?php }
	/** endforeach */ ?>
</div>

<!-- 画像を拡大するモーダル -->
<div class="modal">
	<div class="bigimg"><img src="" alt="bigimg"></div>
	<p class="close-btn"><a href="">✖</a></p>
</div>
<script>
	jQuery(function($) {
		jQuery('#mypost_icon').click(function() {
			jQuery('#mypost_icon').addClass('selected-icon');
			jQuery('#favorite_icon').removeClass('selected-icon');
			jQuery('#favorite_list').addClass('d-none');
			jQuery('#mypost_list').removeClass('d-none');
		});

		jQuery('#favorite_icon').click(function() {
			jQuery('#favorite_icon').addClass('selected-icon');
			jQuery('#mypost_icon').removeClass('selected-icon');
			jQuery('#mypost_list').addClass('d-none', 'selected-icon');
			jQuery('#favorite_list').removeClass('d-none', 'selected-icon');
		});

		jQuery('#cover_image').click(function() {
			magnifyImg($(this).attr('src'));
		});

		jQuery('#profile_icon').click(function() {
			magnifyImg($(this).attr('src'));
		});

		jQuery('.close-btn').click(function() {
			jQuery('.modal').fadeOut();
			jQuery('body,html').css('overflow-y', 'visible');
			return false
		});
	});

	// 拡大した画像を表示
	function magnifyImg(imgSrc) {
		jQuery('.bigimg').children().attr('src', imgSrc).css({
			'width': '100vh',
			'height': '60vh',
			'object-fit': 'cover'
		});
		jQuery('.modal').fadeIn();
		jQuery('body,html').css('overflow-y', 'hidden');
		return false
	};
</script>
<?php
get_footer();
