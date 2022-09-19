<?php
// Add 2022/05/10 by H.Okabe
/**
 * 依頼している依頼の詳細画面
 *
 */
function tcd_membership_action_confirm_request()
{
    global $tcd_membership_vars;
    $typeReceived = 'received';
    $typeComplete = 'complete';
    nocache_headers();

    // リクエストIDの取得
    if (!isset($_REQUEST['request_id']) && empty($_REQUEST['request_id'])) {
        // リクエストIDが存在しない場合 => トップページに遷移
        wp_redirect('/');
        exit();
    }

    $request_id                        = $_REQUEST['request_id'];
    $tcd_membership_vars['request_id'] = $request_id;

    // ユーザー情報の取得
    $user_id = (int)get_current_user_id();

    // リクエストIDからリクエスト情報の取得
    $postsObj = get_post($request_id);
    if ($postsObj->post_status !== 'publish' || $postsObj->post_type !== 'post') {
        // 公開中のリクエストではない場合 => トップページに遷移
        wp_redirect('/');
        exit();
    }
    $author_id = $postsObj->post_author;

    // 発注ユーザー情報の取得
    $profileImageData = get_user_meta($author_id, 'profile_image', true);
    $profile_image    = get_template_directory_uri() . '/assets/img/icon/non_profile_image.png';
    if (!empty($profileImageData)) {
        $profile_image = $profileImageData;
    }

    // 発注ユーザーのディスプレイネームの取得
    $user                                 = get_userdata($author_id);
    $tcd_membership_vars['display_name']  = $user->data->display_name;

    // 発注ユーザーアイコン画像の取得
    $tcd_membership_vars['profile_image'] = $profile_image;

    // 依頼タイトルの取得
    $title        = $postsObj->post_title;

    $workTitle    = urldecode($postsObj->post_name);

    // 本文の取得
    $content      = $postsObj->post_content;

    // 構図の取得
    $composition   = get_post_meta($request_id, 'composition');
    $composition   = $composition[0];

    // キャラクターの取得
    $character     = get_post_meta($request_id, 'character');
    $character     = $character[0];

    // 受付依頼数の取得
    $orderQuantity = get_post_meta($request_id, 'orderQuantity');
    $orderQuantity = $orderQuantity[0];

    // 参考ファイルの取得
    $requestFileName = get_post_meta($request_id, 'requestFileName');
    $requestFileUrl  = get_post_meta($request_id, 'requestFileUrl');
    $requestFileName = $requestFileName[0];
    $requestFileUrl  = $requestFileUrl[0];

    // 参考URLの取得
    $refUrl          = get_post_meta($request_id, 'refUrl');
    $refUrl          = $refUrl[0];

    // 予算の取得
    $budget          = get_post_meta($request_id, 'budget');
    $budget          = $budget[0];

    // 応募期限の取得
    $appDeadlineDate      = get_post_meta($request_id, 'appDeadlineDate');
    $appDeadlineDateClass = new DateTime($appDeadlineDate[0]);
    $appDeadlineDateClass->setTimezone(new DateTimeZone('Asia/Tokyo'));
    $tcd_membership_vars['app_deadline_date'] = $appDeadlineDateClass->format('Y/m/d');

    $appDeadlineY = $appDeadlineDateClass->format('Y');
    $appDeadlineM = $appDeadlineDateClass->format('m');
    $appDeadlineD = $appDeadlineDateClass->format('d');

    // 納品希望日の取得
    $desiredDate  = get_post_meta($request_id, 'desiredDate');

    $strDesiredDate = '';
    $desiredDateY   = '';
    $desiredDateM   = '';
    $desiredDateD   = '';
    if (!empty($desiredDate)) {
        $desiredDateClass = new DateTime($desiredDate[0]);
        $desiredDateClass->setTimezone(new DateTimeZone('Asia/Tokyo'));
        $strDesiredDate   = $desiredDateClass->format('Y/m/d');

        $desiredDateY = $desiredDateClass->format('Y');
        $desiredDateM = $desiredDateClass->format('m');
        $desiredDateD = $desiredDateClass->format('d');
    }
    $tcd_membership_vars['desired_date'] = $strDesiredDate;

    $specifyUser = false;
    $minimumOrderPrice = 0;
    $approval_users = [];
    $specifyUserData  = get_post_meta($request_id, 'specify_user_id');
    if (!empty($specifyUserData)) {
        $approval_users[(int)$author_id]          = true;
        $approval_users[(int)$specifyUserData[0]] = true;
        $specifyUser = $specifyUserData[0];
        $minimumOrderPrice = (int)get_user_meta($specifyUserData[0], 'minimum_order_price', true);
    }
    $tcd_membership_vars['specifyUser'] = $specifyUser;
    $tcd_membership_vars['minimumOrderPrice'] = $minimumOrderPrice;
    $receivedResult = getMyWpTcdMembershipActionsByTypeAndPostIdAndUserId($typeReceived, $request_id);
    $completeResult = getMyWpTcdMembershipActionsByTypeAndPostIdAndUserId($typeComplete, $request_id);
    

    // POSTされた場合
    $error_messages = [];
    $viewFlag       = false;
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
                        wp_safe_redirect(get_tcd_membership_memberpage_url('confirm_request') . '&request_id=' . $request_id);
                        exit;
                    } else {
                        $error_messages['comment'] = 'コメントが未入力です。';
                    }
                } elseif ($request_type === $typeReceived) {
                    // 受注の場合
                    // DB登録
                    insert_tcd_membership_action($typeReceived, $user_id, $postsObj->post_author, $request_id);
                    wp_safe_redirect(get_tcd_membership_memberpage_url('confirm_request') . '&request_id=' . $request_id);
                    exit;
                } elseif ($request_type === $typeComplete) {

                    $message = '依頼を完了にできませんでした。';
                    if (!empty($receivedResult) && (int)$receivedResult->user_id === $user_id) {
                        // 依頼を完了にする場合
                        updateWpTcdMembershipActionsByPostId($typeComplete, $request_id);

                        // Twitterに投稿
                        $message = '依頼を完了しました。';
                        $uri     = '?memberpage=confirm_request&request_id=' . $request_id;
                        publishTwitter($message, $uri);
                        $message = '依頼を完了にしました。';
                    }

                    $_SESSSION['message'] = $message;
                    wp_safe_redirect(get_tcd_membership_memberpage_url('confirm_request') . '&request_id=' . $request_id);
                    exit;
                } elseif ($request_type === 'moddify') {

                    // DB登録
                    $appDeadlineY = $_POST['appDeadlineY'];
                    $appDeadlineM = $_POST['appDeadlineM'];
                    $appDeadlineD = $_POST['appDeadlineD'];
                    $desiredDateY = $_POST['desiredDateY'];
                    $desiredDateM = $_POST['desiredDateM'];
                    $desiredDateD = $_POST['desiredDateD'];

                    $composition     = $_POST['composition'];
                    $character       = $_POST['character'];
                    $orderQuantity   = $_POST['orderQuantity'];
                    $refUrl          = $_POST['refUrl'];
                    $budget          = $_POST['budget'];
                    $title           = $_POST['requestTitle'];
                    $content         = $_POST['content'];
                    $workTitle       = $_POST['workTitle'];

                    // リクエスト情報更新の場合
                    // バリデート
                    // 依頼タイトルの入力チェック
                    if (!isset($_POST['requestTitle']) || empty($_POST['requestTitle'])) {
                        $error_messages['requestTitle'] = '依頼タイトルは必須入力です。';
                    }

                    if (!isset($_POST['workTitle']) || empty($_POST['workTitle'])) {
                        $error_messages['workTitle'] = '依頼内容は必須入力です。';
                    }

                    if (!isset($_POST['content']) || empty($_POST['content'])) {
                        $error_messages['content'] = '本文は必須入力です。';
                    }

                    if (!isset($_POST['composition']) || empty($_POST['composition'])) {
                        $error_messages['composition'] = '構図は必須入力です。';
                    }

                    if (!isset($_POST['character']) || empty($_POST['character'])) {
                        $error_messages['character'] = 'キャラクターは必須入力です。';
                    }

                    if (isset($_POST['refUrl']) && !empty($_POST['refUrl'])) {
                        if (!filter_var($_POST['refUrl'], FILTER_VALIDATE_URL)) {
                            $error_messages['refUrl'] = 'URLの形式を御確認下さい。';
                        }
                    }

                    if (!isset($_POST['budget']) || empty($_POST['budget'])) {
                        $error_messages['budget'] = '予算は必須入力です。';
                    }

                    // $tcd_membership_vars['view_deadline'] = '';
                    $appDeadlineDate = false;
                    if (
                        isset($_POST['appDeadlineY']) || !empty($_POST['appDeadlineY']) ||
                        isset($_POST['appDeadlineM']) || !empty($_POST['appDeadlineM']) ||
                        isset($_POST['appDeadlineD']) || !empty($_POST['appDeadlineD'])
                    ) {

                        try {
                            $appDeadlineDateClass = new DateTime($_POST['appDeadlineY'] . '-' . $_POST['appDeadlineM'] . '-' . $_POST['appDeadlineD']);
                            $appDeadlineDate = $appDeadlineDateClass->format('Y-m-d');
                        } catch (Exception $e) {
                            $error_messages['appDeadline'] = '応募期限を正しく入力してください。';
                        }
                    } else {
                        $error_messages['appDeadline'] = '応募期限は必須入力です。';
                    }

                    $tcd_membership_vars['view_desired_date'] = '';
                    $desiredDate = false;
                    if (
                        isset($_POST['desiredDateY']) && !empty($_POST['desiredDateY']) ||
                        isset($_POST['desiredDateM']) && !empty($_POST['desiredDateM']) ||
                        isset($_POST['desiredDateD']) && !empty($_POST['desiredDateD'])
                    ) {
                        try {

                            $desiredDateClass = new DateTime($_POST['desiredDateY'] . '-' . $_POST['desiredDateM'] . '-' . $_POST['desiredDateD']);
                            $desiredDate = $desiredDateClass->format('Y-m-d');
                        } catch (Exception $e) {
                            $error_messages['appDeadline'] = '応募期限を正しく入力してください。';
                        }
                    }

                    // 画像アップロード処理
                    // $tcd_membership_vars['post_data']['request_file_url']  = '';
                    // $tcd_membership_vars['post_data']['request_file_name'] = '';
                    $requestFileUrl  = false;
                    $requestFileName = false;

                    if (!empty($_FILES['requestFile']['name'])) {
                        $extension = pathinfo($_FILES['requestFile']['name'], PATHINFO_EXTENSION);
                        $file_name = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 100) . '.' . $extension;
                        $uploaded_file = __DIR__ . '/../../upload_file/' . $file_name;
                        $result = move_uploaded_file($_FILES['requestFile']['tmp_name'], $uploaded_file);
                        if ($result) {
                            // $tcd_membership_vars['post_data']['request_file_url']  = get_template_directory_uri() . '/upload_file/' . $file_name;
                            // $tcd_membership_vars['post_data']['request_file_name'] = $_FILES['file']['name'];

                            $requestFileUrl  = get_template_directory_uri() . '/upload_file/' . $file_name;
                            $requestFileName = $_FILES['requestFile']['name'];
                        }
                    }

                    if (count($error_messages) <= 0) {

                        update_request($requestFileUrl, $requestFileName);
                        $_SESSION['messageUpdateConfirm'] = '更新が完了しました。';
                        wp_safe_redirect(get_tcd_membership_memberpage_url('confirm_request') . '&request_id=' . $request_id);
                        exit;
                    }
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
    $tcd_membership_vars['error_message'] = $error_messages;

    $tcd_membership_vars['composition']     = $composition;
    $tcd_membership_vars['character']       = $character;
    $tcd_membership_vars['orderQuantity']   = $orderQuantity;
    $tcd_membership_vars['refUrl']          = $refUrl;
    $tcd_membership_vars['budget']          = $budget;
    $tcd_membership_vars['requestFileName'] = $requestFileName;
    $tcd_membership_vars['requestFileUrl']  = $requestFileUrl;
    $tcd_membership_vars['title']           = $title;
    $tcd_membership_vars['workTitle']       = $workTitle;
    $tcd_membership_vars['content']         = $content;

    $tcd_membership_vars['appDeadlineY'] = $appDeadlineY;
    $tcd_membership_vars['appDeadlineM'] = $appDeadlineM;
    $tcd_membership_vars['appDeadlineD'] = $appDeadlineD;

    $tcd_membership_vars['desiredDateY'] = $desiredDateY;
    $tcd_membership_vars['desiredDateM'] = $desiredDateM;
    $tcd_membership_vars['desiredDateD'] = $desiredDateD;

    /**
     * 表示テンプレート切り替え
     * 
     * 表示条件
     * ・muse_confirm_request
     * => 登録ユーザーではない
     * => 受注済み
     * 
     * ・muse_confirm_request_modify
     * => 登録ユーザーかつ未受託 もしくは 依頼完了済
     */
    $template = 'muse_confirm_request';
    if (!empty($receivedResult) || !empty($completeResult)) {

        if (!empty($completeResult)) {
            $approval_users[(int)$completeResult->user_id] = true;
            $approval_users[(int)$completeResult->target_user_id] = true;
        }
    } else {
        // ステータスが受託済でも完了でもない かつ 登録ユーザーの場合 => 依頼編集表示に変更
        if ((int)$author_id === $user_id) {
            // 依頼登録ユーザーの場合 => 入力用テンプレート
            $template = 'muse_confirm_request_modify';
        }
    }

    /**
     * コメント表示フラグ
     * 
     * 表示条件
     * 1. 受注済み
     * 2, 受注したユーザー AND 発注ユーザー
     */
    $flgComment = false;
    if (!empty($receivedResult)) {
        if (!empty($receivedResult)) {
            $approval_users[(int)$receivedResult->user_id] = true;
            $approval_users[(int)$receivedResult->target_user_id] = true;
        }

        if (isset($approval_users[$user_id])) {
            // 依頼ユーザー or 受託ユーザーのみ表示
            $flgComment = true;
        }
    }

    $comments = [];
    if ($flgComment === TRUE) {
        // 受注されている時のみコメントを表示
        $comments = listCommentByPostId($request_id);
    }
    $tcd_membership_vars['comments'] = $comments;

    /**
     * 受託ボタン
     */
    $flgReceived = true;
    if (!empty($receivedResult) || !empty($completeResult)) {
        $flgReceived = false;
    }

    if ($user_id === (int)$author_id) {
        // 依頼ユーザーの場合
        $flgReceived = false;
    }

    /**
     * 非表示項目表示フラグ
     * 
     * 非表示項目
     * ・ 依頼タイトル
     * ・ キャラクター
     * ・ 受付依頼数
     * ・ 予算
     * ・ 応募期限
     *
     * 表示条件
     * ・ 受注済み
     * ・ 対象指名ユーザー
     */
    $flgView = false;
    if (isset($approval_users[$user_id])) {
        // 依頼ユーザー or 受託ユーザーのみ表示
        $flgView = true;
    }

    /**
     * 依頼完了ボタン
     * 
     * 表示条件
     * ・受注済
     */
    $flgComplete = false;
    if (!empty($receivedResult)) {
        if ($user_id === (int)$receivedResult->user_id) {
            $flgComplete = true;
        }
    }

    $tcd_membership_vars['flgReceived'] = $flgReceived;
    $tcd_membership_vars['flgView']     = $flgView;
    $tcd_membership_vars['flgComment']  = $flgComment;
    $tcd_membership_vars['flgComplete'] = $flgComplete;
    $tcd_membership_vars['template']    = $template;
}
add_action('tcd_membership_action-confirm_request', 'tcd_membership_action_confirm_request');

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

/**
 * リクエストの更新
 *
 * @param string $requestFileUrl
 * @param string $requestFileName
 * @return boolean
 */
function update_request($requestFileUrl, $requestFileName)
{
    $request_id   = $_POST['request_id'];
    $appDeadlineY = $_POST['appDeadlineY'];
    $appDeadlineM = $_POST['appDeadlineM'];
    $appDeadlineD = $_POST['appDeadlineD'];
    $appDeadlineClass = new DateTime($appDeadlineY . '-' . $appDeadlineM . '-' . $appDeadlineD);
    $appDeadlineClass->setTimezone(new DateTimeZone('Asia/Tokyo'));
    $appDeadlineDate = $appDeadlineClass->format('Y-m-d');

    $desiredDate = false;
    if (
        isset($_POST['desiredDateY']) && !empty($_POST['desiredDateY']) ||
        isset($_POST['desiredDateM']) && !empty($_POST['desiredDateM']) ||
        isset($_POST['desiredDateD']) && !empty($_POST['desiredDateD'])
    ) {
        try {

            $desiredDateClass = new DateTime($_POST['desiredDateY'] . '-' . $_POST['desiredDateM'] . '-' . $_POST['desiredDateD']);
            $desiredDateClass->setTimezone(new DateTimeZone('Asia/Tokyo'));
            $desiredDate = $desiredDateClass->format('Y-m-d');
        } catch (Exception $e) {
            $error_messages['appDeadline'] = '応募期限を正しく入力してください。';
        }
    }

    $composition     = $_POST['composition'];
    $character       = $_POST['character'];
    $orderQuantity   = $_POST['orderQuantity'];
    $refUrl          = $_POST['refUrl'];
    $budget          = $_POST['budget'];
    $title           = $_POST['requestTitle'];
    $content         = $_POST['content'];
    $workTitle       = $_POST['workTitle'];

    $my_post = [
        'ID'           => $request_id,
        'post_title'   => $title,
        'post_content' => $content,
        'post_name'    => $workTitle,
    ];

    // データベースにある投稿を更新する
    wp_update_post($my_post);
    update_post_meta($request_id, 'composition',      $composition);
    update_post_meta($request_id, 'character',        $character);
    update_post_meta($request_id, 'orderQuantity',    $orderQuantity);
    update_post_meta($request_id, 'refUrl',           $refUrl);
    update_post_meta($request_id, 'budget',           $budget);
    if (!empty($_FILES['requestFile']['name'])) {
        update_post_meta($request_id, 'requestFileName',  $requestFileName);
        update_post_meta($request_id, 'requestFileUrl',   $requestFileUrl);
    }
    update_post_meta($request_id, 'appDeadlineDate',  $appDeadlineDate);

    if ($desiredDate !== FALSE) {
        update_post_meta($request_id, 'desiredDate',  $desiredDate);
    }
}
