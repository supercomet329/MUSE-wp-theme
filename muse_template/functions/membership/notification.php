<?php
// Add 2022/06/07 by H.Okabe
/**
 * 通知一覧
 */
function tcd_membership_action_notification()
{
    global $tcd_membership_vars;
    $arrayNotice = [];

    $arrayLike = list_like();
    foreach ($arrayLike as $oneLike) {
        $dateClass = new DateTime($oneLike->created_gmt);
        $day        = $dateClass->format('Ymd H:i:00');
        $arrayNotice[$day]['like'][] = [
            'user_id' => $oneLike->user_id,
            'post_id' => $oneLike->post_id,
        ];
    }

    $arrayfollow = list_follow();
    foreach ($arrayfollow as $onefollow) {
        $dateClass = new DateTime($onefollow->created_gmt);
        $day        = $dateClass->format('Ymd H:i:00');
        $arrayNotice[$day]['follow'][] = [
            'user_id' => $onefollow->user_id,
            'post_id' => $onefollow->post_id,
        ];
    }

    // TODO 通知の情報を取得
    krsort($arrayNotice);

    // いいねを既読状態にする
    readOnLike();
    // フォローを既読状態にする
    readOnFollow();

    nocache_headers();

    $user = wp_get_current_user();

    if (!$user) {
        wp_safe_redirect(user_trailingslashit(home_url()));
        exit;
    }

    // テンプレート指定
    $tcd_membership_vars['template']  = 'muse_notice';
    $tcd_membership_vars['arrayNotice'] = $arrayNotice;
}
add_action('tcd_membership_action-notification', 'tcd_membership_action_notification');

/**
 * Add 2022/06/07 
 * 未読のいいねとフォローの合計件数の取得
 */
function count_notice($user_id = NULL)
{
    global $wpdb;

    if (is_null($user_id)) {
        $user_id = get_current_user_id();
    }

    // 未読のいいねの取得
    $sql = '';
    $sql .= 'SELECT COUNT(*) ';
    $sql .= ' FROM wp_tcd_membership_actions ';
    $sql .= ' WHERE target_user_id = %d ';
    $sql .= ' AND type = \'like\' ';
    $sql .= ' AND NOT EXISTS (';
    $sql .= ' SELECT * FROM wp_tcd_membership_action_metas ';
    $sql .= ' WHERE wp_tcd_membership_action_metas.action_id = wp_tcd_membership_actions.id ';
    $sql .= ' AND meta_key = \'read\' ';
    $sql .= ' )';
    $like_count = $wpdb->get_var($wpdb->prepare($sql, $user_id));

    // 未読のフォローの取得
    $sql = '';
    $sql .= 'SELECT COUNT(*) ';
    $sql .= ' FROM wp_tcd_membership_actions ';
    $sql .= ' WHERE target_user_id = %d ';
    $sql .= ' AND type = \'follow\' ';
    $sql .= ' AND NOT EXISTS (';
    $sql .= ' SELECT * FROM wp_tcd_membership_action_metas ';
    $sql .= ' WHERE wp_tcd_membership_action_metas.action_id = wp_tcd_membership_actions.id ';
    $sql .= ' AND meta_key = \'read\' ';
    $sql .= ' )';
    $follow_count = $wpdb->get_var($wpdb->prepare($sql, $user_id));

    return (int)$like_count + (int)$follow_count;
}

/**
 * いいね一覧の取得
 */
function list_like($user_id = NULL)
{
    global $wpdb;

    if (is_null($user_id)) {
        $user_id = get_current_user_id();
    }

    // 未読のいいねの取得
    $prepare = [];
    $prepare[] = $user_id;

    $sql = '';
    $sql .= 'SELECT ';
    $sql .= ' user_id ';
    $sql .= ' ,post_id ';
    $sql .= ' ,created_gmt ';
    $sql .= ' FROM wp_tcd_membership_actions ';
    $sql .= ' WHERE target_user_id = %d ';
    $sql .= ' AND type = \'like\' ';
    $result = $wpdb->get_results($wpdb->prepare($sql, $prepare));
    return $result;
}

/**
 * フォロー一覧の取得
 */
function list_follow($user_id = NULL)
{
    global $wpdb;

    if (is_null($user_id)) {
        $user_id = get_current_user_id();
    }

    // 未読のいいねの取得
    $prepare = [];
    $prepare[] = $user_id;

    $sql = '';
    $sql .= 'SELECT ';
    $sql .= ' user_id ';
    $sql .= ' ,post_id ';
    $sql .= ' ,created_gmt ';
    $sql .= ' FROM wp_tcd_membership_actions ';
    $sql .= ' WHERE target_user_id = %d ';
    $sql .= ' AND type = \'follow\' ';
    $result = $wpdb->get_results($wpdb->prepare($sql, $prepare));
    return $result;
}

/**
 * いいねを既読済みにする
 *
 * @param int $user_id
 * @return boolean
 */
function readOnLike($user_id = NULL)
{
    global $wpdb;

    if (is_null($user_id)) {
        $user_id = get_current_user_id();
    }

    $prepare = [];
    $prepare[] = $user_id;

    $sql = '';
    $sql .= 'SELECT ';
    $sql .= ' id ';
    $sql .= ' FROM wp_tcd_membership_actions ';
    $sql .= ' WHERE target_user_id = %d ';
    $sql .= ' AND type = \'like\' ';
    $sql .= ' AND NOT EXISTS (';
    $sql .= ' SELECT * FROM wp_tcd_membership_action_metas ';
    $sql .= ' WHERE wp_tcd_membership_action_metas.action_id = wp_tcd_membership_actions.id ';
    $sql .= ' AND meta_key = \'read\' ';
    $sql .= ' )';
    $result = $wpdb->get_results($wpdb->prepare($sql, $prepare));

    foreach ($result as $result_one) {
        $data = [
            'action_id' => $result_one->id,
            'meta_key' => 'read',
            'meta_value' => 1,
        ];
        $data_format = array(
            '%d',
            '%s',
            '%s'
        );

        // $target_user_idが配列の場合はカンマ区切りでtarget_user_idsにセット
        $wpdb->insert('wp_tcd_membership_action_metas', $data, $data_format);
    }
}

/**
 * フォローを既読済みにする
 *
 * @param int $user_id
 * @return boolean
 */
function readOnFollow($user_id = NULL)
{
    global $wpdb;

    if (is_null($user_id)) {
        $user_id = get_current_user_id();
    }

    $prepare = [];
    $prepare[] = $user_id;

    $sql = '';
    $sql .= 'SELECT ';
    $sql .= ' id ';
    $sql .= ' FROM wp_tcd_membership_actions ';
    $sql .= ' WHERE target_user_id = %d ';
    $sql .= ' AND type = \'follow\' ';
    $sql .= ' AND NOT EXISTS (';
    $sql .= ' SELECT * FROM wp_tcd_membership_action_metas ';
    $sql .= ' WHERE wp_tcd_membership_action_metas.action_id = wp_tcd_membership_actions.id ';
    $sql .= ' AND meta_key = \'read\' ';
    $sql .= ' )';
    $result = $wpdb->get_results($wpdb->prepare($sql, $prepare));

    foreach ($result as $result_one) {
        $data = [
            'action_id' => $result_one->id,
            'meta_key' => 'read',
            'meta_value' => 1,
        ];

        $data_format = array(
            '%d',
            '%s',
            '%s'
        );

        // $target_user_idが配列の場合はカンマ区切りでtarget_user_idsにセット
        $wpdb->insert('wp_tcd_membership_action_metas', $data, $data_format);
    }
}