<?php

/**
 *
 * メッセージ一覧の取得
 *
 * @param array $params
 * @return array
 */
function api_get_detail_messages($params)
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

        if (!$params['target_user_id']) {
            $response[] = '対象の送信先が存在しません';
            throw new Exception('バリデートエラー');
        }

        // 変数を初期化
        global $tcd_membership_vars;
        $user = get_user_by('id', $user_id);
        $target_user_id = $params['target_user_id'];
        $list_message = [];
        $list_follow  = false;
        $message_flag = false;

        if (!is_null($target_user_id)) {
            // 送信先のユーザー情報できた場合
            $args = [
                'user_id' => $user_id,
                'target_user_id' => $target_user_id,
            ];
            $row_message = get_tcd_membership_messages_user_messages($args);
            $display_user = get_userdata($target_user_id);

            foreach ($row_message as $one_message) {
                $message_id = $one_message->id;
                $dateClass  = new DateTime($one_message->sent_gmt);
                $day        = $dateClass->format('Ymd 00:00:00');

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
            read_on_message($target_user_id);
            $message_flag = true;
        }

        $tcd_membership_vars['list_follow'] = $list_follow;
        $tcd_membership_vars['list_message'] = $list_message;
        $tcd_membership_vars['title_user_name'] = $display_user->display_name;
        $tcd_membership_vars['target_user_id']  = $target_user_id;
        $tcd_membership_vars['message_flag']    = $message_flag;

        foreach ($tcd_membership_vars['list_message'] as $date => $row_message) {
            $viewDate = new DateTime($date);
            $send_date = esc_attr($viewDate->format('Y/m/d'));

            foreach ($row_message as $one_message) {
                // ユーザー情報の取得
                $profileImageData = get_user_meta($one_message['sender_user_id'], 'profile_image', true);
                $profile_image = 'http://localhost.nft.info/wp-content/themes/muse_template/assets/img/icon/non_profile_image.png';
                if (!empty($profileImageData)) {
                    $profile_image = $profileImageData;
                }
                $send_time = esc_attr($one_message['send_time']);
                $message = '';
                $image = '';
                if (!$one_message['image_flag']) {
                    $message = nl2br($one_message['message']);
                }
                if ($one_message['image_flag']) {
                    $image = esc_html($one_message['message']);
                }
                $content[] = [
                    $send_date => [
                        'user_id' => $one_message['sender_user_id'],
                        'display_name'   => $display_user->display_name,
                        'image'   => $image,
                        'message'   => $message,
                        'send_time'   => $send_time,
                        'profile_image'   => $profile_image,
                    ]
                ];
            }
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
