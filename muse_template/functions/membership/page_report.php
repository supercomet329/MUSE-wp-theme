<?php
// Add 2022/06/07 by H.Okabe
/**
 * 通報
 */
function tcd_membership_action_page_report()
{
    global $tcd_membership_vars;

    $post_id       = false;
    $request_id    = false;
    $post_image    = false;
    $request_title = false;
    $report_reason = '';

    if (isset($_REQUEST['post_id'])) {
        // 投稿画像のURL取得
        $post_id = $_REQUEST['post_id'];
        $post_image = get_post_meta($post_id, 'main_image', true);
        if (empty($post_image)) {
            wp_safe_redirect('/');
            exit();
        }
    } else if (isset($_REQUEST['request_id'])) {
        // 依頼タイトルの取得
        $request_id     = $_REQUEST['request_id'];
        $rowResuestData = get_request($request_id);
        if (count($rowResuestData) <= 0) {
            wp_safe_redirect('/');
            exit();
        }
        $request_title  = $rowResuestData[0]->post_title;
    } else {
        wp_safe_redirect('/');
        exit();
    }

    $inlineCheckbox1 = '';
    $inlineCheckbox2 = '';
    $inlineCheckbox3 = '';
    $report_reason   = '';
    if ('POST' === $_SERVER['REQUEST_METHOD']) {
        $inlineCheckbox1 = $_POST['inlineCheckbox1'];
        $inlineCheckbox2 = $_POST['inlineCheckbox2'];
        $inlineCheckbox3 = $_POST['inlineCheckbox3'];
        $report_reason   = $_POST['report_reason'];

        if (
            isset($_POST['nonce'])   &&
            !empty($_POST['nonce']) &&
            wp_verify_nonce($_POST['nonce'], 'tcd_membership_message_report')
        ) {

            // 管理者にメール送信
            $subject   = '[MUSE]通報が御座いました。';
            $message   = [];
            $message[] = '以下の内容で通報が御座いました。';
            if (isset($_REQUEST['post_id'])) {
                $message[] = '画像ID:' . $_REQUEST['post_id'];
            } else if (isset($_REQUEST['request_id'])) {
                $message[] = '依頼ID:' . $_REQUEST['request_id'];
                $message[] = '依頼タイトル:' . $request_title;
            } else {
                wp_safe_redirect('/');
                exit();
            }

            $message[] = '内容:';
            $message[] = $report_reason;

            $toMail = get_option('admin_email');
            $messages = implode("\n", $message);
            wp_mail($toMail, $subject, $messages);
        }
    }

    // テンプレート指定
    $params                    = [];
    $params['post_id']         = $post_id;
    $params['request_id']      = $request_id;
    $params['post_image']      = $post_image;
    $params['request_title']   = $request_title;
    $params['report_reason']   = $report_reason;
    $params['inlineCheckbox1'] = $inlineCheckbox1;
    $params['inlineCheckbox2'] = $inlineCheckbox2;
    $params['inlineCheckbox3'] = $inlineCheckbox3;

    $tcd_membership_vars['template'] = 'muse_page_report';
    $tcd_membership_vars['params']   = $params;
}
add_action('tcd_membership_action-page_report', 'tcd_membership_action_page_report');
