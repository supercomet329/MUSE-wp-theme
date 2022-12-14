<?php
// Add 2022/05/10 by H.Okabe
// require_once(ABSPATH . 'wp-admin/includes/image.php');
/**
 * 画像投稿ページ
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

    $extension_array = array(
        'gif' => 'image/gif',
        'jpg' => 'image/jpeg',
        'png' => 'image/png'
    );

    $setDataParams = [];
    $setDataParams['postTitle']        = '';
    $setDataParams['postDetail']       = '';
    $setDataParams['saleType']         = 'notForSale';
    $setDataParams['suitableAges']     = 'allAges';
    $setDataParams['selectAuction']    = 'notAuction';
    $setDataParams['auctionStartDate'] = 'notSpecified';
    $setDataParams['imagePrice']       = '';
    $setDataParams['binPrice']         = '';
    $setDataParams['extendAuction']    = 'disableAutoExtend';

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

        // var_dump($_POST);exit;
        $tcd_membership_vars['post_data'] = $_POST;

        $setDataParams = $_POST;
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
        $requestFileUrl  = false;
        if (isset($_POST['image_0']) && !empty($_POST['image_0'])) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);

            $file_data = $_POST['image_0'];
            $file_data = str_replace(' ', '+', $file_data);
            $file_data = preg_replace('#^data:image/\w+;base64,#i', '', $file_data);
            $file_data = base64_decode($file_data);
            $mime_type = finfo_buffer($finfo, $file_data);
            $extension = array_search($mime_type, $extension_array, true);
            finfo_close($finfo);

            $file_name = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 100) . '.' . $extension;

            $uploaded_file = __DIR__ . '/../../upload_file/' . $file_name;
            $requestFileUrl  = get_template_directory_uri() . '/upload_file/' . $file_name;
            file_put_contents($uploaded_file, $file_data);
        } else {
            $error_messages['postFile'] = 'アップロードする画像ファイルが御座いません';
        }

        $requestFileUrl2  = false;
        if (isset($_POST['image_1']) && !empty($_POST['image_1'])) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);

            $file_data = $_POST['image_1'];
            $file_data = str_replace(' ', '+', $file_data);
            $file_data = preg_replace('#^data:image/\w+;base64,#i', '', $file_data);
            $file_data = base64_decode($file_data);
            $mime_type = finfo_buffer($finfo, $file_data);
            $extension = array_search($mime_type, $extension_array, true);
            finfo_close($finfo);

            $file_name = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 100) . '.' . $extension;

            $uploaded_file = __DIR__ . '/../../upload_file/' . $file_name;
            $requestFileUrl2  = get_template_directory_uri() . '/upload_file/' . $file_name;
            file_put_contents($uploaded_file, $file_data);
        } 

        $requestFileUrl3  = false;
        if (isset($_POST['image_2']) && !empty($_POST['image_2'])) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);

            $file_data = $_POST['image_2'];
            $file_data = str_replace(' ', '+', $file_data);
            $file_data = preg_replace('#^data:image/\w+;base64,#i', '', $file_data);
            $file_data = base64_decode($file_data);
            $mime_type = finfo_buffer($finfo, $file_data);
            $extension = array_search($mime_type, $extension_array, true);
            finfo_close($finfo);

            $file_name = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 100) . '.' . $extension;

            $uploaded_file = __DIR__ . '/../../upload_file/' . $file_name;
            $requestFileUrl3  = get_template_directory_uri() . '/upload_file/' . $file_name;
            file_put_contents($uploaded_file, $file_data);
        }

        $requestFileUrl4  = false;
        if (isset($_POST['image_3']) && !empty($_POST['image_3'])) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);

            $file_data = $_POST['image_3'];
            $file_data = str_replace(' ', '+', $file_data);
            $file_data = preg_replace('#^data:image/\w+;base64,#i', '', $file_data);
            $file_data = base64_decode($file_data);
            $mime_type = finfo_buffer($finfo, $file_data);
            $extension = array_search($mime_type, $extension_array, true);
            finfo_close($finfo);

            $file_name = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 100) . '.' . $extension;

            $uploaded_file = __DIR__ . '/../../upload_file/' . $file_name;
            $requestFileUrl4  = get_template_directory_uri() . '/upload_file/' . $file_name;
            file_put_contents($uploaded_file, $file_data);
        } 
        // バリデート

        // saleTypeがNFT販売の場合
        $saleType = $_POST['saleType'];
        if ($saleType === 'sale') {

            $selectAuction = $_POST['selectAuction'];

            $postTermsCheck = (int)$_POST['postTermsCheck'];

            if ($postTermsCheck !== 1) {
                $error_messages['postTermsCheck'] = '利用規約に同意して下さい。';
            }

            if ($selectAuction === 'Auction') {

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

                        $error_messages['auctionEndDate'] = 'オークション終了日時を入力してください';
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
                }
            } else {
                if (!isset($_POST['imagePrice']) || empty($_POST['imagePrice'])) {
                    $error_messages['imagePrice'] = '販売金額を入力してください';
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
                [
                    'post_id'    => $post_id,
                    'meta_key'   => 'main_image',
                    'meta_value' => $requestFileUrl,
                ],
                [
                    '%d',
                    '%s',
                    '%s'
                ]
            );

            if ($requestFileUrl2) {
                $result = $wpdb->insert(
                    'wp_postmeta',
                    [
                        'post_id'    => $post_id,
                        'meta_key'   => 'main_image2',
                        'meta_value' => $requestFileUrl2,
                    ],
                    [
                        '%d',
                        '%s',
                        '%s'
                    ]
                );
            }

			if ($requestFileUrl3) {
                $result = $wpdb->insert(
                    'wp_postmeta',
                    [
                        'post_id'    => $post_id,
                        'meta_key'   => 'main_image3',
                        'meta_value' => $requestFileUrl3,
                    ],
                    [
                        '%d',
                        '%s',
                        '%s'
                    ]
                );
            }

            if ($requestFileUrl4) {
                $result = $wpdb->insert(
                    'wp_postmeta',
                    [
                        'post_id'    => $post_id,
                        'meta_key'   => 'main_image4',
                        'meta_value' => $requestFileUrl4,
                    ],
                    [
                        '%d',
                        '%s',
                        '%s'
                    ]
                );
            }

            $result = $wpdb->insert(
                'wp_postmeta',
                [
                    'post_id'    => $post_id,
                    'meta_key'   => 'saleType',
                    'meta_value' => $_POST['saleType'],
                ],
                [
                    '%d',
                    '%s',
                    '%s'
                ]
            );

            if ($_POST['suitableAges'] === 'r18') {
                // R18フラグがある場合 => 18フラグを登録
                $result = $wpdb->insert(
                    'wp_postmeta',
                    [
                        'post_id'    => $post_id,
                        'meta_key'   => 'r18',
                        'meta_value' => 1,
                    ],
                    [
                        '%d',
                        '%s',
                        '%s'
                    ]
                );
            }

            if ($saleType === 'sale') {
                if ($selectAuction === 'Auction') {
                    // R18フラグがある場合 => 18フラグを登録
                    $result = $wpdb->insert(
                        'wp_postmeta',
                        [
                            'post_id'    => $post_id,
                            'meta_key'   => 'selectAuction',
                            'meta_value' => $selectAuction,
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
                            'meta_key'   => 'binPrice',
                            'meta_value' => $_POST['binPrice'],
                        ],
                        [
                            '%d',
                            '%s',
                            '%s'
                        ]
                    );

                    if ($auctionStartDate === 'specify') {
                        $result = $wpdb->insert(
                            'wp_postmeta',
                            [
                                'post_id'    => $post_id,
                                'meta_key'   => 'auctionStartDate',
                                'meta_value' => $auctionStartDate,
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
                                'meta_key'   => 'auctionDate',
                                'meta_value' => $auctionDate,
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
                                'meta_key'   => 'auctionEndDate',
                                'meta_value' => $auctionEndDate,
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
                                'meta_key'   => 'extendAuction',
                                'meta_value' => $_POST['extendAuction'],
                            ],
                            [
                                '%d',
                                '%s',
                                '%s'
                            ]
                        );
                    }
                } else {
                    $result = $wpdb->insert(
                        'wp_postmeta',
                        [
                            'post_id'    => $post_id,
                            'meta_key'   => 'imagePrice',
                            'meta_value' => $_POST['imagePrice'],
                        ],
                        [
                            '%d',
                            '%s',
                            '%s'
                        ]
                    );
                }
            }

            // Twitterに投稿
            $message = '画像を投稿しました。';
            $uri     = '?memberpage=post_comment&post_id=' . $post_id;
            publishTwitter($message, $uri);

            wp_safe_redirect('/');
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

    $viewSaleForm        = 'display:none;';
    $viewNftSaleForm     = 'display:none;';
    $viewAuctionSaleForm = 'display:none;';
    $viewAuctionTimeForm = 'display:none;';

    // 販売形式が(NFT販売の場合)
    if ($setDataParams['saleType'] === 'sale') {
        $viewNftSaleForm = '';
        $viewSaleForm    = '';
    }

    // オークション開催(必須)がありの場合
    if ($setDataParams['selectAuction'] === 'Auction') {
        $viewNftSaleForm     = 'display:none;';
        $viewAuctionSaleForm = '';
    }

    // オークション開始日時が開始時間指定の場合
    if ($setDataParams['auctionStartDate'] === 'specify') {
        $viewNftSaleForm     = 'display:none;';
        $viewAuctionSaleForm = '';
        $viewAuctionTimeForm  = '';
    }

    $tcd_membership_vars['viewSaleForm']        = $viewSaleForm;
    $tcd_membership_vars['viewNftSaleForm']     = $viewNftSaleForm;
    $tcd_membership_vars['viewAuctionSaleForm'] = $viewAuctionSaleForm;
    $tcd_membership_vars['viewAuctionTimeForm'] = $viewAuctionTimeForm;
}
add_action('tcd_membership_action-post_image', 'tcd_membership_action_post_image');

/**
 *
 * ファイルのCrop加工
 * @param string $uploadedFile
 * @param string $resizeFilePath
 * @return void
 */
function cropImage($uploadedFile, $resizeFilePath)
{
    // 元画像のサイズを取得
    list($width, $height) = getimagesize($uploadedFile);

    // 切り抜き位置の取得
    // サイズの倍率の取得
    $cutWidth  = $width / $_POST['campusWidth'];

    // 縦4: 横 3の対応
    // $cutHeight = $height / 193;

    // 正方形の対応
    $cutHeight = $height / $_POST['campusHeight'];

    // 切り出し位置の取得
    $d_x = $cutWidth  * $_POST['profileImageX'];
    $d_y = $cutHeight * $_POST['profileImageY'];
    $d_w = $cutWidth  * $_POST['profileImageW'];
    $d_h = $cutHeight * $_POST['profileImageH'];

    // 画像加工
    $image = wp_get_image_editor($uploadedFile);
    $image->crop($d_x, $d_y, $d_w, $d_h);

    // 縦4: 横 3の対応
    $image->resize(300, 480, true);

    // 正方形の対応
    // $image->resize(400, 400, true);

    // 画像の出力
    $image->save($resizeFilePath);
    // exit;
}

/**
 * 画像サイズの取得
 *
 * @param string $tmp_name
 * @return boolean
 *
 */
function checkImageSize($tmp_name)
{
    list($width, $height) = getimagesize($tmp_name);

    $flg = false;
    if ($width >= 500 && $height >= 500) {
        $flg = true;
    }

    return $flg;
}

/**
 * ファイルの拡張子の取得
 *
 * @param string $path
 * @return string
 */
function getExtension($path)
{
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $info = finfo_file($finfo, $path);
    finfo_close($finfo);

    switch ($info) {
        case 'image/gif':
            $extension = 'gif';
            break;

        case 'image/jpg':
        case 'image/jpeg':
            $extension = 'jpg';
            break;

        case 'image/png':
            $extension = 'png';
            break;
    }

    return $extension;
}

/**
 * アップロード画像のクオリティを維持
 */
add_filter('jpeg_quality', function ($quality) {
    $quality = 100;
    return $quality;
});
