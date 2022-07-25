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

        $profileArray = getTwitterProfile($_GET['code'], home_url() . '/?memberpage=oauth_twitter');

        // 取得したユーザー情報内にtwitterのIDがあるか?確認
        if (isset($profileArray['data']['id']) && !empty($profileArray['data']['id'])) {

            $userData = getUsersMetaByMetaKeyAndMetaValue('twitter_user_id', $profileArray['data']['id']);
            if (count($userData) > 0) {
                // 存在する場合 => ユーザー情報を取得してログイン
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

/**
 * Oauth認証
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
function tcd_membership_action_oauth_login_twitter()
{
    $message = 'Twitterの認証に失敗しました。';
    if (isset($_GET['code']) && !empty($_GET['code'])) {

        $profileArray = getTwitterProfile($_GET['code'], home_url() . '/?memberpage=oauth_login_twitter');

        // 取得したユーザー情報内にtwitterのIDがあるか?確認
        if (isset($profileArray['data']['id']) && !empty($profileArray['data']['id'])) {

            $user_id = get_current_user_id();
            // 現行のusermetaを削除
            delete_usermeta($user_id, 'twitter_user_id');
            // 新規にusermetaを登録
            add_user_meta($user_id, 'twitter_user_id', $profileArray['data']['id']);
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
        $button .= '<img class="col-3 float-left twitter-icon" src="' . get_template_directory_uri() . '/assets/img/icon/twitter_icon.png" alt="twitter">';
        $button .= '<div class="con-6 twitter-login-text">Twitterでログインする</div>';
        $button .= '<div class="con-3"></div>';
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

        $button = '';
        $button .= '<div class="col-12 login-with-sns">';
        $button .= '<a href="' . $base_url . '?' . http_build_query($query) . '" rel="noreferrer">';
        $button .= '<button class="twitter-btn">';
        $button .= '<img class="col-3 float-left twitter-icon" src="' . get_template_directory_uri() . '/assets/img/icon/twitter_icon.png" alt="twitter">';
        $button .= '<div class="con-6 twitter-login-text">Twitterで認証を行う</div>';
        $button .= '<div class="con-3"></div>';
        $button .= '</button>';
        $button .= '</a>';
        $button .= '</div>';

        return $button;
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
    $sql .= ' wp_usermeta.meta_value = \'%s\' ';
    $sql .= ' AND ';
    $sql .= ' wp_users.deleted = 0 ';

    $result = $wpdb->get_results($wpdb->prepare($sql, [$meta_key, $meta_value]));
    return $result;
}

/**
 * Twitter APIを使用して
 * プロフィール情報の取得
 */
function getTwitterProfile($code, $redirect_url)
{
    $twitter_client_id     = get_option('twitter_client_id');
    $twitter_client_secret = get_option('twitter_client_secret');

    $body = '';
    $body .= 'grant_type=authorization_code';
    $body .= '&redirect_uri=' . urlencode($redirect_url);
    $body .= '&code_verifier=' . $_SESSION['code_verifier'];
    $body .= '&client_id=' . $twitter_client_id;
    $body .= '&code=' . $code;

    // アクセストークンの取得
    $ch = curl_init();
    $options = [
        CURLOPT_URL        => 'https://api.twitter.com/2/oauth2/token',
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/x-www-form-urlencoded',
        ],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_USERPWD        => $twitter_client_id . ':' . $twitter_client_secret,
        CURLOPT_POSTFIELDS     => $body,
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
    $response     = curl_exec($ch);
    $profileArray = json_decode($response, true);
    curl_close($ch);

    // TODO: メールアドレスの取得にはTwitter管理画面の設定が必要なため(利用規約のページ And プライバシーポリシーがbasic他がない状態で必要)
    // メールアドレスを取得しwp_usersにメールアドレスがあるか?確認
    // メールアドレスが存在する場合 => wp_usersのユーザーを取得してログイン状態にしてリダイレクト
    // メールアドレスが存在しない場合 => メールアドレスに新規登録メールを送信する

    return $profileArray;
}

/**
 * Oauth新規登録 / ログインページ
 * 
 * 注: 使用する場合は, Googleの開発者登録が必要
 * Callback URI / Redirect URLに/?memberpage=oauth_googleのページを登録しておく
 * 
 * 以下, DBに登録しておく
 * テーブル名: wp_options
 * 
 * 1, 
 * option_name: google_client_id
 * option_value: Google Cloudから取得したクライアントID
 * autoload: yes
 *
 * 2, 
 * option_name: google_secret_key
 * option_value: Google Cloudから取得したシークレット
 * autoload: yes
 */
function tcd_membership_action_oauth_login_google()
{

    if (isset($_GET['code']) && !empty($_GET['code'])) {
        $profileArray = getGoogleProfile($_GET['code']);

        if (isset($profileArray['id']) && !empty($profileArray['id'])) {

            $userData = getUsersMetaByMetaKeyAndMetaValue('google_user_id', $profileArray['id']);
            if (count($userData) > 0) {
                // 存在する場合 => ユーザー情報を取得してログイン
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
add_action('tcd_membership_action-oauth_login_google', 'tcd_membership_action_oauth_login_google');

/**
 * グーグル用のログインボタンの生成
 *
 * @return void
 */
function makeGoogleAuthButton()
{
    $google_api_key    = get_option('google_client_id');

    $button = '';
    if (!empty($google_api_key)) {

        $state             = rand();
        $nonce             = hash('sha512', openssl_random_pseudo_bytes(128));
        $_SESSION['state'] = $state;
        $params = [
            'response_type' => 'code',
            'client_id'     => $google_api_key,
            'redirect_uri'  => home_url() . '/?memberpage=oauth_login_google',
            'state'         => $state,
            'nonce'         => $nonce,
            'scope'         => 'openid email profile',
        ];

        $url = 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params);
        $button .= '<div class="col-12 login-with-sns mt-3">';
        $button .= '<a href="' . $url . '">';
        $button .= '<button class="google-btn">';
        $button .= '<img src="' . get_template_directory_uri() . '/assets/img/icon/g-logo.png" alt="google" class="google-icon">';
        $button .= 'Googleアカウントでログインする';
        $button .= '</button>';
        $button .= '</a>';
        $button .= '</div>';
    }

    return $button;
}

/**
 * Google APIからプロフィール情報の取得
 *
 * @param string $code
 * @return void
 */
function getGoogleProfile($code)
{

    $google_api_key    = get_option('google_client_id');
    $google_secret_key = get_option('google_secret_key');

    $postData = [
        "grant_type"    => "authorization_code",
        "code"          => $code,
        "redirect_uri"  => home_url() . '/?memberpage=oauth_login_google',
        "client_id"     => $google_api_key,
        "client_secret" => $google_secret_key
    ];

    // 
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
    curl_setopt($ch, CURLOPT_URL, 'https://oauth2.googleapis.com/token');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $tokenArray = json_decode($response, true);
    curl_close($ch);

    $access_token = $tokenArray['access_token'];
    $id_token     = $tokenArray['id_token'];

    $ch = curl_init();
    $options = [
        CURLOPT_URL => 'https://www.googleapis.com/oauth2/v1/userinfo',
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json; charser=UTF-8',
            'Authorization: Bearer ' . $access_token
        ],
        CURLOPT_RETURNTRANSFER => true
    ];
    curl_setopt_array($ch, $options);
    $response     = curl_exec($ch);
    $profileArray = json_decode($response, true);
    curl_close($ch);

    return $profileArray;
}
