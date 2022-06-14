<?php
// Add 2022/05/10 by H.Okabe
/**
 * 投稿している画像の詳細
 */
function tcd_membership_action_confirm_post()
{
    global $wpdb, $tcd_membership_vars;

    $post_id = $_GET['post_id'];
    $rowPostData = get_post($post_id);

    if (count($rowPostData) <= 0) {
        wp_safe_redirect(user_trailingslashit(home_url()));
        exit;
    }

    $postDateClass = new DateTime($rowPostData->post_date);
    $postDate      = $postDateClass->format('Y/m/d H:i');

    // テンプレート指定
    $postImageData = [];
    $postImageData['post_id']      = $rowPostData->ID;
    $postImageData['post_author']  = (int)$rowPostData->post_author;
    $postImageData['post_title']   = $rowPostData->post_title;
    $postImageData['post_content'] = $rowPostData->post_content;
    $postImageData['post_date']    = $postDate;

    $postImageData['post_image']   = get_post_meta($rowPostData->ID, 'main_image', true);
    $saleType = get_post_meta($rowPostData->ID, 'saleType', true);

    $r18String = '全年齢';
    $r18Flag   = get_post_meta($rowPostData->ID, 'r18', true);
    if($r18Flag === 'r18') {
        $r18String = 'R18指定';
    }
    $postImageData['r18String']   = $r18String;

    if ($saleType === 'sale') {
        // 通常販売の場合
        $template = 'muse_comfirm_post_sale';

        // 金額を取得
        $postImageData['imagePrice']   = get_post_meta($rowPostData->ID, 'imagePrice', true);

        // 即決金額を取得
        $postImageData['binPrice']   = get_post_meta($rowPostData->ID, 'binPrice', true);

    } elseif ($saleType === 'auction') {
        // オークションの場合
        $template = 'muse_comfirm_post_auction';

    } else {
        // 販売しない場合
        $template = 'muse_comfirm_post_now_sale';
    }

    $tcd_membership_vars['template']  = $template;
    $tcd_membership_vars['postData']  = $postImageData;

    $user = get_userdata($rowPostData->post_author);
    $userArray = [];
    $userArray['display_name'] = $user->display_name;
    $tcd_membership_vars['user']  = $userArray;

    nocache_headers();
}
add_action('tcd_membership_action-confirm_post', 'tcd_membership_action_confirm_post');
