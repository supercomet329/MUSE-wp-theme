<?php
global $dp_options;
if (!$dp_options) $dp_options = get_design_plus_option();

$profileImageData = get_user_meta(get_current_user_id(), 'profile_image', true);
$profile_image = get_template_directory_uri() . '/assets/img/icon/non_profile_image.png';
if (!empty($profileImageData)) {
	$profile_image = $profileImageData;
}

$url = get_tcd_membership_memberpage_url('login');
if (get_current_user_id() > 0) {
	$url = get_author_posts_url(get_current_user_id());
}

?>

<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<!-- Required meta tags -->
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
	<meta charset="utf-8">
	<!-- Icon -->
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/assets/img/icon/logo.png">
	<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/assets/img/icon/logo.png">
	<!-- Main CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/assets/css/style.css">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/all.min.css">
	<?php wp_head(); ?>

	<?php
	$json = [];
	$json['ajax_url'] = home_url('/') . "wp-admin/admin-ajax.php";
	$json['ajax_error_message'] = '接続に失敗しました。';
	$json['login_url'] = home_url('/') . "member/login/";
	$json['registration_url'] = home_url('/') . "member/registration/";
	?>
	<script type='text/javascript' id='tcd-membership-js-extra'>
		/* <![CDATA[ */
		var TCD_MEMBERSHIP = <?php echo json_encode($json); ?>;
		/* ]]> */
	</script>
</head>

<body <?php body_class(); ?>>
	<header>
		<nav class="fixed-top navbar navbar-light bg-light">
			<?php
			$getParams = '?picuture_mode=normal';
			$viewMode  = '';
			if (isset($_GET['picuture_mode'])) {
				$viewMode = $_GET['picuture_mode'];
			} else {
				if (isset($_COOKIE['muse_picuture_mode'])) {
					$viewMode = $_COOKIE['muse_picuture_mode'];
				}
			}

			if ($viewMode === 'picture') {
				$getParams = '?picuture_mode=normal';
			} else {
				$getParams = '?picuture_mode=picture';
			}
			?>

			<a href="<a href=" <?php echo $url; ?>">
				<img src="<?php echo $profile_image; ?>" alt="profile" class="rounded-circle">
			</a>
			<a href="/">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/logo.png" alt="logo">
			</a>
			<div>
				<a href="/<?php echo $getParams; ?>">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/picture_blue.png" alt="change" data-toggle="modal" style="height: 30px; width: 30px;">
				</a>
			</div>
		</nav>
	</header>