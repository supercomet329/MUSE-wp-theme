<?php
// Add 2022/05/10 by H.Okabe
/**
 * 作品検索ページ
 */
function tcd_membership_action_post_search()
{
    global $tcd_membership_vars, $wpdb;

    $txtSearch  = '';
    $selR18flag = 0;
    if ('POST' == $_SERVER['REQUEST_METHOD']) {

        $txtSearch  = $_POST['search'];
        if (isset($_POST['r18flag'])) {
            $selR18flag = $_POST['r18flag'];
        }
    }

    $r18Flag = false;
    if (!is_null(get_current_user_id())) {
        $birth_day = get_user_meta(get_current_user_id(), 'birthday', true);
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

    $tcd_membership_vars['imgList']    = getPostImageByPostTypeAndPostStatusWhere($txtSearch, $selR18flag);
    $tcd_membership_vars['template']   = 'muse_post_search';
    $tcd_membership_vars['selR18flag'] = $selR18flag;
    $tcd_membership_vars['txtSearch']  = $txtSearch;
    $tcd_membership_vars['r18Flag']    = $r18Flag;
}
add_action('tcd_membership_action-post_search', 'tcd_membership_action_post_search');
