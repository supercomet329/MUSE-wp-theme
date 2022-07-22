<?php
/**
 *
 * トップページ画像の取得
 *
 * @param array $params
 * @return array
 */
function api_follow($params)
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

        // フォロー済みの場合、フォロー削除
        if ( is_following( $params['target_user_id'], $user_id ) ) {
            $result = remove_follow( $params['target_user_id'], $user_id );
            if ( $result ) {
                $follow_type = 'deleted';
                $user_id = $params['target_user_id'];
                $json['result'] = 'removed';
                $json['text'] = __( 'Follow', 'tcd-w' );;
            } else {
                $response['message'] = 'Remove follow error: ' . __( 'Failed to save the database.', 'tcd-w' );
            }

        // フォローしていない場合、フォロー追加
        } else {
            $result = add_follow( $params['target_user_id'], $user_id );
            if ( $result ) {
                $follow_type = 'added';
                $user_id = $params['target_user_id'];
                $json['result'] = 'added';
                $json['text'] = __( 'Following', 'tcd-w' );
            } else {
                $response['message'] = 'Add follow error: ' . __( 'Failed to save the database.', 'tcd-w' );
            }
        }
        
        // レスポンスを返す
        $response = [
            'result'        => true,
            'follow_type'   => $follow_type,
            'user_id'       => $user_id,
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