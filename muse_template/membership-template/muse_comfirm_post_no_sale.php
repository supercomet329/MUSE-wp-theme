<?php
global $dp_options;
if (!$dp_options) $dp_options = get_design_plus_option();

$arraySliceImage = array_chunk($tcd_membership_vars['imageArray'], 2);
$imageCount = count($tcd_membership_vars['imageArray']);
get_header();
?>
<!-- Swiper CSS -->
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/swiper-bundle.min.css">


<!-- Swiper JS -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/swiper-bundle.min.js"></script>
<div class="pc-center">
    <form action="POST">
        <div class="container pt-2 confirm-area">

            <div class="post-inarea">
                <?php if ($imageCount <= 1) { ?>
                    <div class="my-2 slid-img swiper swipertum sp-margin">
                        <div class="swiper-wrapper d-flex align-items-center timeline-in">
                            <div class="swiper-slide text-right ">
                                <?php foreach ($tcd_membership_vars['imageArray'] as $photoOne) { ?>
                                    <a id="js-open" href="#" data-image="<?php echo esc_url($photoOne); ?>"><img class="img-fluid mx-auto" src="<?php echo esc_url($photoOne); ?>" /></a>
                                <?php }
                                /** endforeach */ ?>

                            </div>
                        </div>
                    </div>
                <?php } elseif ($imageCount === 2) { ?>
                    <div class="timeline-image timelile-pro">
                        <div class="my-2 slid-img swiper swipertum">
                            <div class="swiper-wrapper d-flex align-items-center post-in">
                                <?php foreach ($tcd_membership_vars['imageArray'] as $photoOne) { ?>
                                    <div class="swiper-slide timeline-2block text-right">
                                        <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('post_comment')); ?>&post_id=<?php echo esc_attr($oneTimeline->post_id); ?>"><img class="img-fluid mx-auto" src="<?php echo esc_url($photoOne); ?>" /></a>
                                    </div>
                                <?php }
                                /** endforeach */ ?>
                            </div>
                        </div>
                    </div>

                    <div class="timeline-image timelile-pro">
                        <div class="my-2 slid-img swiper swipertum sp-margin">
                            <div class="swiper-wrapper d-flex align-items-center timeline-in">

                                <?php foreach ($tcd_membership_vars['imageArray'] as $photoOne) { ?>
                                    <div class="swiper-slide timeline-2block text-right">
                                        <a id="js-open" href="#" data-image="<?php echo esc_url($photoOne); ?>"><img class="img-fluid mx-auto" src="<?php echo esc_url($photoOne); ?>" /></a>
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

                            <div class="swiper-wrapper d-flex align-items-center timeline-in">
                                <?php foreach ($arrayOneSliceImage as $oneSliceImage) { ?>
                                    <div class="swiper-slide <?php echo $timeLineClass; ?> text-right">
                                        <a id="js-open" href="#" data-image="<?php echo esc_url($oneSliceImage); ?>"><img class="img-fluid mx-auto" src="<?php echo esc_url($oneSliceImage); ?>" /></a>
                                    </div>
                                <?php }
                                /** endforech */ ?>
                            </div>

                        <?php
                            $loop++;
                        }
                        /** endforeach */ ?>
                    </div>
                <?php } else { ?>
                    <div class="timeline-image timelile-pro">
                        <?php
                        $loop = 0;
                        foreach ($arraySliceImage as $arrayOneSliceImage) {
                            $timeLineClass = 'timeline-3block-up';
                            if ($loop > 0) {
                                $timeLineClass = 'timeline-4block';
                            }
                        ?>

                            <div class="slid-img swiper swipertum sp-margin">
                                <div class="swiper-wrapper d-flex align-items-center timeline-in">
                                    <?php foreach ($arrayOneSliceImage as $oneSliceImage) { ?>
                                        <div class="swiper-slide <?php echo $timeLineClass; ?> text-right">
                                            <a id="js-open" href="#" data-image="<?php echo esc_url($oneSliceImage); ?>"><img class="img-fluid mx-auto" src="<?php echo esc_url($oneSliceImage); ?>" /></a>
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
                <?php } ?>

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
                    <div class="flex-fill text-right pt-1 bottom-icon-right icon-margin-comment_up">
                        <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('page_report')); ?>&post_id=<?php echo esc_attr($tcd_membership_vars['post_id']); ?>" class="btn btn-primary text-white rounded-pill btn-sm text-white btn-lg main-color float-right post-sp-tuu">通報する</a>
                    </div>
                    <!-- <div class="p-2 bd-highlight col-5"></div>
        <div class="p-2 bd-highlight col-4 arrow_box">
            <a href="./post_img_normal_confirmation.html">
                and more
            </a>
        </div> -->
                </div>
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
            <div class="col-12 mb-2">
                <div class="mb-2">
                    販売しない
                </div>
            </div>
        </div>
    </form>

    <div class="modal fade" id="testModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-center">
            <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="mt-2 mb-2 mx-auto">
                    <img class="modal_image" id="pickup_image" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                </div>
            </div>
        </div>
    </div>
    <?php
    get_footer();
