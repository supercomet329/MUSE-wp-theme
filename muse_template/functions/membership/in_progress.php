<?php

/**
 * 進行中一覧
 */
function tcd_membership_action_in_progress()
{
    global $tcd_membership_vars;

    // user_idの取得
    $user_id = get_current_user_id();

    // user_idが取得できない場合 => ログインページ遷移
    if ($user_id <= 0) {
        wp_safe_redirect(user_trailingslashit(home_url()));
        exit;
    }

    $up_budget = false;
    $down_budget = false;
    $deadline = false;
    $deadline = false;
    $target   = false;
    $whereDeadLine = false;
    $postData = [];
    if ('POST' == $_SERVER['REQUEST_METHOD']) {
        $postData = $_POST;
        // 値がPOSTされたときの対応

        if (!empty($_POST['nonce']) || wp_verify_nonce($_POST['nonce'], 'tcd_membership_action_order_search')) {

            // 予算上限
            if (isset($_POST['up_budget']) && !empty($_POST['up_budget'])) {
                $up_budget = $_POST['up_budget'];
            }

            // 予算下限
            if (isset($_POST['down_budget']) && !empty($_POST['down_budget'])) {
                $down_budget = $_POST['down_budget'];
            }

            // 期日
            if (isset($_POST['deadline']) && !empty($_POST['deadline'])) {
                $deadline = $_POST['deadline'];

                $dateClass = new DateTime();
                $dateClass->modify('+' . $deadline);
                $whereDeadLine = $dateClass->format('Y-m-d 00:00:00');
            }

            // 対象
            if (isset($_POST['target']) && !empty($_POST['target'])) {
                $target = $_POST['target'];
            }
        }
    }


    // 自分が発注して受注されたリクエストの一覧の取得
    $listInProgress = listInProgress($up_budget, $down_budget, $whereDeadLine, $target);

    // テンプレートに値を渡す
    $tcd_membership_vars['template']  = 'muse_in_progress';
    $tcd_membership_vars['listOrder'] = $listInProgress;
    $tcd_membership_vars['post_data']  = $postData;
}
add_action('tcd_membership_action-in_progress', 'tcd_membership_action_in_progress');

/**
 * 自分自身が登録したリクエストで受注がされている一覧を取得
 *
 * @return void
 */
function listInProgress($up_budget, $down_budget, $whereDeadLine, $target)
{

    global $wpdb;

    $sql = '';
    $sql .= 'SELECT ';
    $sql .= 'wp_posts.ID AS post_id ';
    $sql .= ',wp_posts.post_author AS post_author ';
    $sql .= ',wp_posts.post_date AS post_date ';
    $sql .= ',wp_posts.post_title AS post_title ';
    $sql .= ',wp_posts.post_content AS post_content ';
    $sql .= ',wp_users.display_name AS display_name ';
    $sql .= ',wp_tcd_membership_actions.user_id AS contractor_user_id ';
    $sql .= ',(';
    $sql .= ' SELECT meta_value FROM wp_postmeta WHERE wp_postmeta.post_id = wp_posts.ID AND meta_key = \'appDeadlineDate\'';
    $sql .= ') AS appDeadlineDate ';
    $sql .= ',(';
    $sql .= ' SELECT meta_value FROM wp_postmeta WHERE wp_postmeta.post_id = wp_posts.ID AND meta_key = \'budget\'';
    $sql .= ') AS budget ';

    $sql .= 'FROM wp_posts ';
    $sql .= ' INNER JOIN wp_users ';
    $sql .= ' ON wp_users.ID = wp_posts.post_author ';
    $sql .= 'LEFT JOIN wp_tcd_membership_actions ';
    $sql .= 'ON wp_posts.ID = wp_tcd_membership_actions.post_id ';
    $sql .= ' AND wp_tcd_membership_actions.type = \'received\' ';
    $sql .= 'WHERE wp_posts.post_type = \'request\' ';
    $sql .= ' AND wp_posts.post_status = \'publish\'';
    $sql .= ' AND ( ';
    $sql .= ' wp_posts.post_author = ' . get_current_user_id();
    $sql .= ' OR ';
    $sql .= ' wp_tcd_membership_actions.user_id = ' . get_current_user_id();
    $sql .= ' ) ';

    if ($up_budget) {
        // 予算上限
        $sql .= ' AND EXISTS( ';
        $sql .= ' SELECT * FROM wp_postmeta WHERE wp_postmeta.post_id = wp_posts.ID AND meta_key = \'budget\' AND meta_value <= ' . $up_budget;
        $sql .= ' ) ';
    }

    if ($down_budget) {
        // 予算上限
        $sql .= ' AND EXISTS( ';
        $sql .= ' SELECT * FROM wp_postmeta WHERE wp_postmeta.post_id = wp_posts.ID AND meta_key = \'budget\' AND meta_value > ' . $down_budget;
        $sql .= ' ) ';
    }

    if ($whereDeadLine) {
        $sql .= ' AND EXISTS( ';
        $sql .= ' SELECT * FROM wp_postmeta WHERE wp_postmeta.post_id = wp_posts.ID AND meta_key = \'appDeadlineDate\' AND meta_value <= \'' . $whereDeadLine . '\'';
        $sql .= ' ) ';
    }

    if ($target) {
        // $sql .= 'AND wp_posts.post_content LIKE \'%' . $post_content . '%\' ';
    }

    $sql .= ' ORDER BY wp_posts.ID DESC';

    $result = $wpdb->get_results($wpdb->prepare($sql));
    return $result;
}
