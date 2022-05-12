<?php
global $dp_options, $tcd_membership_vars;
get_header();
?>
<div class="text-center bg-white font-weight-bold pt-5 mb-3 pb-3 border-bottom position-fixed" style="width: 100%; z-index: 100;">発注一覧</div>
<div class="list-group">
    <?php
        foreach($tcd_membership_vars['list_received'] as $one_order) {
            $dateClass = new DateTime($one_order->post_date);

            $contractorUserName = '受注者なし';
            if(!is_null($one_order->post_author)) {
                $userInfo           = get_userdata($one_order->post_author);
                $orderUserName = $userInfo->display_name;
            }
    ?>
    <a href="<?php echo esc_attr( get_tcd_membership_memberpage_url( 'comfirm_request' ) ); ?>&request_id=<?php echo esc_attr($one_order->post_id); ?>" class="list-group-item list-group-item-action flex-column align-items-start">
        <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1"><?php echo esc_attr($one_order->post_title); ?></h5>
            <small><?php echo esc_attr($dateClass->format('Y/m/d')); ?></small>
        </div>
        <p class="mb-1"><?php echo nl2br($one_order->post_content); ?></p>
        <small>発注者:  <?php echo esc_attr($orderUserName); ?></small>
    </a>
    <?php } ?>
</div>
<?php
get_footer();
