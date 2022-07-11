<?php
global $dp_options;
if (!$dp_options) $dp_options = get_design_plus_option();

get_header();
?>
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
                <p class="mb-0 mt-3 text-right"><a class="text-dark" href="post_img_comment.html">…</a></p>
            </div>
            <div class="logo-area col-6">
                <?php
                $like_image = 'iine.png';
                if (is_liked($one_photo->post_id, false)) {
                    $like_image = 'iine_on.png';
                }
                ?>
                <img class="js-toggle-like float-left" data-post-id="<?php echo esc_attr($tcd_membership_vars['post_id']); ?>" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/<?php echo esc_attr($like_image); ?>" alt="iine">
                <!-- TODO: NFT決まったら -->
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/social_tipping_on.png" alt="social_tipping_on">
            </div>

            <div class="col-6 my-auto">
                <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('page_report')); ?>&post_id=<?php echo esc_attr($tcd_membership_vars['post_id']); ?>" class="btn btn-primary text-white rounded-pill btn-sm text-white btn-lg main-color float-right">通報する</a>
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
                    オークション
                </div>
            </div>
            <div class="col-12 item-text mb-2">
                オークション開始日時（必須）
            </div>
            <div class="col-12 mb-4">
                <?php echo esc_attr($tcd_membership_vars['auctionString']); ?>
            </div>

            <?php if ($tcd_membership_vars['auctionStartDate'] !== false) { ?>

                <div class="col-12 item-text mb-2">
                    オークション開始日時
                </div>
                <div class="col-12 mb-4">
                    <?php echo esc_attr($tcd_membership_vars['auctionStartDate']); ?>
                </div>
            <?php }
            /** endif */ ?>

            <?php if ($tcd_membership_vars['auctionEndDate'] !== false) { ?>

                <div class="col-12 item-text mb-2">
                    オークション終了日時
                </div>
                <div class="col-12 mb-4">
                    <?php echo esc_attr($tcd_membership_vars['auctionEndDate']); ?>
                </div>
            <?php }
            /** endif */ ?>


            <?php if ($tcd_membership_vars['extendAuction'] !== false) { ?>

                <div class="col-12 item-text mb-2">
                    オークション自動延長
                </div>
                <div class="col-12 mb-2">
                    <?php echo esc_attr($tcd_membership_vars['extendAuction']); ?>
                </div>

                <?php if ($tcd_membership_vars['extendAuction'] === 'あり') { ?>
                    <div class="text-danger mb-3 ml-3 small">
                        ※終了5分前に入札されると、5分延長されます。
                    </div>
                <?php }
                /** endif */ ?>

            <?php }
            /** endif */ ?>

            <?php if ($tcd_membership_vars['viewSubmitButton'] !== FALSE) { ?>
                <!-- NFTが決まったらオークション処理追加 -->
                <div class="col-12 my-3 text-center">
                    <button type="submit" class="btn btn-primary save-btn text-white">オークションに参加</button>
                </div>
            <?php }
            /** endif */ ?>
        </div>
    </form>
</div>
<?php
get_footer();
