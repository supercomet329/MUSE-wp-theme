<?php
// Add 2022/07/20 by H.Okabe
/**
 * Oauth新規登録 / ログインページ
 * 
 * 注: 使用する場合は, Twitterの開発者登録が必要
 * Callback URI / Redirect URLに/?memberpage=oauth_twitterのページを登録しておく
 * 
 * 以下, DBに登録しておく
 * テーブル名: wp_options
 * 
 * 1, 
 * option_name: twitter_client_id
 * option_value: Twitter Developersから取得したclient_id
 * autoload: yes
 *
 * 2, 
 * option_name: twitter_client_secret
 * option_value: Twitter Developersから取得しClient Secret
 * autoload: yes
 */

function tcd_membership_action_oauth_twitter()
{
    if (isset($_GET['code']) && !empty($_GET['code'])) {

        $twitter_client_id     = get_option('twitter_client_id');
        $twitter_client_secret = get_option('twitter_client_secret');

        // TwitterのOauthからcodeが取得できた場合
        $code = $_GET['code'];

        $body = '';
        $body .= 'grant_type=authorization_code';
        $body .= '&redirect_uri=' . urlencode(home_url() . '/?memberpage=oauth_twitter');
        $body .= '&code_verifier=' . $_SESSION['code_verifier'];
        $body .= '&client_id=' . $twitter_client_id;
        $body .= '&code=' . $code;

        // アクセストークンの取得
        $ch = curl_init();
        $options = [
            CURLOPT_URL => 'https://api.twitter.com/2/oauth2/token',
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/x-www-form-urlencoded',
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_USERPWD => $twitter_client_id . ':' . $twitter_client_secret,
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_RETURNTRANSFER => true,
        ];
        curl_setopt_array($ch, $options);
        $response   = curl_exec($ch);
        $tokenArray = json_decode($response, true);
        curl_close($ch);

        $access_token  = $tokenArray['access_token'];
        // $refresh_token = $tokenArray['refresh_token'];

        // Twitterのコードからユーザー情報の取得
        // ヘッダ生成
        $ch = curl_init();
        $options = [
            CURLOPT_URL => 'https://api.twitter.com/2/users/me',
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json; charser=UTF-8',
                'Authorization: Bearer ' . $access_token
            ],
            CURLOPT_RETURNTRANSFER => true
        ];
        curl_setopt_array($ch, $options);
        $response   = curl_exec($ch);
        $profileArray = json_decode($response, true);
        curl_close($ch);

        // TODO: メールアドレスの取得にはTwitter管理画面の設定が必要なため(利用規約のページ And プライバシーポリシーがbasic他がない状態で必要)
        // メールアドレスを取得しwp_usersにメールアドレスがあるか?確認
        // メールアドレスが存在する場合 => wp_usersのユーザーを取得してログイン状態にしてリダイレクト
        // メールアドレスが存在しない場合 => メールアドレスに新規登録メールを送信する

        // 取得したユーザー情報内にtwitterのIDがあるか?確認
        if (isset($profileArray['data']['id']) && !empty($profileArray['data']['id'])) {

            $userData = getUsersMetaByMetaKeyAndMetaValue('twitter_user_id', $profileArray['data']['id']);
            if (count($userData) > 0) {
                // 存在する場合 => ユーザー情報を取得してログイン
                $creds                  = [];
                $creds['user_login']    = $userData[0]->user_login;
                $creds['user_password'] = $userData[0]->user_pass;
                wp_signon($creds, false);

                wp_clear_auth_cookie();
                wp_set_current_user($userData[0]->ID);
                wp_set_auth_cookie($userData[0]->ID);
            }
        }
    }

    /**
     * 必要情報がない場合 => ログインページにリダイレクト
     */
    wp_safe_redirect(home_url('/?memberpage=login&oauth_error=login_error'));
    exit();
}
add_action('tcd_membership_action-oauth_twitter', 'tcd_membership_action_oauth_twitter');

function tcd_membership_action_oauth_login_twitter()
{
    $message = 'Twitterの認証に失敗しました。';
    if (isset($_GET['code']) && !empty($_GET['code'])) {

        $twitter_client_id     = get_option('twitter_client_id');
        $twitter_client_secret = get_option('twitter_client_secret');

        // TwitterのOauthからcodeが取得できた場合
        $code = $_GET['code'];

        $body = '';
        $body .= 'grant_type=authorization_code';
        $body .= '&redirect_uri=' . urlencode(home_url() . '/?memberpage=oauth_login_twitter');
        $body .= '&code_verifier=' . $_SESSION['code_verifier'];
        $body .= '&client_id=' . $twitter_client_id;
        $body .= '&code=' . $code;

        // アクセストークンの取得
        $ch = curl_init();
        $options = [
            CURLOPT_URL => 'https://api.twitter.com/2/oauth2/token',
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/x-www-form-urlencoded',
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_USERPWD => $twitter_client_id . ':' . $twitter_client_secret,
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_RETURNTRANSFER => true,
        ];
        curl_setopt_array($ch, $options);
        $response   = curl_exec($ch);
        $tokenArray = json_decode($response, true);
        curl_close($ch);

        $access_token  = $tokenArray['access_token'];
        // $refresh_token = $tokenArray['refresh_token'];

        // Twitterのコードからユーザー情報の取得
        // ヘッダ生成
        $ch = curl_init();
        $options = [
            CURLOPT_URL => 'https://api.twitter.com/2/users/me',
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json; charser=UTF-8',
                'Authorization: Bearer ' . $access_token
            ],
            CURLOPT_RETURNTRANSFER => true
        ];
        curl_setopt_array($ch, $options);
        $response   = curl_exec($ch);
        $profileArray = json_decode($response, true);
        curl_close($ch);

        // TODO: メールアドレスの取得にはTwitter管理画面の設定が必要なため(利用規約のページ And プライバシーポリシーがbasic他がない状態で必要)
        // メールアドレスを取得しwp_usersにメールアドレスがあるか?確認
        // メールアドレスが存在する場合 => wp_usersのユーザーを取得してログイン状態にしてリダイレクト
        // メールアドレスが存在しない場合 => メールアドレスに新規登録メールを送信する

        // 取得したユーザー情報内にtwitterのIDがあるか?確認
        if (isset($profileArray['data']['id']) && !empty($profileArray['data']['id'])) {

            $user_id = get_current_user_id();
            // 現行のusermetaを削除
            delete_usermeta( $user_id, 'twitter_user_id' );
            // 新規にusermetaを登録
            add_user_meta( $user_id, 'twitter_user_id', $profileArray['data']['id'] );
            $message = 'Twitterの認証に成功しました。';
        }
    }

    /**
     * 必要情報がない場合 => ログインページにリダイレクト
     */
    $_SESSION['success_twitter_message'] = $message;
    wp_safe_redirect(home_url('/?memberpage=edit_profile'));
    exit();
}
add_action('tcd_membership_action-oauth_login_twitter', 'tcd_membership_action_oauth_login_twitter');

/**
 * ログイン用のURLを取得
 * 
 * @return string
 */
function makeTwitterOauthLogin()
{
    $twitter_client_id = get_option('twitter_client_id');
    $base_url = 'https://twitter.com/i/oauth2/authorize';
    if (!empty($twitter_client_id)) {

        // TODO: 20220721 code_challenge_methodをs256で対応
        $state         = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 50);
        $code_verifier = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 128);
        $_SESSION['code_verifier'] = $code_verifier;

        $query = [
            'response_type'         => 'code',
            'client_id'             => $twitter_client_id,
            'redirect_uri'          => home_url() . '/?memberpage=oauth_twitter',
            'scope'                 => 'tweet.read tweet.write users.read offline.access',
            'state'                 => $state,
            'code_challenge'        => $code_verifier,
            'code_challenge_method' => 'plain'
        ];

        $button = '';
        $button .= '<div class="col-12 login-with-sns">';
        $button .= '<a href="' . $base_url . '?' . http_build_query($query) . '" rel="noreferrer">';
        $button .= '<button class="twitter-btn">';
        $button .= '<img src="' . get_template_directory_uri() .'/assets/img/icon/twitter_icon.png" alt="twitter" class="twitter-icon">';
        $button .= '</button>';
        $button .= '</a>';
        $button .= '</div>';

        return $button;
    }

    return "";
}

function makeTwitterOauthLoginLink()
{
    $twitter_client_id = get_option('twitter_client_id');
    $base_url = 'https://twitter.com/i/oauth2/authorize';
    if (!empty($twitter_client_id)) {

        // TODO: 20220721 code_challenge_methodをs256で対応
        $state         = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 50);
        $code_verifier = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 128);
        $_SESSION['code_verifier'] = $code_verifier;

        $query = [
            'response_type'         => 'code',
            'client_id'             => $twitter_client_id,
            'redirect_uri'          => home_url() . '/?memberpage=oauth_login_twitter',
            'scope'                 => 'tweet.read tweet.write users.read offline.access',
            'state'                 => $state,
            'code_challenge'        => $code_verifier,
            'code_challenge_method' => 'plain'
        ];

        $link = '';
        $link .= '<div class="col-6 text-left title py-2 mt-0 border-bottom-dashed">';
        $link .= 'Twitter認証';
        $link .= '</div>';
        $link .= '<a href ="' . $base_url . '?' . http_build_query($query) . '">';
        $link .= 'Twitter認証を行う';
        $link .= '</a>';

        return $link;
    }

    return "";
}

/**
 * meta keyとmeta valueからユーザー情報を取得
 *
 * @param string $meta_key
 * @param string $meta_value
 * @return object
 */
function getUsersMetaByMetaKeyAndMetaValue($meta_key, $meta_value)
{
    global $wpdb;

    $sql = '';
    $sql .= 'SELECT * ';
    $sql .= 'FROM wp_usermeta  ';
    $sql .= ' INNER JOIN wp_users ';
    $sql .= ' ON ';
    $sql .= ' wp_users.ID = wp_usermeta.user_id';
    $sql .= ' WHERE ';
    $sql .= ' wp_usermeta.meta_key = \'%s\' ';
    $sql .= ' AND ';
    $sql .= ' wp_usermeta.meta_value = \'%d\' ';
    $sql .= ' AND ';
    $sql .= ' wp_users.deleted = 0 ';

    $result = $wpdb->get_results($wpdb->prepare($sql, [$meta_key, $meta_value]));
    return $result;
}
