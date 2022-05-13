<?php
// Add 2022/05/10 by H.Okabe
/**
 * 投稿している画像の詳細
 * TODO: 2022/05/11 メッセージのやり取りの対応
 */
function tcd_membership_action_confirm_post()
{
    global $wpdb, $tcd_membership_vars;

    $post_id = $_GET['post_id'];
    $rowPostData = get_post_data($post_id);

    if (count($rowPostData) <= 0) {
        wp_safe_redirect(user_trailingslashit(home_url()));
        exit;
    }

    $user = wp_get_current_user();
    if (!$user) {
        wp_safe_redirect(user_trailingslashit(home_url()));
        exit;
    }

    // テンプレート指定
    $tcd_membership_vars['template']  = 'muse_comfirm_post';

    $postData = [];
    $postData['post_id']     = $rowPostData[0]->ID;
    $postData['post_author'] = $rowPostData[0]->post_author;
    $postData['post_content'] = $rowPostData[0]->post_content;
    $postData['post_content'] = $rowPostData[0]->post_content;
    $tcd_membership_vars['postData']  = $postData;

    nocache_headers();
 
}
add_action('tcd_membership_action-confirm_post', 'tcd_membership_action_confirm_post');
