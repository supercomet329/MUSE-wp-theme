<?php

/**
 *
 * メッセージ一覧の取得
 *
 * @param array $params
 * @return array
 */
function api_insert_message($params)
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
        $target_user_id = $params['target_user_id'];

        if (!empty($_FILES['file']['name'])) {
            // 画像アップロードの場合
            $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $file_name = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 100) . '.' . $extension;
            $uploaded_file = '/home/kusanagi/nft/DocumentRoot/wp-content/themes/muse_template/functions/membership' . '/../../upload_file/' . $file_name;
            $result = move_uploaded_file($_FILES['file']['tmp_name'], $uploaded_file);
            if ($result) {
                $message  = 'http://localhost.nft.info/wp-content/themes/muse_template' . '/upload_file/' . $file_name;
            } else {
                $error_messages[] = 'ファイルのアップロードに失敗しました。';
            }
        } elseif (!empty($params['message'])) {
            // メッセージの場合
            $message = $params['message'];
        }

        if (tcd_membership_messages_add_message($user_id, $target_user_id, $message)) {
            $content = api_get_detail_messages($params);
            $key = array_key_last($content['content']);
            $last_content = [$content['content'][$key]];
        }

        $response = [
            'result' => true,
            'content' => $last_content,
            'message' => $message,
            'image' => $_FILES['file']['name'],
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
