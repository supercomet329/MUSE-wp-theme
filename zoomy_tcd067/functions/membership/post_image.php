<?php
// Add 2022/05/10 by H.Okabe
/**
 * 作品依頼発注一覧ページ
 */
function tcd_membership_action_post_image()
{
    global $tcd_membership_vars, $wpdb;

    nocache_headers();

    ini_set('display_error', 'on');
    $user = wp_get_current_user();

    if (!$user) {
        var_dump(__LINE__);
        exit;
        wp_safe_redirect(user_trailingslashit(home_url()));
        exit;
    }

    $error_message = [];
    if ('POST' == $_SERVER['REQUEST_METHOD']) {
        $tcd_membership_vars['post_data'] = $_POST;

        // 値がPOSTされたときの対応
        if (empty($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'tcd-membership-post_image')) {

            // nonceが一致しない場合 => トップページに遷移
            wp_safe_redirect(home_url('/'));
            exit;
        }
        // バリデート

        // 投稿画像
        $requestFileUrl  = false;
        $requestFileName = false;

        if (isset($_FILES['postFile']['name']) && !empty($_FILES['postFile']['name'])) {
            $extension = pathinfo($_FILES['postFile']['name'], PATHINFO_EXTENSION);
            $file_name = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 100) . '.' . $extension;
            $uploaded_file = __DIR__ . '/../../upload_file/' . $file_name;
            $result = move_uploaded_file($_FILES['postFile']['tmp_name'], $uploaded_file);
            if ($result) {
                $requestFileUrl  = get_template_directory_uri() . '/upload_file/' . $file_name;
                $requestFileName = $_FILES['postFile']['name'];
            } else {
                $error_messages['postFile'] = 'ファイルのアップロードに失敗しました。';
            }
        } else {
            $error_messages['postFile'] = 'ファイルをアップロードしてください。';
        }

        // タイトル
        if (!isset($_POST['postTitle']) || empty($_POST['postTitle'])) {
            $error_messages['postTitle'] = 'タイトルは必須入力です。';
        }

        if ($_POST['saleType'] === 'sale') {
            // 販売形式の場合

            // 販売金額
            if (!isset($_POST['imagePrice']) || empty($_POST['imagePrice'])) {
                $error_messages['imagePrice'] = '販売金額を入力してください';
            }

            // 即決価格
            if (!isset($_POST['binPrice']) || empty($_POST['binPrice'])) {
                $error_messages['binPrice'] = '販売金額を入力してください';
            }
        } elseif ($_POST['saleType'] === 'auction') {
            // オークションの場合

            // 開始時間の指定がある場合
            if ($_POST['auctionStartDate'] === 'specify') {
                if (
                    !isset($_POST['auctionDateY']) || empty($_POST['auctionDateY']) ||
                    !isset($_POST['auctionDateM']) || empty($_POST['auctionDateM']) ||
                    !isset($_POST['auctionDateD']) || empty($_POST['auctionDateD']) ||
                    !isset($_POST['auctionDateH']) || empty($_POST['auctionDateH']) ||
                    !isset($_POST['auctionDateMin']) || empty($_POST['auctionDateMin'])
                ) {
                    $error_messages['appDeadlineMsg'] = 'オークション開始日時を入力してください';
                } else {
                    $auctionDate = $_POST['auctionDateY'] . '-' . $_POST['auctionDateM'] . '-' . $_POST['auctionDateD'] . ' ' . $_POST['auctionDateH'] . ':' . $_POST['auctionDateMin'] . ':00';
                    if (!validate_date($auctionDate)) {
                        $error_messages['appDeadlineMsg'] = 'オークション開始日時を入力してください';
                    }
                }

                if (
                    !isset($_POST['auctionEndDateY']) || empty($_POST['auctionEndDateY']) ||
                    !isset($_POST['auctionEndDateM']) || empty($_POST['auctionEndDateM']) ||
                    !isset($_POST['auctionEndDateD']) || empty($_POST['auctionEndDateD']) ||
                    !isset($_POST['auctionEndDateH']) || empty($_POST['auctionEndDateH']) ||
                    !isset($_POST['auctionEndDateMin']) || empty($_POST['auctionEndDateMin'])
                ) {
                    $error_messages['auctionEndDate'] = 'オークション開始日時を入力してください';
                } else {
                    $auctionEndDate = $_POST['auctionEndDateY'] . '-' . $_POST['auctionEndDateM'] . '-' . $_POST['auctionEndDateD'] . ' ' . $_POST['auctionEndDateH'] . ':' . $_POST['auctionEndDateMin'] . ':00';
                    if (!validate_date($auctionEndDate)) {
                        $error_messages['auctionEndDate'] = 'オークション開始日時を入力してください';
                    }
                }
            }
        } else {
        }

        if (count($error_messages) <= 0) {
            // 登録処理
            // wp_postsに登録
            $my_post = array(
                'post_title'        => $_POST['postTitle'],
                'post_content'      => $_POST['postDetail'],
                'post_name'         => $_POST['postTitle'],
                'post_status'       => 'publish',
                'post_type'         => 'photo'
            );
            $post_id = wp_insert_post($my_post);

            $result = $wpdb->insert(
                'wp_postmeta',
                array(
                    'post_id'    => $post_id,
                    'meta_key'   => 'main_image',
                    'meta_value' => $requestFileUrl,
                ),
                array(
                    '%d',
                    '%s',
                    '%s'
                )
            );

            $result = $wpdb->insert(
                'wp_postmeta',
                array(
                    'post_id'    => $post_id,
                    'meta_key'   => 'image_name',
                    'meta_value' => $requestFileName,
                ),
                array(
                    '%d',
                    '%s',
                    '%s'
                )
            );

            if ($_POST['suitableAges'] === 'r18') {
                // R18フラグがある場合 => 18フラグを登録
                $result = $wpdb->insert(
                    'wp_postmeta',
                    array(
                        'post_id'    => $post_id,
                        'meta_key'   => 'r18',
                        'meta_value' => 1,
                    ),
                    array(
                        '%d',
                        '%s',
                        '%s'
                    )
                );
            }

            if ($_POST['saleType'] === 'sale') {
                // 通常販売の場合
                $result = $wpdb->insert(
                    'wp_postmeta',
                    array(
                        'post_id'    => $post_id,
                        'meta_key'   => 'imagePrice',
                        'meta_value' => $_POST['imagePrice'],
                    ),
                    array(
                        '%d',
                        '%s',
                        '%s'
                    )
                );

                $result = $wpdb->insert(
                    'wp_postmeta',
                    array(
                        'post_id'    => $post_id,
                        'meta_key'   => 'binPrice',
                        'meta_value' => $_POST['binPrice'],
                    ),
                    array(
                        '%d',
                        '%s',
                        '%s'
                    )
                );
            } elseif ($_POST['saleType'] === 'auction') {
                // オークションの場合

                $result = $wpdb->insert(
                    'wp_postmeta',
                    array(
                        'post_id'    => $post_id,
                        'meta_key'   => 'auctionDate',
                        'meta_value' => $auctionDate,
                    ),
                    array(
                        '%d',
                        '%s',
                        '%s'
                    )
                );

                $result = $wpdb->insert(
                    'wp_postmeta',
                    array(
                        'post_id'    => $post_id,
                        'meta_key'   => 'auctionEndDate',
                        'meta_value' => $auctionEndDate,
                    ),
                    array(
                        '%d',
                        '%s',
                        '%s'
                    )
                );
            } else {
                // 販売しない場合
            }

            $url = get_author_posts_url(get_current_user_id());
            wp_safe_redirect( $url );
            exit();
        }
    }

    $chkSaleType = 'sale';
    if (isset($_POST['saleType'])) {
        $chkSaleType = $_POST['saleType'];
    }

    $suitableAges = 'allAges';
    if (isset($_POST['allAges'])) {
        $suitableAges = $_POST['suitableAges'];
    }

    $extendAuction = 'enableAutoExtend';
    if (isset($_POST['extendAuction'])) {
        $extendAuction = $_POST['extendAuction'];
    }

    $auctionStartDate = 'notSpecified';
    if (isset($_POST['auctionStartDate'])) {
        $auctionStartDate = $_POST['auctionStartDate'];
    }

    // テンプレート指定
    $tcd_membership_vars['template']  = 'muse_post_image';
    $tcd_membership_vars['chk_sele_type'] = $chkSaleType;
    $tcd_membership_vars['extend_auction'] = $extendAuction;
    $tcd_membership_vars['chk_suitable_ages'] = $suitableAges;
    $tcd_membership_vars['auction_start_date'] = $auctionStartDate;
    $tcd_membership_vars['error'] = $error_messages;
}
add_action('tcd_membership_action-post_image', 'tcd_membership_action_post_image');
