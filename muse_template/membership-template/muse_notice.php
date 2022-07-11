<?php
global $dp_options, $tcd_membership_vars;
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
                            <?php foreach ($tcd_membership_vars['arrayNotice'] as $key => $arrayNotice) { ?>
                                <?php foreach ($arrayNotice as $type => $value) { ?>
                                    <?php if ($type === 'like') { ?>
                                        <?php
                                        foreach ($value as $valueOne) {
                                            $profileImageData = get_user_meta($valueOne['user_id'], 'profile_image', true);
                                            $profile_image = get_template_directory_uri() . '/assets/img/icon/non_profile_image.png';
                                            if (!empty($profileImageData)) {
                                                $profile_image = $profileImageData;
                                            }
                                            $user = get_userdata($valueOne['user_id']);
                                            $post = get_post($valueOne['post_id']);
                                        ?>
                                            <li class="pt-2 icon-box">
                                                <img src="<?php echo esc_url($profile_image); ?>" class="rounded-circle">
                                                <div class="font-weight-bold">
                                                    <?php echo esc_attr($user->display_name); ?>さんが「いいね」しました。
                                                </div>
                                                <div>
                                                    <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('post_comment')); ?>&post_id=<?php echo esc_attr($post->ID); ?>">
                                                        <?php echo $post->post_title; ?>
                                                    </a>
                                                </div>
                                            </li>
                                        <?php }
                                        /** endforeach */ ?>
                                    <?php } elseif ($type === 'follow') { ?>

                                        <?php
                                        $images = [];
                                        $names  = [];
                                        $others = '';
                                        if (count($value) >= 3) {
                                            $others = '他';
                                        }

                                        foreach ($value as $valueOne) {

                                            $profileImageData = get_user_meta($valueOne['user_id'], 'profile_image', true);
                                            $profile_image = get_template_directory_uri() . '/assets/img/icon/non_profile_image.png';
                                            if (!empty($profileImageData)) {
                                                $profile_image = $profileImageData;
                                            }
                                            $images[] = $profile_image;

                                            if (count($images) >= 2) {
                                                $user = get_userdata($valueOne['user_id']);
                                                $names[]  = $user->display_name . 'さん';
                                            }
                                        }

                                        /** endif */ ?>
                                        <li class="pt-2 icon-box">
                                            <!-- ここのStyleは動的 2つめ以降は5%ずつ左にズレる -->
                                            <?php
                                            $loop = 0;
                                            foreach ($images as $imageOne) {
                                                $stylePer = $loop * 5;
                                            ?>
                                                <img src="<?php echo $imageOne; ?>" class="rounded-circle <?php echo ($loop > 0) ? 'after-icon' : ''; ?>" <?php echo ($loop > 0) ? 'style="left: ' . $stylePer . '%"' : ''; ?>>
                                            <?php
                                                $loop++;
                                            }
                                            ?>
                                            <div class="font-weight-bold">
                                                <?php echo implode('と', $names) . $others; ?>にフォローされました。
                                            </div>
                                        </li>
                                    <?php }
                                    /** endif */
                                    ?>
                                <?php }
                                /** endforeach */ ?>
                            <?php }
                            /** endforeach */ ?>
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
