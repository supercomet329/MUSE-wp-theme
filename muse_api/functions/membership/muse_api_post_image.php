<?php

/**
 * 画像詳細の取得
 *
 * @param array $params
 * @return void
 */
function muse_api_post_image($params)
{
    $response = [];
    $error_message = [];
    try {
        $sale_price         = 0;
        $bin_price          = 0;
        $post_image1        = false;
        $post_image2        = false;
        $post_image3        = false;
        $post_image4        = false;
        $post_title         = false;
        $post_comment       = false;
        $r18                = false;
        $sale_type          = false;
        $auction_type       = false;
        $auction_start_date = false;
        $auction_date       = false;
        $auction_end_date   = false;
        $extend_auction     = false;
        $login_flag         = false;
        $like_flag          = false;

        if (isset($params['access_token']) && !empty($params['access_token'])) {
            $user_id = check_login($params['access_token']);
            if ($user_id) {
                $login_flag = true;
            }
        }

        // 画像の情報の取得
        if (!isset($params['post_id']) || empty($params['post_id'])) {
            $error_message[] = '画像の情報が取得できません。';
        }

        if (count($error_message) > 0) {
            throw new Exception('バリデートエラー');
        }

        $post_id = $params['post_id'];
        if ($login_flag === TRUE) {
            // いいねフラグの取得
            $like_flag = is_liked($post_id, $user_id);
        }

        $result = getPostDataByPostIdAndOnlyPhoto($post_id);
        if (!isset($result[0])) {
            $error_message[] = '画像の情報が取得できません。';
            throw new Exception('バリデートエラー');
        }

        $tmpR18 =  getPostMetaByPostIdAndMetaKey($post_id, 'r18');
        if((int)$tmpR18 > 0) {
            $r18 = true;
        }

        $tmpSaleType = getPostMetaByPostIdAndMetaKey($post_id, 'saleType');
        if($tmpSaleType === 'sale') {
            $selectAuction = getPostMetaByPostIdAndMetaKey($post_id, 'selectAuction');
            $sale_price    = getPostMetaByPostIdAndMetaKey($post_id, 'imagePrice');
            if($selectAuction === 'Auction') {
                $bin_price = getPostMetaByPostIdAndMetaKey($post_id, 'binPrice');
                $auction_start_date = getPostMetaByPostIdAndMetaKey($post_id, 'auctionStartDate');
                if($auction_start_date === 'specify') {
                    $modAuctionDate       = getPostMetaByPostIdAndMetaKey($post_id, 'auctionDate');
                    $dateAuctionDateClass = new DateTime($modAuctionDate);
                    $auction_date     = $dateAuctionDateClass->format('Y/m/d H:i');
                    $modAuctionEndDate       = getPostMetaByPostIdAndMetaKey($post_id, 'auctionEndDate');
                    $dateAuctionDateEndClass = new DateTime($modAuctionEndDate);
                    $auction_end_date = $dateAuctionDateEndClass->format('Y/m/d H:i');
                    $extend_auction   = getPostMetaByPostIdAndMetaKey($post_id, 'extendAuction');
                }
            }
        }

        $response = [
            'result'             => true,
            'post_image1'        => $result[0]->main_image1,
            'post_image2'        => $result[0]->main_image2,
            'post_image3'        => $result[0]->main_image3,
            'post_image4'        => $result[0]->main_image4,
            'post_title'         => $result[0]->post_title,
            'post_content'       => $result[0]->post_content,
            'r18'                => $r18,
            'sale_type'          => $tmpSaleType,
            'sale_price'         => $sale_price,
            'bin_price'          => $bin_price,
            'auction_type'       => $selectAuction,
            'auction_start_date' => $auction_start_date,
            'auction_date'       => $auction_date,
            'auction_end_date'   => $auction_end_date,
            'extend_auction'     => $extend_auction,
            'login_flag'         => $login_flag,
            'like_flag'          => $like_flag,
            'like_count'         => get_likes_number( $post_id ),
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
