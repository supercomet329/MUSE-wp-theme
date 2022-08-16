<?php
// 画像投稿ページ
global $dp_options, $tcd_membership_vars;

get_header();
?>
<!-- Swiper CSS -->
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/swiper-bundle.min.css">
<div class="pc-center">

    <div class="container pt-2 mb-4">
        <div class="row mb-2">
            <div class="col-12">
                <a href="javascript:history.back();">← 戻る</a>
            </div>
        </div>
        <form class="search-post mb-2" method="POST" method="POST" action="<?php echo get_tcd_membership_memberpage_url('post_search'); ?>">
            <input class="search-box px-2 pb-0 d-sm-none	" id="front_search_box" name="search" value="<?php echo $tcd_membership_vars['txtSearch']; ?>" type="text" placeholder="検索" />
            <input class="search-button btn rounded-pill btn-sm font-weight-bold my-auto ml-2 d-sm-none	" name="submit" type="submit" value="検索" />
            <img class="modal-open float-right d-sm-none" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/search_option.png" alt="search_option" class="float-right search-option">
            <!-- モーダル本体 -->
            <div class="modal-container">
                <div class="modal-body">
                    <!-- モーダル内のコンテンツ -->
                    <div class="modal-content text-left p-3">
                        <p class="item-text mx-auto">検索オプション</p>
                        <form class="search-post" method="POST" action="<?php echo get_tcd_membership_memberpage_url('post_search'); ?>">
                            <div class="mb-2 item-text">
                                キーワード
                            </div>
                            <div class="mb-4">
                                <input class="search-box px-2 pb-0" id="modal_search_box" name="search" type="text" value="<?php echo $tcd_membership_vars['txtSearch']; ?>" placeholder="検索" />
                            </div>
                            <?php if ($tcd_membership_vars['r18Flag'] === TRUE) { ?>
                                <div class="mb-2 item-text">
                                    対象
                                </div>
                                <div class="select-wrap">
                                    <select name="r18flag" class="select-box">
                                        <option value="0" <?php echo ($tcd_membership_vars['selR18flag'] === 0) ? 'selected' : ''; ?>>全年齢</option>
                                        <option value="r18" <?php echo ($tcd_membership_vars['selR18flag'] === 'r18') ? 'selected' : ''; ?>>R-18</option>
                                    </select>
                                </div>
                            <?php } ?>
                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-primary search-btn btn-sm btn-lg text-white">検索</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php
    if (!is_null($tcd_membership_vars['imgList'])) {
        foreach ($tcd_membership_vars['imgList'] as $oneTimeline) {

            // 画像の取得
            $profileImage = $oneTimeline->profile_image;
            if (is_null($profileImage)) {
                $profileImage = get_template_directory_uri() . '/assets/img/icon/non_profile_image.png';
            }

            $dateClass = new DateTime($oneTimeline->post_date);
            // FIXED: nginxの場合 php.iniの反映が去れないことがある
            $dateClass->setTimezone(new DateTimeZone('Asia/Tokyo'));

            // 投稿画像の表示
            $imageArray = [];
            $imageArray[] = $oneTimeline->resize_image;
            if (!is_null($oneTimeline->main_image2)) {
                $imageArray[] = $oneTimeline->main_image2;
            }
            if (!is_null($oneTimeline->main_image3)) {
                $imageArray[] = $oneTimeline->main_image3;
            }
            if (!is_null($oneTimeline->main_image4)) {
                $imageArray[] = $oneTimeline->main_image4;
            }

    ?>
            <div class="timeline-inarea">

                <div class="col-12 pt-1">
                    <ul class="tweet-area">
                        <li class="d-flex align-items-start">
                            <figure>
                                <a href="<?php echo get_tcd_membership_memberpage_url('profile'); ?>&user_id=<?php echo esc_attr($oneTimeline->user_id); ?>">
                                    <img src="<?php echo esc_url($profileImage); ?>" class="rounded-circle profile-icon">
                                </a>
                            </figure>
                            <div class="text-area">
                                <a href="<?php echo get_tcd_membership_memberpage_url('profile'); ?>&user_id=<?php echo esc_attr($oneTimeline->user_id); ?>">
                                    <span><?php echo esc_attr($oneTimeline->display_name); ?></span><br>
                                </a>
                                <span class="post-time"><?php echo esc_attr($dateClass->format('Y/m/d H:i')); ?></span>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="timeline-image">
                    <div class="my-2 slid-img swiper swipertum">
                        <div class="swiper-wrapper d-flex align-items-center">
                            <?php foreach ($imageArray as $photoOne) { ?>
                                <div class="swiper-slide"><a href="<?php echo esc_url(get_tcd_membership_memberpage_url('post_comment')); ?>&post_id=<?php echo esc_attr($oneTimeline->post_id); ?>"><img class="img-fluid mx-auto" src="<?php echo esc_url($photoOne); ?>" /></a></div>
                            <?php }
                            /** endforeach */ ?>
                        </div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                    <div class="swiper slid-list swiperlist">
                        <div class="swiper-wrapper">
                            <?php if (count($imageArray) > 1) { ?>
                                <?php foreach ($imageArray as $photoOne) { ?>
                                    <div class="swiper-slide">
                                        <img src="<?php echo esc_url($photoOne); ?>" />
                                    </div>
                                <?php }
                                /** endforeach */ ?>
                            <?php }
                            /** endif */ ?>
                        </div>
                    </div>
                </div>

                <div class="logo-area d-flex flex-row bd-highlight">
                    <div class="p-2 bd-highlight col-8 text-nowrap">
                        <?php
                        $like_image = 'iine.png';
                        if (is_liked($oneTimeline->post_id, false)) {
                            $like_image = 'iine_on.png';
                        }
                        ?>
                        <img class="js-toggle-like float-left" data-post-id="<?php echo esc_attr($oneTimeline->post_id); ?>" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/<?php echo esc_attr($like_image); ?>" alt="iine">
                        <p class="mb-1 float-left mx-2 font-weight-bold" id="count_like_<?php echo esc_attr($oneTimeline->post_id); ?>" id="count_like_<?php echo esc_attr($oneTimeline->post_id); ?>"><?php echo esc_attr(get_likes_number($oneTimeline->post_id)); ?></p>
                        <img class="float-left" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/social_tipping_on.png" alt="social_tipping_on">

                        <?php
                        $favorite_image = 'favorite.png';
                        if (is_favorite($oneTimeline->post_id, false)) {
                            $favorite_image = 'favorite_on.png';
                        }
                        ?>
                        <img class="js-toggle-favorite" data-post-id="<?php echo esc_attr($oneTimeline->post_id); ?>" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/<?php echo $favorite_image; ?>" alt="favorite_on">
                    </div>
                    <div class="comment-right col-4">
                        <a class="text-dark" href="<?php echo esc_url(get_tcd_membership_memberpage_url('post_comment')); ?>&post_id=<?php echo esc_attr($oneTimeline->post_id); ?>">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/comment_up_02.png" alt="コメント">
                        </a>
                    </div>
                    <!-- <div class="p-2 bd-highlight col-5"></div>
        <div class="p-2 bd-highlight col-4 arrow_box">
            <a href="./post_img_normal_confirmation.html">
                and more
            </a>
        </div> -->
                </div>
            </div>
    <?php
        }
    }
    /** endforeach */
    ?>

    <!-- Swiper JS -->
    <script src="<?php echo get_template_directory_uri(); ?>/assets/js/swiper-bundle.min.js"></script>
    <?php
    get_footer();
