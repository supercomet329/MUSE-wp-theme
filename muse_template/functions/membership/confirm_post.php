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
    $imagePrice       = 0;
    $auctionDate      = false;
    $auctionStartDate = false;
    $auctionEndDate   = false;
    $binPrice         = false;
    $auctionString    = '指定しない';
    $extendAuction    = 'なし';
    if ($saleType === 'sale') {
        // 販売の場合のテンプレート
        $template = 'muse_comfirm_post_sale';
        $imagePrice = get_post_meta($rowPostData->ID, 'imagePrice', true);

        $selectAuction = get_post_meta($rowPostData->ID, 'selectAuction', true);
        if ($selectAuction === 'Auction') {
            // オークションの場合のテンプレート
            $template = 'muse_comfirm_post_auction';

            $auctionSelDate = get_post_meta($rowPostData->ID, 'auctionStartDate', true);
            if ($auctionSelDate === 'specify') {
                $auctionString  = '開始時間指定';
                $binPrice          = get_post_meta($rowPostData->ID, 'binPrice', true);

                $rowAuctionDate    = get_post_meta($rowPostData->ID, 'auctionDate', true);
                if (!empty($rowAuctionDate)) {
                    $auctionDateClass = new DateTime($rowAuctionDate);
                    $auctionDateClass->setTimezone(new DateTimeZone('Asia/Tokyo'));
                    $auctionStartDate = $auctionDateClass->format('Y/m/d H:i:s');
                }

                $rowAuctionEndDate = get_post_meta($rowPostData->ID, 'auctionEndDate', true);
                if (!empty($rowAuctionEndDate)) {
                    $auctionEndDateClass = new DateTime($rowAuctionEndDate);
                    $auctionEndDateClass->setTimezone(new DateTimeZone('Asia/Tokyo'));
                    $auctionEndDate = $auctionEndDateClass->format('Y/m/d H:i:s');
                }

                $strExtendAuction = get_post_meta($rowPostData->ID, 'extendAuction', true);
                if ($strExtendAuction === 'enableAutoExtend') {
                    $extendAuction  = 'あり';
                }
            }
        }
    }

    $image  = get_post_meta($rowPostData->ID, 'main_image', true);
    $image2 = get_post_meta($rowPostData->ID, 'main_image2', true);
    $image3 = get_post_meta($rowPostData->ID, 'main_image3', true);
    $image4 = get_post_meta($rowPostData->ID, 'main_image4', true);

    $imageArray = [];
    $imageArray[] = $image;
    if (!empty($image2)) {
        $imageArray[] = $image2;
    }

    if (!empty($image3)) {
        $imageArray[] = $image3;
    }

    if (!empty($image4)) {
        $imageArray[] = $image4;
    }

    $viewSubmitButton = false;
    $user = wp_get_current_user();
    if ($user->ID > 0) {
        $viewSubmitButton = true;
    }

    $tcd_membership_vars['template']         = $template;
    $tcd_membership_vars['imageArray']       = $imageArray;
    $tcd_membership_vars['post_id']          = $post_id;
    $tcd_membership_vars['post_title']       = $rowPostData->post_title;
    $tcd_membership_vars['post_content']     = $rowPostData->post_content;
    $tcd_membership_vars['imagePrice']       = $imagePrice;
    $tcd_membership_vars['auctionString']    = $auctionString;
    $tcd_membership_vars['binPrice']         = $binPrice;
    $tcd_membership_vars['auctionDate']      = $auctionDate;
    $tcd_membership_vars['auctionStartDate'] = $auctionStartDate;
    $tcd_membership_vars['auctionEndDate']   = $auctionEndDate;
    $tcd_membership_vars['extendAuction']    = $extendAuction;
    $tcd_membership_vars['viewSubmitButton'] = $viewSubmitButton;

    nocache_headers();
}
add_action('tcd_membership_action-confirm_post', 'tcd_membership_action_confirm_post');
