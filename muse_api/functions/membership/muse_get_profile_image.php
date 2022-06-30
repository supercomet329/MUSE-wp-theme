<?php

/**
 *
 * ユーザーの投稿画像 / いいね投稿の情報を取得
 *
 * @param array $params
 * @return array
 */
function api_get_profile_image($params)
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

        $arrayCount = get_author_list_totals($user_id);

        // 発注の一覧を取得
        $listPost = muse_list_post($user->ID);
        $chunk_list_post = array_chunk($listPost, 3);
        $list_post = $chunk_list_post;

        $listLike  = muse_list_like($user->ID);
        $chunk_list_like = array_chunk($listLike, 3);
        $list_like = $chunk_list_like;

        // レスポンスを返す
        $response = [
            'result'        => true,
            'post_image'    => $list_post,
            'like_image'    => $list_like,
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
