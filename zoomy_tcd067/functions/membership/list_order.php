<?php
// Add 2022/05/10 by H.Okabe
/**
 * 作品依頼発注一覧ページ
 */
function tcd_membership_action_list_order()
{
    global $tcd_membership_vars;

    nocache_headers();

    $user = wp_get_current_user();

    if (!$user) {
        wp_safe_redirect(user_trailingslashit(home_url()));
        exit;
    }

    // 発注の一覧を取得
    $listOrder = listOrderByPostAuthor($user->ID);

    // テンプレート指定
    $tcd_membership_vars['template']  = 'muse_list_order';
    $tcd_membership_vars['list_order'] = $listOrder;
}
add_action('tcd_membership_action-list_order', 'tcd_membership_action_list_order');