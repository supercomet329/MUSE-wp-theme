<?php
// Add 2022/05/10 by H.Okabe
/**
 * 依頼リクエスト
 */
function tcd_membership_action_request()
{
    global $wpdb, $tcd_membership_vars;

    // テンプレート指定
    $tcd_membership_vars['template']  = 'muse_request_input';

    $arrayInsertColum = [
        'composition',
        'character',
        'refUrl',
        'budget',
        'orderQuantity',
        'specialNotes',
    ];

    $user = wp_get_current_user();
    if (!$user) {
        wp_safe_redirect(user_trailingslashit(home_url()));
        exit();
    }

    $specifyUser = false;
    $user_id     = false;
    if (isset($_REQUEST['user_id'])) {

        // 指定ユーザーがいる場合
        $specifyUser = true;
        $user_id = $_REQUEST['user_id'];
        $user    = get_userdata($user_id);

        if ($user === FALSE) {
            // 指定ユーザーが存在しない場合 => プロフィールページに遷移
            wp_redirect(get_author_posts_url(get_current_user_id()));
            exit();
        }
    }
    $tcd_membership_vars['specifyUser']   = $specifyUser;
    $tcd_membership_vars['specifyUserId'] = $user_id;

    $error_messages = [];
    if (isset($_GET['status'])) {
        $error_messages[] = '登録が完了しました。';
    }

    $dateClass = new DateTime();
    // php.iniの設定が読み込まれない時があるので。。。
    $dateClass->setTimezone(new DateTimeZone('Asia/Tokyo'));
    $dateClass->modify('+1 month');
    $appDeadlineY   = $dateClass->format('Y');
    $appDeadlineM   = (int)$dateClass->format('m');
    $appDeadlineD   = (int)$dateClass->format('d');

    $desiredDateY   = '';
    $desiredDateM   = '';
    $desiredDateD   = '';

    if ('POST' == $_SERVER['REQUEST_METHOD']) {
        $tcd_membership_vars['post_data'] = $_POST;

        $appDeadlineY   = $_POST['appDeadlineY'];
        $appDeadlineM   = (int)$_POST['appDeadlineM'];
        $appDeadlineD   = (int)$_POST['appDeadlineD'];

        $desiredDateY   = $_POST['desiredDateY'];
        $desiredDateM   = (int)$_POST['desiredDateM'];
        $desiredDateD   = (int)$_POST['desiredDateD'];

        // 値がPOSTされたときの対応
        if (empty($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'tcd_membership_action_request')) {
            $error_messages[] = __('Invalid nonce.', 'tcd-w');
        }

        if (isset($_POST['request_type'])) {
            if ($_POST['request_type'] === 'input') {

                // 入力ページから確認ページの遷移

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
                $appDeadlineDate = false;
                if (
                    isset($_POST['appDeadlineY']) || !empty($_POST['appDeadlineY']) ||
                    isset($_POST['appDeadlineM']) || !empty($_POST['appDeadlineM']) ||
                    isset($_POST['appDeadlineD']) || !empty($_POST['appDeadlineD'])
                ) {

                    try {
                        $appDeadlineDateClass = new DateTime($_POST['appDeadlineY'] . '-' . $_POST['appDeadlineM'] . '-' . $_POST['appDeadlineD']);
                        $appDeadlineDate = $appDeadlineDateClass->format('Y-m-d');
                    } catch (Exception $e) {
                        $error_messages['appDeadline'] = '応募期限を正しく入力してください。';
                    }
                } else {
                    $error_messages['appDeadline'] = '応募期限は必須入力です。';
                }

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

                if (isset($_FILES['requestFile']['name'])) {
                    $extension = pathinfo($_FILES['requestFile']['name'], PATHINFO_EXTENSION);
                    $file_name = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 100) . '.' . $extension;
                    $uploaded_file = __DIR__ . '/../../upload_file/' . $file_name;
                    $result = move_uploaded_file($_FILES['requestFile']['tmp_name'], $uploaded_file);
                    if ($result) {
                        // $tcd_membership_vars['post_data']['request_file_url']  = get_template_directory_uri() . '/upload_file/' . $file_name;
                        // $tcd_membership_vars['post_data']['request_file_name'] = $_FILES['file']['name'];

                        $requestFileUrl  = get_template_directory_uri() . '/upload_file/' . $file_name;
                        $requestFileName = $_FILES['requestFile']['name'];
                    } else {
                        $error_messages['requestFile'] = 'ファイルのアップロードに失敗しました。';
                    }
                } else {
                    $error_messages['requestFile'] = 'ファイルをアップロードしてください。';
                }

                if (count($error_messages) <= 0) {
                    // 登録処理
                    // $tcd_membership_vars['template']  = 'muse_request_input_confirm';

                    $my_post = array(
                        'post_title'        => $_POST['requestTitle'],
                        'post_content'      => $_POST['content'],
                        'post_name'         => $_POST['workTitle'],
                        'post_status'       => 'publish',
                        'post_type'         => 'request'
                    );
                    $post_id = wp_insert_post($my_post);

                    // wp_tcd_membership_action_metasの登録
                    foreach ($arrayInsertColum as $oneInsertColum) {
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
                    $result = $wpdb->insert(
                        'wp_postmeta',
                        [
                            'post_id'    => $post_id,
                            'meta_key'   => 'appDeadlineDate',
                            'meta_value' => $appDeadlineDate,
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

                    if (isset($_POST['specify_user_id']) && !empty($_POST['specify_user_id'])) {
                        $result = $wpdb->insert(
                            'wp_postmeta',
                            [
                                'post_id'    => $post_id,
                                'meta_key'   => 'specify_user_id',
                                'meta_value' => $_POST['specify_user_id'],
                            ],
                            [
                                '%d',
                                '%s',
                                '%s'
                            ]
                        );
                    }

                    // 指定ユーザーがいない場合Tweet
                    // $message = '依頼が発行されました。';
                    // $uri = '/?memberpage=confirm_request&request_id=' . $post_id;
                    // publishTwitter($message, $uri);

                    // TODO: 登録完了時に遷移させるのは依頼一覧
                    $redirect = get_tcd_membership_memberpage_url('list_order') . '&status=request_complete';
                    wp_redirect(remove_query_arg('settings-updated', $redirect));
                }

                $tcd_membership_vars['error_message'] = $error_messages;
            }
        }
    }
    $tcd_membership_vars['appDeadlineY']   = $appDeadlineY;
    $tcd_membership_vars['appDeadlineM']   = (int)$appDeadlineM;
    $tcd_membership_vars['appDeadlineD']   = (int)$appDeadlineD;

    $tcd_membership_vars['desiredDateY']   = $desiredDateY;
    $tcd_membership_vars['desiredDateM']   = (int)$desiredDateM;
    $tcd_membership_vars['desiredDateD']   = (int)$desiredDateD;


    nocache_headers();
}
add_action('tcd_membership_action-request', 'tcd_membership_action_request');
