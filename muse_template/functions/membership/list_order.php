<?php
// Add 2022/05/10 by H.Okabe
/**
 * 依頼一覧ページ
 */
function tcd_membership_action_list_order()
{
    global $tcd_membership_vars;

    nocache_headers();

    $user = wp_get_current_user();

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

    if (!$user) {
        wp_safe_redirect(user_trailingslashit(home_url()));
        exit;
    }

    // 発注の一覧を取得
    $listOrder = listOrder($up_budget, $down_budget, $whereDeadLine, $target);

    // テンプレート指定
    $tcd_membership_vars['template']   = 'muse_list_order';
    $tcd_membership_vars['list_order'] = $listOrder;
    $tcd_membership_vars['post_data']  = $postData;
}
add_action('tcd_membership_action-list_order', 'tcd_membership_action_list_order');

/**
 * 依頼一覧の取得
 */
function lisetOrder($sort, $search_txt, $sel_up_budget, $sel_down_budget, $sel_limit)
{
    global $wpdb;

    $sql = '';
    $sql .= 'SELECT ';
    $sql .= ' DISTINCT wp_posts.ID AS post_id ';
    $sql .= ',wp_posts.post_author AS post_author ';
    $sql .= ',wp_posts.post_date AS post_date ';
    $sql .= ',wp_posts.post_title AS post_title ';
    $sql .= ',wp_posts.post_content AS post_content ';
    $sql .= ',wp_users.display_name AS display_name ';

    $sql .= ',(';
    $sql .= ' SELECT meta_value FROM wp_postmeta WHERE wp_postmeta.post_id = wp_posts.ID AND meta_key = \'appDeadlineDate\'';
    $sql .= ') AS appDeadlineDate ';

    $sql .= ',(';
    $sql .= ' SELECT meta_value FROM wp_postmeta WHERE wp_postmeta.post_id = wp_posts.ID AND meta_key = \'budget\'';
    $sql .= ') AS budget ';

    $sql .= 'FROM wp_posts ';
    $sql .= ' INNER JOIN wp_users ';
    $sql .= ' ON wp_users.ID = wp_posts.post_author ';
    $sql .= 'WHERE wp_posts.post_type = \'request\' ';
    $sql .= ' AND wp_posts.post_status = \'publish\'';
    $sql .= ' AND NOT EXISTS(';
    $sql .= ' SELECT * 
            FROM wp_tcd_membership_actions 
            WHERE 
                wp_tcd_membership_actions.post_id = wp_posts.ID 
            AND 
                wp_tcd_membership_actions.type = \'received\' 
            ';
    $sql .= ' ) ';
    $sql .= ' AND EXISTS(';
    $sql .= ' SELECT * 
            FROM wp_postmeta 
            WHERE 
                wp_postmeta.post_id = wp_posts.ID 
            AND 
                wp_postmeta.meta_key = \'appDeadlineDate\' 
            AND 
                wp_postmeta.meta_value > NOW()
    ';
    $sql .= ')';

    if (!empty($sel_up_budget)) {
        $sql .= ' AND (';
        $sql .= ' SELECT meta_value FROM wp_postmeta WHERE wp_postmeta.post_id = wp_posts.ID AND meta_key = \'budget\'';
        $sql .= ') <= ' . $sel_up_budget;
    }

    if (!empty($sel_down_budget)) {
        $sql .= ' AND (';
        $sql .= ' SELECT meta_value FROM wp_postmeta WHERE wp_postmeta.post_id = wp_posts.ID AND meta_key = \'budget\'';
        $sql .= ') >= ' . $sel_down_budget;
    }

    if (!empty($sel_limit)) {
        $dateClass = new DateTime();
        $dateClass->modify('+' . $sel_limit);

        $sql .= ' AND (';
        $sql .= ' SELECT meta_value FROM wp_postmeta WHERE wp_postmeta.post_id = wp_posts.ID AND meta_key = \'appDeadlineDate\'';
        $sql .= ') <= \'' . $dateClass->format('Y-m-d 23:59:59') . '\'';
    }

    if (!empty($search_txt)) {
        $sql .= ' AND (
                wp_posts.post_title LIKE \'%' . $search_txt . '%\'
            OR
                wp_posts.post_content LIKE \'%' . $search_txt . '%\'
            OR
                wp_posts.post_name LIKE \'%' . $search_txt . '%\'
            )';
    }

    if ($sort === 'id_old') {
        $sql .= ' ORDER BY wp_posts.ID ASC';
    } else if ($sort === 'budget_down') {
        $sql .= ' ORDER BY budget ASC';
    } else if ($sort === 'budget_up') {
        $sql .= ' ORDER BY budget DESC';
    } else {
        $sql .= ' ORDER BY wp_posts.ID DESC';
    }

    // echo $sql;exit;
    $result = $wpdb->get_results($wpdb->prepare($sql));
    return $result;
}
