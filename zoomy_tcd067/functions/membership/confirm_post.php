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

    $viewButtonFlag = false;
    if (!is_null(get_current_user_id())) {
        if ((int)$rowPostData->post_author !== get_current_user_id()) {
            $viewButtonFlag = true;
        }
    }
    $postImageData['viewButtonFlag']    = $viewButtonFlag;

    $postImageData['post_image']   = get_post_meta($rowPostData->ID, 'main_image', true);
    $saleType = get_post_meta($rowPostData->ID, 'saleType', true);

    $r18String = '全年齢';
    $r18Flag   = get_post_meta($rowPostData->ID, 'r18', true);
    if ($r18Flag === 'r18') {
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

        $auctionCheckFlag = get_post_meta($rowPostData->ID, 'auctionStartDate', true);
        $auctionFlag = false;
        $auctionStartDate = false;
        $auctionEndDate = false;
        $extendAuctionString  = false;
        if ($auctionCheckFlag === 'specify') {
            // オークション時刻指定あり
            $auctionFlag = true;

            // 開始時刻の取得
            $auctionDate = get_post_meta($rowPostData->ID, 'auctionDate', true);
            $auctionDateClass = new DateTime($auctionDate);
            $auctionStartDate = $auctionDateClass->format('Y/m/d H:i:s');

            // 終了時刻の取得
            $auctionEndDate = get_post_meta($rowPostData->ID, 'auctionEndDate', true);
            $auctionEndDateClass = new DateTime($auctionEndDate);
            $auctionEndDate = $auctionEndDateClass->format('Y/m/d H:i:s');

            // 自動延長の文字列の取得
            $extendAuctionString = 'なし';
            $extendAuctionFlag = get_post_meta($rowPostData->ID, 'extendAuction', true);
            if ($extendAuctionFlag === 'enableAutoExtend') {
                $extendAuctionString = 'あり';
            }
        }
        $postImageData['auctionFlag']         = $auctionFlag;
        $postImageData['auctionStartDate']    = $auctionStartDate;
        $postImageData['auctionEndDate']      = $auctionEndDate;
        $postImageData['extendAuctionString'] = $extendAuctionString;
    } else {
        // 販売しない場合
        $template = 'muse_comfirm_post_no_sale';
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
