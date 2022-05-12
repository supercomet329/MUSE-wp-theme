<?php
// Add 2022/05/10 by H.Okabe
/**
 * 依頼している依頼の詳細画面
 * TODO: 2022/05/11 メッセージのやり取りの対応
 */
function tcd_membership_action_comfirm_request()
{
    global $wpdb, $tcd_membership_vars;

    $request_id = $_GET['request_id'];
    $rowResuestData = get_request($request_id);

    if (count($rowResuestData) <= 0) {
        wp_safe_redirect(user_trailingslashit(home_url()));
        exit;
    }

    // テンプレート指定
    $tcd_membership_vars['template']  = 'muse_comfirm_request';

    $user = wp_get_current_user();
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

    $viewReceivedButton = false;
    if((int)$rowResuestData[0]->post_author !== $user->ID && is_null($rowResuestData[0]->user_id)) {
        $viewReceivedButton = true;
    }
    $requestData['viewReceivedButton'] = $viewReceivedButton;

    nocache_headers();
    if (!$user) {
        wp_safe_redirect(user_trailingslashit(home_url()));
        exit;
    }
    $tcd_membership_vars['requestData']  = $requestData;
}
add_action('tcd_membership_action-comfirm_request', 'tcd_membership_action_comfirm_request');
