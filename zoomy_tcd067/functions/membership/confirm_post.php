<?php
// Add 2022/05/10 by H.Okabe
/**
 * 投稿している画像の詳細
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

    // テンプレート指定
    $tcd_membership_vars['template']  = 'muse_comfirm_post';

    $postDateClass = new DateTime($rowPostData[0]->post_content);
    $postDate      = $postDateClass->format('Y/m/d H:i');

    $postData = [];
    $postData['post_id']      = $rowPostData[0]->ID;
    $postData['post_author']  = $rowPostData[0]->post_author;
    $postData['post_title']   = $rowPostData[0]->post_title;
    $postData['post_content'] = $rowPostData[0]->post_content;
    $postData['post_date']    = $postDate;
    $tcd_membership_vars['postData']  = $postData;

    $user = get_userdata( $rowPostData[0]->post_author );
    $userArray = [];
    $userArray['display_name'] = $user->display_name;
    $tcd_membership_vars['user']  = $userArray;

    nocache_headers();
 
}
add_action('tcd_membership_action-confirm_post', 'tcd_membership_action_confirm_post');
