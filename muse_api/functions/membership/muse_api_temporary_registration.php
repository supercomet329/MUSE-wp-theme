<?php

/**
 * 仮登録の対応
 *
 * @param [type] $params
 * @return void
 */
function muse_api_temporary_registration($params)
{
    global $wpdb;

    $response = [];
    try {

        // メールアドレスの必須チェック
        if (!isset($params['mail_address']) || empty($params['mail_address'])) {
            $response[] = 'メールアドレスは必須入力です。';
        }

        // メールアドレスからユーザーが存在しないか?チェック
        if (count($response) <= 0) {
            if (!is_email($params['mail_address'])) {
                $response[] = 'メールアドレスを正しく入力して下さい。';
            }
        }

        if (count($response) <= 0) {

            if (email_exists($params['mail_address'])) {
                // 登録済のメールアドレスの場合
                $response[] = '登録済のメールアドレスです。';
            }
        }

        if (count($response) > 0) {
            throw new Exception('バリデートエラー');
        }

        $action_id = insert_tcd_membership_action('registration', 0, 0, 0);
        if ($action_id) {
            // パスワードは可能なら暗号化
            // 重複しないトークン生成
            do {
                $registration_token = wp_generate_password(20, false, false);
                $wpdb->flush();
            } while (get_tcd_membership_meta_by_meta('registration_token', $registration_token));

            $registration_account_url = add_query_arg('token', rawurlencode($registration_token), get_tcd_membership_memberpage_url('registration_account'));

            // メタ保存
            update_tcd_membership_action_meta($action_id, 'registration_email', $params['mail_address']);
            update_tcd_membership_action_meta($action_id, 'registration_password', substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 8));
            update_tcd_membership_action_meta($action_id, 'registration_token', $registration_token);
            update_tcd_membership_action_meta($action_id, 'registration_expire', current_time('timestamp', true) + DAY_IN_SECONDS);

            // メール送信
            $replaces = [
                '[user_email]' => $params['mail_address'],
                '[registration_account_url]' => $registration_account_url
            ];

            if (!tcd_membership_mail('registration', $params['mail_address'], $replaces)) {
                $error_messages[] = __('Failed to send mail.', 'tcd-w');
                delete_tcd_membership_action_by_id($action_id);
            }

            $response = [
                'result' => true,
            ];
        }
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
