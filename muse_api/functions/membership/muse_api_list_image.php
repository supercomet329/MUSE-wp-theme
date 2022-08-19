<?php

/**
 * 画像検索
 *
 * @param array $params
 * @return void
 */
function muse_api_list_image($params)
{

    $response = [];
    $error_message = [];
    $content = [];
    try {

        $search = '';
        if (isset($params['search']) && !empty($params['search'])) {
            $search = $params['search'];
        }

        $user_id = NULL;
        if (isset($params['access_token']) && !empty($params['access_token'])) {
            $user_id = check_login($params['access_token']);
        }

        if (count($error_message) > 0) {
            throw new Exception('バリデートエラー');
        }

        $resultSearch = getPostImageByPostTypeAndPostStatusWhere($search, false, 'photo', 'publish', $user_id);
        if(count($resultSearch) > 0) {
            foreach($resultSearch as $resultOne) {

                $like_flag = 0;
                $favorite_flag = 0;
                if (!is_null($user_id)) {
                    // いいねフラグの取得
                    $like_flag = is_liked($resultOne->post_id, $user_id);
                    $favorite_flag = is_favorite($resultOne->post_id, $user_id);
                }

                $content[] = [
                    'post_id'         => $resultOne->post_id,
                    'post_image1'     => $resultOne->main_image,
                    'post_image2'     => $resultOne->main_image2,
                    'post_image3'     => $resultOne->main_image3,
                    'post_image4'     => $resultOne->main_image4,
                    'like_flag'       => $like_flag,
                    'favorite_flag'   => $favorite_flag,
                    'user_id'         => $resultOne->user_id,
                    'user_icon_image' => $resultOne->profile_image,
                    'display_name'    => $resultOne->display_name,
                ];
            }
        }

        $response['result']  = true;
        $response['content'] = $content;
    } catch (Exception $e) {

        // エラー時の処理
        $response['result']        = false;
        $response['error_message'] = $error_message;
        error_publish($e);
    }
    return $response;
}

/**
 * wp_postsの情報を取得
 *
 * @param string $postType
 * @return array
 */
function getPostImageByPostTypeAndPostStatusWhere($txtSearch = '', $selR18 = false, $post_type = 'photo', $post_status = 'publish', $user_id = NULL)
{
    global $dp_options, $wpdb;

    $r18Flag = false;
    if (!is_null($user_id)) {
        $birth_day = get_user_meta($user_id, 'birthday', true);
        if (!empty($birth_day)) {
            $birthDayDateClass = new DateTime($birth_day);
            $nowDateClass      = new DateTime();
            $interval          = $nowDateClass->diff($birthDayDateClass);
            $old               = $interval->y;
            if ($old >= 18) {
                $r18Flag = true;
            }
        }
    }

    $sql = '
        SELECT
            wp_users.ID                    AS user_id
            ,wp_users.display_name         AS display_name
            ,wp_usermeta.meta_value        AS profile_image
            ,wp_posts.ID                   AS post_id
            ,wp_posts.post_date            AS post_date
            ,main_image_table.meta_value   AS main_image
            ,resize_image_table.meta_value AS resize_image
            ,main_image_table2.meta_value  AS main_image2
            ,main_image_table3.meta_value  AS main_image3
            ,main_image_table4.meta_value  AS main_image4
        FROM
            wp_posts AS wp_posts
        INNER JOIN 
            wp_users AS wp_users
        ON
            wp_users.ID = wp_posts.post_author
        INNER JOIN
            wp_postmeta AS main_image_table
        ON
            main_image_table.post_id = wp_posts.ID
        AND
            main_image_table.meta_key = \'main_image\'
        INNER JOIN
            wp_postmeta AS resize_image_table
        ON
            resize_image_table.post_id = wp_posts.ID
        AND
            resize_image_table.meta_key = \'resize_image\'
        LEFT JOIN
            wp_usermeta AS wp_usermeta
        ON
            wp_usermeta.user_id = wp_users.ID
        AND
            wp_usermeta.meta_key = \'profile_image\'
        LEFT JOIN
            wp_postmeta AS main_image_table2
        ON
            main_image_table2.post_id = wp_posts.ID
        AND
            main_image_table2.meta_key = \'main_image2\'
        LEFT JOIN
            wp_postmeta AS main_image_table3
        ON
            main_image_table3.post_id = wp_posts.ID
        AND
            main_image_table3.meta_key = \'main_image3\'
        LEFT JOIN
            wp_postmeta AS main_image_table4
        ON
            main_image_table4.post_id = wp_posts.ID
        AND
            main_image_table4.meta_key = \'main_image4\'

        LEFT JOIN
            wp_postmeta AS t18_table
        ON
            t18_table.post_id = wp_posts.ID
        AND
            t18_table.meta_key = \'r18\'

        WHERE
            wp_posts.post_type = \'%s\'
        AND
            wp_posts.post_status = \'%s\'
        AND
            wp_users.deleted = 0
    ';

    if (!empty($txtSearch)) {
        $sql .= '
        AND
            (
                wp_posts.post_title LIKE "%' . $txtSearch . '%"
                OR
                wp_posts.post_content LIKE "%' . $txtSearch . '%"
            )
        ';
    }

    if ($selR18 === 'r18') {
        $sql .= ' AND EXISTS ( ';
        $sql .= 'SELECT * ';
        $sql .= 'FROM wp_postmeta ';
        $sql .= 'WHERE meta_key = \'r18\' ';
        $sql .= 'AND wp_posts.ID = wp_postmeta.post_id ';
        $sql .= ' ) ';
    }

    if (!$r18Flag) {
        // R18フラグがfalseの場合はR18の商品を表示させない
        $sql .= ' AND NOT EXISTS ( ';
        $sql .= 'SELECT * ';
        $sql .= 'FROM wp_postmeta ';
        $sql .= 'WHERE meta_key = \'r18\' ';
        $sql .= 'AND wp_posts.ID = wp_postmeta.post_id ';
        $sql .= ' ) ';
    }

    $sql .= '
            ORDER BY wp_posts.post_date DESC
    ';

    $result_sql = $wpdb->prepare($sql, $post_type, $post_status);
    $result = $wpdb->get_results($result_sql);
    return $result;
}
