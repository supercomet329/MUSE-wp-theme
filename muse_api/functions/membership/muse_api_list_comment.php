<?php

/**
 * 投稿画像情報とコメント一覧の取得
 *
 * @param array $params
 * @return array
 */
function muse_api_list_comment($params)
{
    global $tcd_membership_vars, $wpdb;

    $response = [];
    $login_flag = false;
    $like_flag  = false;
    $error_message = [];
    try {
        if (isset($params['access_token']) && !empty($params['access_token'])) {
            $user_id = check_login($params['access_token']);
            if ($user_id) {
                $login_flag = true;
            }
        }

        // 画像の情報の取得
        if (!isset($params['post_id']) || empty($params['post_id'])) {
            $error_message[] = '画像の情報が取得できません。';
        }

        if (count($error_message) > 0) {
            throw new Exception('バリデートエラー');
        }

        $post_id = $params['post_id'];
        $result = getPostDataByPostIdAndOnlyPhoto($post_id);

        if(!isset($result[0])) {
            $error_message[] = '画像の情報が取得できません。';
            throw new Exception('バリデートエラー');
        }

        if ($login_flag === TRUE) {
            // いいねフラグの取得
            $like_flag = is_liked($post_id, $user_id);
        }

        $comment_list = muse_list_comment($post_id);

        $response['result']       = true;
        $response['post_image1']  = $result[0]->main_image1;
        $response['post_image2']  = $result[0]->main_image2;
        $response['post_image3']  = $result[0]->main_image3;
        $response['post_image4']  = $result[0]->main_image4;
        $response['login_flag']   = $login_flag;
        $response['like_flag']    = $like_flag;
        $response['comment_list'] = $comment_list;
    } catch (Exception $e) {

        // エラー時の処理
        $response['result']        = false;
        $response['error_message'] = $error_message;
        error_publish($e);
    }
    return $response;
}
