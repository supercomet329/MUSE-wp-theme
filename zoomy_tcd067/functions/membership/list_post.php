<?php
// Add 2022/05/10 by H.Okabe
/**
 * 投稿画像一覧ページ
 */
function tcd_membership_action_list_post()
{
    global $tcd_membership_vars;

    nocache_headers();

    $user = wp_get_current_user();

    if (!$user) {
        wp_safe_redirect(user_trailingslashit(home_url()));
        exit;
    }

    $sel_r18    = (isset($_SESSION['sel_r18']))    ? $_SESSION['sel_r18'] : false;
    $txtSearch  = (isset($_SESSION['txt_search'])) ? $_SESSION['txt_search'] : '';
    $sort       = (isset($_SESSION['sort']))        ? $_SESSION['sort'] : 'ASC';

    if(isset($_GET['sort'])) {
        $sort = $_GET['sort'];
    }

    $orderDescButton = true;
    $orderAscButton  = false;
    if ($sort === 'asc') {
        $orderDescButton = false;
        $orderAscButton  = true;
    }
    $tcd_membership_vars['orderDescButton'] = $orderDescButton;
    $tcd_membership_vars['orderAscButton']  = $orderAscButton;

    if ('POST' == $_SERVER['REQUEST_METHOD']) {
        // 検索が実行された場合の処理

        if (isset($_POST['txt_search'])) {
            $txtSearch = $_POST['txt_search'];
        }

        if ($_POST['sel_r18']) {
            $sel_r18 = $_POST['sel_r18'];
        }
    }

    // ▼ 年齢計算
    $r18Flag  = false;
    $view_r18 = false;
    $birth_day = get_user_meta($user->data->ID, 'birthday', true);
    if (!empty($birth_day)) {
        $birthDayDateClass = new DateTime($birth_day);
        $nowDateClass      = new DateTime();
        $interval          = $nowDateClass->diff($birthDayDateClass);
        $old               = $interval->y;
        if ($old >= 18) {
            $view_r18 = true;
            // 年齢が18以上の場合に選択したR18のフラグを有効にする
            if ($sel_r18 === 'r-18') {
                $r18Flag = true;
            }
        }
    }
    // ▲ 年齢計算
    $tcd_membership_vars['text_search'] = $txtSearch;
    $tcd_membership_vars['sel_r18']     = $r18Flag;
    $tcd_membership_vars['view_r18']    = $view_r18;

    // 検索パラメータ保持しておきたいので SESSIONに格納
    // TODO: 複数サーバ構成になった場合に要相談
    $_SESSION['txt_search'] = $txtSearch;
    $_SESSION['sel_r18']    = $r18Flag;
    $_SESSION['sort']       = $sort;

    // 画像の一覧を取得
    $listImage = muse_list_image($txtSearch, $r18Flag, $sort);

    // テンプレート指定
    $tcd_membership_vars['template']  = 'muse_list_post';
    $chunkListImage                   = array_chunk($listImage, 3);
    $tcd_membership_vars['listImage'] = $chunkListImage;
}
add_action('tcd_membership_action-list_post', 'tcd_membership_action_list_post');
