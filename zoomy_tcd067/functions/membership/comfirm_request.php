<?php
// Add 2022/05/10 by H.Okabe
/**
 * 依頼している依頼の詳細画面
 * TODO: 2022/05/11 メッセージのやり取りの対応
 */
function tcd_membership_action_comfirm_request()
{
    global $wpdb, $tcd_membership_vars;

    $request_id = $_REQUEST['request_id'];
    $rowResuestData = get_request($request_id);

    if (count($rowResuestData) <= 0) {
        wp_safe_redirect(user_trailingslashit(home_url()));
        exit;
    }

    if (!is_null($rowResuestData[0]->received_user_id)) {
        // すでに依頼を受けていた場合

        if (
            (int)$rowResuestData[0]->received_user_id !== (int)get_current_user_id() &&
            (int)$rowResuestData[0]->received_tareget_user_id !== (int)get_current_user_id()
        ) {
            wp_safe_redirect(user_trailingslashit(home_url()));
            exit;
        }
    }

    $user = wp_get_current_user();

    nocache_headers();
    if (!$user) {
        wp_safe_redirect(user_trailingslashit(home_url()));
        exit;
    }

    if ('POST' === $_SERVER['REQUEST_METHOD']) {
        // データがPOSTされた場合
        if ($_POST['request_type'] === 'contract') {
            // 受託の場合
            if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'tcd-membership-confirm_request-' . $request_id)) {
                // POSTトークンの取得がおかしい場合 => トップページに遷移
                wp_safe_redirect(user_trailingslashit(home_url()));
                exit();
            }
            // 受託した場合のwp_tcd_member_ship_actionsに登録
            insert_tcd_membership_action('received', get_current_user_id(), $rowResuestData[0]->post_author, $request_id);
        } else if ($_POST['request_type'] === 'message') {

            // コメントの場合
            if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'tcd-membership-confirm_message-' . $request_id)) {
                // POSTトークンの取得がおかしい場合 => トップページに遷移
                wp_safe_redirect(user_trailingslashit(home_url()));
                exit();
            }

            if (!empty($_POST['message'])) {
                // wp_commentの登録
                $data = [
                    'comment_post_ID' => $request_id,
                    'comment_content' => $_POST['message'],
                    'user_id' => get_current_user_id(),
                    'comment_date' => date('Y-m-d H:i:s'),
                    'comment_approved' => 1,
                ];
                wp_insert_comment($data);
            }
        }
        $redirect_url = get_tcd_membership_memberpage_url('comfirm_request') . '&request_id=' . $request_id;
        wp_safe_redirect($redirect_url);
        exit();
    }

    // テンプレート指定
    $tcd_membership_vars['template']  = 'muse_comfirm_request';

    $requestData = [];
    // 作品ID
    $post_id = $rowResuestData[0]->post_id;

    $requestData['post_id'] = $post_id;

    // 作品タイトル
    $requestData['post_name'] = $rowResuestData[0]->post_name;

    // 依頼タイトル
    $requestData['title'] = $rowResuestData[0]->post_title;

    // 依頼内容
    $requestData['content'] = $rowResuestData[0]->post_content;

    // 構図
    $requestData['composition'] = get_post_meta($post_id, 'composition', true);

    // キャラクター
    $requestData['character'] = get_post_meta($post_id, 'character', true);

    // 受付依頼数
    $requestData['orderQuantity'] = get_post_meta($post_id, 'orderQuantity', true);

    // 添付ファイル
    $requestData['requestFileName'] = get_post_meta($post_id, 'requestFileName', true);
    $requestData['requestFileUrl']  = get_post_meta($post_id, 'requestFileUrl', true);
    $filePathArray = explode('/', $requestData['requestFileUrl']);
    $fileName = end($filePathArray);
    $checkFile = __DIR__ . '/../../upload_file/' . $fileName;
    $requestData['requestFileFlag']  = exif_imagetype($checkFile);

    // 参考URL
    $requestData['refUrl']  = get_post_meta($post_id, 'refUrl', true);

    // 予算
    $requestData['budget']  = get_post_meta($post_id, 'budget', true);

    // 特記事項
    $requestData['specialNotes']  = get_post_meta($post_id, 'specialNotes', true);

    // 応募期限
    $appDeadlineDate = get_post_meta($post_id, 'appDeadlineDate', true);
    $appDeadClass = new DateTime($appDeadlineDate);
    $requestData['appDeadlineDate']  = $appDeadClass->format('Y/m/d');

    // 納品希望日
    $requestData['desiredDate']  = false;
    $desiredDate = get_post_meta($post_id, 'desiredDate', true);
    if (!empty($desiredDate)) {
        $desiredDateClass = new DateTime($desiredDate);
        $desiredDate = $desiredDateClass->format('Y/m/d');
    }
    $requestData['desiredDate']  = $desiredDate;

    // プロフィールイメージ
    $author_id = $rowResuestData[0]->post_author;
    $profileImageData = get_user_meta($author_id, 'profile_image', true);
    $profile_image = get_template_directory_uri() . '/assets/img/icon/non_profile_image.png';
    if (!empty($profileImageData)) {
        $profile_image = $profileImageData;
    }
    $requestData['profile_image'] = $profile_image;

    $author = get_user_by('id', $author_id);
    $requestData['display_name'] = $author->data->display_name;
    $requestData['author_id'] = $author_id;

    $viewReceivedButton = false;
    if ((int)$author_id !== (int)$user->ID && !is_null(get_current_user())) {
        $viewReceivedButton = true;
    }

    if (!is_null($rowResuestData[0]->received_user_id)) {
        // 依頼を受けている場合 => ボタンを表示しない
        $viewReceivedButton = false;
    }
    $requestData['viewReceivedButton'] = $viewReceivedButton;

    $tcd_membership_vars['requestData']  = $requestData;
    $tcd_membership_vars['list_comment'] = listComment( $request_id );
}
add_action('tcd_membership_action-comfirm_request', 'tcd_membership_action_comfirm_request');

/**
 * wp_commentの取得
 *
 * @param [type] $rquest_id
 * @return void
 */
function listComment($rquest_id) {
    $params = [
        'post_id' => $rquest_id,
        'orderby' => [
            'ID' => 'ASC',
        ],
    ];
    $commentArray = get_comments( $params );

    $messageArray = [];
    foreach($commentArray as $commentOne) {
        $dataClass = new DateTime($commentOne->comment_date);

        $profileImageData = get_user_meta($commentOne->user_id, 'profile_image', true);
        $profile_image = get_template_directory_uri() . '/assets/img/icon/non_profile_image.png';
        if (!empty($profileImageData)) {
            $profile_image = $profileImageData;
        }

        $messageArray[$dataClass->format('Ymd 00:00:00')][] = [
            'comment'       => $commentOne->comment_content,
            'comment_date'  => $dataClass->format('H:i'),
            'user_id'       => $commentOne->user_id,
            'profile_image' => $profile_image,
        ];
    }

    return $messageArray;
}
