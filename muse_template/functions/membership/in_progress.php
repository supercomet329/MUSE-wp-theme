<?php

/**
 * 進行中一覧
 */
function tcd_membership_action_in_progress()
{
    global $tcd_membership_vars;

    // user_idの取得
    $user_id = get_current_user_id();

    // user_idが取得できない場合 => ログインページ遷移
    if ($user_id <= 0) {
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
            if(isset($_POST['up_budget']) && !empty($_POST['up_budget'])) {
                $up_budget = $_POST['up_budget'];
            }

            // 予算下限
            if(isset($_POST['down_budget']) && !empty($_POST['down_budget'])) {
                $down_budget = $_POST['down_budget'];
            }

            // 期日
            if(isset($_POST['deadline']) && !empty($_POST['deadline'])) {
                $deadline = $_POST['deadline'];

                $dateClass = new DateTime();
                $dateClass->modify('+' . $deadline);
                $whereDeadLine = $dateClass->format('Y-m-d 00:00:00');
            }

            // 対象
            if(isset($_POST['target']) && !empty($_POST['target'])) {
                $target = $_POST['target'];
            }
        }
    }

    // 自分が発注して受注されたリクエストの一覧の取得
    $listInProgress = listInProgress($up_budget, $down_budget, $whereDeadLine, $target);

    // テンプレートに値を渡す
    $tcd_membership_vars['template']  = 'muse_in_progress';
    $tcd_membership_vars['listOrder'] = $listInProgress;
}
add_action('tcd_membership_action-in_progress', 'tcd_membership_action_in_progress');
