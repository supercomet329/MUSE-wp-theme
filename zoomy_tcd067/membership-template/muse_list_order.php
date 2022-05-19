<?php
global $dp_options, $tcd_membership_vars;
get_header();
?>
<div class="text-center bg-white font-weight-bold pt-5 mb-3 pb-3 border-bottom position-fixed" style="width: 100%; z-index: 100;">発注一覧</div>
<form action="<?php echo esc_attr(get_tcd_membership_memberpage_url('list_order')); ?>" method="post">
    <div class="row">
        <div class="col-12">
            <label class="form-label " for="">発注者名</label>
        </div>
        <div class="col-12 pb-3">
            <input type="text" name="display_name" id="" value="<?php if(isset($_REQUEST['display_name'])) { echo $_REQUEST['display_name']; } ?>" class="form-control form-control-lg" placeholder="発注者名" />
        </div>
        <div class="col-12">
            <label class="form-label " for="">依頼タイトル</label>
        </div>
        <div class="col-12 pb-3">
            <input type="text" name="post_title" id="" value="<?php if(isset($_REQUEST['post_title'])) { echo $_REQUEST['post_title']; } ?>" class="form-control form-control-lg" placeholder="依頼タイトル" />
        </div>

        <div class="col-12">
            <label class="form-label " for="">依頼内容</label>
        </div>
        <div class="col-12 pb-3">
            <input type="text" name="post_content" id="" class="form-control form-control-lg"  value="<?php if(isset($_REQUEST['post_content'])) { echo $_REQUEST['post_content']; } ?>" placeholder="依頼内容" />
        </div>
    </div>
    <div class="d-flex justify-content-center pt-4 pb-2">
        <button type="submit" class="btn btn-primary text-white btn-block btn-lg gradient-custom-4 font-weight-bold f-size-4">ログイン</button>
    </div>
    <input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('tcd_membership_action_order_search')); ?>">
</form>
<div class="list-group">
    <?php
    foreach ($tcd_membership_vars['list_order'] as $one_order) {
        $dateClass = new DateTime($one_order->post_date);

        $contractorUserName = '受注者なし';
        if (!is_null($one_order->contractor_user_id)) {
            $userInfo           = get_userdata($user->ID);
            $contractorUserName = $userInfo->display_name;
        }
    ?>
        <a href="<?php echo esc_attr(get_tcd_membership_memberpage_url('comfirm_request')); ?>&request_id=<?php echo esc_attr($one_order->post_id); ?>" class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1"><?php echo esc_attr($one_order->post_title); ?></h5>
                <small><?php echo esc_attr($dateClass->format('Y/m/d')); ?></small>
            </div>
            <p class="mb-1"><?php echo nl2br($one_order->post_content); ?></p>
            <small>受注者: <?php echo esc_attr($contractorUserName); ?></small>
        </a>
    <?php } ?>
</div>
<?php
get_footer();
