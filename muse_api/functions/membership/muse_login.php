<?php

/**
 * ログイントークンの出力
 *
 * @param array $params
 * @return array
 */
function muse_login($params)
{

    $response = [];
    try {

        if (!isset($params['mail_address']) || empty($params['mail_address'])) {
            $response[] = 'メールアドレスは必須入力です。';
        }

        if (!isset($params['password']) || empty($params['password'])) {
            $response[] = 'パスワードは必須入力です。';
        }

        if (count($response) > 0) {
            throw new Exception('バリデートエラー');
        }

        $creds = [];
        $creds['user_login'] = $params['mail_address'];
        $creds['user_password'] = $params['password'];
        $result = wp_signon($creds, false);
        if(isset($result->data->ID)) {
            // ログイン成功時
            $string = $params['mail_address'] . '%' . $params['password'];
            $token  = openssl_encrypt($string, 'AES-128-ECB', SECURE_AUTH_SALT);
            // $token  = openssl_decrypt($token, 'AES-128-ECB', SECURE_AUTH_SALT);
            $response = [
                'result' => true,
                'token'  => $token,
            ];
        } else {
            $response[] = 'ログインができませんでした。';
            throw new Exception('No User');
        }

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
