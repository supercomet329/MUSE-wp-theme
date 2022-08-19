<?php

/**
 * レポート送信API
 *
 * @param array $params
 * @return void
 */
function muse_api_report($params)
{

    $response = [];
    $error_message = [];
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

        $message = [];
        $report_post_id = false;
        if (isset($params['post_id']) && !empty($params['post_id'])) {
            $report_post_id = $params['post_id'];
            $post = get_post_by_post_id($report_post_id);
            if ($post[0]->post_type === 'photo') {
                $message[] = '画像ID:' . $report_post_id;
            } else if ($post[0]->post_type === 'post') {
                $message[] = '依頼ID:' . $report_post_id;
                $message[] = '依頼タイトル:' . $post[0]->post_title;
            }

        } else {
            $error_message[] = '通報の種類が不明です。';
        }

        if (!isset($params['sel_report']) || empty($params['sel_report'])) {
            $error_message[] = '通報の内容が不明です。';
        }

        $report_reason = '';
        if (isset($params['report_reason'])) {
            $report_reason = $params['report_reason'];
        }

        if (count($error_message) > 0) {
            throw new Exception('バリデートエラー');
        }

        $message[] = $report_reason;

        $subject   = '[MUSE]通報が御座いました。';
        $toMail = get_option('admin_email');
        $messages = implode("\n", $message);

        $result = wp_mail($toMail, $subject, $messages);
        if($result === 'true') {
            $error_message[] = 'メール送信失敗';
            throw new Exception('メール送信エラー');
        }

        $response = [
            'result' => true,
        ];
    } catch (Exception $e) {

        // エラー時の処理
        $response = [
            'result'        => false,
            'error_message' => $error_message,
        ];
        error_publish($e);
    }
    return $response;
}
