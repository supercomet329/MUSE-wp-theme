<?php
// Add 2022/05/10 by H.Okabe
/**
 * 依頼情報更新
 */
function tcd_membership_action_modify_request()
{
    global $wpdb, $tcd_membership_vars;

    // テンプレート指定
    $tcd_membership_vars['template']  = 'muse_modify_request_input';

    $weekArray = [
        '0' => '日',
        '1' => '月',
        '2' => '火',
        '3' => '水',
        '4' => '木',
        '5' => '金',
        '6' => '土',
    ];

    $arrayInsertColum = [
        'url',
        'money',
        'sales_format',
        'deadline',
        'receptions_count',
        'delivery_request',
        'special_report',
        'request_file_url',
        'request_file_name'
    ];

    $user = wp_get_current_user();

    if ('POST' == $_SERVER['REQUEST_METHOD']) {
        $tcd_membership_vars['post_data'] = $_POST;

        // 値がPOSTされたときの対応
        if (empty($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'tcd_membership_action_request')) {
            $error_messages[] = __('Invalid nonce.', 'tcd-w');
        }

        if (isset($_POST['request_type'])) {
            if ($_POST['request_type'] === 'input') {

                // 入力ページから確認ページの遷移

                // 依頼タイトルの入力チェック
                if (!isset($_POST['title']) || empty($_POST['title'])) {
                    $error_messages[] = '依頼タイトルは必須入力です。';
                }

                if (!isset($_POST['content']) || empty($_POST['content'])) {
                    $error_messages[] = '依頼内容は必須入力です。';
                }

                if (isset($_POST['url']) && !empty($_POST['url'])) {
                    if (!filter_var($_POST['url'], FILTER_VALIDATE_URL)) {
                        $error_messages[] = 'URLの形式を御確認下さい。';
                    }
                }

                if (isset($_POST['sales_format']) && (int)$_POST['sales_format'] === 1) {
                    if (!isset($_POST['money']) || empty($_POST['money'])) {
                        $error_messages[] = '予算を指定する場合は金額の指定もお願い致します。';
                    }
                }

                $tcd_membership_vars['view_deadline'] = '';
                if (isset($_POST['deadline'])) {
                    $dateClass = new DateTime($_POST['deadline']);
                    $week = $weekArray[$dateClass->format('w')];
                    $tcd_membership_vars['view_deadline'] = $dateClass->format('Y年m月d日(' . $week . ') 24:00');
                }

                // 画像アップロード処理
                $tcd_membership_vars['post_data']['request_file_url']  = '';
                $tcd_membership_vars['post_data']['request_file_name'] = '';

                if (!empty($_FILES['file']['name'])) {
                    $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                    $file_name = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 100) . '.' . $extension;
                    $uploaded_file = __DIR__ . '/../../upload_file/' . $file_name;
                    $result = move_uploaded_file($_FILES['file']['tmp_name'], $uploaded_file);
                    if ($result) {
                        $tcd_membership_vars['post_data']['request_file_url']  = get_template_directory_uri() . '/upload_file/' . $file_name;
                        $tcd_membership_vars['post_data']['request_file_name'] = $_FILES['file']['name'];
                    } else {
                        $error_messages[] = 'ファイルのアップロードに失敗しました。';
                    }
                }

                if (count($error_messages) <= 0) {
                    $tcd_membership_vars['template']  = 'muse_modify_request_input_confirm';
                }
                $tcd_membership_vars['error_message'] = $error_messages;
            } else if ($_POST['request_type'] === 'confirm') {
                // 確認ページからの遷移

                // wp_tcd_membership_actionsの登録
                // $action_id = insert_tcd_membership_action('request', $user->ID, 0, 0);

                $my_post = array(
                    'ID'                => $_POST['post_id'],
                    'post_title'        => $_POST['title'],
                    'post_content'      => $_POST['content'],
                    'post_name'         => 'request',
                    'post_type'         => 'request'
                );
                wp_insert_post($my_post);

                // wp_tcd_membership_action_metasの登録
                foreach ($arrayInsertColum as $oneInsertColum) {
                    $result = $wpdb->update(
                        'wp_postmeta',
                        array(
                            'meta_value' => $_POST[$oneInsertColum],
                        ),
                        array(
                            'post_id'    => $_POST['post_id'],
                            'meta_key'   => $oneInsertColum,
                        ),
                        array(
                            '%s'
                        )
                    );
                }

                if (count($error_messages) <= 0) {
                    $redirect = esc_attr(get_tcd_membership_memberpage_url('modify_request')) . '&status=complete&request_id=' . $_POST['post_id'];
                    wp_redirect(remove_query_arg('settings-updated', $redirect));
                }
            }
        }
    } else {
        if (!$_GET['request_id']) {
            // 依頼IDが取得できない場合 => トップページへ遷移
            wp_safe_redirect(user_trailingslashit(home_url()));
            exit;
        }

        // データの取得
        $request = get_request($_GET['request_id']);
        if (count($request) <= 0 || (int)$request[0]->post_author !== $user->ID) {
            // 依頼が取得できない場合 OR 作成者とログインユーザーが違う場合 => トップページへ遷移
            wp_safe_redirect(user_trailingslashit(home_url()));
            exit;
        }
        $tcd_membership_vars['requestData'] = $request[0];
    }
    $dateClass = new DateTime($request[0]->deadline . ' 00:00:00');

    $chkDeadline  = '';
    if (isset($_POST['deadline'])) {
        $chkDeadline  = $_POST['deadline'];
    }

    $selDeadline    = [];
    for ($i = 1; $i <= 10; $i++) {
        // $dateClass->modify('+1 day');
        $week = $weekArray[$dateClass->format('w')];

        $deadLineOne = [];
        $deadLineOne['value'] = $dateClass->format('Y-m-d');
        $deadLineOne['text']  = $dateClass->format('Y年m月d日(' . $week . ') 24:00');
        $deadLineOne['check']  = ($chkDeadline === $dateClass->format('Y-m-d')) ? 'selected' : '';
        $selDeadline[] = $deadLineOne;
    }
    $tcd_membership_vars['sel_deadline'] = $selDeadline;

    nocache_headers();
    if (!$user) {
        wp_safe_redirect(user_trailingslashit(home_url()));
        exit;
    }
}
add_action('tcd_membership_action-modify_request', 'tcd_membership_action_modify_request');
