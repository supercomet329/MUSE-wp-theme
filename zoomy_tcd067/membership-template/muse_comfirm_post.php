<?php
global $dp_options, $tcd_membership_vars, $tcd_membership_post;

// プレビュー確認はsingle-photo.php
if (is_tcd_membership_preview_photo()) :
    get_template_part('single-photo');
    return;
endif;

$profileImageData = get_user_meta($tcd_membership_vars['postData']['post_author'], 'profile_image', true);
$profile_image = get_template_directory_uri() . '/assets/img/icon/non_profile_image.png';
if (!empty($profileImageData)) {
    $profile_image = $profileImageData;
}

get_header();
?>
<div class="col-12 mt-3 mb-2 tweet-area d-flex align-items-center">
    <img src="<?php echo $profile_image; ?>" class="rounded-circle profile-icon">
    <span class="pl-2"><?php echo $tcd_membership_vars['user']['display_name']; ?></span>
    <span class="follow-area ml-auto">
        <?php if ($tcd_membership_vars['postData']['post_author'] !== get_current_user_id()) { ?>
            <?php if (is_following($tcd_membership_vars['postData']['post_author'])) { ?>
                <button type="button" data-user-id="<?php echo esc_attr($tcd_membership_vars['postData']['post_author']); ?>" class="btn btn-primary rounded-pill btn-sm text-white btn-lg main-color js-toggle-follow">フォロー中</button>
            <?php } else { ?>
                <button type="button" data-user-id="<?php echo esc_attr($tcd_membership_vars['postData']['post_author']); ?>" class="btn rounded-pill btn-outline-primary outline-btn btn-sm js-toggle-follow">フォローする</button>
            <?php }
            /** endif */ ?>
        <?php }
        /** endif */ ?>
    </span>
</div>
<div class="d-flex align-items-center justify-content-center font-weight-bold production-title">
    <?php echo $tcd_membership_vars['postData']['post_title']; ?>
</div>
<div class="timeline-image">
    <img src="<?php echo esc_url($tcd_membership_vars['postData']['post_image']); ?>" alt="">
</div>

<?php if ($tcd_membership_vars['postData']['post_author'] !== get_current_user_id()) { ?>

    <div class="logo-area border-bottom-dashed pb-2">

        <?php
        $like_image = 'iine.png';
        if (is_liked($tcd_membership_vars['postData']['post_id'], false)) {
            $like_image = 'iine_on.png';
        }
        ?>
        <img class="js-toggle-like" data-post-id="<?php echo $tcd_membership_vars['postData']['post_id']; ?>" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/<?php echo $like_image; ?>" alt="iine">
        <?php /** TODO: 決済方法が決まってから投げ銭部の対応 */ ?>
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/social_tipping_on.png" alt="social_tipping_on">
    </div>
<?php }
/** endif */ ?>

<div class="mb-2 ml-2 mr-2">
    <?php echo nl2br($tcd_membership_vars['postData']['post_content']); ?>
</div>
<div class="mb-2 ml-2 mr-2 subtext text-right">
    <?php echo $tcd_membership_vars['postData']['post_date']; ?>
</div>
<?php
get_footer();
