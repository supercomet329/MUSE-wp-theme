<?php
global $dp_options, $tcd_membership_vars;
get_header();

$arraySliceImage = array_chunk($tcd_membership_vars['post_image_array'], 2);
$imageCount = count($tcd_membership_vars['post_image_array']);


?>
<div class="pc-center">
    <div class="container pt-2 confirm-area">
        <div class="col-12 item-text mb-2">
            投稿画像（必須）
        </div>
        <div class="post-inarea">
            <?php if ($imageCount <= 1) { ?>
                <div class="timeline-image timelile-pro">
                    <div class="my-2 slid-img swiper swipertum">
                        <div class="swiper-wrapper d-flex align-items-center timeline-in">
                            <div class="swiper-slide text-right">
                                <?php foreach ($tcd_membership_vars['post_image_array'] as $photoOne) { ?>
                                    <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('post_comment')); ?>&post_id=<?php echo esc_attr($oneTimeline->post_id); ?>"><img class="img-fluid mx-auto" src="<?php echo esc_url($photoOne); ?>" /></a>
                                <?php }
                                /** endforeach */ ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } elseif ($imageCount === 2) { ?>
                <div class="timeline-image timelile-pro">
                    <div class="my-2 slid-img swiper swipertum">
                        <div class="swiper-wrapper d-flex align-items-center timeline-in">
                            <?php foreach ($tcd_membership_vars['post_image_array'] as $photoOne) { ?>
                                <div class="swiper-slide timeline-2block text-right">
                                    <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('post_comment')); ?>&post_id=<?php echo esc_attr($oneTimeline->post_id); ?>"><img class="img-fluid mx-auto" src="<?php echo esc_url($photoOne); ?>" /></a>
                                </div>
                            <?php }
                            /** endforeach */ ?>
                        </div>
                    </div>
                </div>
            <?php } elseif ($imageCount === 3) { ?>
                <div class="timeline-image timelile-pro">
                    <?php
                    $loop = 0;
                    foreach ($arraySliceImage as $arrayOneSliceImage) {
                        $timeLineClass = 'timeline-3block-up';
                        if ($loop > 0) {
                            $timeLineClass = 'timeline-3block-down';
                        }
                    ?>
                        <div class="timeline-image timelile-pro">
                            <div class="slid-img swiper swipertum">
                                <div class="swiper-wrapper d-flex align-items-center timeline-in">
                                    <?php foreach ($arrayOneSliceImage as $oneSliceImage) { ?>
                                        <div class="swiper-slide <?php echo $timeLineClass; ?> text-right">
                                            <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('post_comment')); ?>&post_id=<?php echo esc_attr($oneTimeline->post_id); ?>"><img class="img-fluid mx-auto" src="<?php echo esc_url($oneSliceImage); ?>" /></a>
                                        </div>
                                    <?php }
                                    /** endforech */ ?>
                                </div>
                            </div>
                        </div>
                    <?php
                        $loop++;
                    }
                    /** endforeach */ ?>
                </div>
            <?php } else { ?>
                <?php
                $loop = 0;
                foreach ($arraySliceImage as $arrayOneSliceImage) {
                    $timeLineClass = 'timeline-3block-up';
                    if ($loop > 0) {
                        $timeLineClass = 'timeline-4block';
                    }
                ?>
                    <div class="timeline-image timelile-pro">
                        <div class="slid-img swiper swipertum">
                            <div class="swiper-wrapper d-flex align-items-center timeline-in">
                                <?php foreach ($arrayOneSliceImage as $oneSliceImage) { ?>
                                    <div class="swiper-slide <?php echo $timeLineClass; ?> text-right">
                                        <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('post_comment')); ?>&post_id=<?php echo esc_attr($oneTimeline->post_id); ?>"><img class="img-fluid mx-auto" src="<?php echo esc_url($oneSliceImage); ?>" /></a>
                                    </div>
                                <?php }
                                /** endforech */ ?>
                            </div>
                        </div>
                    </div>
                <?php
                    $loop++;
                }
                /** endforeach */ ?>
            <?php } ?>

            <div class="logo-area d-flex bd-highlight icon-margin-top">
                <?php
                $like_image = 'iine.png';
                if (is_liked($tcd_membership_vars['post_id'], false)) {
                    $like_image = 'iine_on.png';
                }
                ?>
                <div class="bd-highlight text-nowrap flex-fill bottom-icon-left icon-margin-iine post-margin2">
                    <img class="js-toggle-like float-left" data-post-id="<?php echo esc_attr($tcd_membership_vars['post_id']); ?>" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/<?php echo $like_image; ?>" alt="iine">
                    <p class="mb-1 float-left mx-1 font-weight-bold" id="count_like_<?php echo esc_attr($tcd_membership_vars['post_id']); ?>"><?php echo esc_attr(get_likes_number($oneTimeline->post_id)); ?></p>
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
                <!-- div class="pl-4 flex-fill text-right pt-1 bottom-icon-right icon-margin-comment_up">
                    <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('page_report')); ?>&post_id=<?php echo esc_attr($tcd_membership_vars['post_id']); ?>" class="btn btn-primary text-white rounded-pill btn-sm text-white btn-lg main-color float-right">通報する</a>
                </div -->
                <!-- <div class="p-2 bd-highlight col-5"></div>
        <div class="p-2 bd-highlight col-4 arrow_box">
            <a href="./post_img_normal_confirmation.html">
                and more
            </a>
        </div> -->
            </div>

            <!-- div class="col-12">
                <hr class="hr-line">
            </div>
            <div class="col-12 pt-2 item-text mb-2">
                メッセージ
            </div>
        </div -->

        <div class="col-12 pt-2 item-text mb-2">
            メッセージ
        </div>
        <div class="col-12">
            <?php foreach ($tcd_membership_vars['comment'] as $one_comment) { ?>
                <div class="row my-3">
                    <div class="col-3 col-sm-2 col-lg-1 pr-0 post-pc-com">
                        <img src="<?php echo esc_url($one_comment['profile_image']); ?>" class="rounded-circle" width="60" height="60">
                    </div>
                    <div class="col-8 col-sm-9 col-lg-10 bg-gray p-2 rounded">
                        <div class="row">
                            <div class="col-12 msg-detail">
                                <span class="mr-2 msg-name font-weight-bold"><?php echo esc_attr($one_comment['display_name']); ?></span>
                                <span class="msg-date"><?php echo esc_attr($one_comment['date']); ?></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 msg">
                                <p class="mb-0"><?php echo nl2br($one_comment['comment']); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }
            /** endforeach */ ?>
        </div>
        <?php if ($tcd_membership_vars['flg_submit_flag'] === TRUE) { ?>
            <div class="col-12 my-3">
                <form class="mx-1" method="POST" action="<?php echo esc_attr(get_tcd_membership_memberpage_url('post_comment')); ?>">
                    <textarea name="message" class="form-control" rows="6" placeholder="ここにメッセージを入力"></textarea>
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

    <?php
    get_footer();
