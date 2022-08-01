<?php

/**
 *
 * フォロワー一覧の取得
 *
 * @param array $params
 * @return array
 */
function api_get_followers($params)
{
    // 変数を初期化
    $response = [];
    try {
        if (isset($params['user_id'])) {
            $user_id = $params['user_id'];
        } else if (isset($params['access_token']) && !empty($params['access_token'])) {
            $user_id = check_login($params['access_token']);
            if (!$user_id) {
                $response[] = '対象のユーザーが存在しません';
                throw new Exception('バリデートエラー');
            }
        } else {
            $response[] = '対象のユーザーが存在しません';
            throw new Exception('バリデートエラー');
        }
        $user = get_user_by('id', $user_id);


        $my_user_id = false;
        if ($params['access_token'] && !empty($params['access_token'])) {
            $my_user_id = check_login($params['access_token']);
        }

        if (!$user) {
            $response[] = '対象のユーザーが存在しません';
            throw new Exception('バリデートエラー');
        }

        $tcd_membership_vars['list_followers'] = muse_list_followers($user->ID);
        // フォロワーー一覧を取得
        foreach ($tcd_membership_vars['list_followers'] as $one_follower) {
            $user_info = get_userdata($one_follower->user_id);

            $description = '';
            $descriptionData = get_user_meta($one_follower->user_id, 'description', true);
            // プロフィールの取得
            if (!empty($descriptionData)) {
                $description = $descriptionData;
            }

            $profileImageData = get_user_meta($one_follower->user_id, 'profile_image', true);
            $profile_image = 'http://localhost.nft.info/wp-content/themes/muse_template/assets/img/icon/non_profile_image.png';
            if (!empty($profileImageData)) {
                $profile_image = $profileImageData;
            }

            // フォロワーの画像・名前・IDを取得
            $content[] = [
                'profile_image'  => $profile_image,
                'author_name'    => $user_info->display_name,
                'is_following'   => is_following($one_follower->user_id, $user_id),
                'target_user_id' => $one_follower->user_id,
                'description'    => $description
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
