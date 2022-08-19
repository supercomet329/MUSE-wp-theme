<?php

/**
 *
 * プロフィール編集
 *
 * @param array $params
 * @return array
 */
function api_edit_profile($params)
{
    // 変数を初期化
	global $wpdb;
    $wpdb->prefix = "wp_";

    $response = [];

    try {
        if (isset($params['access_token']) && !empty($params['access_token'])) {
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
        $form_type = 'edit_profile';
        $data = [
            'description' => 'aaaa',
            'nickname' => $params['display_name'],
            'birthday' => $params['birthday'],
            'area' => $params['area'],
            'website_url' => $params['website_url'],
            'nonce' => esc_attr(wp_create_nonce('tcd-membership-edit_profile')),
        ];

        if (!empty($params['author_image'])) {
            // 画像アップロードの場合
            $image_parts = explode(";base64,", $params['author_image']);
            $image_type_aux = explode("image/", $image_parts[0]); // ファイルの型を取り出す
            $image_type = $image_type_aux[1]; // ファイルの型を取り出す
            $image_base64 = base64_decode($image_parts[1]); // 画像データとして取り出す
            $file_name = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 100) . '.' . '.png';
            $uploaded_file = '/home/kusanagi/nft/DocumentRoot/wp-content/themes/muse_template/functions/membership' . '/../../upload_file/' . $file_name;

            $result = file_put_contents($uploaded_file, $image_base64); // ファイルを保存
            if ($result) {
                $profile_image  = 'http://localhost.nft.info/wp-content/themes/muse_template' . '/upload_file/' . $file_name;
            } else {
                $error_messages[] = 'ファイルのアップロードに失敗しました。';
            }
        } elseif (!empty($params['message'])) {
            // メッセージの場合
            $message = $params['message'];
        }

        $wpdb->update(
            $wpdb->users,
            array(
                'display_name' => $params['display_name'],
                'user_url' => $params['website_url'],
            ),
            array(
                'ID' => $user->ID
            ),
            array(
                '%s'
            ),
            array(
                '%d'
            )
        );

        // foreach ($data as $key => $value ) {
        //     $wpdb->update(
        //         $wpdb->usermeta,
        //         array(
        //             'meta_value' => $value,
        //         ),
        //         array(
        //             'user_id'    => $user->ID,
        //             'meta_key'   => $key,
        //         ),
        //         array(
        //             '%s'
        //         ),
        //         array(
        //             '%d'
        //         )
        //     );
        // }

		$result = tcd_membership_user_form_fields_save_metas($form_type, $data, $user, $args);

        $response = [
            'result' => $params['birthday'],
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
