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

    $arrayInsertColum = [
        'composition',
        'character',
        'refUrl',
        'budget',
        'orderQuantity',
        'specialNotes',
    ];

    $user = wp_get_current_user();
    $request_id = $_REQUEST['request_id'];
    $rowResuestData = get_request($request_id);

    if (count($rowResuestData) <= 0) {
        wp_safe_redirect(user_trailingslashit(home_url()));
        exit;
    }

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
                    }
                }
                $tcd_membership_vars['error_message'] = $error_messages;

                if (count($error_messages) <= 0) {
                    $my_post = array(
                        'ID'                => $request_id,
                        'post_title'        => $_POST['requestTitle'],
                        'post_content'      => $_POST['content'],
                        'post_name'         => $_POST['workTitle'],
                        'post_status'       => 'publish',
                        'post_type'         => 'request'
                    );
                    wp_update_post($my_post);

                    // wp_tcd_membership_action_metasの登録
                    foreach ($arrayInsertColum as $oneInsertColum) {
                        $result = $wpdb->update(
                            'wp_postmeta',
                            array(
                                'meta_value' => $_POST[$oneInsertColum],
                            ),
                            array(
                                'post_id'    => $request_id,
                                'meta_key'   => $oneInsertColum,
                            ),
                            array(
                                '%s'
                            )
                        );
                    }

                    if ($requestFileUrl) {
                        // ファイルの名称の登録
                        $result = $wpdb->update(
                            'wp_postmeta',
                            array(
                                'meta_value' => $requestFileName,
                            ),
                            array(
                                'post_id'    => $request_id,
                                'meta_key'   => 'requestFileName',
                            ),
                            array(
                                '%s'
                            )
                        );

                        $result = $wpdb->update(
                            'wp_postmeta',
                            array(
                                'meta_value' => $requestFileUrl,
                            ),
                            array(
                                'post_id'    => $request_id,
                                'meta_key'   => 'requestFileUrl',
                            ),
                            array(
                                '%s'
                            )
                        );
                    }

                    $result = $wpdb->update(
                        'wp_postmeta',
                        array(
                            'meta_value' => $appDeadlineDate,
                        ),
                        array(
                            'post_id'    => $request_id,
                            'meta_key'   => 'appDeadlineDate',
                        ),
                        array(
                            '%s'
                        )
                    );

                    // 納品希望日の登録
                    if ($desiredDate) {
                        $result = $wpdb->insert(
                            'wp_postmeta',
                            array(
                                'post_id'    => $request_id,
                                'meta_key'   => 'desiredDate',
                                'meta_value' => $desiredDate,
                            ),
                            array(
                                '%d',
                                '%s',
                                '%s'
                            )
                        );
                    }
                    $redirect = get_tcd_membership_memberpage_url('list_order') . '&status=request_complete';
                    wp_redirect(remove_query_arg('settings-updated', $redirect));
                }
                $tcd_membership_vars['error_message'] = $error_messages;
            }
        }
    }
    $requestData = [];
    // 作品ID
    $post_id = $rowResuestData[0]->post_id;

    $requestData['post_id'] = $post_id;

    // 作品タイトル
    $requestData['post_name'] = $rowResuestData[0]->post_name;

    // 依頼タイトル
    $requestData['title'] = $rowResuestData[0]->post_title;

    // 依頼内容
    $requestData['content'] = $rowResuestData[0]->post_content;

    // 構図
    $requestData['composition'] = get_post_meta($post_id, 'composition', true);

    // キャラクター
    $requestData['character'] = get_post_meta($post_id, 'character', true);

    // 受付依頼数
    $requestData['orderQuantity'] = get_post_meta($post_id, 'orderQuantity', true);

    // 添付ファイル
    $requestData['requestFileName'] = get_post_meta($post_id, 'requestFileName', true);
    $requestData['requestFileUrl']  = get_post_meta($post_id, 'requestFileUrl', true);

    $filePathArray = explode('/', $requestData['requestFileUrl']);
    $fileName = end($filePathArray);
    $checkFile = __DIR__ . '/../../upload_file/' . $fileName;
    $requestData['requestFileFlag']  = exif_imagetype($checkFile);

    // 参考URL
    $requestData['refUrl']  = get_post_meta($post_id, 'refUrl', true);

    // 予算
    $requestData['budget']  = get_post_meta($post_id, 'budget', true);

    // 特記事項
    $requestData['specialNotes']  = get_post_meta($post_id, 'specialNotes', true);

    // 応募期限
    $appDeadlineDate = get_post_meta($post_id, 'appDeadlineDate', true);
    $appDeadClass = new DateTime($appDeadlineDate);
    $requestData['appDeadlineDate']  = $appDeadClass->format('Y/m/d');

    // 納品希望日
    $requestData['desiredDate']  = false;
    $desiredDate = get_post_meta($post_id, 'desiredDate', true);
    if (!empty($desiredDate)) {
        $desiredDateClass = new DateTime($desiredDate);
        $desiredDate = $desiredDateClass->format('Y/m/d');
    }
    $requestData['desiredDate']  = $desiredDate;
    $requestData['request_id'] = $request_id;

    $tcd_membership_vars['requestData'] = $requestData;

    nocache_headers();
    if (!$user) {
        wp_safe_redirect(user_trailingslashit(home_url()));
        exit;
    }
}
add_action('tcd_membership_action-modify_request', 'tcd_membership_action_modify_request');
