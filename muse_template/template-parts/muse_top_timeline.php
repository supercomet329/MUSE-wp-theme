<!-- Swiper CSS -->
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/swiper-bundle.min.css">
<div class="pc-center">

    <div class="container pt-2">
        <div class="row mb-2">
            <div class="col-12">
                <a href="javascript:history.back();">← 戻る</a>
            </div>
        </div>
    </div>

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

    <div class="col-12 pt-1">
        <ul class="tweet-area">
            <li class="d-flex align-items-start">
                <figure>
                    <a href="./profile.html">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_64747350_M.jpg" class="rounded-circle profile-icon">
                    </a>
                </figure>
                <div class="text-area">
                    <a href="./profile.html">
                        <span>投稿者名</span><br>
                    </a>
                    <span class="post-time">2022/04/11 16:00</span>
                </div>
            </li>
        </ul>
    </div>

    <div class="timeline-image">
        <div class="my-2 slid-img swiper swipertum">
            <div class="swiper-wrapper d-flex align-items-center">
                <div class="swiper-slide"><a href="post_img_comment.html"><img class="img-fluid mx-auto" src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_85053177_M.jpg" /></a></div>
                <div class="swiper-slide"><a href="post_img_comment.html"><img class="img-fluid mx-auto" src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_27669641_M.jpg" /></a></div>
                <div class="swiper-slide"><a href="post_img_comment.html"><img class="img-fluid mx-auto" src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_64747350_M.jpg" /></a></div>
                <div class="swiper-slide"><a href="post_img_comment.html"><img class="img-fluid mx-auto" src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_58266021_M.jpg" /></a></div>
                <div class="swiper-slide"><a href="post_img_comment.html"><img class="img-fluid mx-auto" src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_40272765_M.jpg" /></a></div>
                <div class="swiper-slide"><a href="post_img_comment.html"><img class="img-fluid mx-auto" src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_56091176_M.jpg" /></a></div>
            </div>
        </div>
        <div class="swiper slid-list swiperlist">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_85053177_M.jpg" /></div>
                <div class="swiper-slide"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_27669641_M.jpg" /></div>
                <div class="swiper-slide"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_64747350_M.jpg" /></div>
                <div class="swiper-slide"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_58266021_M.jpg" /></div>
                <div class="swiper-slide"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_40272765_M.jpg" /></div>
                <div class="swiper-slide"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_56091176_M.jpg" /></div>
            </div>
        </div>
    </div>

    <div class="logo-area d-flex flex-row bd-highlight mb-3">
        <div class="p-2 bd-highlight col-8 text-nowrap">
            <img class="float-left" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/iine_on.png" alt="iine">
            <p class="mb-1 float-left mx-2 font-weight-bold">400</p>
            <img class="float-left" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/social_tipping_on.png" alt="social_tipping_on">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/favorite_on.png" alt="favorite_on">
        </div>
        <div class="comment-right col-4">
            <a class="text-dark" href="post_img_comment.html"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/comment_up_02.png" alt="コメント"></a>
        </div>
        <!-- <div class="p-2 bd-highlight col-5"></div>
        <div class="p-2 bd-highlight col-4 arrow_box">
            <a href="./post_img_normal_confirmation.html">
                and more
            </a>
        </div> -->
    </div>

    <div class="col-12 pt-3">
        <ul class="tweet-area">
            <li class="d-flex align-items-start">
                <a href="./profile.html">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_64747350_M.jpg" class="rounded-circle profile-icon">
                </a>
                <div class="text-area">
                    <a href="./profile.html">
                        <span>投稿者名</span><br>
                    </a>
                    <span class="post-time">2022/04/11 16:00</span>
                </div>
            </li>
        </ul>
    </div>

    <div class="timeline-image col-12">
        <div class="my-2 slid-img swiper swipertum">
            <div class="swiper-wrapper d-flex align-items-center">
                <div class="swiper-slide"><a href="post_img_comment.html"><img class="img-fluid mx-auto" src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_85053177_M.jpg" /></a></div>
                <div class="swiper-slide"><a href="post_img_comment.html"><img class="img-fluid mx-auto" src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_27669641_M.jpg" /></a></div>
            </div>
        </div>
        <div class="swiper slid-list swiperlist">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_85053177_M.jpg" /></div>
                <div class="swiper-slide"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_27669641_M.jpg" /></div>
            </div>
        </div>
    </div>

    <div class="logo-area d-flex flex-row bd-highlight mb-3">
        <div class="p-2 bd-highlight col-8 text-nowrap">
            <img class="float-left" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/iine_on.png" alt="iine">
            <p class="mb-1 float-left mx-2 font-weight-bold">400</p>
            <img class="float-left" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/social_tipping_on.png" alt="social_tipping_on">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/favorite_on.png" alt="favorite_on">
        </div>
        <div class="comment-right col-4">
            <a class="text-dark" href="post_img_comment.html"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/comment_up_02.png" alt="コメント"></a>
        </div>
        <!-- <div class="p-2 bd-highlight col-5"></div>
        <div class="p-2 bd-highlight col-4 arrow_box">
            <a href="./post_img_normal_confirmation.html">
                and more
            </a>
        </div> -->
    </div>
    <!-- Swiper JS -->
    <script src="<?php echo get_template_directory_uri(); ?>/assets/js/swiper-bundle.min.js"></script>