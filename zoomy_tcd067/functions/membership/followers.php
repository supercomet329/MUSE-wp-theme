<?php
// Add 2022/05/10 by H.Okabe
/**
 * フォローしている一覧取得
 */
function tcd_membership_action_followers()
{
    global $tcd_membership_vars;

    nocache_headers();

    $user = wp_get_current_user();

    if (!$user) {
        wp_safe_redirect(user_trailingslashit(home_url()));
        exit;
    }

    // テンプレート指定
    $tcd_membership_vars['template'] = 'muse_followers';
    $tcd_membership_vars['list_follow'] = muse_list_followers($user->ID);
}
add_action('tcd_membership_action-followers', 'tcd_membership_action_followers');