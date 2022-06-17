<?php
// Add 2022/05/10 by H.Okabe
/**
 * いいねしている投稿一覧取得
 */
function tcd_membership_action_likes()
{
    global $tcd_membership_vars;

    nocache_headers();

    $user = wp_get_current_user();

    if (!$user) {
        wp_safe_redirect(user_trailingslashit(home_url()));
        exit;
    }
    // テンプレート指定
    $tcd_membership_vars['template']  = 'muse_likes';
    $list_like  = muse_list_like($user->ID);
    $chunk_list_like = array_chunk($list_like, 3);
    $tcd_membership_vars['list_like'] = $chunk_list_like;
}
add_action('tcd_membership_action-likes', 'tcd_membership_action_likes');
