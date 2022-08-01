<?php
// Add 2022/05/10 by H.Okabe
/**
 * いいねしている投稿一覧取得
 */
function tcd_membership_action_confirm_received()
{
    global $tcd_membership_vars;
    if ('POST' !== $_SERVER['REQUEST_METHOD']) {
        // POSTで遷移されていない場合 => トップページに遷移
        wp_safe_redirect(user_trailingslashit(home_url()));
        exit;
    }

    // 値がPOSTされたときの対応
    if (empty($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'tcd_membership_confirm_request')) {
        // POSTトークンの取得がおかしい場合 => トップページに遷移
        wp_safe_redirect(user_trailingslashit(home_url()));
        exit;
    }

    $user = wp_get_current_user();
    // POST情報からリクエストの情報を取得
    $request_id = $_POST['post_id'];
    $rowResuestData = get_request($request_id);

    if (count($rowResuestData) <= 0 || $user->ID === (int)$rowResuestData[0]->post_author) {
        wp_safe_redirect(user_trailingslashit(home_url()));
        exit;
    }

    if ((int)$rowResuestData[0]->post_author === $user->ID || !is_null($rowResuestData[0]->user_id)) {
        wp_safe_redirect(user_trailingslashit(home_url()));
        exit;
    }

    if (isset($_POST['request_type']) && $_POST['request_type'] === 'confirm') {
        // 確認ページに遷移したとき
        insert_tcd_membership_action('received', $user->ID, $rowResuestData[0]->post_author, $rowResuestData[0]->post_id);
        $url = get_tcd_membership_memberpage_url('confirm_request') . '&request_id=' . $rowResuestData[0]->post_id . '&status=complete';
        wp_safe_redirect(user_trailingslashit($url));
        exit;
    }

    // テンプレート指定
    $tcd_membership_vars['template']  = 'muse_confirm_received';

    $deadLineClass = new DateTime($rowResuestData[0]->deadline);
    $requestData = [];
    $requestData['post_id'] = $rowResuestData[0]->post_id;
    $requestData['title'] = $rowResuestData[0]->post_title;
    $requestData['content'] = $rowResuestData[0]->post_content;
    $requestData['url'] = $rowResuestData[0]->url;
    $requestData['money'] = $rowResuestData[0]->money;
    $requestData['sales_format'] = $rowResuestData[0]->sales_format;
    $requestData['deadline'] = $rowResuestData[0]->sales_format;
    $requestData['receptions_count'] = $rowResuestData[0]->receptions_count;
    $requestData['delivery_request'] = $rowResuestData[0]->delivery_request;
    $requestData['special_report'] = $rowResuestData[0]->special_report;
    $requestData['request_file_url'] = $rowResuestData[0]->request_file_url;
    $requestData['request_file_name'] = $rowResuestData[0]->request_file_name;
    $requestData['deadline'] = $deadLineClass->format('Y/m/d');
    $requestData['post_author'] = $rowResuestData[0]->post_author;
    $requestData['user_id']     = $user->ID;
    $tcd_membership_vars['requestData']  = $requestData;
}
add_action('tcd_membership_action-confirm_received', 'tcd_membership_action_confirm_received');
