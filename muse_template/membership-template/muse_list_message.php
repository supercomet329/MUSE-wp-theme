<?php
global $dp_options, $tcd_membership_vars;
get_header();
?>
<div class="container pt-2">
    <div class="row mb-2">
        <div class="col-12">
            <a href="javascript:history.back();">← 戻る</a>
        </div>
    </div>
    <div class="text-center font-weight-bold title">
        メッセージ一覧
    </div>

    <div class="row">
        <div class="col-12">
            <ul class="list-area">
                <?php
                foreach ($tcd_membership_vars['list_message'] as $one_message) {

                    $profile_image = get_template_directory_uri() . '/assets/img/icon/non_profile_image.png';
                    if ((int)get_current_user_id() !== (int)$one_message->sender_user_id) {
                        // 送信者と自分が違う場合 => 表示させるメンバー情報は送信者
                        $user_id = $one_message->sender_user_id;
                    } else {
                        // 送信者と自分が同じ場合 => 表示させるメンバー情報は受信者
                        $user_id = $one_message->recipient_user_id;
                    }

                    $userData = get_userdata($user_id);
                    $profileImageData = get_user_meta($user_id, 'profile_image', true);

                    $dateTimeClass = new DateTime($one_message->sent_gmt);
                    $display_name = $userData->display_name;
                    if (!empty($profileImageData)) {
                        $profile_image = $profileImageData;
                    }

                ?>
                    <a href="<?php echo esc_attr(get_tcd_membership_memberpage_url('detail_message')); ?>&user_id=<?php echo $user_id; ?>">
                        <li class="d-flex align-items-start pt-2">
                            <img src="<?php echo esc_html($profile_image); ?>" class="rounded-circle">
                            <span class="name text-dark"><?php echo esc_attr($display_name); ?><br><br><span class="content"><?php echo nl2br($one_message->message); ?></span></span>
                            <span class="created_at">
                                <?php echo esc_attr($dateTimeClass->format('Y/m/d')); ?><br />
                                <?php echo esc_attr($dateTimeClass->format('H:i')); ?>
                            </span>
                        </li>
                    </a>

                <?php }
                /** endforeach */ ?>
            </ul>
        </div>
        <div class="col-12 d-flex justify-content-end">
            <div class="message-add-icon-area">
                <a href="<?php echo esc_attr(get_tcd_membership_memberpage_url('detail_message')); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/image_upload.png" class="message-add-icon" alt="メッセージ作成"></a>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
