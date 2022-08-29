<?php
// Add 2022/06/03 by H.Okabe
/**
 * メッセージの一覧
 */
function tcd_membership_action_list_message()
{
    global $tcd_membership_vars;

    nocache_headers();

    $user = wp_get_current_user();

    if (!$user) {
        wp_safe_redirect(user_trailingslashit(home_url()));
        exit;
    }

    $args = [
        'user_id' => $user->ID,
    ];

    // メッセージの一覧の取得
    $listMessage = get_tcd_membership_messages_latest_list($args);
    $tcd_membership_vars['template']  = 'muse_list_message';
    $tcd_membership_vars['list_message'] = $listMessage;
}
add_action('tcd_membership_action-list_message', 'tcd_membership_action_list_message');
