<?php
// Add 2022/05/10 by H.Okabe
/**
 * 投稿画像コメントページ
 */
function tcd_membership_action_post_comment()
{
    global $tcd_membership_vars;
    nocache_headers();

    // $_REQUESTでのpost_idの取得
    if (!isset($_REQUEST['post_id']) || empty($_REQUEST['post_id'])) {
        // 取得できない場合 => トップページにリダイレクト
        wp_safe_redirect('/');
        exit();
    }
    $post_id = $_REQUEST['post_id'];
    $tcd_membership_vars['post_id'] = $post_id;

    $rowPostData = get_post($post_id);

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

    // ユーザー存在チェック
    $user_id = get_current_user_id();

    $viewSubmitButton = false;
    $user = wp_get_current_user();
    if ($user->ID > 0) {
        $viewSubmitButton = true;
    }

    // 投稿ボタンの表示 / 非表示
    $flg_submit_flag = false;
    if ((int)$user_id > 0) {
        // user_idが取得できる場合は投稿ボタンを表示
        $flg_submit_flag = true;
    }
    $tcd_membership_vars['flg_submit_flag']  = $flg_submit_flag;

    // コメントがPOSTされた場合の処理
    $error_message = '';
    if ('POST' === $_SERVER['REQUEST_METHOD']) {
        if (isset($_POST['nonce']) && wp_verify_nonce($_POST['nonce'], 'tcd_membership_action-post_comment')) {

            // 文字列のバリデート
            $message  = '';
            if (isset($_POST['message'])) {
                $message  = preg_replace("/( |　)/", "", $_POST['message']);
            }

            if (!empty($message)) {

                // 投稿者のIPアドレスを取得
                $ip = $_SERVER['REMOTE_ADDR'];
                if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    // WAF使っていた時とかの対応
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                }

                $user = get_userdata($user_id);
                // wp_commentの登録
                $data = [
                    'comment_post_ID'      => $post_id,
                    'comment_content'      => $_POST['message'],
                    'comment_author_IP'    => $ip,
                    'user_id'              => get_current_user_id(),
                    'comment_date'         => date('Y-m-d H:i:s'),
                    'comment_author_email' => $user->user_email,
                    'comment_approved'     => 1,
                ];
                wp_insert_comment($data);

                // DB登録成功時(同ページへリダイレクト)
                wp_safe_redirect(esc_url(get_tcd_membership_memberpage_url('post_comment')) . '&post_id=' . $post_id);
                exit();
            } else {
                $error_message = 'コメントは必須入力です。';
            }
        }
    }

    // 画像情報の取得
    $post_image = get_post_meta($post_id, 'main_image', true);
    if (empty($post_image)) {
        wp_safe_redirect('/');
        exit();
    }
    $post_image_array = [];
    $post_image_array[] = $post_image;

    $main_image2 = get_post_meta($post_id, 'main_image2', true);
    if (!empty($main_image2)) {
        $post_image_array[] = $main_image2;
    }

    $main_image3 = get_post_meta($post_id, 'main_image3', true);
    if (!empty($main_image3)) {
        $post_image_array[] = $main_image3;
    }

    $main_image4 = get_post_meta($post_id, 'main_image4', true);
    if (!empty($main_image4)) {
        $post_image_array[] = $main_image4;
    }
    $tcd_membership_vars['post_image_array']  = $post_image_array;

    // 画像のコメント一覧の取得(wp_comments)
    $array_comment = muse_list_comment($post_id);
    $tcd_membership_vars['comment']  = $array_comment;

    $stringSaleType = false;
    if ($saleType === 'sale') {
        $stringSaleType = 'NFT販売';
        if ($selectAuction === 'Auction') {
            $stringSaleType = 'オークション販売';
        }
    }

    // テンプレートの設定
    $tcd_membership_vars['template']       = 'muse_post_comment';
    $tcd_membership_vars['error_message']  = $error_message;

    $tcd_membership_vars['stringSaleType']   = $stringSaleType;
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
}
add_action('tcd_membership_action-post_comment', 'tcd_membership_action_post_comment');

/**
 * 投稿のコメントを取得して一覧を生成
 *
 * @param int $post_id
 * @return array
 */
function muse_list_comment($post_id)
{
    $args = array(
        'post_id' => $post_id,
        'order'   => 'DESC',
    );
    $row_comment = get_comments($args);

    $list_comment = [];
    foreach ($row_comment as $one_comment) {

        if ((int)$one_comment->user_id <= 0) {
            // ユーザーIDが0の場合落とす
            continue;
        }

        $comment = [];

        // ユーザーアイコンの取得
        $profileImageData  = get_user_meta($one_comment->user_id, 'profile_image', true);
        $profile_image     = get_template_directory_uri() . '/assets/img/icon/non_profile_image.png';
        if (!empty($profileImageData)) {
            $profile_image = $profileImageData;
        }
        $comment['profile_image'] = $profile_image;

        $user = get_userdata($one_comment->user_id);
        // ユーザーネームの取得
        $comment['display_name'] = $user->data->display_name;

        // コメントの取得
        $comment['comment'] = $one_comment->comment_content;

        // コメント投稿日時の取得
        $dateClass = new DateTime($one_comment->comment_date);
        $dateClass->setTimezone(new DateTimeZone('Asia/Tokyo'));
        $comment['date'] = $dateClass->format('Y/m/d H:i');
        $list_comment[] = $comment;
    }

    return $list_comment;
}
