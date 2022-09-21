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
    <div class="container">
        <div class="post-icon"><a href="<?php echo esc_url(get_tcd_membership_memberpage_url('post_image')); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/image_post.png" alt=""></a></div>
    </div>

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
            $imageArray[] = $oneTimeline->main_image;
            if (!is_null($oneTimeline->main_image2)) {
                $imageArray[] = $oneTimeline->main_image2;
            }
            if (!is_null($oneTimeline->main_image3)) {
                $imageArray[] = $oneTimeline->main_image3;
            }
            if (!is_null($oneTimeline->main_image4)) {
                $imageArray[] = $oneTimeline->main_image4;
            }

            $arraySliceImage = array_chunk($imageArray, 2);
            $imageCount = count($imageArray);
    ?>

            <?php if ($imageCount <= 1) { ?>
                <!--標準ブロック-->
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

                    <div class="timeline-image timelile-pro">
                        <div class="my-2 slid-img swiper swipertum sp-margin">
                            <div class="swiper-wrapper d-flex align-items-center timeline-in">
                                <div class="swiper-slide text-right ">
                                    <?php foreach ($imageArray as $photoOne) { ?>
                                        <a href="<?php echo get_tcd_membership_memberpage_url('confirm_post'); ?>&&post_id=<?php echo esc_attr($oneTimeline->post_id); ?>" data-image="<?php echo esc_url($photoOne); ?>"><img class="img-fluid mx-auto" src="<?php echo esc_url($photoOne); ?>" /></a>
                                    <?php }
                                    /** endforeach */ ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="logo-area d-flex bd-highlight icon-margin-top">
                        <div class="bd-highlight text-nowrap flex-fill bottom-icon-left icon-margin-iine">
                            <?php
                            $like_image = 'iine.png';
                            if (is_liked($oneTimeline->post_id, false)) {
                                $like_image = 'iine_on.png';
                            }
                            ?>
                            <img class="js-toggle-like float-left" data-post-id="<?php echo esc_attr($oneTimeline->post_id); ?>" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/<?php echo esc_attr($like_image); ?>" alt="iine">
                            <p class="mb-1 float-left mx-1 font-weight-bold" id="count_like_<?php echo esc_attr($oneTimeline->post_id); ?>"><?php echo esc_attr(get_likes_number($oneTimeline->post_id)); ?></p>
                        </div>
                        <div class="pl-4 bd-highlight text-nowrap flex-fill icon-margin-tipping">
                            <img class="float-left" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/social_tipping_on.png" alt="social_tipping_on">
                            <p class="mb-1 float-left font-weight-bold">400円<br />400ETH</p>
                        </div>
                        <div class="pl-4 bd-highlight text-nowrap flex-fill icon-margin-favorite">
                            <?php
                            $favorite_image = 'favorite.png';
                            if (is_favorite($oneTimeline->post_id, false)) {
                                $favorite_image = 'favorite_on.png';
                            }
                            ?>
                            <img class="js-toggle-favorite float-left" data-post-id="<?php echo esc_attr($oneTimeline->post_id); ?>" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/<?php echo $favorite_image; ?>" alt="favorite_on">
                            <p class="mb-1 float-left mx-1 font-weight-bold" id="count_favorite_<?php echo esc_attr($oneTimeline->post_id); ?>"><?php echo esc_attr(get_favorite_number($oneTimeline->post_id)); ?></p>
                        </div>
                        <div class="pl-4 flex-fill text-right pt-1 bottom-icon-right icon-margin-comment_up">
                            <a class="text-dark" href="<?php echo esc_url(get_tcd_membership_memberpage_url('post_comment')); ?>&post_id=<?php echo esc_attr($oneTimeline->post_id); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/comment_up_02.png" alt="コメント"></a>
                        </div>
                        <!-- <div class="p-2 bd-highlight col-5"></div>
        <div class="p-2 bd-highlight col-4 arrow_box">
            <a href="./post_img_normal_confirmation.html">
                and more
            </a>
        </div> -->
                    </div>
                </div>
            <?php } elseif ($imageCount === 2) { ?>
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

                    <div class="timeline-image timelile-pro">
                        <div class="my-2 slid-img swiper swipertum sp-margin">
                            <div class="swiper-wrapper d-flex align-items-center timeline-in">
                                <?php foreach ($imageArray as $photoOne) { ?>
                                    <div class="swiper-slide timeline-2block text-right">
                                        <a href="<?php echo get_tcd_membership_memberpage_url('confirm_post'); ?>&post_id=<?php echo esc_attr($oneTimeline->post_id); ?>" ><img class="img-fluid mx-auto" src="<?php echo esc_url($photoOne); ?>" /></a>
                                    </div>
                                <?php }
                                /** endforeach */ ?>
                            </div>
                        </div>
                    </div>

                    <div class="logo-area d-flex bd-highlight icon-margin-top">
                        <div class="bd-highlight text-nowrap flex-fill bottom-icon-left icon-margin-iine">
                            <?php
                            $like_image = 'iine.png';
                            if (is_liked($oneTimeline->post_id, false)) {
                                $like_image = 'iine_on.png';
                            }
                            ?>
                            <img class="js-toggle-like float-left" data-post-id="<?php echo esc_attr($oneTimeline->post_id); ?>" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/<?php echo esc_attr($like_image); ?>" alt="iine">
                            <p class="mb-1 float-left mx-1 font-weight-bold" id="count_like_<?php echo esc_attr($oneTimeline->post_id); ?>"><?php echo esc_attr(get_likes_number($oneTimeline->post_id)); ?></p>
                        </div>
                        <div class="pl-4 bd-highlight text-nowrap flex-fill icon-margin-tipping">
                            <img class="float-left" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/social_tipping_on.png" alt="social_tipping_on">
                            <p class="mb-1 float-left font-weight-bold">400円<br />400ETH</p>
                        </div>
                        <div class="pl-4 bd-highlight text-nowrap flex-fill icon-margin-favorite">
                            <?php
                            $favorite_image = 'favorite.png';
                            if (is_favorite($oneTimeline->post_id, false)) {
                                $favorite_image = 'favorite_on.png';
                            }
                            ?>
                            <img class="js-toggle-favorite float-left" data-post-id="<?php echo esc_attr($oneTimeline->post_id); ?>" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/<?php echo $favorite_image; ?>" alt="favorite_on">
                            <p class="mb-1 float-left mx-1 font-weight-bold" id="count_favorite_<?php echo esc_attr($oneTimeline->post_id); ?>"><?php echo esc_attr(get_favorite_number($oneTimeline->post_id)); ?></p>
                        </div>
                        <div class="pl-4 flex-fill text-right pt-1 bottom-icon-right icon-margin-comment_up">
                            <a class="text-dark" href="<?php echo esc_url(get_tcd_membership_memberpage_url('post_comment')); ?>&post_id=<?php echo esc_attr($oneTimeline->post_id); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/comment_up_02.png" alt="コメント"></a>
                        </div>
                        <!-- <div class="p-2 bd-highlight col-5"></div>
        <div class="p-2 bd-highlight col-4 arrow_box">
            <a href="./post_img_normal_confirmation.html">
                and more
            </a>
        </div> -->
                    </div>
                </div>
            <?php } elseif ($imageCount === 3) { ?>
                <!--3段ブロック-->
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


                    <div class="timeline-image timelile-pro">
                        <?php
                        $loop = 0;
                        foreach ($arraySliceImage as $arrayOneSliceImage) {
                            $timeLineClass = 'timeline-3block-up';
                            if ($loop > 0) {
                                $timeLineClass = 'timeline-3block-down';
                            }
                        ?>

                            <div class="slid-img swiper swipertum sp-margin">
                                <div class="swiper-wrapper d-flex align-items-center timeline-in">
                                    <?php foreach ($arrayOneSliceImage as $oneSliceImage) { ?>
                                        <div class="swiper-slide <?php echo $timeLineClass; ?> text-right">
                                            <a href="<?php echo get_tcd_membership_memberpage_url('confirm_post'); ?>&post_id=<?php echo esc_attr($oneTimeline->post_id); ?>" data-image="<?php echo esc_url($oneSliceImage); ?>"><img class="img-fluid mx-auto" src="<?php echo esc_url($oneSliceImage); ?>" /></a>
                                        </div>
                                    <?php }
                                    /** endforech */ ?>
                                </div>
                            </div>
                        <?php
                            $loop++;
                        }
                        /** endforeach */ ?>
                    </div>

                    <div class="logo-area d-flex bd-highlight icon-margin-top">
                        <div class="bd-highlight text-nowrap flex-fill bottom-icon-left icon-margin-iine">
                            <?php
                            $like_image = 'iine.png';
                            if (is_liked($oneTimeline->post_id, false)) {
                                $like_image = 'iine_on.png';
                            }
                            ?>
                            <img class="js-toggle-like float-left" data-post-id="<?php echo esc_attr($oneTimeline->post_id); ?>" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/<?php echo esc_attr($like_image); ?>" alt="iine">
                            <p class="mb-1 float-left mx-1 font-weight-bold" id="count_like_<?php echo esc_attr($oneTimeline->post_id); ?>"><?php echo esc_attr(get_likes_number($oneTimeline->post_id)); ?></p>
                        </div>
                        <div class="pl-4 bd-highlight text-nowrap flex-fill icon-margin-tipping">
                            <img class="float-left" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/social_tipping_on.png" alt="social_tipping_on">
                            <p class="mb-1 float-left font-weight-bold">400円<br />400ETH</p>
                        </div>
                        <div class="pl-4 bd-highlight text-nowrap flex-fill icon-margin-favorite">
                            <?php
                            $favorite_image = 'favorite.png';
                            if (is_favorite($oneTimeline->post_id, false)) {
                                $favorite_image = 'favorite_on.png';
                            }
                            ?>
                            <img class="js-toggle-favorite float-left" data-post-id="<?php echo esc_attr($oneTimeline->post_id); ?>" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/<?php echo $favorite_image; ?>" alt="favorite_on">
                            <p class="mb-1 float-left mx-1 font-weight-bold" id="count_favorite_<?php echo esc_attr($oneTimeline->post_id); ?>"><?php echo esc_attr(get_favorite_number($oneTimeline->post_id)); ?></p>
                        </div>
                        <div class="pl-4 flex-fill text-right pt-1 bottom-icon-right icon-margin-comment_up">
                            <a class="text-dark" href="" <?php echo esc_url(get_tcd_membership_memberpage_url('post_comment')); ?>&post_id=<?php echo esc_attr($oneTimeline->post_id); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/comment_up_02.png" alt="コメント"></a>
                        </div>
                        <!-- <div class="p-2 bd-highlight col-5"></div>
        <div class="p-2 bd-highlight col-4 arrow_box">
            <a href="./post_img_normal_confirmation.html">
                and more
            </a>
        </div> -->
                    </div>
                </div>
            <?php } elseif ($imageCount === 4) { ?>
                <!--4段ブロック-->
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

                    <div class="timeline-image timelile-pro">
                        <?php
                        $loop = 0;
                        foreach ($arraySliceImage as $arrayOneSliceImage) {
                            $timeLineClass = 'timeline-4block-up';
                            if ($loop > 0) {
                                $timeLineClass = 'timeline-4block';
                            }
                        ?>
                            <div class="slid-img swiper swipertum sp-margin">
                                <div class="swiper-wrapper d-flex align-items-center timeline-in">
                                    <?php foreach ($arrayOneSliceImage as $oneSliceImage) { ?>
                                        <div class="swiper-slide <?php echo $timeLineClass; ?> text-right">
                                            <a href="<?php echo get_tcd_membership_memberpage_url('confirm_post'); ?>&&post_id=<?php echo esc_attr($oneTimeline->post_id); ?>" data-image="<?php echo esc_url($oneSliceImage); ?>"><img class="img-fluid mx-auto" src="<?php echo esc_url($oneSliceImage); ?>" /></a>
                                        </div>
                                    <?php }
                                    /** endforech */ ?>
                                </div>
                            </div>
                        <?php
                            $loop++;
                        }
                        /** endforeach */ ?>
                    </div>

                    <div class="logo-area d-flex bd-highlight icon-margin-top">
                        <div class="bd-highlight text-nowrap flex-fill bottom-icon-left icon-margin-iine">
                            <?php
                            $like_image = 'iine.png';
                            if (is_liked($oneTimeline->post_id, false)) {
                                $like_image = 'iine_on.png';
                            }
                            ?>
                            <img class="js-toggle-like float-left" data-post-id="<?php echo esc_attr($oneTimeline->post_id); ?>" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/<?php echo esc_attr($like_image); ?>" alt="iine">
                            <p class="mb-1 float-left mx-1 font-weight-bold" id="count_like_<?php echo esc_attr($oneTimeline->post_id); ?>"><?php echo esc_attr(get_likes_number($oneTimeline->post_id)); ?></p>
                        </div>
                        <div class="pl-4 bd-highlight text-nowrap flex-fill icon-margin-tipping">
                            <img class="float-left" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/social_tipping_on.png" alt="social_tipping_on">
                            <p class="mb-1 float-left font-weight-bold">400円<br />400ETH</p>
                        </div>
                        <div class="pl-4 bd-highlight text-nowrap flex-fill icon-margin-favorite">
                            <?php
                            $favorite_image = 'favorite.png';
                            if (is_favorite($oneTimeline->post_id, false)) {
                                $favorite_image = 'favorite_on.png';
                            }
                            ?>
                            <img class="js-toggle-favorite float-left" data-post-id="<?php echo esc_attr($oneTimeline->post_id); ?>" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/<?php echo $favorite_image; ?>" alt="favorite_on">
                            <p class="mb-1 float-left mx-1 font-weight-bold" id="count_favorite_<?php echo esc_attr($oneTimeline->post_id); ?>"><?php echo esc_attr(get_favorite_number($oneTimeline->post_id)); ?></p>
                        </div>
                        <div class="pl-4 flex-fill text-right pt-1 bottom-icon-right icon-margin-comment_up">
                            <a class="text-dark" href="" <?php echo esc_url(get_tcd_membership_memberpage_url('post_comment')); ?>&post_id=<?php echo esc_attr($oneTimeline->post_id); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/comment_up_02.png" alt="コメント"></a>
                        </div>
                        <!-- <div class="p-2 bd-highlight col-5"></div>
        <div class="p-2 bd-highlight col-4 arrow_box">
            <a href="./post_img_normal_confirmation.html">
                and more
            </a>
        </div> -->
                    </div>
                </div>
            <?php }
            /** endif */ ?>
        <?php } else { ?>
            <?php /** リクエストの画像表示対応 */ ?>
        <?php }
        /** endif */ ?>
    <?php }
    /** endforeach */ ?>

    <!-- Swiper JS -->
    <script src="<?php echo get_template_directory_uri(); ?>/assets/js/swiper-bundle.min.js"></script>