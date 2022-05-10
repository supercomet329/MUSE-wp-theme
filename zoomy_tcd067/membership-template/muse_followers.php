<?php
global $dp_options, $tcd_membership_vars;

get_header();
?>
<div class="text-center bg-white font-weight-bold pt-5 mb-3 pb-3 border-bottom position-fixed" style="width: 100%; z-index: 100;">フォロー</div>
<div class="container" style="padding-top: 100px;">
    <ul class="row pl-0">
        <?php
        foreach ($tcd_membership_vars['list_follow'] as $one_follow) {
            $user_info = get_userdata($one_follow->user_id);
        ?>
            <li class="justify-content-between col-12 col-lg-9 col-xl-7">
                <div class="float-left">
                    <div class="icon mt-2 mr-2 float-left">
                        <img src="<?php echo $user_info->profile_image; ?>" class="rounded-circle" width="50" height="50">
                    </div>
                    <h6 class="pl-2 pt-4 font-weight-bold float-right"><?php echo $user_info->display_name; ?></h6>
                </div>
                <div class="justify-content-center pt-4 pb-3 float-right">
                    <?php if (is_following($one_follow->user_id)) { ?>
                        <a href="#" id="follow_button" data-user-id="<?php echo esc_attr($one_follow->user_id); ?>" class="js-toggle-follow btn btn-light btn-sm text-dark btn-block btn-lg gradient-custom-4 font-weight-bold f-size-2">フォロー中</a>
                    <?php } else { ?>
                        <a href="#" id="follow_button" data-user-id="<?php echo esc_attr($one_follow->user_id); ?>" class="js-toggle-follow btn btn-primary btn-sm text-white btn-block btn-lg gradient-custom-4 font-weight-bold f-size-2">フォローする</a>
                    <?php } ?>
                </div>
            </li>
        <?php } ?>
    </ul>
</div>
<?php
get_footer();
