<?php

// 予算用配列
$array_budget = [
    '0' => '',
    '1' => '5千円未満',
    '2' => '5千円～1万円',
    '3' => '1万円～5万円',
    '4' => '5万円～10万円',
    '5' => '10万円～30万円',
    '6' => '30万円～50万円',
    '7' => '50万円以上',
];
define('ARRAY_BUDGET', $array_budget);

// 応募期限用配列
$array_app_dead_line = [
    '1week' => '1週間',
    '2week' => '2週間',
    '3week' => '3週間',
    '4week' => '4週間',
    '5week' => '5週間',
];
define('ARRAY_APP_DEAD_LINE', $array_app_dead_line);
define('DEFAULT_APP_DEAD_LINE', '2week');

$array_db_colum = [
    'composition',
    'character',
    'refUrl',
    'budget',
    'orderQuantity',
    'specialNotes',
];
define('ARRAY_DB_COLUM', $array_db_colum);

/**
 * 新規リクエスト登録の処理
 *
 * @return void
 */
add_action('tcd_membership_action-request', 'tcd_membership_action_request');
function tcd_membership_action_request()
{
    global $wpdb, $tcd_membership_vars;

    // テンプレートの指定
    $tcd_membership_vars['template']  = 'muse_request_input';

    $specifyUser = false;
    $user_id     = false;
    $minimumOrderPrice = 0;
    if (isset($_REQUEST['user_id'])) {

        // 指定ユーザーがいる場合
        $specifyUser = true;
        $user_id = $_REQUEST['user_id'];
        $user    = get_userdata($user_id);
        $minimumOrderPrice = (int)get_user_meta($user_id, 'minimum_order_price', true);

        if ($user === FALSE) {
            // 指定ユーザーが存在しない場合 => プロフィールページに遷移
            wp_redirect(get_author_posts_url(get_current_user_id()));
            exit();
        }
    }

    $tcd_membership_vars['specifyUser']       = $specifyUser;
    $tcd_membership_vars['specifyUserId']     = $user_id;
    $tcd_membership_vars['minimumOrderPrice'] = $minimumOrderPrice;
    $tcd_membership_vars['budget']            = '';
    $tcd_membership_vars['app_dead_line']     = DEFAULT_APP_DEAD_LINE;

    $desiredDateY   = '';
    $desiredDateM   = '';
    $desiredDateD   = '';

    if ('POST' == $_SERVER['REQUEST_METHOD']) {
        // POSTされた場合の処理

        $tcd_membership_vars['post_data']     = $_POST;
        $tcd_membership_vars['budget']        = (int)$_POST['budget'];
        $tcd_membership_vars['app_dead_line'] = $_POST['appDeadline'];

        $desiredDateY   = $_POST['desiredDateY'];
        $desiredDateM   = (int)$_POST['desiredDateM'];
        $desiredDateD   = (int)$_POST['desiredDateD'];

        if (empty($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'tcd_membership_action_request')) {
            $error_messages[] = __('Invalid nonce.', 'tcd-w');
        }

        // 依頼タイトルの入力チェック
        if (!isset($_POST['requestTitle']) || empty($_POST['requestTitle'])) {
            $error_messages['requestTitle'] = '依頼タイトルは必須入力です。';
        }

        if (!isset($_POST['workTitle']) || empty($_POST['workTitle'])) {
            $error_messages['workTitle'] = '依頼内容は必須入力です。';
        }

        if (!isset($_POST['content']) || empty($_POST['content'])) {
            $error_messages['content'] = '本文は必須入力です。';
        }

        if (!isset($_POST['composition']) || empty($_POST['composition'])) {
            $error_messages['composition'] = '構図は必須入力です。';
        }

        if (!isset($_POST['character']) || empty($_POST['character'])) {
            $error_messages['character'] = 'キャラクターは必須入力です。';
        }

        if (isset($_POST['refUrl']) && !empty($_POST['refUrl'])) {
            if (!filter_var($_POST['refUrl'], FILTER_VALIDATE_URL)) {
                $error_messages['refUrl'] = 'URLの形式を御確認下さい。';
            }
        }

        if (!isset($_POST['budget']) || empty($_POST['budget'])) {
            $error_messages['budget'] = '予算は必須入力です。';
        }

        // $tcd_membership_vars['view_deadline'] = '';
        $tcd_membership_vars['view_desired_date'] = '';
        $desiredDate = false;
        if (
            isset($_POST['desiredDateY']) && !empty($_POST['desiredDateY']) ||
            isset($_POST['desiredDateM']) && !empty($_POST['desiredDateM']) ||
            isset($_POST['desiredDateD']) && !empty($_POST['desiredDateD'])
        ) {
            try {

                $desiredDateClass = new DateTime($_POST['desiredDateY'] . '-' . $_POST['desiredDateM'] . '-' . $_POST['desiredDateD']);
                $desiredDate = $desiredDateClass->format('Y-m-d');
            } catch (Exception $e) {
                $error_messages['appDeadline'] = '応募期限を正しく入力してください。';
            }
        }

        // 画像アップロード処理
        // $tcd_membership_vars['post_data']['request_file_url']  = '';
        // $tcd_membership_vars['post_data']['request_file_name'] = '';
        $requestFileUrl  = false;
        $requestFileName = false;

        if (!empty($_FILES['requestFile']['name'])) {
            $extension = pathinfo($_FILES['requestFile']['name'], PATHINFO_EXTENSION);
            $file_name = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 100) . '.' . $extension;
            $uploaded_file = __DIR__ . '/../../upload_file/' . $file_name;
            $result = move_uploaded_file($_FILES['requestFile']['tmp_name'], $uploaded_file);
            if ($result) {
                // $tcd_membership_vars['post_data']['request_file_url']  = get_template_directory_uri() . '/upload_file/' . $file_name;
                // $tcd_membership_vars['post_data']['request_file_name'] = $_FILES['file']['name'];

                $requestFileUrl  = get_template_directory_uri() . '/upload_file/' . $file_name;
                $requestFileName = $_FILES['requestFile']['name'];
            }
        }

        // var_dump($error_messages);exit;
        if (count($error_messages) <= 0) {
            // 登録処理
            // $tcd_membership_vars['template']  = 'muse_request_input_confirm';

            $my_post = [
                'post_title'        => $_POST['requestTitle'],
                'post_content'      => $_POST['content'],
                'post_name'         => $_POST['workTitle'],
                'post_status'       => 'publish',
                'post_type'         => 'post'
            ];
            $post_id = wp_insert_post($my_post);


            // wp_tcd_membership_action_metasの登録
            foreach (ARRAY_DB_COLUM as $oneInsertColum) {
                if (isset($_POST[$oneInsertColum]) && !empty($_POST[$oneInsertColum])) {
                    $result = $wpdb->insert(
                        'wp_postmeta',
                        array(
                            'post_id'    => $post_id,
                            'meta_key'   => $oneInsertColum,
                            'meta_value' => $_POST[$oneInsertColum],
                        ),
                        array(
                            '%d',
                            '%s',
                            '%s'
                        )
                    );
                }
            }

            // ファイルの名称の登録
            $result = $wpdb->insert(
                'wp_postmeta',
                [
                    'post_id'    => $post_id,
                    'meta_key'   => 'requestFileName',
                    'meta_value' => $requestFileName,
                ],
                [
                    '%d',
                    '%s',
                    '%s'
                ]
            );

            // ファイルのURLの登録
            $result = $wpdb->insert(
                'wp_postmeta',
                [
                    'post_id'    => $post_id,
                    'meta_key'   => 'requestFileUrl',
                    'meta_value' => $requestFileUrl,
                ],
                [
                    '%d',
                    '%s',
                    '%s'
                ]
            );

            // 応募期限の登録
            $nowDate = new DateTime();
            $nowDate->modify('+' . $_POST['appDeadline']);
            $result = $wpdb->insert(
                'wp_postmeta',
                [
                    'post_id'    => $post_id,
                    'meta_key'   => 'appDeadlineDate',
                    'meta_value' => $nowDate->format('Y-m-d'),
                ],
                [
                    '%d',
                    '%s',
                    '%s'
                ]
            );

            $result = $wpdb->insert(
                'wp_postmeta',
                [
                    'post_id'    => $post_id,
                    'meta_key'   => 'appDeadlineDateKey',
                    'meta_value' => $_POST['appDeadline'],
                ],
                [
                    '%d',
                    '%s',
                    '%s'
                ]
            );

            // 納品希望日の登録
            if ($desiredDate) {
                $result = $wpdb->insert(
                    'wp_postmeta',
                    [
                        'post_id'    => $post_id,
                        'meta_key'   => 'desiredDate',
                        'meta_value' => $desiredDate,
                    ],
                    [
                        '%d',
                        '%s',
                        '%s'
                    ]
                );
            }

            // デフォルトの登録完了時の遷移先
            $redirectUrl = get_tcd_membership_memberpage_url('list_order') . '&status=request_complete';
            if (isset($_POST['specify_user_id']) && !empty($_POST['specify_user_id'])) {
                $userId = $_POST['specify_user_id'];
                $result = $wpdb->insert(
                    'wp_postmeta',
                    [
                        'post_id'    => $post_id,
                        'meta_key'   => 'specify_user_id',
                        'meta_value' => $userId,
                    ],
                    [
                        '%d',
                        '%s',
                        '%s'
                    ]
                );

                // ユーザー指名がある場合の遷移先(指名ユーザーのプロフィール画面)
                $redirectUrl = get_tcd_membership_memberpage_url('profile') . '&user_id=' . $userId;
            }

            // 指定ユーザーがいない場合Tweet
            // $message = '依頼が発行されました。';
            // $uri = '/?memberpage=confirm_request&request_id=' . $post_id;
            // publishTwitter($message, $uri);

            wp_redirect(remove_query_arg('settings-updated', $redirectUrl));
            $_SESSION['success'] = '依頼の登録が完了しました。';
            $tcd_membership_vars['error_message'] = $error_messages;
        }
    }

    // 値の初期化
    $tcd_membership_vars['desiredDateY']   = $desiredDateY;
    $tcd_membership_vars['desiredDateM']   = (int)$desiredDateM;
    $tcd_membership_vars['desiredDateD']   = (int)$desiredDateD;
    $tcd_membership_vars['array_budget']   = ARRAY_BUDGET;
    $tcd_membership_vars['array_app_dead_line']   = ARRAY_APP_DEAD_LINE;

    // ブラウザのキャッシュを無効にするヘッダー出力
    nocache_headers();
}

/**
 * リクエスト更新の処理
 */
add_action('tcd_membership_action-modify_request', 'tcd_membership_action_modify_request');
function tcd_membership_action_modify_request()
{
    global $tcd_membership_vars;

    $user_id = (int)get_current_user_id();
    if (!isset($_REQUEST['request_id']) && empty($_REQUEST['request_id'])) {
        // リクエストIDが存在しない場合 => トップページに遷移
        wp_redirect('/');
        exit();
    }
    $request_id = $_REQUEST['request_id'];
    $tcd_membership_vars['request_id'] = $request_id;

    // リクエスト一覧の取得
    $postsObj = get_post($request_id);
    if ($postsObj->post_status !== 'publish' || $postsObj->post_type !== 'post') {
        // 公開中のリクエストではない場合 => トップページに遷移
        wp_redirect('/');
        exit();
    }

    // var_dump($postsObj);exit;
    if (get_current_user_id() !== (int)$postsObj->post_author) {
        // 登録ユーザーとログインユーザーが違う場合 => トップページに遷移
        wp_redirect('/');
        exit();
    }

    // リクエストユーザーの確認
    $specifyUserId     = false;
    $minimumOrderPrice = 0;
    $arraySpecifyUserId = get_post_meta($request_id, 'specify_user_id');
    if (isset($arraySpecifyUserId[0])) {
        $specifyUserId = (int)$arraySpecifyUserId[0];
        $minimumOrderPrice = (int)get_user_meta($user_id, 'minimum_order_price', true);
    }
    $tcd_membership_vars['specifyUserId'] = $specifyUserId;
    $tcd_membership_vars['minimumOrderPrice'] = $minimumOrderPrice;

    // 依頼タイトルの取得
    $tcd_membership_vars['requestTitle']   = $postsObj->post_title;

    // 作品タイトルの取得
    $tcd_membership_vars['workTitle']   = urldecode($postsObj->post_name);

    // 本文の取得
    $tcd_membership_vars['content']   = $postsObj->post_content;

    // 構図の取得
    $tcd_membership_vars['composition']   = get_post_meta($request_id, 'composition', true);

    // キャラクターの取得
    $tcd_membership_vars['character']   = get_post_meta($request_id, 'character', true);

    // 受付数の取得
    $tcd_membership_vars['orderQuantity']   = get_post_meta($request_id, 'orderQuantity', true);

    // 参考URLの取得
    $tcd_membership_vars['refUrl']   = get_post_meta($request_id, 'refUrl', true);

    // 予算の取得
    $tcd_membership_vars['budget']   = (int)get_post_meta($request_id, 'budget', true);

    // 応募期限の取得
    $tcd_membership_vars['appDeadlineDateKey']   = get_post_meta($request_id, 'appDeadlineDateKey', true);

    // 納品希望日の取得
    $desiredDate  = get_post_meta($request_id, 'desiredDate');

    // 添付ファイル名の取得
    $tcd_membership_vars['requestFileName'] = get_post_meta($request_id, 'requestFileName');
    $tcd_membership_vars['requestFileUrl']  = get_post_meta($request_id, 'requestFileUrl');

    $strDesiredDate = '';
    $desiredDateY   = '';
    $desiredDateM   = '';
    $desiredDateD   = '';
    if (!empty($desiredDate)) {
        $desiredDateClass = new DateTime($desiredDate[0]);
        $desiredDateClass->setTimezone(new DateTimeZone('Asia/Tokyo'));
        $strDesiredDate   = $desiredDateClass->format('Y/m/d');

        $tcd_membership_vars['desiredDateY']   = $desiredDateClass->format('Y');
        $tcd_membership_vars['desiredDateM']   = (int)$desiredDateClass->format('m');
        $tcd_membership_vars['desiredDateD']   = (int)$desiredDateClass->format('d');
    }
    $tcd_membership_vars['desired_date'] = $strDesiredDate;

    $error_messages = [];
    if ('POST' == $_SERVER['REQUEST_METHOD']) {
        // POSTされた場合の処理

        $tcd_membership_vars['post_data']     = $_POST;
        $tcd_membership_vars['budget']        = (int)$_POST['budget'];
        $tcd_membership_vars['app_dead_line'] = $_POST['appDeadline'];

        $tcd_membership_vars['desiredDateY']   = $_POST['desiredDateY'];
        $tcd_membership_vars['desiredDateM']   = (int)$_POST['desiredDateM'];
        $tcd_membership_vars['desiredDateD']   = (int)$_POST['desiredDateD'];

        $tcd_membership_vars['requestTitle']   = $_POST['requestTitle'];
        $tcd_membership_vars['workTitle']   = $_POST['workTitle'];
        $tcd_membership_vars['content']   = $_POST['content'];
        $tcd_membership_vars['composition']   = $_POST['composition'];
        $tcd_membership_vars['character']   = $_POST['character'];
        $tcd_membership_vars['orderQuantity']   = $_POST['orderQuantity'];
        $tcd_membership_vars['refUrl']   = $_POST['refUrl'];
        $tcd_membership_vars['budget']   = $_POST['budget'];

        if (empty($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'tcd_membership_action_request')) {
            $error_messages[] = __('Invalid nonce.', 'tcd-w');
        }

        // 依頼タイトルの入力チェック
        if (!isset($_POST['requestTitle']) || empty($_POST['requestTitle'])) {
            $error_messages['requestTitle'] = '依頼タイトルは必須入力です。';
        }

        if (!isset($_POST['workTitle']) || empty($_POST['workTitle'])) {
            $error_messages['workTitle'] = '依頼内容は必須入力です。';
        }

        if (!isset($_POST['content']) || empty($_POST['content'])) {
            $error_messages['content'] = '本文は必須入力です。';
        }

        if (!isset($_POST['composition']) || empty($_POST['composition'])) {
            $error_messages['composition'] = '構図は必須入力です。';
        }

        if (!isset($_POST['character']) || empty($_POST['character'])) {
            $error_messages['character'] = 'キャラクターは必須入力です。';
        }

        if (isset($_POST['refUrl']) && !empty($_POST['refUrl'])) {
            if (!filter_var($_POST['refUrl'], FILTER_VALIDATE_URL)) {
                $error_messages['refUrl'] = 'URLの形式を御確認下さい。';
            }
        }

        if (!isset($_POST['budget']) || empty($_POST['budget'])) {
            $error_messages['budget'] = '予算は必須入力です。';
        }

        // $tcd_membership_vars['view_deadline'] = '';
        $tcd_membership_vars['view_desired_date'] = '';
        $desiredDate = false;
        if (
            isset($_POST['desiredDateY']) && !empty($_POST['desiredDateY']) ||
            isset($_POST['desiredDateM']) && !empty($_POST['desiredDateM']) ||
            isset($_POST['desiredDateD']) && !empty($_POST['desiredDateD'])
        ) {
            try {

                $desiredDateClass = new DateTime($_POST['desiredDateY'] . '-' . $_POST['desiredDateM'] . '-' . $_POST['desiredDateD']);
                $desiredDate = $desiredDateClass->format('Y-m-d');
            } catch (Exception $e) {
                $error_messages['appDeadline'] = '応募期限を正しく入力してください。';
            }
        }

        // 画像アップロード処理
        // $tcd_membership_vars['post_data']['request_file_url']  = '';
        // $tcd_membership_vars['post_data']['request_file_name'] = '';
        $requestFileUrl  = false;
        $requestFileName = false;

        if (!empty($_FILES['requestFile']['name'])) {
            $extension = pathinfo($_FILES['requestFile']['name'], PATHINFO_EXTENSION);
            $file_name = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 100) . '.' . $extension;
            $uploaded_file = __DIR__ . '/../../upload_file/' . $file_name;
            $result = move_uploaded_file($_FILES['requestFile']['tmp_name'], $uploaded_file);
            if ($result) {
                // $tcd_membership_vars['post_data']['request_file_url']  = get_template_directory_uri() . '/upload_file/' . $file_name;
                // $tcd_membership_vars['post_data']['request_file_name'] = $_FILES['file']['name'];

                $requestFileUrl  = get_template_directory_uri() . '/upload_file/' . $file_name;
                $requestFileName = $_FILES['requestFile']['name'];
            }
        }

        if (count($error_messages) <= 0) {
            update_request($requestFileUrl, $requestFileName);
            $_SESSION['messageUpdateConfirm'] = '更新が完了しました。';
            wp_safe_redirect(get_tcd_membership_memberpage_url('confirm_request') . '&request_id=' . $request_id);
            exit;
        }
    }

    // テンプレートの指定
    $tcd_membership_vars['template']  = 'muse_request_modify';

    // 配列を渡す処理
    $tcd_membership_vars['array_budget']   = ARRAY_BUDGET;
    $tcd_membership_vars['array_app_dead_line']   = ARRAY_APP_DEAD_LINE;

    nocache_headers();
}

/**
 * リクエスト確認の処理
 */
add_action('tcd_membership_action-confirm_request', 'tcd_membership_action_confirm_request');
function tcd_membership_action_confirm_request()
{
    global $tcd_membership_vars;

    var_dump(__LINE__);
    exit;

    // ブラウザのキャッシュを無効にするヘッダー出力
    nocache_headers();
}

/**
 * 募集リクエストの一覧
 */
add_action('tcd_membership_action-list_order', 'tcd_membership_action_list_order');
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
    $tcd_membership_vars['array_budget']  = ARRAY_BUDGET;
}

/**
 * リクエストの一覧
 */
add_action('tcd_membership_action-list_received', 'tcd_membership_action_list_received');
function tcd_membership_action_list_received()
{
    global $tcd_membership_vars;
    var_dump(__LINE__);
    exit;

    $tcd_membership_vars['array_budget']  = ARRAY_BUDGET;
}

/**
 * 進行中リクエストの一覧
 */
add_action('tcd_membership_action-in_progress', 'tcd_membership_action_in_progress');
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
    $tcd_membership_vars['list_order'] = $listInProgress;
    $tcd_membership_vars['post_data']  = $postData;

    $tcd_membership_vars['array_budget']  = ARRAY_BUDGET;
}

// ▼ ここから内部Function
/**
 * オーダー一覧の取得
 *
 * @param [type] $post_title
 * @param [type] $post_content
 * @return void
 */
function listOrder($up_budget, $down_budget, $whereDeadLine, $target)
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
    $sql .= 'WHERE wp_posts.post_type = \'post\' ';
    $sql .= ' AND wp_posts.post_status = \'publish\'';
    $sql .= ' AND wp_posts.post_author = ' . get_current_user_id();

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

    $sql .= ' AND NOT EXISTS (';
    $sql .= ' SELECT * FROM wp_tcd_membership_actions WHERE type=\'received\' AND wp_tcd_membership_actions.post_id = wp_posts.ID';
    $sql .= ')';

    $sql .= ' ORDER BY wp_posts.ID DESC';

    $result = $wpdb->get_results($wpdb->prepare($sql));
    //    echo $sql;exit;
    return $result;
}

/**
 * リクエストの更新
 *
 * @param string $requestFileUrl
 * @param string $requestFileName
 * @return boolean
 */
function update_request($requestFileUrl, $requestFileName)
{
    $request_id   = $_POST['request_id'];

    $desiredDate = false;
    if (
        isset($_POST['desiredDateY']) && !empty($_POST['desiredDateY']) ||
        isset($_POST['desiredDateM']) && !empty($_POST['desiredDateM']) ||
        isset($_POST['desiredDateD']) && !empty($_POST['desiredDateD'])
    ) {
        try {

            $desiredDateClass = new DateTime($_POST['desiredDateY'] . '-' . $_POST['desiredDateM'] . '-' . $_POST['desiredDateD']);
            $desiredDateClass->setTimezone(new DateTimeZone('Asia/Tokyo'));
            $desiredDate = $desiredDateClass->format('Y-m-d');
        } catch (Exception $e) {
            $error_messages['appDeadline'] = '応募期限を正しく入力してください。';
        }
    }

    $composition     = $_POST['composition'];
    $character       = $_POST['character'];
    $orderQuantity   = $_POST['orderQuantity'];
    $refUrl          = $_POST['refUrl'];
    $budget          = $_POST['budget'];
    $title           = $_POST['requestTitle'];
    $content         = $_POST['content'];
    $workTitle       = $_POST['workTitle'];

    $my_post = [
        'ID'           => $request_id,
        'post_title'   => $title,
        'post_content' => $content,
        'post_name'    => $workTitle,
    ];

    // データベースにある投稿を更新する
    wp_update_post($my_post);
    update_post_meta($request_id, 'composition',      $composition);
    update_post_meta($request_id, 'character',        $character);
    update_post_meta($request_id, 'orderQuantity',    $orderQuantity);
    update_post_meta($request_id, 'refUrl',           $refUrl);
    update_post_meta($request_id, 'budget',           $budget);
    if (!empty($_FILES['requestFile']['name'])) {
        update_post_meta($request_id, 'requestFileName',  $requestFileName);
        update_post_meta($request_id, 'requestFileUrl',   $requestFileUrl);
    }
    $nowDate = new DateTime();
    $nowDate->modify('+' . $_POST['appDeadline']);
    update_post_meta($request_id, 'appDeadlineDate',  $nowDate->format('Y-m-d'));
    update_post_meta($request_id, 'appDeadlineDateKey', $_POST['appDeadline']);

    if ($desiredDate !== FALSE) {
        update_post_meta($request_id, 'desiredDate',  $desiredDate);
    }
}

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
    $sql .= 'INNER JOIN wp_tcd_membership_actions ';
    $sql .= 'ON wp_posts.ID = wp_tcd_membership_actions.post_id ';
    $sql .= ' AND wp_tcd_membership_actions.type = \'received\' ';
    $sql .= 'WHERE wp_posts.post_type = \'post\' ';
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
