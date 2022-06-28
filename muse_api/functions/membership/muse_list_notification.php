<?php

/**
 *
 * 通知一覧の取得
 *
 * @param array $params
 * @return array
 */
function api_get_notifications($params)
{
    // 変数を初期化
    $response = [];
    $user_id = "";
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

        global $tcd_membership_vars;
        $arrayNotice = [];

        $arrayLike = list_like($user_id);
        foreach ($arrayLike as $oneLike) {
            $dateClass = new DateTime($oneLike->created_gmt);
            $day        = $dateClass->format('Ymd H:i:00');
            $arrayNotice[$day]['like'][] = [
                'user_id' => $oneLike->user_id,
                'post_id' => $oneLike->post_id,
            ];
        }

        $arrayfollow = list_follow($user_id);
        foreach ($arrayfollow as $onefollow) {
            $dateClass = new DateTime($onefollow->created_gmt);
            $day        = $dateClass->format('Ymd H:i:00');
            $arrayNotice[$day]['follow'][] = [
                'user_id' => $onefollow->user_id,
                'post_id' => $onefollow->post_id,
            ];
        }

        // 通知の情報を取得
        krsort($arrayNotice);

        // いいねを既読状態にする
        readOnLike($user_id);
        // フォローを既読状態にする
        readOnFollow($user_id);

        nocache_headers();

        $tcd_membership_vars['arrayNotice'] = $arrayNotice;

        foreach ($tcd_membership_vars['arrayNotice'] as $key => $arrayNotice) {
            foreach ($arrayNotice as $type => $value) {
                if ($type === 'like') {
                    foreach ($value as $valueOne) {
                        $profileImageData = get_user_meta($valueOne['user_id'], 'profile_image', true);
                        $profile_image = 'http://localhost.nft.info/wp-content/themes/muse_template/assets/img/icon/non_profile_image.png';
                        if (!empty($profileImageData)) {
                            $profile_image = $profileImageData;
                        }
                        $user = get_userdata($valueOne['user_id']);
                        $post = get_post($valueOne['post_id']);
                    }

                    $content[] = [
                        'type' => $type,
                        'message'   =>  $user->display_name . "さんが「いいね」しました。",
                        'profile_image'   => $profile_image,
                        'post_id' => $post->ID,
                    ];
                } elseif ($type === 'follow') {
                    $images = [];
                    $names  = [];
                    $others = '';
                    if (count($value) >= 3) {
                        $others = '他';
                    }

                    foreach ($value as $valueOne) {

                        if (count($images) >= 2) {
                            break;
                        }

                        $profileImageData = get_user_meta($valueOne['user_id'], 'profile_image', true);
                        $profile_image = get_template_directory_uri() . '/assets/img/icon/non_profile_image.png';
                        if (!empty($profileImageData)) {
                            $profile_image = $profileImageData;
                        }
                        $images[] = $profile_image;

                        $user = get_userdata($valueOne['user_id']);
                        $names[]  = $user->display_name . 'さん';
                    }

                    $content[] = [
                        'type' => $type,
                        'message'   =>  implode('と', $names) . $others . 'にフォローされました。',
                        'profile_image'   => $images,
                        'post_id' => $post->ID,
                    ];
                }
            }
        }
        // レスポンスを返す
        $response = [
            'result'        => true,
            'content'       => $content,
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
