<?php
$imageList = getPostImageByPostTypeAndPostStatus();
?>
<!-- Swiper CSS -->
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/swiper-bundle.min.css">
<div class="container pt-2">
    <div class="row mb-2">
        <div class="col-12">
            <a href="javascript:history.back();">← 戻る</a>
        </div>
    </div>
</div>

<ul class="horizontal-list">
    <li class="item ml-2 ranking-icon-box"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/ranking_01.png" class="ranking-icon" alt="ranking_icon"><br /></li>
    <a href="profile.html">
        <li class="item"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/profile.jpg" alt="profile" class="rounded-circle"></li>
    </a>
    <a href="profile.html">
        <li class="item"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_85053177_M.jpg" alt="profile" class="rounded-circle"></li>
    </a>
    <a href="profile.html">
        <li class="item"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_64747350_M.jpg" alt="profile" class="rounded-circle"></li>
    </a>
    <a href="profile.html">
        <li class="item"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_27669641_M.jpg" alt="profile" class="rounded-circle"></li>
    </a>
    <a href="profile.html">
        <li class="item"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_40272765_M.jpg" alt="profile" class="rounded-circle"></li>
    </a>
    <a href="profile.html">
        <li class="item"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_40855053_M.jpg" alt="profile" class="rounded-circle"></li>
    </a>
    <a href="profile.html">
        <li class="item"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_45010284_M.jpg" alt="profile" class="rounded-circle"></li>
    </a>
    <a href="profile.html">
        <li class="item"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_56091176_M.jpg" alt="profile" class="rounded-circle"></li>
    </a>
    <a href="profile.html">
        <li class="item"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_58266021_M.jpg" alt="profile" class="rounded-circle"></li>
    </a>
    <a href="profile.html">
        <li class="item"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_58642077_M.jpg" alt="profile" class="rounded-circle"></li>
    </a>
    <a href="ranking.html">
        <li class="item"><img class="transform-x-reverse border border-dark rounded-circle" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/arrow.png" alt="profile" class="rounded-circle"></li>
    </a>
</ul>

<?php
foreach ($imageList as $imageOne) {

    // 画像の取得
    $profileImage = $imageOne->profile_image;
    if (is_null($profileImage)) {
        $profileImage = get_template_directory_uri() . '/assets/img/icon/non_profile_image.png';
    }

    $imageArray = [];
    $imageArray[] = $imageOne->resize_image;
    if (!is_null($imageOne->main_image2)) {
        $imageArray[] = $imageOne->main_image2;
    }
    if (!is_null($imageOne->main_image3)) {
        $imageArray[] = $imageOne->main_image3;
    }
    if (!is_null($imageOne->main_image4)) {
        $imageArray[] = $imageOne->main_image4;
    }

    $dateClass = new DateTime($imageOne->post_date);
    // FIXED: nginxの場合 php.iniの反映が去れないことがある
    $dateClass->setTimezone(new DateTimeZone('Asia/Tokyo'));
?>
    <div class="col-12 pt-1">
        <ul class="tweet-area">
            <li class="d-flex align-items-start">
                <figure>
                    <a href="<?php echo get_tcd_membership_memberpage_url('profile'); ?>&user_id=<?php echo esc_attr($imageOne->user_id); ?>">
                        <img src="<?php echo esc_url($profileImage); ?>" class="rounded-circle profile-icon">
                    </a>
                </figure>
                <div class="text-area">
                    <a href="<?php echo get_tcd_membership_memberpage_url('profile'); ?>&user_id=<?php echo esc_attr($imageOne->user_id); ?>">
                        <span><?php echo esc_attr($imageOne->display_name); ?></span><br>
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
                    <div class="swiper-slide">
                        <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('post_comment')); ?>&post_id=<?php echo esc_attr($imageOne->post_id); ?>">
                            <img class="img-fluid mx-auto" src="<?php echo esc_url($photoOne); ?>" />
                        </a>
                    </div>
                <?php }
                /** endforeach */ ?>
            </div>
        </div>
        <div class="swiper slid-list swiperlist">
            <div class="swiper-wrapper">
                <?php if(count($imageArray) > 1) { ?>
                <?php foreach ($imageArray as $photoOne) { ?>
                    <div class="swiper-slide">
                        <img src="<?php echo esc_url($photoOne); ?>" />
                    </div>
                <?php }
                /** endforeach */ ?>
                <?php } /** endif */ ?>
            </div>
        </div>
    </div>

    <div class="logo-area d-flex flex-row bd-highlight mb-3">
        <div class="p-2 bd-highlight col-10 text-nowrap">
            <?php
            $like_image = 'iine.png';
            if (is_liked($one_photo->post_id, false)) {
                $like_image = 'iine_on.png';
            }
            ?>
            <img class="js-toggle-like float-left" data-post-id="<?php echo esc_attr($imageOne->post_id); ?>" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/<?php echo esc_attr($like_image); ?>" alt="iine">
            <p class="mb-1 float-left mx-2 font-weight-bold"><?php echo esc_attr(get_likes_number($imageOne->post_id)); ?></p>
            <?php /** TODO: 仮想通貨時に対応 */ ?>
            <img class="float-left" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/social_tipping_on.png" alt="social_tipping_on">
            <?php /** TODO: 仮想通貨時に対応 */ ?>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/favorite_on.png" alt="favorite_on">
        </div>
        <div class="col-2 text-right">
            <a class="text-dark" href="post_img_comment.html">…</a>
        </div>
    </div>
<?php
}
/** endforeach */
?>


<!-- Swiper JS -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/swiper-bundle.min.js"></script>