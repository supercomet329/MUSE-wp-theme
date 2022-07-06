<?php
// Add 2022/05/10 by H.Okabe
/**
 * 作品依頼発注一覧ページ
 */
function tcd_membership_action_post_image()
{
    global $tcd_membership_vars, $wpdb;

    nocache_headers();

    $user = wp_get_current_user();
    if (!$user) {
        wp_safe_redirect(user_trailingslashit(home_url()));
        exit;
    }

    $setDataParams = [];
    $dateClass = new DateTime();
    // FIXED: nginxの場合 php.iniの反映が去れないことがある
    $dateClass->setTimezone(new DateTimeZone('Asia/Tokyo'));
    $setDataParams['setAuctionDateY']   = $dateClass->format('Y');
    $setDataParams['setAuctionDateM']   = (int)$dateClass->format('m');
    $setDataParams['setAuctionDateD']   = (int)$dateClass->format('d');
    $setDataParams['setAuctionDateH']   = (int)$dateClass->format('H');
    $setDataParams['setAuctionDateMin'] = (int)$dateClass->format('i');

    $dateClass->modify('+1 month');
    $setDataParams['setAuctionEndDateY']   = $dateClass->format('Y');
    $setDataParams['setAuctionEndDateM']   = (int)$dateClass->format('m');
    $setDataParams['setAuctionEndDateD']   = (int)$dateClass->format('d');
    $setDataParams['setAuctionEndDateH']   = (int)$dateClass->format('H');
    $setDataParams['setAuctionEndDateMin'] = (int)$dateClass->format('i');

    $error_messages = [];
    if ('POST' == $_SERVER['REQUEST_METHOD']) {
        $tcd_membership_vars['post_data'] = $_POST;

        $setDataParams['setAuctionDateY']   = $_POST['auctionDateY'];
        $setDataParams['setAuctionDateM']   = $_POST['auctionDateM'];
        $setDataParams['setAuctionDateD']   = $_POST['auctionDateD'];
        $setDataParams['setAuctionDateH']   = $_POST['auctionDateH'];
        $setDataParams['setAuctionDateMin'] = $_POST['auctionDateMin'];

        $setDataParams['setAuctionEndDateY']   = $_POST['auctionEndDateY'];
        $setDataParams['setAuctionEndDateM']   = $_POST['auctionEndDateM'];
        $setDataParams['setAuctionEndDateD']   = $_POST['auctionEndDateD'];
        $setDataParams['setAuctionEndDateH']   = $_POST['auctionEndDateH'];
        $setDataParams['setAuctionEndDateMin'] = $_POST['auctionEndDateMin'];

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

            $file_data = base64_decode($_POST['file_data']);

            $resizeFileName = 'resize_' . $file_name;
            $resize_uploaded_file = __DIR__ . '/../../upload_file/' . $resizeFileName;
            $requestResizeFileUrl  = get_template_directory_uri() . '/upload_file/' . $resizeFileName;
            file_put_contents($resize_uploaded_file, $file_data);
        } else {
            $error_messages['postFile'] = 'ファイルをアップロードしてください。';
        }

        $requestFileUrl2  = false;
        if (isset($_FILES['postFile2']['name']) && !empty($_FILES['postFile2']['name'])) {
            $extension = pathinfo($_FILES['postFile2']['name'], PATHINFO_EXTENSION);
            $file_name = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 100) . '.' . $extension;
            $uploaded_file = __DIR__ . '/../../upload_file/' . $file_name;
            $result = move_uploaded_file($_FILES['postFile2']['tmp_name'], $uploaded_file);
            if ($result) {
                $requestFileUrl2  = get_template_directory_uri() . '/upload_file/' . $file_name;
            } else {
                $error_messages['postFile'] = 'ファイルのアップロードに失敗しました。';
            }

            file_put_contents($resize_uploaded_file, $file_data);
        }

        $requestFileUrl3  = false;
        if (isset($_FILES['postFile3']['name']) && !empty($_FILES['postFile3']['name'])) {
            $extension = pathinfo($_FILES['postFile3']['name'], PATHINFO_EXTENSION);
            $file_name = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 100) . '.' . $extension;
            $uploaded_file = __DIR__ . '/../../upload_file/' . $file_name;
            $result = move_uploaded_file($_FILES['postFile3']['tmp_name'], $uploaded_file);
            if ($result) {
                $requestFileUrl3  = get_template_directory_uri() . '/upload_file/' . $file_name;
            } else {
                $error_messages['postFile'] = 'ファイルのアップロードに失敗しました。';
            }

            file_put_contents($resize_uploaded_file, $file_data);
        }

        $requestFileUrl4  = false;
        if (isset($_FILES['postFile4']['name']) && !empty($_FILES['postFile4']['name'])) {
            $extension = pathinfo($_FILES['postFile4']['name'], PATHINFO_EXTENSION);
            $file_name = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 100) . '.' . $extension;
            $uploaded_file = __DIR__ . '/../../upload_file/' . $file_name;
            $result = move_uploaded_file($_FILES['postFile4']['tmp_name'], $uploaded_file);
            if ($result) {
                $requestFileUrl4  = get_template_directory_uri() . '/upload_file/' . $file_name;
            } else {
                $error_messages['postFile'] = 'ファイルのアップロードに失敗しました。';
            }

            file_put_contents($resize_uploaded_file, $file_data);
        }

        // バリデート

        // saleTypeがNFT販売の場合
        $saleType = $_POST['saleType'];
        if ($saleType === 'sale') {

            $auctionStartDate = $_POST['auctionStartDate'];
            if ($auctionStartDate === 'specify') {
                // オークションの場合
                $auctionDateUnix = false;
                if (
                    !isset($_POST['auctionDateY']) || empty($_POST['auctionDateY']) ||
                    !isset($_POST['auctionDateM']) || empty($_POST['auctionDateM']) ||
                    !isset($_POST['auctionDateD']) || empty($_POST['auctionDateD']) ||
                    !isset($_POST['auctionDateH']) || empty($_POST['auctionDateH']) ||
                    !isset($_POST['auctionDateMin']) || empty($_POST['auctionDateMin'])
                ) {
                    $error_messages['appDeadlineMsg'] = 'オークション開始日時を入力してください';
                } else {
                    $auctionDate = $_POST['auctionDateY'] . '-' . str_pad($_POST['auctionDateM'], 2, "0", STR_PAD_LEFT)  . '-' . str_pad($_POST['auctionDateD'], 2, "0", STR_PAD_LEFT) . ' ' . str_pad($_POST['auctionDateH'], 2, "0", STR_PAD_LEFT) . ':' . str_pad($_POST['auctionDateMin'], 2, "0", STR_PAD_LEFT) . ':00';

                    $auctionDateClass = new DateTime($auctionDate);
                    $auctionDateUnix = $auctionDateClass->format('U');
                    if (!validate_date($auctionDate)) {
                        $error_messages['appDeadlineMsg'] = 'オークション開始日時を入力してください';
                    }
                }

                $auctionEndDateUnix = false;
                if (
                    !isset($_POST['auctionEndDateY']) || empty($_POST['auctionEndDateY']) ||
                    !isset($_POST['auctionEndDateM']) || empty($_POST['auctionEndDateM']) ||
                    !isset($_POST['auctionEndDateD']) || empty($_POST['auctionEndDateD']) ||
                    !isset($_POST['auctionEndDateH']) || empty($_POST['auctionEndDateH']) ||
                    !isset($_POST['auctionEndDateMin']) || empty($_POST['auctionEndDateMin'])
                ) {
                    $error_messages['auctionEndDate'] = 'オークション開始日時を入力してください';
                } else {
                    $auctionEndDate = $_POST['auctionEndDateY'] . '-' . str_pad($_POST['auctionEndDateM'], 2, "0", STR_PAD_LEFT)  . '-' . str_pad($_POST['auctionEndDateD'], 2, "0", STR_PAD_LEFT) . ' ' . str_pad($_POST['auctionEndDateH'], 2, "0", STR_PAD_LEFT) . ':' . str_pad($_POST['auctionEndDateMin'], 2, "0", STR_PAD_LEFT) . ':00';
                    $auctionEndDateClass = new DateTime($auctionEndDate);
                    $auctionEndDateUnix = $auctionEndDateClass->format('U');
                    if (!validate_date($auctionEndDate)) {
                        $error_messages['auctionEndDate'] = 'オークション終了日時を入力してください';
                    }
                }

                if ($auctionDateUnix && $auctionEndDateUnix) {
                    if ($auctionDateUnix > $auctionEndDateUnix) {
                        $error_messages['auctionEndDate'] = 'オークション日時の御確認を御願い致します。';
                    }
                }
            } else {
                if (!isset($_POST['imagePrice']) || empty($_POST['imagePrice'])) {
                    $error_messages['imagePrice'] = '販売金額を入力してください';
                }

                // 即決価格
                if (!isset($_POST['binPrice']) || empty($_POST['binPrice'])) {
                    $error_messages['binPrice'] = '販売金額を入力してください';
                }
            }
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
                    'meta_key'   => 'resize_image',
                    'meta_value' => $requestResizeFileUrl,
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

            if ($requestFileUrl2) {
                $result = $wpdb->insert(
                    'wp_postmeta',
                    array(
                        'post_id'    => $post_id,
                        'meta_key'   => 'main_image2',
                        'meta_value' => $requestFileUrl2,
                    ),
                    array(
                        '%d',
                        '%s',
                        '%s'
                    )
                );
            }

            if ($requestFileUrl3) {
                $result = $wpdb->insert(
                    'wp_postmeta',
                    array(
                        'post_id'    => $post_id,
                        'meta_key'   => 'main_image3',
                        'meta_value' => $requestFileUrl3,
                    ),
                    array(
                        '%d',
                        '%s',
                        '%s'
                    )
                );
            }

            if ($requestFileUrl4) {
                $result = $wpdb->insert(
                    'wp_postmeta',
                    array(
                        'post_id'    => $post_id,
                        'meta_key'   => 'main_image4',
                        'meta_value' => $requestFileUrl4,
                    ),
                    array(
                        '%d',
                        '%s',
                        '%s'
                    )
                );
            }

            $result = $wpdb->insert(
                'wp_postmeta',
                array(
                    'post_id'    => $post_id,
                    'meta_key'   => 'saleType',
                    'meta_value' => $_POST['saleType'],
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
                $selectAuction    = $_POST['selectAuction'];
                $result = $wpdb->insert(
                    'wp_postmeta',
                    array(
                        'post_id'    => $post_id,
                        'meta_key'   => 'selectAuction',
                        'meta_value' => $selectAuction,
                    ),
                    array(
                        '%d',
                        '%s',
                        '%s'
                    )
                );

                if ($selectAuction === 'Auction') {
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
                } else {
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
                }


                $auctionStartDate = $_POST['auctionStartDate'];
                if ($auctionStartDate === 'specify') {

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

                    $result = $wpdb->insert(
                        'wp_postmeta',
                        array(
                            'post_id'    => $post_id,
                            'meta_key'   => 'auction_start_date',
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
                            'meta_key'   => 'auction_end_date',
                            'meta_value' => $auctionEndDate,
                        ),
                        array(
                            '%d',
                            '%s',
                            '%s'
                        )
                    );

                    $extendAuction = $_POST['extendAuction'];
                    $result = $wpdb->insert(
                        'wp_postmeta',
                        array(
                            'post_id'    => $post_id,
                            'meta_key'   => 'extend_auction',
                            'meta_value' => $extendAuction,
                        ),
                        array(
                            '%d',
                            '%s',
                            '%s'
                        )
                    );
                }
            }


            $url = get_author_posts_url(get_current_user_id());
            wp_safe_redirect($url);
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
    $tcd_membership_vars['setDataParams'] = $setDataParams;
    $tcd_membership_vars['template']  = 'muse_post_image';
    $tcd_membership_vars['chk_sele_type'] = $chkSaleType;
    $tcd_membership_vars['extend_auction'] = $extendAuction;
    $tcd_membership_vars['chk_suitable_ages'] = $suitableAges;
    $tcd_membership_vars['auction_start_date'] = $auctionStartDate;
    $tcd_membership_vars['error'] = $error_messages;
}
add_action('tcd_membership_action-post_image', 'tcd_membership_action_post_image');
