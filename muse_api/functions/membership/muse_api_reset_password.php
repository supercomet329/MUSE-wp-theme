<?php

function muse_api_reset_password($params)
{
    global $dp_options, $tcd_membership_vars, $wpdb;

    $formdata = wp_unslash($params);

    $user = null;

    $response = [];
    try {

        // メールアドレスの必須チェック
        if (!isset($params['mail_address']) || empty($params['mail_address'])) {
            $response[] = 'メールアドレスは必須入力です。';
        }

        if (count($response) <= 0) {

            if ( ! is_email( $params['mail_address'] ) ) {
                $response[] = 'メールアドレスを正しく入力して下さい。';
            }
        }


        if (count($response) > 0) {
            throw new Exception('バリデートエラー');
        }

        $user = get_user_by('email', $params['mail_address']);

        // 重複しないトークン生成
        $sql = "SELECT user_id FROM {$wpdb->usermeta} WHERE meta_key = %s AND meta_value = %s LIMIT 1";
        do {
            $reset_password_token = wp_generate_password(20, false, false);
            $wpdb->flush();
        } while ($wpdb->get_var($wpdb->prepare($sql, 'reset_password_token', $reset_password_token)));

        // トークン・有効期限（24時間）をユーザーメタに保存
        update_user_meta($user->ID, 'reset_password_token', $reset_password_token);
        update_user_meta($user->ID, 'reset_password_token_expire', current_time('timestamp', true) + DAY_IN_SECONDS);

        $replaces = [
            '[user_email]'         => $params['mail_address'],
            '[user_display_name]'  => $user->display_name,
            '[user_name]'          => $user->display_name,
            '[reset_password_url]' => add_query_arg('token', $reset_password_token, get_tcd_membership_memberpage_url('reset_password'))
        ];
        tcd_membership_mail('reset_password', $params['mail_address'], $replaces);

        $response = [
            'result' => true,
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
