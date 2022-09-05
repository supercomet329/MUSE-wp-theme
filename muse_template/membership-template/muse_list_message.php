<?php
global $dp_options, $tcd_membership_vars;
get_header();
?>

<div class="pc-center">
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
                        $dateTimeClass->setTimezone(new DateTimeZone('Asia/Tokyo'));
                        $display_name = $userData->display_name;
                        if (!empty($profileImageData)) {
                            $profile_image = $profileImageData;
                        }
                    ?>
                        <!--メッセージブロック start -->
                        <a href="<?php echo esc_attr(get_tcd_membership_memberpage_url('detail_message')); ?>&user_id=<?php echo $user_id; ?>">
                            <li class="d-flex align-items-start pt-2">
                                <img src="<?php echo esc_html($profile_image); ?>" class="rounded-circle">
                                <span class="name text-dark"><?php echo esc_attr($display_name); ?><br><span class="content"><span class="content"><?php echo nl2br($one_message->message); ?></span></span>
                                    <span class="created_at">
                                        <?php echo esc_attr($dateTimeClass->format('Y/m/d')); ?><br><?php echo esc_attr($dateTimeClass->format('H:i')); ?>
                                    </span>
                            </li>
                        </a>
                        <!--メッセージブロック end -->
                    <?php }
                    /** endforeach */ ?>
                </ul>
            </div>
            <div class="col-12 d-flex justify-content-end mt-2">
                <div class="message-add-icon-area">
                    <a href="<?php echo esc_attr(get_tcd_membership_memberpage_url('detail_message')); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/image_upload02.png" class="message-add-icon" alt="メッセージ作成"></a>
                </div>
            </div>
        </div>
    </div>

    <?php
    get_footer();
