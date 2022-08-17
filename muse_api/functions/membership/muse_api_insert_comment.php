<?php


/**
 * 画像コメント登録API
 *
 * @param array $params
 * @return array
 */
function muse_api_insert_comment($params)
{
    $response = [];
    try {

        if (isset($params['access_token']) && !empty($params['access_token'])) {
            $user_id = check_login($params['access_token']);
            if (!$user_id) {
                $response[] = 'ユーザーが存在しません';
                throw new Exception('バリデートエラー');
            }
        } else {
            $response[] = '対象のユーザーが存在しません';
            throw new Exception('バリデートエラー');
        }

        if (!isset($params['post_id']) || empty($params['post_id'])) {
            $response[] = 'コメント登録先が不明です。';
        }

        if (!isset($params['comment']) || empty($params['comment'])) {
            $response[] = 'コメントの登録ができません';
        }

        if (count($response) > 0) {
            throw new Exception('バリデートエラー');
        }

        $post_id = $params['post_id'];

        // 投稿者のIPアドレスを取得
        $ip = 'アプリからの登録';

        $user = get_userdata($user_id);
        // wp_commentの登録
        $data = [
            'comment_post_ID'      => $post_id,
            'comment_content'      => $params['comment'],
            'comment_author_IP'    => $ip,
            'user_id'              => get_current_user_id(),
            'comment_date'         => date('Y-m-d H:i:s'),
            'comment_author_email' => $user->user_email,
            'comment_approved'     => 1,
        ];
        $result = insert_comment($data);
        if((int)$result !== 1) {
            throw new Exception('SQLの実行エラー');
        }

        $comment_list = muse_list_comment($post_id);
        $response = [
            'result'       => true,
            'comment_list' => $comment_list,
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

/**
 * コメントの新規登録
 *
 * @param array $params
 * @return void
 */
function insert_comment($params)
{
    global $wpdb;

    $sql = '';
    $sql .= 'INSERT INTO wp_comments (';
    $sql .= ' `comment_post_ID` ';
    $sql .= ' ,comment_author ';
    $sql .= ' ,comment_content ';
    $sql .= ' ,`comment_author_IP` ';
    $sql .= ' ,user_id ';
    $sql .= ' ,comment_date ';
    $sql .= ' ,comment_author_email ';
    $sql .= ' ,comment_approved ';
    $sql .= ' ) VALUES ( ';
    $sql .= ' %d ';
    $sql .= ' ,\'\' ';
    $sql .= ' ,%s ';
    $sql .= ' ,%s ';
    $sql .= ' ,%d ';
    $sql .= ' ,%s ';
    $sql .= ' ,%s ';
    $sql .= ' ,%d ';
    $sql .= ' ) ';

    $result_sql = $wpdb->prepare($sql, $params);
    $result = $wpdb->query($result_sql);
    return $result;
}
