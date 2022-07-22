<?php
// Add 2022/06/03 by H.Okabe
/**
 * メッセージ詳細
 */
function tcd_membership_action_detail_message()
{
    global $tcd_membership_vars;

    $user = wp_get_current_user();
    $target_user_id = $_REQUEST['user_id'];

    if (!$user) {
        wp_safe_redirect(user_trailingslashit(home_url()));
        exit;
    }

    if ('POST' == $_SERVER['REQUEST_METHOD']) {

        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'tcd_membership_message_request')) {
            // POSTトークンの取得がおかしい場合 => トップページに遷移
            wp_safe_redirect(user_trailingslashit(home_url()));
            exit();
        }

        if (!empty($_FILES['file']['name'])) {
            // 画像アップロードの場合
            $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $file_name = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 100) . '.' . $extension;
            $uploaded_file = __DIR__ . '/../../upload_file/' . $file_name;
            $result = move_uploaded_file($_FILES['file']['tmp_name'], $uploaded_file);
            if ($result) {
                $message  = get_template_directory_uri() . '/upload_file/' . $file_name;
            } else {
                $error_messages[] = 'ファイルのアップロードに失敗しました。';
            }
        } else {
            // メッセージの場合
            $message = $_POST['message'];
        }
        tcd_membership_messages_add_message(get_current_user_id(), $target_user_id, $message);
        $redirect = get_tcd_membership_memberpage_url('detail_message') . '&user_id=' . $target_user_id;
        wp_safe_redirect($redirect);
        exit;
    }

    $list_message = [];
    $list_user    = false;
    $message_flag = false;
    if (!is_null($target_user_id)) {
        // 送信先のユーザー情報できた場合
        $args = [
            'user_id' => get_current_user_id(),
            'target_user_id' => $target_user_id,

        ];
        $row_message = get_tcd_membership_messages_user_messages($args);
        $display_user = get_userdata($target_user_id);

        foreach ($row_message as $one_message) {
            $message_id = $one_message->id;
            $dateClass = new DateTime($one_message->sent_gmt);
            $day       = $dateClass->format('Ymd 00:00:00');

            $message = $one_message->message;
            $imgFlag = false;
            if (preg_match('/.gif|.png|.jpg|.jpeg/', $message) === 1) {
                $imgFlag = true;
            }

            $list_message[$day][] = [
                'sender_user_id' => $one_message->sender_user_id,
                'message'        => $one_message->message,
                'image_flag'     => $imgFlag,
                'send_time'      => $dateClass->format('H:i'),
            ];
        }
        // tcd_membership_messages_recipient_read($message_id);
        read_on_message($target_user_id);
        $message_flag = true;
    } else {
        // 送信先のユーザー情報が取得できない場合
        // フォローしているユーザーの一覧を取得
        $list_user = muse_list_user();
        if(count($list_user) > 0) {
            $message_flag = true;
        }
    }

    $tcd_membership_vars['list_user'] = $list_user;
    $tcd_membership_vars['template']  = 'muse_detail_message';
    $tcd_membership_vars['list_message'] = $list_message;
    $tcd_membership_vars['title_user_name'] = $display_user->display_name;
    $tcd_membership_vars['target_user_id']  = $target_user_id;
    $tcd_membership_vars['message_flag']    = $message_flag;
}
add_action('tcd_membership_action-detail_message', 'tcd_membership_action_detail_message');
