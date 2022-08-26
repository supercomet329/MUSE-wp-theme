<?php
global $dp_options;
if (!$dp_options) $dp_options = get_design_plus_option();

// 202206/14 TODO: 決済方法が決まったら決済部の対応

get_header();
?>
<!-- Swiper CSS -->
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/swiper-bundle.min.css">

</div>
<div class="container pt-2 confirm-area">
    <div class="row mb-2">
        <div class="col-12">
            <a href="javascript:history.back();">← 戻る</a>
        </div>
    </div>
    <form action="POST">
        <div class="row">
            <div class="col-12 item-text mb-2">
                投稿画像（必須）
            </div>
            <div class="col-12 mb-4 confirm-image-area">
                <div class="my-2 slid-img swiper swipertum">
                    <div class="swiper-wrapper d-flex align-items-center">
                        <?php foreach ($tcd_membership_vars['imageArray'] as $imageOne) { ?>
                            <div class="swiper-slide">
                                <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('post_comment')); ?>&post_id=<?php echo esc_attr($tcd_membership_vars['post_id']); ?>">
                                    <img class="img-fluid mx-auto" src="<?php echo esc_url($imageOne); ?>" />
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="swiper slid-list swiperlist">
                    <div class="swiper-wrapper">
                        <?php foreach ($tcd_membership_vars['imageArray'] as $imageOne) { ?>
                            <div class="swiper-slide"><img src="<?php echo esc_url($imageOne); ?>" /></div>
                        <?php } ?>
                    </div>
                </div>
                <p class="mb-0 mt-3 text-right"><a class="text-dark" href="<?php echo esc_url(get_tcd_membership_memberpage_url('post_comment')); ?>&post_id=<?php echo esc_attr($tcd_membership_vars['post_id']); ?>">…</a></p>
            </div>
            <div class="logo-area d-flex bd-highlight icon-margin-top">
                <div class="bd-highlight text-nowrap flex-fill bottom-icon-left icon-margin-iine">
                    <?php
                    $like_image = 'iine.png';
                    if (is_liked($tcd_membership_vars['post_id'], false)) {
                        $like_image = 'iine_on.png';
                    }
                    ?>
                    <img class="js-toggle-like float-left" data-post-id="<?php echo esc_attr($tcd_membership_vars['post_id']); ?>" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/<?php echo esc_attr($like_image); ?>" alt="iine">
                    <p class="mb-1 float-left mx-1 font-weight-bold" id="count_like_<?php echo esc_attr($tcd_membership_vars['post_id']); ?>"><?php echo esc_attr(get_likes_number($tcd_membership_vars['post_id'])); ?></p>
                </div>
                <div class="pl-4 bd-highlight text-nowrap flex-fill icon-margin-tipping">
                    <img class="float-left" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/social_tipping_on.png" alt="social_tipping_on">
                    <p class="mb-1 float-left font-weight-bold">400円<br />400ETH</p>
                </div>
                <div class="pl-4 bd-highlight text-nowrap flex-fill icon-margin-favorite">
                    <?php
                    $favorite_image = 'favorite.png';
                    if (is_favorite($tcd_membership_vars['post_id'], false)) {
                        $favorite_image = 'favorite_on.png';
                    }
                    ?>
                    <img class="js-toggle-favorite float-left" data-post-id="<?php echo esc_attr($tcd_membership_vars['post_id']); ?>" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/<?php echo $favorite_image; ?>" alt="favorite_on">
                    <p class="mb-1 float-left mx-1 font-weight-bold" id="count_favorite_<?php echo esc_attr($tcd_membership_vars['post_id']); ?>"><?php echo esc_attr(get_favorite_number($tcd_membership_vars['post_id'])); ?></p>
                </div>
                <div class="pl-4 flex-fill text-right pt-1 bottom-icon-right icon-margin-comment_up">
                <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('page_report')); ?>&post_id=<?php echo esc_attr($tcd_membership_vars['post_id']); ?>" class="btn btn-primary text-white rounded-pill btn-sm text-white btn-lg main-color float-right">通報する</a>
                </div>
                <!-- <div class="p-2 bd-highlight col-5"></div>
        <div class="p-2 bd-highlight col-4 arrow_box">
            <a href="./post_img_normal_confirmation.html">
                and more
            </a>
        </div> -->
            </div>

            <div class="col-12 item-text mb-2">
                タイトル（必須）
            </div>
            <div class="col-12 mb-4">
                <?php echo esc_attr($tcd_membership_vars['post_title']); ?>
            </div>
            <div class="col-12 item-text mb-2">
                詳細（任意）
            </div>
            <div class="col-12 mb-4">
                <?php echo nl2br($tcd_membership_vars['post_content']); ?>
            </div>
            <div class="col-12 mb-2 item-text">
                販売形式（必須）
            </div>
            <div class="col-12 mb-4">
                <div class="mb-2">
                    NFT販売
                </div>
            </div>
            <div class="col-12 item-text mb-2">
                販売価格（必須）
            </div>
            <div class="col-12 mb-4">
                <div class="mb-2">
                    <?php echo esc_attr($tcd_membership_vars['imagePrice']); ?>
                </div>
            </div>
        </div>
        <?php if ($tcd_membership_vars['viewSubmitButton'] !== FALSE) { ?>

            <!-- NFTが決まったら購入処理追加 -->
            <div class="col-12 my-3 text-center">
                <button type="submit" class="btn btn-primary save-btn text-white">購入する</button>
            </div>
        <?php }
        /** endif */ ?>
    </form>
</div>

<!-- Swiper JS -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/swiper-bundle.min.js"></script>

<?php
get_footer();
