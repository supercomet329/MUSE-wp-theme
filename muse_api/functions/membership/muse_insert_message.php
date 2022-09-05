<?php

/**
 *
 * メッセージの登録
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

        if (!empty($params['image'])) {
            // 画像アップロードの場合
            $postImage = $params['image'];
            $postImage = str_replace(' ', '+', $postImage);
            $postImage = preg_replace('#^data:image/\w+;base64,#i', '', $postImage);
            $imageData = base64_decode($postImage);

            // 拡張子の取得
            $extension     = finfo_buffer(finfo_open(), $imageData, FILEINFO_EXTENSION);
            $file_name     = 'api_' . substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 100) . '.' . $extension;
            $uploaded_file = muse_modify_template_directory_upload_dir() . $file_name;
            $result        = file_put_contents($uploaded_file, $imageData);

            if ($result) {
                $message = muse_modify_template_directory_uri() . '/upload_file/' . $file_name;
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
