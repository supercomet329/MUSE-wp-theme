<!-- Swiper CSS -->
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/swiper-bundle.min.css">
<div class="pc-center">

    <?php if (count(partsRanking()) > 0) { ?>
        <ul class="horizontal-list">
            <li class="item ml-2 ranking-icon-box"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/ranking_01.png" class="ranking-icon" alt="ranking_icon"><br /></li>

            <?php
            foreach (partsRanking() as $rankingOne) {

                $profile_image = get_template_directory_uri() . '/assets/img/icon/non_profile_image.png';
                if (!is_null($rankingOne->profile_image)) {
                    $profile_image = $rankingOne->profile_image;
                }
            ?>
                <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('profile')) ?>&user_id=<?php echo esc_attr($rankingOne->user_id); ?>">
                    <li class="item"><img src="<?php echo esc_url($profile_image); ?>" alt="profile" class="rounded-circle"></li>
                </a>
            <?php
            }
            /** endforeach */ ?>
            <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('ranking')) ?>">
                <li class="item"><img class="transform-x-reverse border border-dark rounded-circle" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/arrow.png" alt="profile" class="rounded-circle"></li>
            </a>
        </ul>
    <?php }
    /** endif */ ?>
    <?php
    $listTimeline = listTopTimeLine();
    foreach ($listTimeline as $oneTimeline) {

        // 画像の取得
        $profileImage = $oneTimeline->profile_image;
        if (is_null($profileImage)) {
            $profileImage = get_template_directory_uri() . '/assets/img/icon/non_profile_image.png';
        }

        $dateClass = new DateTime($oneTimeline->post_date);
        // FIXED: nginxの場合 php.iniの反映が去れないことがある
        $dateClass->setTimezone(new DateTimeZone('Asia/Tokyo'));

        if ($oneTimeline->post_type === 'photo') {
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
        } else {
            // リクエストの表示
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
                    <div class="slid-img swiper swipertum">
                        <div class="swiper-wrapper d-flex align-items-center">
                            <div class="swiper-slide">
                                <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('confirm_request')); ?>&request_id=<?php echo esc_attr($oneTimeline->post_id); ?>">
                                    <?php echo esc_attr($oneTimeline->post_title); ?>の依頼が完了しました。
                                </a>
                            </div>

                        </div>
                    </div>
                    <div class="swiper slid-list swiperlist">
                        <div class="swiper-wrapper">
                        </div>
                    </div>
                </div>
            </div>

        <?php }
        /** endif **/ ?>
    <?php
    }
    /** endforeach */
    ?>

    <!-- Swiper JS -->
    <script src="<?php echo get_template_directory_uri(); ?>/assets/js/swiper-bundle.min.js"></script>