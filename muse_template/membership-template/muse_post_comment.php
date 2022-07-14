<?php
global $dp_options, $tcd_membership_vars;
get_header();
?>
<!-- Swiper CSS -->
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/swiper-bundle.min.css">
<div class="container pt-2 confirm-area">
    <div class="row mb-2">
        <div class="col-12">
            <a href="javascript:history.back();">← 戻る</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12 item-text mb-2">
            投稿画像（必須）
        </div>
        <div class="col-12 mb-4 confirm-image-area">
            <div class="my-2 slid-img swiper swipertum">
                <div class="swiper-wrapper d-flex align-items-center">
                    <?php foreach ($tcd_membership_vars['post_image_array'] as $post_image_one) { ?>
                        <div class="swiper-slide">
                            <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('post_comment')); ?>&post_id=<?php echo esc_attr($post_image_one->post_id); ?>">
                                <img class="img-fluid mx-auto" src="<?php echo esc_url($post_image_one); ?>" />
                            </a>
                        </div>
                    <?php }
                    /** endforeach */ ?>
                </div>
            </div>
            <div class="swiper slid-list swiperlist">
                <div class="swiper-wrapper">
                    <?php if (count($tcd_membership_vars['post_image_array']) > 1) { ?>
                        <?php foreach ($tcd_membership_vars['post_image_array'] as $post_image_one) { ?>

                            <div class="swiper-slide">
                                <img src="<?php echo esc_url($post_image_one); ?>" />
                            </div>
                        <?php }
                        /** endforeach */ ?>
                    <?php }
                    /** endif */ ?>
                </div>
            </div>
        </div>
        <div class="logo-area">
            <?php
            $like_image = 'iine.png';
            if (is_liked($tcd_membership_vars['post_id'], false)) {
                $like_image = 'iine_on.png';
            }
            ?>
            <img class="float-left" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/<?php echo $like_image; ?>" alt="iine">

            <!-- TODO: 投げ銭対応の時に対応 -->
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/social_tipping_on.png" alt="social_tipping_on">
        </div>
        <div class="col-12">
            <hr class="hr-line">
        </div>
        <div class="col-12 pt-2 item-text mb-2">
            メッセージ
        </div>
        <div class="col-12">
            <?php foreach ($tcd_membership_vars['comment'] as $one_comment) { ?>
                <div class="row my-3">
                    <div class="col-3 col-sm-2 col-lg-1 pr-0">
                        <img src="<?php echo esc_url($one_comment['profile_image']); ?>" class="rounded-circle" width="60" height="60">
                    </div>
                    <div class="col-8 col-sm-9 col-lg-10 bg-gray p-2 rounded">
                        <div class="row">
                            <div class="col-12 msg-detail">
                                <span class="mr-2 msg-name font-weight-bold">
                                    <?php echo esc_attr($one_comment['display_name']); ?>
                                </span>
                                <span class="msg-date"><?php echo esc_attr($one_comment['date']); ?></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 msg">
                                <p class="mb-0">
                                    <?php echo nl2br($one_comment['comment']); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }
            /** endforeach */ ?>
        </div>
        <?php if ($tcd_membership_vars['flg_submit_flag'] === TRUE) { ?>
            <div class="col-12 my-3">
                <form class="mx-1" action="<?php echo esc_attr(get_tcd_membership_memberpage_url('post_comment')); ?>" method="post">
                    <textarea name="message" class="form-control" rows="6" placeholder="ここにメッセージを入力"></textarea>
                    <?php if (!empty($tcd_membership_vars['error_message'])) { ?>
                        <div class="col-12">
                            <div class="error_message" id="errPostImage"><?php echo esc_attr($tcd_membership_vars['error_message']); ?></div>
                        </div>
                    <?php } ?>
                    <div class="my-3 text-center">
                        <button type="submit" class="btn btn-primary text-white" id="msg-btn">メッセージ送信</button>
                    </div>
                    <input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('tcd_membership_action-post_comment')); ?>">
                    <input type="hidden" name="post_id" value="<?php echo esc_attr($tcd_membership_vars['post_id']); ?>">
                </form>
            </div>
        <?php }
        /** endif */ ?>
    </div>
</div>
<!-- Swiper JS -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/swiper-bundle.min.js"></script>
<?php
get_footer();
