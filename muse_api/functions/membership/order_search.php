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
    if(isset($_GET['sort'])) {
        $orderSort = $_GET['sort'];
    }
    $sort = $orderSort;
    $_SESSION['sort'] = $orderSort;

    $searchTxt = (isset($_SESSION['search_txt'])) ? $_SESSION['search_txt'] : '';
    if(isset($_POST['search_txt'])) {
        $searchTxt = $_POST['search_txt'];
    }
    $search_txt = $searchTxt;
    $_SESSION['search_txt'] = $searchTxt;

    $selUpBudget = (isset($_SESSION['sel_up_budget'])) ? $_SESSION['sel_up_budget'] : '';
    if(isset($_POST['sel_up_budget'])) {
        $selUpBudget = $_POST['sel_up_budget'];
    }
    $sel_up_budget = $selUpBudget;
    $_SESSION['sel_up_budget'] = $selUpBudget;

    $selDownBudget = (isset($_SESSION['sel_down_budget'])) ? $_SESSION['sel_down_budget'] : '';
    if(isset($_POST['sel_down_budget'])) {
        $selDownBudget = $_POST['sel_down_budget'];
    }
    $sel_down_budget = $selDownBudget;
    $_SESSION['sel_down_budget'] = $selDownBudget;

    $selLimit = (isset($_SESSION['sel_limit'])) ? $_SESSION['sel_limit'] : '';
    if(isset($_POST['sel_limit'])) {
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