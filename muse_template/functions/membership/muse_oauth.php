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
    global $tcd_membership_vars;
    if (isset($_GET['code']) && !empty($_GET['code'])) {

        $base_url              = 'https://api.twitter.com/2/oauth2/token';
        $twitter_client_id     = get_option('twitter_client_id');
        $twitter_client_secret = get_option('twitter_client_secret');

        // TwitterのOauthからcodeが取得できた場合
        $code = $_GET['code'];

        // アクセストークンの取得
        $curl = curl_init($base_url);
        curl_setopt($curl, CURLOPT_POST, TRUE);


        // Twitterのコードからユーザー情報の取得

        // メールアドレスを取得しwp_usersにメールアドレスがあるか?確認

        // メールアドレスが存在する場合 => wp_usersのユーザーを取得してログイン状態にしてリダイレクト

        // メールアドレスが存在しない場合 => メールアドレスに新規登録メールを送信する
    }

    var_dump(__LINE__);
    exit;
    /**
     * 必要情報がない場合 => TOPページにリダイレクト
     */
    wp_safe_redirect(home_url('/'));
    exit();
}
add_action('tcd_membership_action-oauth_twitter', 'tcd_membership_action_oauth_twitter');

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

        $query = [
            'response_type' => 'code',
            'client_id' => $twitter_client_id,
            'redirect_uri' => home_url() . '/?memberpage=oauth_twitter',
            'scope' => 'tweet.write users.read offline.access',
            'state' => 'state',
            'code_challenge' => 'codeChallenge',
            'code_challenge_method' => 'S256'
        ];

        return '<a href="' . $base_url . '?' . http_build_query($query) . '"> ログイン</a>';
    }

    return "";
}
