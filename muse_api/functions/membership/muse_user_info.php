<?php

/**
 * 
 * ユーザー情報の取得
 *
 * @param array $params
 * @return array
 */
function api_get_profile($params)
{

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

        $authorImageData = get_user_meta($user_id, 'profile_image', true);
        $author_iamge = get_template_directory_uri() . '/assets/img/icon/non_profile_image.png';
        if (!empty($authorImageData)) {
            $author_iamge = $authorImageData;
        }

        $bannerImageData = get_user_meta($user_id, 'header_image', true);
        $banner_image = get_template_directory_uri() . '/assets/img/add_image360-250.png';
        if (!empty($bannerImageData)) {
            $banner_image = $bannerImageData;
        }

        $area = '';
        $areaData = get_user_meta($user_id, 'area', true);
        if (!empty($areaData)) {
            $area = $areaData;
        }

        $birthday = '';
        $birthdayData = get_user_meta($user_id, 'birthday', true);
        if (!empty($birthdayData)) {
            $birthday = $birthdayData;
        }

        $profile_text = '';
        $profileTxt = get_user_meta($user_id, 'description', true);
        if (!empty($profileTxt)) {
            $profile_text = $profileTxt;
        }

        // 
        $countArray = get_author_list_totals($user_id);

        $follow = false;
        if ($my_user_id) {
            if(is_following($user_id, $my_user_id)) {
                $follow = true;
            }
        }

        $response = [
            'result'         => true,
            'user_id'        => $user_id,
            'banner_iamge'   => $banner_image,
            'author_iamge'   => $author_iamge,
            'display_name'   => $user->data->display_name,
            'profile_text'   => $profile_text,
            'follow_count'   => $countArray['following']['total'],
            'follower_count' => $countArray['follower']['total'],
            'birthday'       => $birthday,
            'area'           => $area,
            'web_site'       => $user->data->user_url,
            'follow'         => $follow,
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
