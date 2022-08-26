<?php
global $dp_options, $tcd_membership_vars, $tcd_membership_post, $post;

get_header();
?>
<div class="container pt-2">
    <div class="row mb-2">
        <div class="col-12">
            <a href="javascript:history.back();">← 戻る</a>
        </div>
    </div>
</div>

<form action="<?php echo esc_attr(get_tcd_membership_memberpage_url('detail_message')); ?>" method="POST" enctype="multipart/form-data">

    <?php if (count($tcd_membership_vars['error_messages']) > 0) { ?>
        <div class="col-12 mb-3" id="inputRequestErrMsgArea">

            <div class="inputFile" id="inputFile">
                <?php foreach($tcd_membership_vars['error_messages'] as $error_message) { ?>
                <p id="inputRequestErrMsg" class="alert-color font-weight-bold"><?php echo $error_message; ?></p>
                <?php } ?>
            </div>
        </div>

    <?php } ?>
    <div class="container message-show-area" id="message_show_area">
        <?php if (!is_null($tcd_membership_vars['target_user_id'])) { ?>

            <!-- ユーザー指定がある場合 -->
            <div class="font-weight-bold title border-bottom-solid mt-4">
                <?php echo esc_attr($tcd_membership_vars['title_user_name']); ?>
                <input type="hidden" name="user_id" value="<?php echo $tcd_membership_vars['target_user_id']; ?>" wtx-context="4C293744-6AAE-4895-9E4D-551C00D5FF73">
            </div>
        <?php } else { ?>
            <div class="form-group col-12 px-0 my-2">
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
                <?php } else { ?>
                    送信できるユーザーがいません
                <?php } ?>
            </div>
        <?php } ?>

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
                                        <p><?php echo esc_attr($one_message['message']); ?></p>
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

        <?php if ($tcd_membership_vars['message_flag']) { ?>
            <div class="row text-center message-create">
                <div>
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
    </div>
<?php } ?>
<input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('tcd_membership_message_request')); ?>">
</form>
<?php
get_footer();
