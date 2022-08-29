<?php
global $dp_options, $tcd_membership_vars, $tcd_membership_post, $post;

get_header();
?>
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

<div class="container pt-2">
    <form action="<?php echo esc_attr(get_tcd_membership_memberpage_url('detail_message')); ?>" method="POST" enctype="multipart/form-data">
        <div class="container message-show-area" id="message_show_area">
            <?php if (!is_null($tcd_membership_vars['target_user_id'])) { ?>

                <!-- ユーザー指定がある場合 -->
                <div class="font-weight-bold title border-bottom-solid mt-4">
                    <?php echo esc_attr($tcd_membership_vars['title_user_name']); ?>
                    <input type="hidden" name="user_id" value="<?php echo $tcd_membership_vars['target_user_id']; ?>" wtx-context="4C293744-6AAE-4895-9E4D-551C00D5FF73">
                </div>
            <?php } else { ?>

                <div class="font-weight-bold title border-bottom-solid mt-4">
                    <?php if ($tcd_membership_vars['list_user']) { ?>
                        <!-- ユーザー指定がない場合 -->
                        <select name="user_id" class="shadow-none form-control form-control-sm col-12 col-md-5 col-lg-4 mb-2">
                            <?php
                            foreach ($tcd_membership_vars['list_user'] as $one_user) {
                                $target_user = get_user_by('id', $one_user->ID);
                            ?>
                                <option value="<?php echo $one_user->ID; ?>"><?php echo $target_user->data->display_name; ?></option>
                            <?php } ?>
                        </select>
                    <?php }
                    /** endif */ ?>
                </div>
            <?php }
            /** endif */ ?>


            <div class="row mb-5 pb-3">
                <?php
                foreach ($tcd_membership_vars['list_message'] as $date => $row_message) {
                    $viewDate = new DateTime($date);
                    $viewDate->setTimezone(new DateTimeZone('Asia/Tokyo'));
                ?>
                    <div class="d-flex col-12 justify-content-center">
                        <div class="main-color font-weight-bold text-white text-center rounded-pill small w-25 mt-4">
                            <?php echo esc_attr($viewDate->format('Y/m/d')); ?>
                        </div>
                    </div>
                    <?php
                    foreach ($row_message as $one_message) {
                        // ユーザー情報の取得
                        $profileImageData = get_user_meta($one_message['sender_user_id'], 'profile_image', true);
                        $profile_image = get_template_directory_uri() . '/assets/img/icon/non_profile_image.png';
                        if (!empty($profileImageData)) {
                            $profile_image = $profileImageData;
                        }
                    ?>

                        <div class="col-12">
                            <?php if ((int)$one_message['sender_user_id'] !== (int)get_current_user_id()) { ?>
                                <div class="balloon_l">
                                    <div class="faceicon">
                                        <img src="<?php echo esc_html($profile_image); ?>" alt="" class="rounded-circle">
                                        <div class="ml-xl-4 ml-1">
                                            <?php echo esc_attr($one_message['send_time']); ?>
                                        </div>
                                    </div>
                                    <?php if (!$one_message['image_flag']) { ?>
                                        <div class="says">
                                            <p><?php echo nl2br($one_message['message']); ?></p>
                                        </div>
                                    <?php }
                                    /** endif */ ?>
                                    <?php if ($one_message['image_flag']) { ?>
                                        <img src="<?php echo esc_html($one_message['message']); ?>" class="post-image result">
                                    <?php }
                                    /** endif */ ?>
                                </div>
                            <?php } else { ?>
                                <div class="balloon_r">
                                    <div class="faceicon">
                                        <img src="<?php echo esc_html($profile_image); ?>" class="rounded-circle" alt="">
                                        <div class="ml-xl-4 ml-1">
                                            <?php echo esc_attr($one_message['send_time']); ?>
                                        </div>
                                    </div>
                                    <?php if (!$one_message['image_flag']) { ?>
                                        <div class="says">
                                            <p><?php echo nl2br($one_message['message']); ?></p>
                                        </div>
                                    <?php }
                                    /** endif */ ?>
                                    <?php if ($one_message['image_flag']) { ?>
                                        <img src="<?php echo esc_html($one_message['message']); ?>" class="post-image result">
                                    <?php }
                                    /** endif */ ?>
                                </div>
                            <?php }
                            /** endif */ ?>
                        </div>
                    <?php }
                    /** endforeach */ ?>
                <?php }
                /** endforeach */ ?>

            </div>

            <?php if ($tcd_membership_vars['message_flag']) { ?>
                <div class="row text-center message-create">
                    <div class="col-9">
                        <textarea name="message" rows="3" id="chat_input" class="border border-0"></textarea>
                    </div>
                    <div class="col-2 icon-area">
                        <div>
                            <label>
                                <input type="file" name="file" accept="image/png, image/jpeg" id="messages_file_input">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/camera_bule.png" class="camera" alt="camera">
                            </label>
                        </div>
                        <label>
                            <input type="image" name="btn_confirm" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/send.png" class="send" alt="send" id="chat_button">
                        </label>
                    </div>
                </div>
                <!-- 画像投稿時のモーダル -->
                <div class="modal">
                    <div class="text-center title">
                        投稿画像確認
                    </div>
                    <div class="bigimg"><img src="" alt="bigimg"></div>
                    <p class="close-btn"><a href="">✖</a></p>
                    <button type="submit" class="btn btn-primary rounded-pill btn-sm text-white btn-lg main-color post-image-btn" id="post_image_btn">投稿する</button>
                </div>
                <input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('tcd_membership_message_request')); ?>">
            <?php } ?>
        </div>
    </form>
</div>

<?php
get_footer();
