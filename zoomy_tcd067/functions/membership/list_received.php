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

    // 発注の一覧を取得
    $listReceived = listReceivedByUserId($user->ID);

    // テンプレート指定
    $tcd_membership_vars['template']  = 'muse_list_received';
    $tcd_membership_vars['list_received'] = $listReceived;
}
add_action('tcd_membership_action-list_received', 'tcd_membership_action_list_received');
