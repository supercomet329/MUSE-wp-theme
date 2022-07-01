<?php
global $dp_options;
if (!$dp_options) $dp_options = get_design_plus_option();

$post_json = file_get_contents('php://input');
$params    = json_decode($post_json, true);

if (!defined('SYS_ERROR_FILE')) {
    define('SYS_ERROR_FILE', __DIR__ . '/log/' . date('Ymd') . '_error.log');
}


header("Content-Type: application/json; charset=utf-8");
header('Access-Control-Allow-Origin: *');

$default_error_json = [];
$default_error_json['result']  = false;
$default_error_json['message'] = '対象のAPIが存在しません';

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {

    // リクエストMethodが"POST"の場合
    switch ($params['api_type']) {
        case 'top_image':
            // トップページの表示
            // アクセストークンがある場合がある
            $response = api_get_top_image($params);
            break;

        case 'tail_image':
            // トップページの表示
            // アクセストークンがある場合がある
            $response = api_get_tail_image($params);
            break;

        case 'login':
            // ログインの対応
            $response = api_muse_login($params);
            break;

        case 'registration':
            // 仮登録の対応
            $response = muse_api_temporary_registration($params);
            break;

        case 'profile':
            // ユーザー情報の取得
            // アクセストークン or ユーザーIDのどちらか?は必須
            $response = api_get_profile($params);
            break;

        case 'profile_image':
            // ユーザーの投稿画像 / いいね投稿の情報を取得
            $response = api_get_profile_image($params);
            break;

        case 'edit_profile':
            // プロフィール編集
            // アクセストークン必須
            $response = api_edit_profile($params);
            break;

        case 'list_order':
            // 発注一覧
            // アクセストークン必須
            break;

        case 'list_received':
            // 発注一覧
            // アクセストークン必須
            break;

        case 'list_all_order':
            // 全依頼表示
            // アクセストークン必須
            break;

        case 'input_order':
            // 依頼新規登録
            // アクセストークン必須
            $response = muse_api_input_order($params);
            break;

        case 'edit_order':
            // 依頼情報更新
            // アクセストークン必須
            break;

        case 'detail_order':
            // 依頼情報詳細
            // アクセストークン必須
            break;

        case 'receive_request':
            // 依頼を受ける
            // アクセストークン必須
            break;

        case 'insert_post':
            // 画像登録
            // アクセストークン必須
            $response = muse_api_insert_image($params);
            break;

        case 'list_notification':
            // 通知一覧
            // アクセストークン必須
            $response = api_get_notifications($params);
            break;

        case 'list_message':
            // メッセージ一覧
            // アクセストークン必須
            $response = api_get_messages($params);
            break;

        case 'list_detail_message':
            // メッセージ詳細
            // アクセストークン必須
            $response = api_get_detail_messages($params);
            break;

        case 'insert_message':
            // メッセージ登録
            // アクセストークン必須
            $response = api_insert_message($params);
            break;

        case 'get_non_read_count':
            // 未読件数の取得
            // アクセストークン必須
            break;

        case 'follow':
            // フォロー登録/更新
            // アクセストークン必須
            $response = api_follow($params);
            break;

        case 'get_tail_follow':
            // フォロータイル一覧取得
            // アクセストークン必須
            $response = api_get_tail_follow($params);
            break;

        case 'get_follow':
            // フォロー一覧取得
            // アクセストークン必須
            $response = api_get_follow($params);
            break;

        case 'get_followers':
            // フォロワー一覧取得
            // アクセストークン必須
            $response = api_get_followers($params);
            break;

        case 'like':
            // いいね登録/更新
            // アクセストークン必須
            break;

        case 'keep':
            // キープ登録/更新
            // アクセストークン必須
            break;

        case 'password_reset':
            // パスワードリセット
            $response = muse_api_reset_password($params);
            break;

        case 'list_comment':
            $response = muse_api_list_comment($params);
            break;

        case 'insert_comment':
            $response = muse_api_insert_comment($params);
            break;

        case 'post_image':
            $response = muse_api_post_image($params);
            break;

        default:
            $response = $default_error_json;
            break;
    }
    echo json_encode($response);
} else {
    echo json_encode($default_error_json);
}
exit();
