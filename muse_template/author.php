<?php
global $dp_options;
if (!$dp_options) $dp_options = get_design_plus_option();

$user_id = get_current_user_id();
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
$listPost = muse_list_post();

// テンプレート指定
$tcd_membership_vars['template']  = 'muse_list_post';
$chunk_list_post = array_chunk($listPost, 3);
$list_post = $chunk_list_post;

$listLike  = muse_list_like($user->ID);
$chunk_list_like = array_chunk($listLike, 3);
$list_like = $chunk_list_like;

get_header();
?>
<div class="container pt-2">
    <div class="row mb-2">
        <div class="col-12">
            <a href="javascript:history.back();">← 戻る</a>
        </div>
    </div>
</div>

<div class="cover-area">
    <img src="<?php echo esc_attr($header_image); ?>" class="img-fluid cover-image" id="cover_image">
</div>
<div class="container profile-area">
    <div class="row icon">
        <img src="<?php echo esc_attr($profile_image); ?>" class="ml-1 rounded-circle profile_icon" id="profile_icon">
    </div>
    <div class="row mt-2">
        <div class="col-12 text-right profile-btn">
            <!-- 自分が見た場合 -->
            <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('in_progress')); ?>"><button class="px-0 btn rounded-pill btn-outline-primary outline-btn btn-sm">　進行中　</button></a>
            <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('request')); ?>"><button class="px-0 mx-1 btn rounded-pill btn-outline-primary outline-btn btn-sm request-btn">　作品依頼　</button></a>
            <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('edit_profile')); ?>"><button class="px-0 btn rounded-pill btn-outline-primary outline-btn btn-sm edit-btn">　編集　</button></a>
            <!-- 自分以外が見た場合 -->
            <!-- button type="button" class="btn btn-primary rounded-pill btn-sm text-white btn-lg main-color follow-btn follow-on">フォロー中</button>
            <a href="request.html"><button class="px-0 mx-1 btn rounded-pill btn-outline-primary outline-btn btn-sm request-btn">　依頼　</button></a -->
        </div>
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
            <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('follows')); ?>"><span class="follow">フォロー<br>
                    <span><?php echo number_format($arrayCount['following']['total']); ?></span></span></a>
            <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('followers')); ?>"><span class="follower">フォロワー<br>
                    <span><?php echo number_format($arrayCount['follower']['total']); ?></span></span></a>
        </div>
        <!-- 自分が見た場合のみ表示 -->
        <div class="col-5"></div>
        <div class="col-7 profile-money">
            <div class="row">
                <div class="col-6 float-right font-weight-bold text-left">
                    <p class="mb-0 text-nowrap">売上預金</p>
                </div>
                <div class="col-6 float-right font-weight-bold text-right">
                    <p class="mb-0 text-nowrap">￥1,000,000-</p>
                </div>
            </div>
            <div class="row">
                <div class="col-6 float-right font-weight-bold text-left">
                    <p class="mb-0 text-nowrap">NFT時価総額</p>
                </div>
                <div class="col-6 float-right font-weight-bold text-right">
                    <p class="mb-0 text-nowrap">￥2,000,000-</p>
                </div>
            </div>
        </div>
        <!-- 自分が見た場合のみ表示 -->

        <!-- <div class="col-5 d-block btn-area text-right pl-0 my-auto">
           <button type="button" class="btn btn-primary rounded-pill btn-sm text-white btn-lg main-color follow-btn follow-on">フォロー中</button>
      </div> -->
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
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/iine.png" id="favorite_icon" alt="profile_favorite">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/favorite.png" id="purcher_icon" alt="profile_purcher">
            <p id="have_nft_icon" class="mb-0 pt-1 font-weight-bold">NFT</p>
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

<!-- 購入保管した画像一覧 -->
<div class="d-none py-1" id="purcher_list">
    <?php /** TODO: NFTが決まったら対応 */ ?>
</div>
<!-- 所有NFT一覧 -->
<div class="d-none py-1" id="have_nft_list">
    <?php /** TODO: NFTが決まったら対応 */ ?>
</div>

<!-- 画像を拡大するモーダル -->
<div class="modal">
    <div class="bigimg"><img src="" alt="bigimg"></div>
    <p class="close-btn"><a href="">✖</a></p>
</div>
<script>
    jQuery(function() {
        jQuery('#mypost_icon').click(function() {
            jQuery('#mypost_icon').addClass('selected-icon');
            jQuery('#favorite_icon').removeClass('selected-icon');
            jQuery('#purcher_icon').removeClass('selected-icon');
            jQuery('#have_nft_icon').removeClass('selected-icon');
            jQuery('#favorite_list').addClass('d-none');
            jQuery('#purcher_list').addClass('d-none');
            jQuery('#have_nft_list').addClass('d-none');
            jQuery('#mypost_list').removeClass('d-none');
        });
        jQuery('#favorite_icon').click(function() {
            jQuery('#favorite_icon').addClass('selected-icon');
            jQuery('#purcher_icon').removeClass('selected-icon');
            jQuery('#have_nft_icon').removeClass('selected-icon');
            jQuery('#mypost_icon').removeClass('selected-icon');
            jQuery('#mypost_list').addClass('d-none', 'selected-icon');
            jQuery('#purcher_list').addClass('d-none', 'selected-icon');
            jQuery('#have_nft_list').addClass('d-none', 'selected-icon');
            jQuery('#favorite_list').removeClass('d-none', 'selected-icon');
        });

        jQuery('#purcher_icon').click(function() {
            jQuery('#purcher_icon').addClass('selected-icon');
            jQuery('#favorite_icon').removeClass('selected-icon');
            jQuery('#have_nft_icon').removeClass('selected-icon');
            jQuery('#mypost_icon').removeClass('selected-icon');
            jQuery('#mypost_list').addClass('d-none', 'selected-icon');
            jQuery('#favorite_list').addClass('d-none', 'selected-icon');
            jQuery('#have_nft_list').addClass('d-none', 'selected-icon');
            jQuery('#purcher_list').removeClass('d-none', 'selected-icon');
        });
        jQuery('#have_nft_icon').click(function() {
            jQuery('#have_nft_icon').addClass('selected-icon');
            jQuery('#favorite_icon').removeClass('selected-icon');
            jQuery('#purcher_icon').removeClass('selected-icon');
            jQuery('#mypost_icon').removeClass('selected-icon');
            jQuery('#mypost_list').addClass('d-none', 'selected-icon');
            jQuery('#favorite_list').addClass('d-none', 'selected-icon');
            jQuery('#purcher_list').addClass('d-none', 'selected-icon');
            jQuery('#have_nft_list').removeClass('d-none', 'selected-icon');
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
