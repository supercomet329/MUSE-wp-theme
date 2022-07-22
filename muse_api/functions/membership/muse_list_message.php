<?php

/**
 *
 * メッセージ一覧の取得
 *
 * @param array $params
 * @return array
 */
function api_get_messages($params)
{
    // 変数を初期化
    $response = [];
    try {
        if (isset($params['access_token']) && !empty($params['access_token'])) {
            $user_id = check_login($params['access_token']);
            if (!$user_id) {
                $response[] = '対象のユーザーが存在しません';
                throw new Exception('バリデートエラー');
            }
        } else {
            $response[] = '対象のユーザーが存在しません';
            throw new Exception('バリデートエラー');
        }

        // メッセージの一覧の取得
        $args = [
            'user_id' => $user_id,
        ];
        $listMessage = get_tcd_membership_messages_latest_list($args);
        $tcd_membership_vars['list_message'] = $listMessage;

        foreach ($tcd_membership_vars['list_message'] as $one_message) {
            $profile_image = 'http://localhost.nft.info/wp-content/themes/muse_template/assets/img/icon/non_profile_image.png';
            if ((int)get_current_user_id() !== (int)$one_message->sender_user_id) {
                // 送信者と自分が違う場合 => 表示させるメンバー情報は送信者
                $user_id = $one_message->sender_user_id;
            } else {
                // 送信者と自分が同じ場合 => 表示させるメンバー情報は受信者
                $user_id = $one_message->recipient_user_id;
            }

            $userData = get_userdata($user_id);
            $profileImageData = get_user_meta($user_id, 'profile_image', true);

            $dateTimeClass = new DateTime($one_message->sent_gmt);
            $display_name = $userData->display_name;
            if (!empty($profileImageData)) {
                $profile_image = $profileImageData;
            }

            $content[] = [
                'author_image' => $profile_image,
                'display_name'   => $display_name,
                'message'   => $one_message->message,
                'user_id' => $user_id,
                'send_day'   => esc_attr($dateTimeClass->format('Y/m/d')),
                'send_time'   => esc_attr($dateTimeClass->format('H:i')),
            ];
        }

        // レスポンスを返す
        $response = [
            'result'        => true,
            'content'       => $content,
        ];

    } catch (Exception $e) {
        // エラー時の処理
        $response = [
            'result'        => false,
            'error_message' => $response,
        ];
        error_publish($e);
    }
    return $response;
}
