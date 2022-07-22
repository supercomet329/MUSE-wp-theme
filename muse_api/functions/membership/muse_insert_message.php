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
            $image_parts = explode(";base64,", $params['image']);
            $image_type_aux = explode("image/", $image_parts[0]); // ファイルの型を取り出す
            $image_type = $image_type_aux[1]; // ファイルの型を取り出す
            $image_base64 = base64_decode($image_parts[1]); // 画像データとして取り出す
            $file_name = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 100) . '.' . '.png';
            $uploaded_file = '/home/kusanagi/nft/DocumentRoot/wp-content/themes/muse_template/functions/membership' . '/../../upload_file/' . $file_name;

            $result = file_put_contents($uploaded_file, $image_base64); // ファイルを保存
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
