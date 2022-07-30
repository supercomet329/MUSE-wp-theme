<?php
global $dp_options;
if (!$dp_options) $dp_options = get_design_plus_option();

$profileImageData = get_user_meta(get_current_user_id(), 'profile_image', true);
$profile_image = get_template_directory_uri() . '/assets/img/icon/non_profile_image.png';
if (!empty($profileImageData)) {
    $profile_image = $profileImageData;
}

count_non_read_thread();
$url = get_tcd_membership_memberpage_url('login');
if (get_current_user_id() > 0) {
    $url = get_author_posts_url(get_current_user_id());
}


$ogp_title     = false;
$ogp_url       = false;
$ogp_image     = false;
$ogp_site_name = false;
if (isset($_GET['memberpage']) && isset($_GET['post_id']) && $_GET['memberpage'] === 'post_comment') {
    $post_id = $_GET['post_id'];
    $post = get_post($post_id);
    $ogp_title     = $post->post_title;
    $ogp_url       = home_url() . '?memberpage=post_comment&post_id=' . $post_id;
    $ogp_image     = get_post_meta($post_id, 'main_image', true);
}

if (isset($_GET['memberpage']) && isset($_GET['request_id']) && $_GET['memberpage'] === 'confirm_request') {
    $post_id = $_GET['request_id'];
    $post = get_post($post_id);
    $ogp_title     = $post->post_title;
    $ogp_url       = home_url() . '?memberpage=confirm_request&request_id=' . $post_id;
    $ogp_image     = get_post_meta($post_id, 'main_image', true);
}
?>
<!doctype html>
<html lang="ja">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
    <!-- Required meta tags -->
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta charset="utf-8">

    <?php if ($ogp_title !== FALSE && ! empty($ogp_title)) { ?>
        <meta property="og:title" content="<?php echo esc_attr($ogp_title); ?>" />
    <?php }
    /** endif */ ?>

    <?php if ($ogp_image !== FALSE && ! empty($ogp_image)) { ?>
        <meta property="og:image" content="<?php echo esc_url($ogp_image); ?>" />
    <?php }
    /** endif */ ?>

    <?php if ($ogp_url !== FALSE && ! empty($ogp_url)) { ?>
        <meta property="og:url" content="<?php echo esc_attr($ogp_url); ?>" />
    <?php }
    /** endif */ ?>
    <meta name="twitter:card" content="summary_large_image" />
    <meta property="og:site_name" content="<?php echo esc_attr(bloginfo('name')); ?>" />

    <!-- Icon -->
    <?php wp_head(); ?>

    <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/assets/img/icon/logo.png">
    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/assets/img/icon/logo.png">
    <!-- Main CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/assets/css/style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/all.min.css">
    <!-- cropper.css -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/cropper.min.css">

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
    <div class="orver-lay"></div>
    <header>
        <nav class="navbar navbar-light bg-light">
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
            <div id="menu-container" class="d-block d-sm-none">
                <div id="menu-wrapper">
                    <div id="hamburger-menu"><span></span><span></span><span></span></div>
                </div>
            </div>
            <a href="<?php echo $url; ?>" class="d-none d-sm-block"><img src="<?php echo $profile_image; ?>" alt="profile" class="rounded-circle"></a>
            <a href="/"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/logo.png" alt="logo"></a>
            <div class="d-none d-sm-block">
                <a href="/<?php echo $getParams; ?>">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/picture_blue.png" alt="change" data-toggle="modal" class="change-logo">
                </a>
            </div>
            <a href="<?php echo $url; ?>" class="d-block d-sm-none"><img src="<?php echo $profile_image; ?>" alt="profile" class="rounded-circle"></a>
        </nav>
    </header>

    <sidebar class="d-block d-sm-none">
        <ul class="menu-list accordion">
            <li class="toggle accordion-toggle side_mar my-3"><a href="#" class="py-0 pl-4"><span>項目1</span></a></li>
            <li class="toggle accordion-toggle side_mar my-3"><a href="#" class="py-0 pl-4"><span>項目2</span></a></li>
            <li class="toggle accordion-toggle side_mar my-3"><a href="#" class="py-0 pl-4"><span>項目3</span></a></li>
            <li class="toggle accordion-toggle side_mar my-3"><a href="#" class="py-0 pl-4"><span>項目4</span></a></li>
            <li class="toggle accordion-toggle side_mar my-3"><a href="#" class="py-0 pl-4"><span>項目5</span></a></li>
            <li class="toggle accordion-toggle side_mar my-3"><a href="#" class="py-0 pl-4"><span>項目6</span></a></li>
            <li class="toggle accordion-toggle side_mar my-3"><a href="#" class="py-0 pl-4"><span>項目7</span></a></li>
            <li class="toggle accordion-toggle side_mar my-3"><a href="#" class="py-0 pl-4"><span>項目8</span></a></li>
            <li class="toggle accordion-toggle side_mar my-3"><a href="#" class="py-0 pl-4"><span>項目9</span></a></li>
            <li class="toggle accordion-toggle side_mar my-3"><a href="#" class="py-0 pl-4"><span>項目10</span></a></li>
            <div class="side_down">&nbsp;</div>
        </ul>
    </sidebar>