<?php
global $dp_options, $tcd_membership_vars;

get_header();
?>
<div class="text-center font-weight-bold title">
    フォロー一覧
</div>
<div class="container">
    <div class="row">
        <div class="col-12">
            <ul class="list-area">
                <?php
                foreach ($tcd_membership_vars['list_follow'] as $one_follow) {
                    $user_info = get_userdata($one_follow->target_user_id);

                    $description = '';
                    $descriptionData = get_user_meta($one_follow->target_user_id, 'description', true);
                    // プロフィールの取得
                    if (!empty($descriptionData)) {
                        $description = $descriptionData;
                    }

                    $profileImageData = get_user_meta($one_follow->target_user_id, 'profile_image', true);
                    $profile_image = get_template_directory_uri() . '/assets/img/icon/non_profile_image.png';
                    if (!empty($profileImageData)) {
                        $profile_image = $profileImageData;
                    }
                ?>
                    <div class="row my-2">
                        <div class="col-2 d-block d-lg-none pr-0">
                            <img src="<?php echo $profile_image; ?>" class="rounded-circle profile-icon">
                        </div>
                        <div class="col-2 d-none d-lg-block pr-0">
                            <img src="<?php echo $profile_image; ?>" class="rounded-circle profile-icon">
                        </div>
                        <div class="col-6 d-block d-lg-none">
                            <p class="name font-weight-bold mb-1"><?php echo $user_info->display_name; ?></p>
                            <p class="profile-detail mb-1"><?php echo $description; ?></p>
                        </div>
                        <div class="col-8 d-none d-lg-block">
                            <p class="name font-weight-bold mb-1"><?php echo $user_info->display_name; ?></p>
                            <p class="profile-detail mb-1"><?php echo $description; ?></p>
                        </div>
                        <div class="col-4 d-block d-lg-none btn-area text-right pl-0 my-auto">
                            <?php if (is_following($one_follow->target_user_id)) { ?>
                                <a href="#" id="follow_button" data-user-id="<?php echo esc_attr($one_follow->target_user_id); ?>" class="js-toggle-follow btn btn-primary rounded-pill btn-sm text-white btn-lg main-color">フォロー中</a>
                            <?php } else { ?>
                                <a href="#" id="follow_button" data-user-id="<?php echo esc_attr($one_follow->target_user_id); ?>" class="js-toggle-follow btn rounded-pill btn-outline-primary outline-btn btn-sm">フォローする</a>
                            <?php } ?>
                        </div>
                        <div class="col-2 d-none d-lg-block btn-area text-right pl-0 my-auto">
                            <?php if (is_following($one_follow->target_user_id)) { ?>
                                <a href="#" id="follow_button" data-user-id="<?php echo esc_attr($one_follow->target_user_id); ?>" class="js-toggle-follow btn btn-primary rounded-pill btn-sm text-white btn-lg main-color">フォロー中</a>
                            <?php } else { ?>
                                <a href="#" id="follow_button" data-user-id="<?php echo esc_attr($one_follow->target_user_id); ?>" class="js-toggle-follow btn rounded-pill btn-outline-primary outline-btn btn-sm">フォローする</a>
                            <?php } ?>
                        </div>
                    </div>
                    <hr class="list-area-border my-0">
                <?php }
                /** endforeach **/ ?>
            </ul>
        </div>
    </div>
</div>
<?php
get_footer();
