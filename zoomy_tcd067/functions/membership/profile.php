<?php
// Add 2022/05/10 by H.Okabe
/**
 * 他人が見るプロフィールページ
 */
function tcd_membership_action_profile()
{
    global $tcd_membership_vars;

    nocache_headers();

    $user_id = $_GET['user_id'];
    $tcd_membership_vars['user_id']   = $user_id;
    $tcd_membership_vars['template']  = 'muse_author';

    $userData = get_userdata($user_id);
    if (!$userData) {
        // ユーザー情報が取得できない場合 => トップページに遷移
        wp_safe_redirect('/');
        exit;
    }
}
add_action('tcd_membership_action-profile', 'tcd_membership_action_profile');
