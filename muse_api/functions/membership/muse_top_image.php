<?php

/**
 *
 * トップページ画像の取得
 *
 * @param array $params
 * @return array
 */
function api_get_top_image($params)
{
    // 変数を初期化
    $response = [];
    try {
        $user_id = "";
        // アクセストークンが渡されていて、間違っている場合はエラーを返す
        if (isset($params['access_token']) && !empty($params['access_token'])) {
            $user_id = check_login($params['access_token']);
            if (!$user_id) {
                $response[] = '対象のユーザーが存在しません';
                throw new Exception('バリデートエラー');
            }
        }
        // 投稿記事一覧を取得
        $list_photo = list_author_post($user_id, 'photo');
        // 投稿記事一覧から「投稿ID、投稿日時、投稿者プロフィールアイコン、投稿者名、投稿画像、いいね」を取得
        foreach ($list_photo as $one_photo) {
            $user_info = get_userdata($one_photo->post_author);
            $profileImageData = get_user_meta($user_info->ID, 'profile_image', true);
            $dataClass = new DateTime($one_photo->post_modified);

            $profile_image = 'http://localhost.nft.info/wp-content/themes/muse_template/assets/img/icon/non_profile_image.png';
            if (!empty($profileImageData)) {
                $profile_image = $profileImageData;
            }

            // 「投稿ID、投稿日時、投稿者プロフィールアイコン、投稿者名、投稿画像、いいね」を定義
            $content[] = [
                    'post_id'       => $one_photo->post_id,
                    'post_date'     => $dataClass->format('Y/m/d H:i'),
                    'author_image'  => $profile_image,
                    'author_name'   => $user_info->display_name,
                    'post_image'    => $one_photo->meta_value,
                    'like'          => is_liked($one_photo->post_id, false) ? true : false
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
