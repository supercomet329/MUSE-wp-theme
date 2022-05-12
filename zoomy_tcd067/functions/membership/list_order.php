<?php
// Add 2022/05/10 by H.Okabe
/**
 * 依頼一覧ページ
 */
function tcd_membership_action_list_order()
{
    global $tcd_membership_vars;

    nocache_headers();

    $user = wp_get_current_user();

    $post_title   = false;
    $post_content = false;
    $display_name = false;
    if ('POST' == $_SERVER['REQUEST_METHOD']) {
        // 値がPOSTされたときの対応
        if (!empty($_POST['nonce']) || wp_verify_nonce($_POST['nonce'], 'tcd_membership_action_order_search')) {

            if (isset($_POST['display_name']) && !empty($_POST['display_name'])) {
                // ユーザーの一覧の取得
                $display_name = $_POST['display_name'];
            }

            if (isset($_POST['post_title']) || !empty($_POST['post_title'])) {
                $post_title = $_POST['post_title'];
            }

            if (isset($_POST['post_content']) || !empty($_POST['post_content'])) {
                $post_content = $_POST['post_content'];
            }
        }
    }

    if (!$user) {
        wp_safe_redirect(user_trailingslashit(home_url()));
        exit;
    }

    // 発注の一覧を取得
    $listOrder = listOrder($post_title, $post_content, $display_name);

    // テンプレート指定
    $tcd_membership_vars['template']  = 'muse_list_order';
    $tcd_membership_vars['list_order'] = $listOrder;
}
add_action('tcd_membership_action-list_order', 'tcd_membership_action_list_order');
