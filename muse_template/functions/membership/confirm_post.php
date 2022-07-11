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

    // 販売しない場合のテンプレート
    $template = 'muse_comfirm_post_no_sale';

    $saleType = get_post_meta($rowPostData->ID, 'saleType', true);
    if($saleType === 'sale') {
        // 販売の場合のテンプレート
        $template = 'muse_comfirm_post_sale';
        $selectAuction = get_post_meta($rowPostData->ID, 'selectAuction', true);
        if($selectAuction === 'Auction') {
            // オークションの場合のテンプレート
            $template = 'muse_comfirm_post_sale';
        }
    }

    $image  = get_post_meta($rowPostData->ID, 'main_image', true);
    $image2 = get_post_meta($rowPostData->ID, 'main_image2', true);
    $image3 = get_post_meta($rowPostData->ID, 'main_image3', true);
    $image4 = get_post_meta($rowPostData->ID, 'main_image4', true);


    $imageArray = [];
    $imageArray[] = $image;
    if(! empty($image2)) {
        $imageArray[] = $image2;
    }

    if(! empty($image3)) {
        $imageArray[] = $image3;
    }

    if(! empty($image4)) {
        $imageArray[] = $image4;
    }

    $tcd_membership_vars['template']   = $template;
    $tcd_membership_vars['imageArray'] = $imageArray;
    $tcd_membership_vars['post_id']    = $post_id;
    $tcd_membership_vars['post_title']   = $rowPostData->post_title;
    $tcd_membership_vars['post_content'] = $rowPostData->post_content;
    nocache_headers();
}
add_action('tcd_membership_action-confirm_post', 'tcd_membership_action_confirm_post');
