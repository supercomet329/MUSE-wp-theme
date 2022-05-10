<?php
global $dp_options, $tcd_membership_vars;

$list_follow = muse_list_follow(get_current_user_id());
get_header();
?>
<div class="text-center bg-white font-weight-bold pt-5 mb-3 pb-3 border-bottom position-fixed" style="width: 100%; z-index: 100;">フォロー</div>
<div class="container" style="padding-top: 100px;">
    <ul class="row pl-0">
        <?php 
            foreach ($list_follow as $one_follow) { 
                $user_info = get_userdata($one_follow->target_user_id);
        ?>
            <li class="justify-content-between col-12 col-lg-9 col-xl-7">
                <div class="float-left">
                    <div class="icon mt-2 mr-2 float-left">
                        <img src="<?php echo $user_info->profile_image; ?>" class="rounded-circle" width="50" height="50">
                    </div>
                    <h6 class="pl-2 pt-4 font-weight-bold float-right"><?php echo $user_info->display_name; ?></h6>
                </div>
                <div class="justify-content-center pt-4 pb-3 float-right">
                    <button type="button" class="btn btn-light btn-sm text-dark btn-block btn-lg gradient-custom-4 font-weight-bold f-size-2">フォロー中</button>
                </div>
            </li>
        <?php } ?>
    </ul>
</div>
<?php
get_footer();

