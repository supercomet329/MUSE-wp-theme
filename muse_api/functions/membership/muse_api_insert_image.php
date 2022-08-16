<?php

function muse_api_insert_image($params)
{
    global $tcd_membership_vars, $wpdb;

    $response = [];
    try {

        if (isset($params['access_token']) && !empty($params['access_token'])) {
            $user_id = check_login($params['access_token']);
            if (!$user_id) {
                $response[] = '対象のユーザーが存在しません';
                throw new Exception('バリデートエラー');
            }
        } else {
            $response[] = '対象のユーザーが存在しません';
            throw new Exception('バリデートエラー');
        }

        // タイトル
        if (!isset($params['postTitle']) || empty($params['postTitle'])) {
            $response[] = 'タイトルは必須入力です。';
        }

        // 販売タイプ
        if (!isset($params['saleType']) || empty($params['saleType'])) {
            $response[] = '販売タイプは必須選択です。';
        }

        $requestFileUrl  = false;
        $requestFileName = false;

        if (isset($params['postImage1']) && !empty($params['postImage1'])) {

            $postImage = $params['postImage1'];
            $postImage = str_replace(' ', '+', $postImage);
            $postImage = preg_replace('#^data:image/\w+;base64,#i', '', $postImage);
            $imageData1 = base64_decode($postImage);

            // 拡張子の取得
            $extension     = finfo_buffer(finfo_open(), $imageData1, FILEINFO_EXTENSION);
            $file_name     = 'api_' . substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 100) . '.' . $extension;
            $uploaded_file = muse_modify_template_directory_upload_dir() . $file_name;
            $result        = file_put_contents($uploaded_file, $imageData1);

            if ($result) {
                $requestFileUrl  = muse_modify_template_directory_uri() . '/upload_file/' . $file_name;
                $requestFileName = $file_name;
            } else {
                $response[] = 'ファイルのアップロードに失敗しました。';
            }
        } else {
            $response[] = 'ファイルをアップロードして下さい';
        }

        $requestFileUrl2  = false;
        if (isset($params['postImage2']) && !empty($params['postImage2'])) {
            // $imageData2 = base64_decode($params['postImage2']);

            $postImage = $params['postImage2'];
            $postImage = str_replace(' ', '+', $postImage);
            $postImage = preg_replace('#^data:image/\w+;base64,#i', '', $postImage);
            $imageData2 = base64_decode($postImage);

            // 拡張子の取得
            $extension     = finfo_buffer(finfo_open(), $imageData2, FILEINFO_EXTENSION);
            $file_name     = 'api_' . substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 100) . '.' . $extension;
            $uploaded_file = muse_modify_template_directory_upload_dir() . $file_name;
            $result        = file_put_contents($uploaded_file, $imageData2);

            if ($result) {
                $requestFileUrl2  = muse_modify_template_directory_uri() . '/upload_file/' . $file_name;
            } else {
                $response[] = 'ファイルのアップロードに失敗しました。';
            }
        }

        $requestFileUrl3  = false;
        if (isset($params['postImage3']) && !empty($params['postImage3'])) {
            // $imageData3 = base64_decode($params['postImage3']);

            $postImage = $params['postImage3'];
            $postImage = str_replace(' ', '+', $postImage);
            $postImage = preg_replace('#^data:image/\w+;base64,#i', '', $postImage);
            $imageData3 = base64_decode($postImage);

            // 拡張子の取得
            $extension     = finfo_buffer(finfo_open(), $imageData3, FILEINFO_EXTENSION);
            $file_name     = 'api_' . substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 100) . '.' . $extension;
            $uploaded_file = muse_modify_template_directory_upload_dir() . $file_name;
            $result        = file_put_contents($uploaded_file, $imageData3);

            if ($result) {
                $requestFileUrl3  = muse_modify_template_directory_uri() . '/upload_file/' . $file_name;
            } else {
                $response[] = 'ファイルのアップロードに失敗しました。';
            }
        }

        $requestFileUrl4  = false;
        if (isset($params['postImage4']) && !empty($params['postImage4'])) {
            // $imageData4 = base64_decode($params['postImage4']);

            $postImage = $params['postImage4'];
            $postImage = str_replace(' ', '+', $postImage);
            $postImage = preg_replace('#^data:image/\w+;base64,#i', '', $postImage);
            $imageData4 = base64_decode($postImage);

            // 拡張子の取得
            $extension     = finfo_buffer(finfo_open(), $imageData4, FILEINFO_EXTENSION);
            $file_name     = 'api_' . substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 100) . '.' . $extension;
            $uploaded_file = muse_modify_template_directory_upload_dir() . $file_name;
            $result        = file_put_contents($uploaded_file, $imageData4);

            if ($result) {
                $requestFileUrl4  = muse_modify_template_directory_uri() . '/upload_file/' . $file_name;
            } else {
                $response[] = 'ファイルのアップロードに失敗しました。';
            }
        }

        $saleType = $params['saleType'];
        if ($saleType === 'sale') {

            $selectAuction = $params['selectAuction'];
            if ($selectAuction === 'Auction') {

                $auctionStartDate = $params['auctionStartDate'];
                if ($auctionStartDate === 'specify') {
                    // オークションの場合
                    $auctionDateUnix = false;
                    if (
                        !isset($params['auctionDateY']) || empty($params['auctionDateY']) ||
                        !isset($params['auctionDateM']) || empty($params['auctionDateM']) ||
                        !isset($params['auctionDateD']) || empty($params['auctionDateD']) ||
                        !isset($params['auctionDateH']) || empty($params['auctionDateH']) ||
                        !isset($params['auctionDateMin']) || empty($params['auctionDateMin'])
                    ) {
                        $response[] = 'オークション開始日時を入力してください';
                    } else {
                        $auctionDate = $params['auctionDateY'] . '-' . str_pad($params['auctionDateM'], 2, "0", STR_PAD_LEFT)  . '-' . str_pad($params['auctionDateD'], 2, "0", STR_PAD_LEFT) . ' ' . str_pad($params['auctionDateH'], 2, "0", STR_PAD_LEFT) . ':' . str_pad($params['auctionDateMin'], 2, "0", STR_PAD_LEFT) . ':00';

                        $auctionDateClass = new DateTime($auctionDate);
                        $auctionDateUnix = $auctionDateClass->format('U');
                        if (!validate_date($auctionDate)) {
                            $response[] = 'オークション開始日時を入力してください';
                        }
                    }

                    $auctionEndDateUnix = false;
                    if (
                        !isset($params['auctionEndDateY']) || empty($params['auctionEndDateY']) ||
                        !isset($params['auctionEndDateM']) || empty($params['auctionEndDateM']) ||
                        !isset($params['auctionEndDateD']) || empty($params['auctionEndDateD']) ||
                        !isset($params['auctionEndDateH']) || empty($params['auctionEndDateH']) ||
                        !isset($params['auctionEndDateMin']) || empty($params['auctionEndDateMin'])
                    ) {

                        $response[] = 'オークション終了日時を入力してください';
                    } else {
                        $auctionEndDate = $params['auctionEndDateY'] . '-' . str_pad($params['auctionEndDateM'], 2, "0", STR_PAD_LEFT)  . '-' . str_pad($params['auctionEndDateD'], 2, "0", STR_PAD_LEFT) . ' ' . str_pad($params['auctionEndDateH'], 2, "0", STR_PAD_LEFT) . ':' . str_pad($params['auctionEndDateMin'], 2, "0", STR_PAD_LEFT) . ':00';
                        $auctionEndDateClass = new DateTime($auctionEndDate);
                        $auctionEndDateUnix = $auctionEndDateClass->format('U');
                        if (!validate_date($auctionEndDate)) {
                            $response[] = 'オークション終了日時を入力してください';
                        }
                    }

                    if ($auctionDateUnix && $auctionEndDateUnix) {
                        if ($auctionDateUnix > $auctionEndDateUnix) {
                            $response[] = 'オークション日時の御確認を御願い致します。';
                        }
                    }
                }
            } else {
                if (!isset($params['imagePrice']) || empty($params['imagePrice'])) {
                    $response[] = '販売金額を入力してください';
                }
            }
        }

        if (count($response) > 0) {
            throw new Exception('バリデートエラー');
        }

        // 登録処理
        // wp_postsに登録
        $my_post = array(
            'post_title'        => $params['postTitle'],
            'post_content'      => $params['postDetail'],
            'post_name'         => $params['postTitle'],
            'post_status'       => 'publish',
            'post_type'         => 'photo',
            'post_date'         => date('Y-m-d H:i:s'),
            'post_date_gmt'     => date('Y-m-d H:i:s'),
            'post_author'       => $user_id,
        );
        // $post_id = wp_insert_post($my_post);
        $wpdb->insert(
            'wp_posts',
            $my_post,
            [
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
            ]
        );
        $post_id = $wpdb->insert_id;

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
                'meta_value' => $params['saleType'],
            ],
            [
                '%d',
                '%s',
                '%s'
            ]
        );

        if ($params['suitableAges'] === 'r18') {
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
                        'meta_value' => $params['binPrice'],
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
                            'meta_value' => $params['extendAuction'],
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
                        'meta_value' => $params['imagePrice'],
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
        publishTwitter($message, $uri, $user_id);

        $response = [
            'result' => true,
        ];
    } catch (Exception $e) {

        // エラー時の処理
        $response = [
            'result'        => false,
            'error_message' => $response,
        ];
        error_publish($e);
    }
    return $response;
}
