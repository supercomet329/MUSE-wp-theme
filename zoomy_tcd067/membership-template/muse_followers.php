<?php
global $dp_options, $tcd_membership_vars;

get_header();
?>
<div class="text-center font-weight-bold title">
    フォロワー一覧
</div>
<div class="container">
    <div class="row">
        <div class="col-12">
            <ul class="list-area">
                <?php
                foreach ($tcd_membership_vars['list_follow'] as $one_follow) {
                    $user_info = get_userdata($one_follow->user_id);

                    $profileImageData = get_user_meta($one_follow->user_id, 'profile_image', true);
                    $profile_image = get_template_directory_uri() . '/assets/img/icon/non_profile_image.png';
                    if (!empty($profileImageData)) {
                        $profile_image = $profileImageData;
                    }
                ?>
                    <li class="d-flex align-items-start pt-2">
                        <img src="<?php echo $profile_image; ?>" class="rounded-circle">
                        <span class="name"><?php echo $user_info->display_name; ?></span>
                        <span class="btn-area">
                            <?php if (is_following($one_follow->user_id)) { ?>
                                <a href="#" id="follow_button" data-user-id="<?php echo esc_attr($one_follow->user_id); ?>" class="js-toggle-follow btn btn-primary rounded-pill btn-sm text-white btn-lg main-color">フォロー中</a>
                            <?php } else { ?>
                                <a href="#" id="follow_button" data-user-id="<?php echo esc_attr($one_follow->user_id); ?>" class="js-toggle-follow btn rounded-pill btn-outline-primary outline-btn btn-sm">フォローする</a>
                            <?php } ?>
                        </span>
                    </li>
                <?php }
                /** endforeach **/ ?>
            </ul>
        </div>
    </div>
</div>
<?php
get_footer();
