<?php
global $dp_options, $tcd_membership_vars, $tcd_membership_post, $post;

get_header();
?>
<div class="container message-show-area" id="message_show_area">
    <div class="font-weight-bold title border-bottom-solid mt-4">
        <?php echo esc_attr($tcd_membership_vars['title_user_name']); ?>
    </div>
    <div class="row mb-5 pb-3">
        <?php
        foreach ($tcd_membership_vars['list_message'] as $date => $row_message) {
            $viewDate = new DateTime($date);
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

                <?php if ((int)$one_message['sender_user_id'] !== (int)get_current_user_id()) { ?>
                    <?php /** 送信者がログインユーザー以外 */ ?>
                    <div class="col-12">
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
                    </div>
                <?php } else { ?>
                    <div class="col-12">
                        <div class="balloon_r">
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
                    </div>
                <?php }
                /** endif */ ?>
            <?php }
            /** endforeach */ ?>

        <?php }
        /** endforeach */ ?>
    </div>

    <div class="row text-center message-create">
        <div>
            <div class="col-9">
                <textarea name="" rows="3" id="chat_input" class="border border-0"></textarea>
            </div>
            <div class="col-2 icon-area">
                <div>
                    <label>
                        <input type="file" name="file" accept="image/png, image/jpeg" id="messages_file_input">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/camera_bule.png" class="camera" alt="camera">
                    </label>
                </div>
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/send.png" class="send" alt="send" id="chat_button">
            </div>
        </div>
    </div>

    <!-- 画像投稿時のモーダル -->
    <div class="modal">
        <div class="text-center title">
            投稿画像確認
        </div>
        <div class="bigimg"><img src="" alt="bigimg"></div>
        <p class="close-btn"><a href="">✖</a></p>
        <button class="btn btn-primary rounded-pill btn-sm text-white btn-lg main-color post-image-btn" id="post_image_btn">投稿する</button>
    </div>
</div>

<?php
get_footer();
