<?php
// 2022/05/23 追加
/**
 * お知らせ既読の件数の取得
 */
function count_non_read_muse_information($user_id = null)
{
    global $wpdb;

    if (is_null($user_id)) {
        $user_id = get_current_user_id();
    }

    $sql = '';
    $sql .= ' SELECT COUNT(*) ';
    $sql .= ' FROM wp_posts ';
    $sql .= ' WHERE post_type = "information" ';
    $sql .= ' AND ';
    $sql .= ' NOT EXISTS (';
    $sql .= ' SELECT * ';
    $sql .= ' FROM wp_tcd_membership_actions ';
    $sql .= ' WHERE user_id = ' . $user_id;
    $sql .= ' AND wp_posts.ID = wp_tcd_membership_actions.post_id ';
    $sql .= ' AND type = "information_read" ';
    $sql .= ') ';

    return $wpdb->get_var($sql);
}

/**
 * お知らせ既読の登録
 */
function add_muse_information($user_id = null, $post_id = null)
{
    global $wpdb;

    if (is_null($user_id)) {
        $user_id = get_current_user_id();
    }

    if (is_null($post_id)) {
        return false;
    }

    $chk = chk_read_information($user_id, $post_id);

    $data = [
        'type'        => 'information_read',
        'user_id'     => absint($user_id),
        'post_id'     => absint($post_id),
        'created_gmt' => current_time('mysql', true)
    ];

    $data_format = [
        '%s',
        '%d',
        '%d',
        '%s'
    ];

    if($chk <= 0) {
        $wpdb->insert(get_tcd_membership_tablename('actions'), $data, $data_format);
    }
}

function chk_read_information($user_id = null, $post_id = null)
{
    global $wpdb;

    if (is_null($user_id)) {
        $user_id = get_current_user_id();
    }

    if (is_null($post_id)) {
        return false;
    }

    $sql = '';
    $sql .= ' SELECT COUNT(*) ';
    $sql .= ' FROM wp_tcd_membership_actions ';
    $sql .= ' WHERE user_id = ' . $user_id;
    $sql .= ' AND type = "information_read" ';
    $sql .= ' AND post_id = ' . $post_id;

    return $wpdb->get_var($sql);
}
