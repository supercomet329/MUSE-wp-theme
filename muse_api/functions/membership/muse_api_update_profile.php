<?php

/**
 * プロフィールの更新API
 *
 * @param array $params
 * @return array
 */
function muse_api_update_profile($params)
{
    global $wpdb;

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

        $userObj = get_userdata($user_id);

        // アイコン画像の場合 => アップロードファイルをbase_64データに変更
        $icon_url = false;
        if (isset($params['icon_file']) && !empty($params['icon_file'])) {
            $icon_file = $params['icon_file'];
            $icon_file = str_replace(' ', '+', $icon_file);
            $icon_file = preg_replace('#^data:image/\w+;base64,#i', '', $icon_file);
            $icon_file = base64_decode($icon_file);
            if (!empty($icon_file)) {
                $icon_url = upload_profile_file($icon_file, $user_id);
            }
        }

        $header_url = false;
        if (isset($params['header_image']) && !empty($params['header_image'])) {
            $header_image = $params['header_image'];
            $header_image = str_replace(' ', '+', $header_image);
            $header_image = preg_replace('#^data:image/\w+;base64,#i', '', $header_image);
            $header_image = base64_decode($header_image);
            if (!empty($header_image)) {
                $header_url = upload_profile_file($header_image, $user_id);
            }
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

function upload_profile_file($base64Data, $user_id)
{
    $file_dir = __DIR__ . '/../../../../uploads/user/' . $user_id;
    if (!file_exists($file_dir)) {
        mkdir($file_dir);
    }

    $extension = finfo_buffer(finfo_open(), $base64Data, FILEINFO_EXTENSION);
    $fileName  = 'api_' . substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 100) . '.' . $extension;
    file_put_contents($file_dir . '/' . $fileName, $base64Data);
    return muse_modify_profile_directory_uri($user_id, $fileName);
}
