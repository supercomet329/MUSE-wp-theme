<?php
global $dp_options, $tcd_membership_vars;
$tcd_membership_vars['list_like'];
get_header();
?>
<!-- swiper CSS -->
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/swiper-bundle.min.css">

<div class="container pt-2">
    <div class="row mb-2">
        <div class="col-12">
            <a href="javascript:history.back();">← 戻る</a>
        </div>
    </div>
    <div class="text-center font-weight-bold title">
        通知一覧
    </div>
    <div class="swiper tab-menu">
        <div class="swiper-wrapper">
            <div class="swiper-slide col-6 mr-0 text-center">
                <p class="mb-0">通知</p>
            </div>
            <div class="swiper-slide col-6 mx-0 text-center">
                <p class="mb-0">投銭・購入履歴</p>
            </div>
        </div>
    </div>
    <div class="swiper tab-contents">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="row">
                    <div class="col-12">
                        <ul class="list-area">
                            <li class="pt-2 icon-box">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_64747350_M.jpg" class="rounded-circle" width="50" height="50">
                                <div class="font-weight-bold">
                                    ○○さんが「いいね」しました。
                                </div>
                                <div class="screen_id">
                                    <a href="post_img_comment.html">投稿タイトル</a>
                                </div>
                            </li>
                            <li class="pt-2 icon-box">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_27669641_M.jpg" class="rounded-circle">
                                <div class="font-weight-bold">
                                    ○○さんが「いいね」しました。
                                </div>
                                <div>
                                    <a href="post_img_comment.html">投稿タイトル</a>
                                </div>
                            </li>
                            <li class="pt-2 icon-box">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_33901813_M.jpg" class="rounded-circle">
                                <!-- ここのStyleは動的 2つめ以降は5%ずつ左にズレる -->
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_85053177_M.jpg" class="rounded-circle after-icon" style="left: 5%">
                                <div class="font-weight-bold">
                                    ○○さんと○○さんにフォローされました。
                                </div>
                            </li>
                            <li class="pt-2 icon-box">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_40272765_M.jpg" class="rounded-circle">
                                <div class="font-weight-bold">
                                    ○○さんが「いいね」しました。
                                </div>
                                <div>
                                    <a href="post_img_comment.html">投稿タイトル</a>
                                </div>
                            </li>
                            <li class="pt-2 icon-box">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_40855053_M.jpg" class="rounded-circle">
                                <div class="font-weight-bold">
                                    ○○さんに依頼が受注されました。
                                </div>
                                <div>
                                    <a href="post_img_comment.html">投稿タイトル</a>
                                </div>
                            </li>
                            <li class="pt-2 icon-box">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_45010284_M.jpg" class="rounded-circle">
                                <div class="font-weight-bold">
                                    ○○さんに「コメント」されました。
                                </div>
                                <div>
                                    <a href="post_img_comment.html">投稿タイトル</a>
                                </div>
                            </li>
                            <li class="pt-2 icon-box">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_56091176_M.jpg" class="rounded-circle">
                                <div class="font-weight-bold">
                                    ○○さんが「いいね」しました。
                                </div>
                                <div>
                                    <a href="post_img_comment.html">投稿タイトル</a>
                                </div>
                            </li>
                            <li class="pt-2 icon-box">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_58266021_M.jpg" class="rounded-circle">
                                <div class="font-weight-bold">
                                    ○○さんが「いいね」しました。
                                </div>
                                <div>
                                    <a href="post_img_comment.html">投稿タイトル</a>
                                </div>
                            </li>
                            <li class="pt-2 icon-box">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_58642077_M.jpg" class="rounded-circle">
                                <div class="font-weight-bold">
                                    ○○さんが「いいね」しました。
                                </div>
                                <div>
                                    <a href="post_img_comment.html">投稿タイトル</a>
                                </div>
                            </li>
                            <li class="pt-2 icon-box">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_58661692_M.jpg" class="rounded-circle">
                                <div class="font-weight-bold">
                                    ○○さんが「いいね」しました。
                                </div>
                                <div>
                                    <a href="post_img_comment.html">投稿タイトル</a>
                                </div>
                            </li>
                            <li class="pt-2 icon-box">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_63325478_M.jpg" class="rounded-circle">
                                <div class="font-weight-bold">
                                    ○○さんが「いいね」しました。
                                </div>
                                <div>
                                    <a href="post_img_comment.html">投稿タイトル</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="row">
                    <div class="col-12">
                        <ul class="list-area">
                            <?php
                            foreach ($tcd_membership_vars['arrayMoney'] as $oneMoney) {
                                $profileImageData = get_user_meta($oneMoney->target_user_id, 'profile_image', true);
                                $profileImage = get_template_directory_uri() . '/assets/img/icon/non_profile_image.png';
                                if (!empty($profileImageData)) {
                                    $profileImage = $profileImageData;
                                }

                                $string = 'さんの作品に投銭しました。';
                                if ($oneMoney->type === 'purchase') {
                                    $string = 'さんの作品を購入しました。';
                                }

                                $user_obj = get_userdata($oneMoney->target_user_id);
                            ?>
                                <li class="pt-2 icon-box">
                                    <img src="<?php echo esc_url($profileImage); ?>" class="rounded-circle">
                                    <div class="font-weight-bold">
                                        <?php echo esc_attr($user_obj->data->display_name); ?><?php echo $string; ?>
                                    </div>
                                    <div>
                                        <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('post_comment')); ?>&post_id=<?php echo esc_attr($oneMoney->post_id); ?>">
                                            <?php echo esc_attr(get_post($oneMoney->post_id)->post_title); ?>
                                        </a>
                                    </div>
                                </li>
                            <?php
                            }
                            ?>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- swiper JS -->
    <script src="<?php echo get_template_directory_uri(); ?>/assets/js/swiper-bundle.min.js"></script>
    <?php
    get_footer();
