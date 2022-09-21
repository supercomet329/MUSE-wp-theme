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
<!doctype html>

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
    <!-- Required meta tags -->
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta charset="utf-8">

    <?php if ($ogp_title !== FALSE && !empty($ogp_title)) { ?>
        <meta property="og:title" content="<?php echo esc_attr($ogp_title); ?>" />
    <?php }
    /** endif */ ?>

    <?php if ($ogp_image !== FALSE && !empty($ogp_image)) { ?>
        <meta property="og:image" content="<?php echo esc_url($ogp_image); ?>" />
    <?php }
    /** endif */ ?>

    <?php if ($ogp_url !== FALSE && !empty($ogp_url)) { ?>
        <meta property="og:url" content="<?php echo esc_attr($ogp_url); ?>" />
    <?php }
    /** endif */ ?>
    <meta name="twitter:card" content="summary_large_image" />
    <meta property="og:site_name" content="<?php echo esc_attr(bloginfo('name')); ?>" />

    <!-- Icon -->
    <?php
    wp_head();
    ?>

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

    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Round|Material+Icons+Sharp|Material+Icons+Two+Tone" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">

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
<html lang="ja">
<div class="wrap">

    <body <?php body_class(); ?>>
        <div class="orver-lay"></div>

        <header class="popular_artist">
            <nav class="navbar navbar-light bg-light">
                <div id="menu-container" class="d-block d-sm-none">
                    <div id="menu-wrapper">
                        <div id="hamburger-menu"><span></span><span></span><span></span></div>
                    </div>
                </div>
                <a href="<?php echo $url; ?>" class="d-none d-sm-block"><img src="<?php echo $profile_image; ?>" alt="profile" class="rounded-circle"></a>
                <a href="/"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/logo.png" alt="logo" class="logo-sp"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/logo-pc.png" alt="logo" class="logo-pc"></a>
                <div class="d-none d-sm-block"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/picture_blue.png" alt="change" data-toggle="modal" class="change-logo"></div>
                <a href="<?php echo $url; ?>" class="d-block d-sm-none"><img src="<?php echo $profile_image; ?>" alt="profile" class="rounded-circle"></a>
            </nav>
        </header>


        <div class="pc-left">
            <ul class="PC-menu">
                <li class="my-3"><a href="/" class="py-0 pl-4"><span class="material-icons-outlined">home</span><span>ホーム</span></a></li>
                <li class="toggle accordion-toggle side_mar my-3 "><a href="<?php echo esc_url(get_tcd_membership_memberpage_url('ranking')) ?>" class="py-0 pl-4"><span class="material-icons-outlined">star_border</span><span>ランキング</span></a></li>
                <li class="toggle accordion-toggle side_mar my-3"><a href="<?php echo $url; ?>" class="py-0 pl-4"><span class="material-icons-outlined">person_outline</span><span>プロフィール</span></a></li>
                <li class="toggle accordion-toggle side_mar my-3"><a href="#" class="py-0 pl-4"><span class="material-icons-outlined">color_lens</span><span>NFT売買</span></a></li>
                <li class="toggle accordion-toggle side_mar my-3"><a href="#" class="py-0 pl-4"><span class="material-icons-outlined">category</span><span>NFTコレクション</span></a></li>
                <li class="toggle accordion-toggle side_mar my-3"><a href="<?php echo esc_url(get_tcd_membership_memberpage_url('notification')); ?>" class="py-0 pl-4"><span class="material-icons-outlined">notifications</span><span>通知</span></a></li>
                <li class="toggle accordion-toggle side_mar my-3"><a href="<?php echo esc_url(get_tcd_membership_memberpage_url('list_message')); ?>" class="py-0 pl-4"><span class="material-icons-outlined">mail_outline</span><span>メッセージ</span></a></li>
                <li class="toggle accordion-toggle side_mar my-3"><a href="<?php echo esc_attr(get_tcd_membership_memberpage_url('list_received')); ?>" class="py-0 pl-4"><span class="material-icons-outlined">list_alt</span><span>受注リクエスト</span></a></li>
                <li class="toggle accordion-toggle side_mar my-3"><a href="/<?php echo $getParams; ?>" class="py-0 pl-4"><span class="material-icons-outlined">published_with_changes</span><span>表示変更</span></a></li>
                <li class="toggle accordion-toggle side_mar my-3"><a href="<?php echo esc_attr(get_tcd_membership_memberpage_url('post_image')); ?>" class="py-0 pl-4"><span class="material-icons-outlined">post_add</span><span>投稿</span></a></li>
                <li class="toggle accordion-toggle side_mar my-3"><a href="#" class="py-0 pl-4"><span class="material-icons-outlined">wallet</span><span>残高振込申請</span></a></li>
                <li class="toggle accordion-toggle side_mar my-3"><a href="#" class="py-0 pl-4"><span class="material-icons-outlined">integration_instructions</span><span>ガイドライン</span></a></li>
                <li class="toggle accordion-toggle side_mar my-3"><a href="#" class="py-0 pl-4"><span class="material-icons-outlined">local_atm</span><span>NFTについて</span></a></li>
                <li class="toggle accordion-toggle side_mar my-3"><a href="#" class="py-0 pl-4"><span class="material-icons-outlined">copyright</span><span>著作権について</span></a></li>
                <li class="toggle accordion-toggle side_mar my-3"><a href="<?php echo wp_logout_url(); ?>" class="py-0 pl-4"><span class="material-icons-outlined">logout</span><span>ログアウト</span></a></li>
                <div class="side_down">&nbsp;</div>
            </ul>
        </div>

        <sidebar class="d-block d-sm-none">
            <ul class="menu-list accordion">
                <li class="toggle accordion-toggle side_mar my-3"><a href="/" class="py-0 pl-4"><span class="material-icons-outlined">home</span><span>ホーム</span></a></li>
                <li class="toggle accordion-toggle side_mar my-3"><a href="<?php echo esc_url(get_tcd_membership_memberpage_url('ranking')) ?>" class="py-0 pl-4"><span class="material-icons-outlined">star_border</span><span>ランキング</span></a></li>
                <li class="toggle accordion-toggle side_mar my-3"><a href="<?php echo $url; ?>" class="py-0 pl-4"><span class="material-icons-outlined">person_outline</span><span>プロフィール</span></a></li>
                <li class="toggle accordion-toggle side_mar my-3"><a href="#" class="py-0 pl-4"><span class="material-icons-outlined">color_lens</span><span>NFT売買</span></a></li>
                <li class="toggle accordion-toggle side_mar my-3"><a href="#" class="py-0 pl-4"><span class="material-icons-outlined">category</span><span>NFTコレクション</span></a></li>
                <li class="toggle accordion-toggle side_mar my-3"><a href="<?php echo esc_url(get_tcd_membership_memberpage_url('notification')); ?>" class="py-0 pl-4"><span class="material-icons-outlined">notifications</span><span>通知</span></a></li>
                <li class="toggle accordion-toggle side_mar my-3"><a href="<?php echo esc_url(get_tcd_membership_memberpage_url('list_message')); ?>" class="py-0 pl-4"><span class="material-icons-outlined">mail_outline</span><span>メッセージ</span></a></li>
                <li class="toggle accordion-toggle side_mar my-3"><a href="<?php echo esc_attr(get_tcd_membership_memberpage_url('list_received')); ?>" class="py-0 pl-4"><span class="material-icons-outlined">list_alt</span><span>受注リクエスト</span></a></li>
                <li class="toggle accordion-toggle side_mar my-3"><a href="/<?php echo $getParams; ?>" class="py-0 pl-4"><span class="material-icons-outlined">published_with_changes</span><span>表示変更</span></a></li>
                <li class="toggle accordion-toggle side_mar my-3 more_menu">
                    <label for="menu_bar01"><span class="material-icons-outlined">more_horiz</span><span class="more_text">もっと見る</span></label>
                    <input type="checkbox" id="menu_bar01" />
                    <ul id="links01">
                        <li class="toggle accordion-toggle side_mar my-3"><a href="<?php echo esc_attr(get_tcd_membership_memberpage_url('post_image')); ?>" class="py-0 pl-4"><span class="material-icons-outlined">post_add</span><span>投稿</span></a></li>
                        <li class="toggle accordion-toggle side_mar my-3"><a href="#" class="py-0 pl-4"><span class="material-icons-outlined">wallet</span><span>残高振込申請</span></a></li>
                        <li class="toggle accordion-toggle side_mar my-3"><a href="#" class="py-0 pl-4"><span class="material-icons-outlined">integration_instructions</span><span>ガイドライン</span></a></li>
                        <li class="toggle accordion-toggle side_mar my-3"><a href="#" class="py-0 pl-4"><span class="material-icons-outlined">local_atm</span><span>NFTについて</span></a></li>
                        <li class="toggle accordion-toggle side_mar my-3"><a href="#" class="py-0 pl-4"><span class="material-icons-outlined">copyright</span><span>著作権について</span></a></li>
                        <li class="toggle accordion-toggle side_mar my-3"><a href="<?php echo wp_logout_url(); ?>" class="py-0 pl-4"><span class="material-icons-outlined">logout</span><span>ログアウト</span></a></li>
                    </ul>
                </li>
                <div class="side_down">&nbsp;</div>
            </ul>
        </sidebar>