<?php
// Add 2022/05/10 by H.Okabe
require_once(ABSPATH . 'wp-admin/includes/image.php');
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
    $setDataParams['postTitle'] = '';
    $setDataParams['postDetail'] = '';
    $setDataParams['saleType'] = 'notForSale';
    $setDataParams['suitableAges'] = 'allAges';
    $setDataParams['selectAuction'] = 'notAuction';
    $setDataParams['imagePrice'] = '';
    $setDataParams['binPrice'] = '';
    $setDataParams['extendAuction'] = '';

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
        // 投稿画像
        $requestFileUrl  = false;
        $requestFileName = false;
        if (isset($_FILES['postFile']['name']) && !empty($_FILES['postFile']['name'])) {

            $sizeFlag = checkImageSize($_FILES['postFile']['tmp_name']);
            if ($sizeFlag === TRUE) {
                $extension = getExtension($_FILES['postFile']['tmp_name']);

                $file_name = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 100) . '.' . $extension;
                $uploaded_file = __DIR__ . '/../../upload_file/' . $file_name;
                $result = move_uploaded_file($_FILES['postFile']['tmp_name'], $uploaded_file);
                if ($result) {
                    $requestFileUrl  = get_template_directory_uri() . '/upload_file/' . $file_name;
                    $requestFileName = $_FILES['postFile']['name'];
                } else {
                    $error_messages['postFile'] = 'ファイルのアップロードに失敗しました。';
                }

                $resizeFileName = 'resize_' . $file_name;
                $resize_uploaded_file = __DIR__ . '/../../upload_file/' . $resizeFileName;
                $requestResizeFileUrl  = get_template_directory_uri() . '/upload_file/' . $resizeFileName;
                cropImage($uploaded_file, $resize_uploaded_file);
            } else {
                $error_messages['postFile'] = 'ファイルの大きさが小さいです。';
            }

            /**
            $file_data = $_POST['file_data'];
            $file_data = str_replace(' ', '+', $file_data);
            $file_data = preg_replace('#^data:image/\w+;base64,#i', '', $file_data);
            $file_data = base64_decode($file_data);
            file_put_contents($resize_uploaded_file, $file_data);
             */
        } else {
            $error_messages['postFile'] = 'ファイルをアップロードしてください。';
        }

        $requestFileUrl2  = false;
        if (isset($_FILES['postFile2']['name']) && !empty($_FILES['postFile2']['name'])) {
            $extension = getExtension($_FILES['postFile2']['tmp_name']);
            $file_name = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 100) . '.' . $extension;
            $uploaded_file = __DIR__ . '/../../upload_file/' . $file_name;
            $result = move_uploaded_file($_FILES['postFile2']['tmp_name'], $uploaded_file);
            if ($result) {
                $requestFileUrl2  = get_template_directory_uri() . '/upload_file/' . $file_name;
            } else {
                $error_messages['postFile'] = 'ファイルのアップロードに失敗しました。';
            }
        }

        $requestFileUrl3  = false;
        if (isset($_FILES['postFile3']['name']) && !empty($_FILES['postFile3']['name'])) {

            $extension = getExtension($_FILES['postFile3']['tmp_name']);
            $file_name = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 100) . '.' . $extension;
            $uploaded_file = __DIR__ . '/../../upload_file/' . $file_name;
            $result = move_uploaded_file($_FILES['postFile3']['tmp_name'], $uploaded_file);
            if ($result) {
                $requestFileUrl3  = get_template_directory_uri() . '/upload_file/' . $file_name;
            } else {
                $error_messages['postFile'] = 'ファイルのアップロードに失敗しました。';
            }
        }

        $requestFileUrl4  = false;
        if (isset($_FILES['postFile4']['name']) && !empty($_FILES['postFile4']['name'])) {

            $extension = getExtension($_FILES['postFile4']['tmp_name']);
            $file_name = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 100) . '.' . $extension;
            $uploaded_file = __DIR__ . '/../../upload_file/' . $file_name;
            $result = move_uploaded_file($_FILES['postFile4']['tmp_name'], $uploaded_file);
            if ($result) {
                $requestFileUrl4  = get_template_directory_uri() . '/upload_file/' . $file_name;
            } else {
                $error_messages['postFile'] = 'ファイルのアップロードに失敗しました。';
            }
        }

        // バリデート

        // saleTypeがNFT販売の場合
        $saleType = $_POST['saleType'];
        if ($saleType === 'sale') {

            $selectAuction = $_POST['selectAuction'];
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

            $result = $wpdb->insert(
                'wp_postmeta',
                [
                    'post_id'    => $post_id,
                    'meta_key'   => 'resize_image',
                    'meta_value' => $requestResizeFileUrl,
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
                    'meta_key'   => 'image_name',
                    'meta_value' => $requestFileName,
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
    // var_dump($setDataParams);exit;
    $tcd_membership_vars['template']  = 'muse_post_image';
    $tcd_membership_vars['chk_sele_type'] = $chkSaleType;
    $tcd_membership_vars['extend_auction'] = $extendAuction;
    $tcd_membership_vars['chk_suitable_ages'] = $suitableAges;
    $tcd_membership_vars['auction_start_date'] = $auctionStartDate;
    $tcd_membership_vars['error'] = $error_messages;
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
    // $image->resize(NULL, 400, true);

    // 正方形の対応
    $image->resize(400, 400, true);

    // 画像の出力
    $image->save($resizeFilePath);
    // exit;
}

function checkImageSize($tmp_name)
{
    list($width, $height) = getimagesize($tmp_name);

    $flg = false;
    if ($width >= 5000 && $height >= 5000) {
        $flg = true;
    }

    return $flg;
}

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
