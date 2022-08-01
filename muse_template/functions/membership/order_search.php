<?php
// Add 2022/05/10 by H.Okabe
/**
 * 作品依頼発注一覧ページ
 */
function tcd_membership_action_order_search()
{
    global $tcd_membership_vars;

    nocache_headers();

    $user = wp_get_current_user();

    if (!$user) {
        wp_safe_redirect(user_trailingslashit(home_url()));
        exit;
    }

    $orderSort = (isset($_SESSION['sort'])) ? $_SESSION['sort'] : 'id_new';
    if (isset($_GET['sort'])) {
        $orderSort = $_GET['sort'];
    }
    $sort = $orderSort;
    $_SESSION['sort'] = $orderSort;

    $searchTxt = (isset($_SESSION['search_txt'])) ? $_SESSION['search_txt'] : '';
    if (isset($_POST['search_txt'])) {
        $searchTxt = $_POST['search_txt'];
    }
    $search_txt = $searchTxt;
    $_SESSION['search_txt'] = $searchTxt;

    $selUpBudget = (isset($_SESSION['sel_up_budget'])) ? $_SESSION['sel_up_budget'] : '';
    if (isset($_POST['sel_up_budget'])) {
        $selUpBudget = $_POST['sel_up_budget'];
    }
    $sel_up_budget = $selUpBudget;
    $_SESSION['sel_up_budget'] = $selUpBudget;

    $selDownBudget = (isset($_SESSION['sel_down_budget'])) ? $_SESSION['sel_down_budget'] : '';
    if (isset($_POST['sel_down_budget'])) {
        $selDownBudget = $_POST['sel_down_budget'];
    }
    $sel_down_budget = $selDownBudget;
    $_SESSION['sel_down_budget'] = $selDownBudget;

    $selLimit = (isset($_SESSION['sel_limit'])) ? $_SESSION['sel_limit'] : '';
    if (isset($_POST['sel_limit'])) {
        $selLimit = $_POST['sel_limit'];
    }
    $sel_limit = $selLimit;
    $_SESSION['sel_limit'] = $selLimit;

    // 依頼の一覧を取得
    $listOrder = lisetOrder($sort, $search_txt, $sel_up_budget, $sel_down_budget, $sel_limit);

    // テンプレート指定
    $tcd_membership_vars['template']  = 'muse_order_search';
    $tcd_membership_vars['list_order'] = $listOrder;
    $tcd_membership_vars['sort'] = $sort;
    $tcd_membership_vars['search_txt'] = $search_txt;
    $tcd_membership_vars['sel_up_budget'] = $sel_up_budget;
    $tcd_membership_vars['sel_down_budget'] = $sel_down_budget;
    $tcd_membership_vars['sel_limit'] = $sel_limit;
}
add_action('tcd_membership_action-order_search', 'tcd_membership_action_order_search');

/**
 * 依頼一覧の取得
 */
function lisetOrder($sort, $search_txt, $sel_up_budget, $sel_down_budget, $sel_limit)
{
    global $wpdb;

    $minimum_order_price = 0;
    $user_id = get_current_user_id();
    $get_minimum_order_price = get_user_meta($user_id, 'minimum_order_price', true);
    if(!empty($get_minimum_order_price)) {
        $minimum_order_price = $get_minimum_order_price;
    }

    $sql = '';
    $sql .= 'SELECT ';
    $sql .= ' DISTINCT wp_posts.ID  AS post_id ';
    $sql .= ',wp_posts.post_author  AS post_author ';
    $sql .= ',wp_posts.post_date    AS post_date ';
    $sql .= ',wp_posts.post_title   AS post_title ';
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
    $sql .= 'WHERE wp_posts.post_type = \'post\' ';
    $sql .= ' AND wp_posts.post_status = \'publish\'';
    $sql .= ' AND (';
    $sql .= ' SELECT meta_value FROM wp_postmeta WHERE wp_postmeta.post_id = wp_posts.ID AND meta_key = \'budget\'';
    $sql .= ') >= ' . (int)$minimum_order_price;

    $sql .= ' AND NOT EXISTS(';
    $sql .= ' SELECT * 
            FROM wp_postmeta 
            WHERE 
                wp_postmeta.post_id = wp_posts.ID 
            AND 
                wp_postmeta.meta_key = \'specify_user_id\' 
    ';
    $sql .= ')';
    $sql .= ' AND NOT EXISTS(';
    $sql .= ' SELECT * 
            FROM wp_tcd_membership_actions 
            WHERE 
                wp_tcd_membership_actions.post_id = wp_posts.ID 
            AND 
                wp_tcd_membership_actions.type = \'received\' 
            ';
    $sql .= ' ) ';

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
