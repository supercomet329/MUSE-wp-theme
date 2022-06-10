<?php
// Add 2022/05/10 by H.Okabe
/**
 * 受注一覧
 */
function tcd_membership_action_list_received()
{
    global $tcd_membership_vars;

    nocache_headers();

    $user = wp_get_current_user();

    if (!$user) {
        wp_safe_redirect(user_trailingslashit(home_url()));
        exit;
    }

    $up_budget = false;
    $down_budget = false;
    $deadline = false;
    $deadline = false;
    $target   = false;
    $whereDeadLine = false;
    $postData = [];
    if ('POST' == $_SERVER['REQUEST_METHOD']) {
        $postData = $_POST;
        // 値がPOSTされたときの対応
        if (!empty($_POST['nonce']) || wp_verify_nonce($_POST['nonce'], 'tcd_membership_action_order_search')) {

            // 予算上限
            if (isset($_POST['up_budget']) && !empty($_POST['up_budget'])) {
                $up_budget = $_POST['up_budget'];
            }

            // 予算下限
            if (isset($_POST['down_budget']) && !empty($_POST['down_budget'])) {
                $down_budget = $_POST['down_budget'];
            }

            // 期日
            if (isset($_POST['deadline']) && !empty($_POST['deadline'])) {
                $deadline = $_POST['deadline'];

                $dateClass = new DateTime();
                $dateClass->modify('+' . $deadline);
                $whereDeadLine = $dateClass->format('Y-m-d 00:00:00');
            }

            // 対象
            if (isset($_POST['target']) && !empty($_POST['target'])) {
                $target = $_POST['target'];
            }
        }
    }

    // 受注の一覧を取得
    $listReceived = listReceivedByUserId($user->ID, $up_budget, $down_budget, $whereDeadLine, $target);

    // テンプレート指定
    $tcd_membership_vars['template']  = 'muse_list_received';
    $tcd_membership_vars['list_received'] = $listReceived;
    $tcd_membership_vars['post_data']  = $postData;
}
add_action('tcd_membership_action-list_received', 'tcd_membership_action_list_received');
