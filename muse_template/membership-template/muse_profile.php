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

$active_flag = false;
$active = get_user_meta($user_id, 'request_box', true);
if (!empty($active)) {
    $active_flag = $active;
}
$arrayCount = get_author_list_totals($user_id);

$listPost = muse_list_post($user_id);
$chunk_list_post = array_chunk($listPost, 3);
$list_post = $chunk_list_post;

$listLike  = muse_list_like($user_id);
$chunk_list_like = array_chunk($listLike, 3);
$list_like = $chunk_list_like;

$listFavorite = muse_list_favorite($user_id);
$chunk_list_favorite = array_chunk($listFavorite, 3);
$list_favorite = $chunk_list_favorite;
get_header();
?>
<div class="pc-center">

    <div class="cover-area">
        <?php if (get_current_user_id() == $user_id) { ?>
            <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('edit_profile')); ?>">
                <img src="<?php echo esc_attr($header_image); ?>" class="img-fluid cover-image" id="cover_image">
            </a>
        <?php } else { ?>
            <img src="<?php echo esc_attr($header_image); ?>" class="img-fluid cover-image" id="cover_image">
        <?php } ?>
    </div>
    <div class="container profile-area">
        <div class="row icon">
            <?php if (get_current_user_id() == $user_id) { ?>
                <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('edit_profile')); ?>">
                    <img src="<?php echo esc_attr($profile_image); ?>" class="ml-1 rounded-circle profile_icon" id="profile_icon">
                </a>
            <?php } else { ?>
                <img src="<?php echo esc_attr($profile_image); ?>" class="ml-1 rounded-circle profile_icon" id="profile_icon">
            <?php } ?>
        </div>
        <div class="row mt-2">
            <div class="col-12 text-right profile-btn">
                <?php if (get_current_user_id() == $user_id) { ?>
                    <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('in_progress')); ?>"><button class="px-0 btn rounded-pill btn-outline-primary outline-btn btn-sm">???????????????</button></a>
                    <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('request')); ?>"><button class="px-0 mx-1 btn rounded-pill btn-outline-primary outline-btn btn-sm request-btn">??????????????????</button></a>
                    <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('edit_profile')); ?>"><button class="px-0 btn rounded-pill btn-outline-primary outline-btn btn-sm">????????????</button></a>
                <?php } else { ?>
                    <!-- ??????????????????????????? -->
                    <a href="<?php echo esc_attr(get_tcd_membership_memberpage_url('detail_message')); ?>&user_id=<?php echo $user_id; ?>" class="second-btn rounded-circle dm-icon-block">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/dm.png" alt="message" class="profile-dm_icon">
                    </a>
                    <?php if (is_following($user_id)) { ?>
                        <button type="button" data-user-id="<?php echo esc_attr($user_id); ?>" class="js-toggle-follow btn btn-primary rounded-pill btn-sm text-white btn-lg main-color follow-btn follow-on">???????????????</button>
                    <?php } else { ?>
                        <button type="button" data-user-id="<?php echo esc_attr($user_id); ?>" class="js-toggle-follow btn rounded-pill btn-outline-primary btn-sm follow-btn follow-off">??????????????????</button>
                    <?php } ?>
                    <?php if ($active_flag !== FALSE) { ?>
                        <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('request')); ?>&user_id=<?php echo $user_id; ?>"><button class="px-0 mx-1 btn rounded-pill btn-outline-primary outline-btn btn-sm request-btn">????????????</button></a>
                    <?php } ?>
                <?php } ?>
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
                <?php if (get_current_user_id() == $user_id) { ?>
                    <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('follows')); ?>"><span class="follow">????????????<br>
                            <span><?php echo number_format($arrayCount['following']['total']); ?></span></span>
                    </a>
                    <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('followers')); ?>"><span class="follower">???????????????<br>
                            <span><?php echo number_format($arrayCount['follower']['total']); ?></span></span>
                    </a>
                <?php } else { ?>
                    <span class="follow">????????????<br>
                        <span><?php echo number_format($arrayCount['following']['total']); ?></span></span>
                    <span class="follower">???????????????<br>
                        <span><?php echo number_format($arrayCount['follower']['total']); ?></span></span>
                <?php } ?>
            </div>
            <!-- ????????????????????????????????? -->
            <div class="col-5"></div>
            <div class="col-7 profile-money">
                <div class="row">
                    <div class="col-6 float-right font-weight-bold text-left">
                        <p class="mb-0 text-nowrap">????????????</p>
                    </div>
                    <div class="col-6 float-right font-weight-bold text-right">
                        <p class="mb-0">???1,000,000-</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 float-right font-weight-bold text-left">
                        <p class="mb-0 text-nowrap">NFT????????????</p>
                    </div>
                    <div class="col-6 float-right font-weight-bold text-right">
                        <p class="mb-0">???2,000,000-</p>
                    </div>
                </div>
            </div>
            <!-- ????????????????????????????????? -->

            <!-- <div class="col-5 d-block btn-area text-right pl-0 my-auto">
           <button type="button" class="btn btn-primary rounded-pill btn-sm text-white btn-lg main-color follow-btn follow-on">???????????????</button>
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
    <!-- ?????????????????? -->
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

    <!-- ??????????????????????????? -->
    <div class="d-none py-1" id="favorite_list">
        <?php foreach ($list_like as $array_like) { ?>
            <div class="content">
                <?php foreach ($array_like as $onePost) { ?>
                    <div class="content-item shadow d-flex align-items-center justify-content-center px-1">
                        <img class="image-list" src="<?php echo $onePost->main_image; ?>">
                    </div>
                <?php }
                /** endforeach */ ?>
            </div>
        <?php }
        /** endforeach */ ?>
    </div>

    <!-- ?????????????????????????????? -->
    <div class="d-none py-1" id="purcher_list">
        <?php foreach ($list_favorite as $array_favorite) { ?>
            <div class="content">
                <?php foreach ($array_favorite as $onePost) { ?>
                    <div class="content-item shadow d-flex align-items-center justify-content-center px-1">
                        <img class="image-list" src="<?php echo $onePost->main_image; ?>">
                    </div>
                <?php }
                /** endforeach */ ?>
            </div>
        <?php }
        /** endforeach */ ?>
    </div>
    <!-- ??????NFT?????? -->
    <div class="d-none py-1" id="have_nft_list">
        <?php /** TODO: NFT???????????????????????? */ ?>
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

        // ???????????????????????????
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
