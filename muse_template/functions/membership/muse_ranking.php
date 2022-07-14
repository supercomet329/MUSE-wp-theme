<?php
// Add 2022/05/10 by H.Okabe
/**
 * ランキングページ
 */
function tcd_membership_action_ranking()
{
    var_dump(__LINE__);
    exit;
}
add_action('tcd_membership_action-ranking', 'tcd_membership_action_ranking');

/**
 * パーツ用のランキングの生成
 *
 * @return void
 */
function partsRanking()
{

    // DBからランキングの生成
}

/**
 * ランキングをDBに登録するための処理
 * TODO: 運用が始まってしばらくたったらNFT関連でランキングを作成する
 * FIEXED: 一旦は投稿作品数でランキングの生成
 * @return void
 */
function makeRankingInDb()
{

    publishLog('FILE  => ' . __FILE__ . ' LINE  => ' . __LINE__ . ' START  => ランキング生成');
    // ユーザーをランダムに取得する(最大10名)
    $objUser = randomUsers();
    publishLog('FILE  => ' . __FILE__ . ' LINE  => ' . __LINE__ . ' ' . print_r($objUser, true));

    // DBからデータを削除
    deleteRankingUser();

    // 取得したユーザーでforeach
    $loop = 1;
    foreach ($objUser as $objUserOne) {
        // wp_tcd_membership_actionsに登録を行う
        $action_id = insert_tcd_membership_action('ranking', $objUserOne->user_id);

        // wp_tcd_membership_action_metasにランキングの数字を登録する(key: ranking)
        update_tcd_membership_action_meta($action_id, 'ranking', $loop);

        // wp_tcd_membership_action_metasに取引数を登録する(key: count_transaction)
        update_tcd_membership_action_meta($action_id, 'count_transaction', 0);

        // wp_tcd_membership_action_metasに平均価格を登録する(key: average_price)
        update_tcd_membership_action_meta($action_id, 'average_price', 0);

        // wp_tcd_membership_action_metasに所有者数を登録する(key: count_owned)
        update_tcd_membership_action_meta($action_id, 'count_owned', 0);

        // wp_tcd_membership_action_metasに作品数を登録する(key: count_work)
        update_tcd_membership_action_meta($action_id, 'count_owned', $objUserOne->count_photo);

        $loop++;
    }

    publishLog('FILE  => ' . __FILE__ . ' LINE  => ' . __LINE__ . ' END => ランキング生成');
}
add_action('muse_ranking_function_cron', 'makeRankingInDb');

// cron登録処理
if (!wp_next_scheduled('muse_ranking_function_cron')) {
    date_default_timezone_set('Asia/Tokyo');  // タイムゾーンの設定
    $dateClass = new DateTime();
    $dateClass->setTimezone(new DateTimeZone('Asia/Tokyo'));
    $dateClass->modify('+1 hour');
    wp_schedule_event($dateClass->format('U'), 'hour', 'muse_ranking_function_cron');
}

/**
 * ランキングユーザーの削除
 *
 * @return boolean
 */
function deleteRankingUser()
{
    global $wpdb;


    // ランキングユーザーの取得
    $sql = '
        SELECT
            id
            ,type
            ,user_id
        FROM
            wp_tcd_membership_actions 
        WHERE
            type = \'ranking\'
        ORDER BY id ASC
    ';
    $listRankingUser = $wpdb->get_results($wpdb->prepare($sql));
    publishLog('FILE  => ' . __FILE__ . ' LINE  => ' . __LINE__ . ' ' . print_r($listRankingUser, true));

    // 取得したユーザーでランキング情報の削除
    foreach ($listRankingUser as $oneRankingUser) {

        // wp_tcd_membership_actionsのデータを削除
        $results = $wpdb->delete(
            'wp_tcd_membership_actions',
            array('id' => $oneRankingUser->id),
            array('%d')
        );

        if ($results) {
            // wp_tcd_membership_action_metas の削除
            delete_tcd_membership_action_meta($oneRankingUser->id);
        }
    }
}

/**
 * 投稿数でランキングの生成
 *
 * @return object
 */
function randomUsers()
{
    global $wpdb;

    $sql = '
        SELECT
            wp_users.ID            AS user_id
            ,wp_users.display_name AS display_name
            ,wp_users.deleted      AS deleted
            ,(
                SELECT
                    COUNT(*)
                FROM
                    wp_posts
                WHERE
                    wp_posts.post_type   = \'photo\'
                AND
                    wp_posts.post_status = \'publish\'
                AND
                    wp_posts.post_author = wp_users.ID
            ) AS count_photo
        FROM
            wp_users 
        WHERE
            wp_users.deleted = 0
        ORDER BY count_photo DESC
        LIMIT 10
    ';

    return $wpdb->get_results($wpdb->prepare($sql));
}
