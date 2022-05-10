<?php
global $dp_options;
if (!$dp_options) $dp_options = get_design_plus_option();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="description" content="">
<meta charset="utf-8">
<link rel="shortcut icon" href="">
<link rel="apple-touch-icon" href="">
<?php wp_head(); ?>

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
<?php if ($dp_options['use_ogp']) {
	ogp();
} ?>

</head>

<body <?php body_class(); ?>>

<?php if(isset($_GET['memberpage']) && $_GET['memberpage'] === 'add_photo') { ?>
	<header class="p-b-10">
<?php } else { ?>
	<header class="pb-3">
<?php } ?>
		<nav class="navbar navbar-light bg-light fixed-top shadow">
			<!-- <div class="container d-flex justify-content-between"> -->
			<a href="<?php echo get_author_posts_url( get_current_user_id() ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/profile.jpg" alt="profile" class="rounded-circle" width="100" height="100"></a>
			<!-- <strong>UserName</strong> -->
			<a href="picture_mode.html"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/logo.png" alt="logo" width="100" height="100"></a>
			<!-- <strong>Muse</strong> -->
			<div>
				<img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/change.png" alt="change" data-toggle="modal" data-target="#exampleModal" width="100" height="100">
			</div>
			<!-- <strong data-toggle="modal" data-target="#exampleModal">TimeLine</strong> -->
			<!-- </div> -->
		</nav>
	</header>