<?php
// Add 2022/05/10 by H.Okabe
/**
 * 依頼している依頼の詳細画面
 * TODO: 2022/05/11 メッセージのやり取りの対応
 */
function tcd_membership_action_comfirm_request()
{
    global $tcd_membership_vars;
    nocache_headers();

    // リクエストIDの取得
    if (!isset($_REQUEST['request_id']) && empty($_REQUEST['request_id'])) {
        // リクエストIDが存在しない場合 => トップページに遷移
        wp_redirect('/');
        exit();
    }

    $request_id = $_REQUEST['request_id'];
    $tcd_membership_vars['request_id'] = $request_id;

    // ユーザー情報の取得
    $user_id = get_current_user_id();

    // リクエストIDからリクエスト情報の取得
    $postsObj = get_post($request_id);
    if ($postsObj->post_status !== 'publish' || $postsObj->post_type !== 'request') {
        // 公開中のリクエストではない場合 => トップページに遷移
        wp_redirect('/');
        exit();
    }
    $author_id = $postsObj->post_author;

    // POSTされた場合
    $error_message = [];
    if ('POST' == $_SERVER['REQUEST_METHOD']) {

        if (!empty($_POST['nonce']) || wp_verify_nonce($_POST['nonce'], 'tcd-membership-confirm_message-' . $request_id)) {

            if (isset($_POST['request_type'])) {
                $request_type = $_POST['request_type'];

                // コメントの場合
                if ($request_type === 'comment') {
                    // バリデート
                    if (isset($_POST['comment']) && !empty($_POST['comment'])) {
                        // DB登録
                        // 投稿者のIPアドレスを取得
                        $ip = $_SERVER['REMOTE_ADDR'];
                        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                            // WAF使っていた時とかの対応
                            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                        }

                        $user = get_userdata($user_id);
                        // wp_commentの登録
                        $data = [
                            'comment_post_ID'      => $request_id,
                            'comment_content'      => $_POST['comment'],
                            'comment_author_IP'    => $ip,
                            'user_id'              => $user_id,
                            'comment_date'         => date('Y-m-d H:i:s'),
                            'comment_author_email' => $user->user_email,
                            'comment_approved'     => 1,
                        ];
                        wp_insert_comment($data);
                    } else {
                        $error_message['comment'] = 'コメントが未入力です。';
                    }
                } elseif ($request_type === 'received') {
                    // 受注の場合
                    // DB登録
                    insert_tcd_membership_action('received', $user_id, $postsObj->post_author, $request_id);
                } elseif ($request_type === 'moddify') {

                    // リクエスト情報更新の場合
                    // バリデート
                    // DB登録

                } else {
                    // nonceが一致しない場合 => トップページに遷移
                    wp_safe_redirect(home_url('/'));
                    exit;
                }
            }
        } else {
            // nonceが一致しない場合 => トップページに遷移
            wp_safe_redirect(home_url('/'));
            exit;
        }
    }
    $tcd_membership_vars['error_message'] = $error_message;

    // リクエスト作成者の確認
    // リクエスト作成者とログインユーザーが違う場合 => 確認用テンプレートへ
    $template = 'muse_comfirm_request';
    if ($author_id === $user_id) {
        // リクエスト作成者とログインユーザーが同じ場合 => 入力用テンプレートへ
        $template = 'muse_comfirm_request_modify';
    }
    $tcd_membership_vars['template'] = $template;

    // 受注済か確認
    // 受注済みの場合受注ユーザーの取得
    $comment_flag = false;
    $receivedData = get_memberShipActionsByPostId($request_id, 'received');
    if (count($receivedData) > 0) {
        // 受注済の場合は作成者でも確認用テンプレート
        $template = 'muse_comfirm_request';
        $receivedData = $receivedData[0];
        $approval_users = [
            $receivedData->user_id        => true,
            $receivedData->target_user_id => true,
        ];

        // ログインユーザーが発注ユーザーでも受注ユーザーでもない場合
        if (!isset($approval_users[$user_id])) {
            // 受注済みかつ リクエスト作成者とログインユーザーが違う場合 => トップページに遷移
            wp_redirect('/');
            exit();
        }
        $comment_flag = true;
    }
    $tcd_membership_vars['comment_flag'] = $comment_flag;

    $my_order_flag = false;
    if((int)$user_id !== (int)$postsObj->post_author) {
        $my_order_flag = true;
    }
    $tcd_membership_vars['my_order_flag'] = $my_order_flag;

    // 発注ユーザー情報の取得
    $profileImageData = get_user_meta($author_id, 'profile_image', true);
    $profile_image = get_template_directory_uri() . '/assets/img/icon/non_profile_image.png';
    if (!empty($profileImageData)) {
        $profile_image = $profileImageData;
    }

    // 発注ユーザーのディスプレイネームの取得
    $user = get_userdata($author_id);
    $tcd_membership_vars['display_name']    = $user->data->display_name;

    // 発注ユーザーアイコン画像の取得
    $tcd_membership_vars['profile_image']   = $profile_image;

    // 依頼タイトルの取得
    $tcd_membership_vars['title']           = $postsObj->post_title;

    // 本文の取得
    $tcd_membership_vars['content']         = $postsObj->post_content;

    // 構図の取得
    $composition = get_post_meta($request_id, 'composition');
    $tcd_membership_vars['composition']     = $composition[0];

    // キャラクターの取得
    $character = get_post_meta($request_id, 'character');
    $tcd_membership_vars['character']       = $character[0];

    // 受付依頼数の取得
    $orderQuantity = get_post_meta($request_id, 'orderQuantity');
    $tcd_membership_vars['orderQuantity']   = $orderQuantity[0];

    // 参考ファイルの取得
    $requestFileName = get_post_meta($request_id, 'requestFileName');
    $requestFileUrl  = get_post_meta($request_id, 'requestFileUrl');
    $tcd_membership_vars['requestFileName'] = $requestFileName[0];
    $tcd_membership_vars['requestFileUrl']  = $requestFileUrl[0];

    // 参考URLの取得
    $refUrl = get_post_meta($request_id, 'refUrl');
    $tcd_membership_vars['refUrl'] = $refUrl[0];

    // 予算の取得
    $budget = get_post_meta($request_id, 'budget');
    $tcd_membership_vars['budget'] = $budget[0];

    // 応募期限の取得
    $appDeadlineDate                        = get_post_meta($request_id, 'appDeadlineDate');
    $appDeadlineDateClass                   = new DateTime($appDeadlineDate[0]);
    $appDeadlineDateClass->setTimezone(new DateTimeZone('Asia/Tokyo'));
    $tcd_membership_vars['app_deadline_date'] = $appDeadlineDateClass->format('Y/m/d');

    // 納品希望日の取得
    $desiredDate  = get_post_meta($request_id, 'desiredDate');

    $strDesiredDate = '';
    if (!empty($desiredDate)) {
        $desiredDateClass = new DateTime($desiredDate[0]);
        $desiredDateClass->setTimezone(new DateTimeZone('Asia/Tokyo'));
        $strDesiredDate   = $appDeadlineDateClass->format('Y/m/d');
    }
    $tcd_membership_vars['desired_date'] = $strDesiredDate;

    // コメント欄の取得
    $comments = [];
    if ($comment_flag === TRUE) {
        // 受注されている時のみコメントを表示
        $comments = listCommentByPostId($request_id);
    }
    $tcd_membership_vars['comments'] = $comments;
}
add_action('tcd_membership_action-comfirm_request', 'tcd_membership_action_comfirm_request');

/**
 * コメントの一覧の取得
 *
 * @param int $request_id
 * @return array
 */
function listCommentByPostId($request_id)
{
    $args = [
        'post_id' => $request_id,
        'order'   => 'DESC',
    ];
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
