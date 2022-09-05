<?php

/**
 * オーダーの新規登録API
 *
 * @param array $params
 * @return array
 */
function muse_api_input_order($params)
{
    global $wpdb;

    $arrayInsertColum = [
        'composition',
        'character',
        'refUrl',
        'budget',
        'orderQuantity',
        'specialNotes',
    ];

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

        if (!isset($params['title']) || empty(isset($params['title']))) {
            $response[] = 'タイトルは必須入力です。';
        }

        if (!isset($params['workTitle']) || empty(isset($params['workTitle']))) {
            $response[] = '依頼タイトルは必須入力です。';
        }

        if (!isset($params['workTitle']) || empty(isset($params['workTitle']))) {
            $response[] = '本文は必須入力です。';
        }

        if (!isset($params['composition']) || empty(isset($params['composition']))) {
            $response[] = '構図は必須入力です。';
        }

        if (!isset($params['character']) || empty(isset($params['character']))) {
            $response[] = 'キャラクターは必須入力です。';
        }

        if (!isset($params['requestFile']) || empty(isset($params['requestFile']))) {
            $response[] = '添付ファイルは必須入力です。';
        }

        if (!isset($params['requestFileName']) || empty(isset($params['requestFileName']))) {
            $response[] = '添付ファイルが取得できません。';
        }

        if (!isset($params['budget']) || empty(isset($params['budget']))) {
            $response[] = '予算は必須入力です。';
        } else {
            if (!is_int($params['budget'])) {
                $response[] = '予算を正しく入力して下さい。';
            }
        }

        if (!isset($params['orderQuantity']) || empty(isset($params['orderQuantity']))) {
            $response[] = '受付依頼数は必須入力です。';
        } else {
            if (!is_int($params['orderQuantity'])) {
                $response[] = '受付依頼数を正しく入力して下さい。';
            }
        }

        $requestFile = $params['requestFile'];
        $requestFile = str_replace(' ', '+', $requestFile);
        $requestFile = preg_replace('#^data:image/\w+;base64,#i', '', $requestFile);
        $requestFile = base64_decode($requestFile);

        // 拡張子の取得
        $extension     = pathinfo($params['requestFileName'], PATHINFO_EXTENSION);
        $requestFileName = $params['requestFileName'];

        $file_name     = 'api_' . substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 100) . '.' . $extension;
        $uploaded_file = muse_modify_template_directory_upload_dir() . $file_name;
        $result        = file_put_contents($uploaded_file, $requestFile);

        if ($result) {
            $requestFileUrl  = muse_modify_template_directory_uri() . '/upload_file/' . $file_name;
        } else {
            $response[] = 'ファイルのアップロードに失敗しました。';
        }

        if (
            isset($params['appDeadlineY']) || !empty($params['appDeadlineY']) ||
            isset($params['appDeadlineM']) || !empty($params['appDeadlineM']) ||
            isset($params['appDeadlineD']) || !empty($params['appDeadlineD'])
        ) {

            try {
                $appDeadlineDateClass = new DateTime($params['appDeadlineY'] . '-' . $params['appDeadlineM'] . '-' . $params['appDeadlineD']);
                $appDeadlineDate = $appDeadlineDateClass->format('Y-m-d');
            } catch (Exception $e) {
                $response[] = '応募期限を正しく入力してください。';
            }
        } else {
            $response[] = '応募期限は必須入力です。';
        }

        $tcd_membership_vars['view_desired_date'] = '';
        $desiredDate = false;
        if (
            isset($params['desiredDateY']) && !empty($params['desiredDateY']) ||
            isset($params['desiredDateM']) && !empty($params['desiredDateM']) ||
            isset($params['desiredDateD']) && !empty($params['desiredDateD'])
        ) {
            try {

                $desiredDateClass = new DateTime($params['desiredDateY'] . '-' . $params['desiredDateM'] . '-' . $params['desiredDateD']);
                $desiredDate = $desiredDateClass->format('Y-m-d');
            } catch (Exception $e) {
                $response[] = '応募期限を正しく入力してください。';
            }
        }

        if (count($response) > 0) {
            throw new Exception('バリデートエラー');
        }

        $result = $wpdb->insert(
            'wp_posts',
            [
                'post_author'   => $user_id,
                'post_date'     => date('Y-m-d H:i:s'),
                'post_date_gmt' => date('Y-m-d H:i:s'),
                'post_title'    => $params['title'],
                'post_content'  => $params['content'],
                'post_name'     => $params['workTitle'],
                'post_status'   => 'publish',
                'post_type'     => 'post',
            ],
            [
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s'
            ]
        );

        $post_id = $wpdb->insert_id;
        foreach ($arrayInsertColum as $oneInsertColum) {
            if (isset($params[$oneInsertColum]) && !empty($params[$oneInsertColum])) {
                $result = $wpdb->insert(
                    'wp_postmeta',
                    array(
                        'post_id'    => $post_id,
                        'meta_key'   => $oneInsertColum,
                        'meta_value' => $params[$oneInsertColum],
                    ),
                    array(
                        '%d',
                        '%s',
                        '%s'
                    )
                );
            }
        }

        // ファイルの名称の登録
        $result = $wpdb->insert(
            'wp_postmeta',
            [
                'post_id'    => $post_id,
                'meta_key'   => 'requestFileName',
                'meta_value' => $requestFileName,
            ],
            [
                '%d',
                '%s',
                '%s'
            ]
        );

        // ファイルのURLの登録
        $result = $wpdb->insert(
            'wp_postmeta',
            [
                'post_id'    => $post_id,
                'meta_key'   => 'requestFileUrl',
                'meta_value' => $requestFileUrl,
            ],
            [
                '%d',
                '%s',
                '%s'
            ]
        );

        // 応募期限の登録
        $result = $wpdb->insert(
            'wp_postmeta',
            [
                'post_id'    => $post_id,
                'meta_key'   => 'appDeadlineDate',
                'meta_value' => $appDeadlineDate,
            ],
            [
                '%d',
                '%s',
                '%s'
            ]
        );

        // 納品希望日の登録
        if ($desiredDate) {
            $result = $wpdb->insert(
                'wp_postmeta',
                [
                    'post_id'    => $post_id,
                    'meta_key'   => 'desiredDate',
                    'meta_value' => $desiredDate,
                ],
                [
                    '%d',
                    '%s',
                    '%s'
                ]
            );
        }

        // デフォルトの登録完了時の遷移先
        if (isset($params['specifyUserId']) && !empty($params['specifyUserId'])) {
            $userId = $params['specifyUserId'];
            $result = $wpdb->insert(
                'wp_postmeta',
                [
                    'post_id'    => $post_id,
                    'meta_key'   => 'specify_user_id',
                    'meta_value' => $userId,
                ],
                [
                    '%d',
                    '%s',
                    '%s'
                ]
            );
        }

        $response = [
            'result' => true,
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
