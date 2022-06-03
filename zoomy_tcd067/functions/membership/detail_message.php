<?php
// Add 2022/06/03 by H.Okabe
/**
 * メッセージ詳細
 */
function tcd_membership_action_detail_message()
{
    global $tcd_membership_vars;

    $user = wp_get_current_user();
    $target_user_id = filter_input(INPUT_GET, 'user_id');

    if (!$user || is_null($target_user_id)) {
        wp_safe_redirect(user_trailingslashit(home_url()));
        exit;
    }

    $args = [
        'user_id' => get_current_user_id(),
        'target_user_id' => $target_user_id,

    ];
    $row_message = get_tcd_membership_messages_user_messages($args);
    $display_user = get_userdata( $target_user_id );

    $list_message = [];
    foreach ($row_message as $one_message) {
        $dateClass = new DateTime($one_message->sent_gmt);
        $day       = $dateClass->format('Ymd 00:00:00');

        $message = $one_message->message;
        $imgFlag = false;
        if (preg_match('/.gif|.png|.jpg|.jpeg/', $message) === 1) {
            $imgFlag = true;
        }

        $list_message[$day][] = [
            'sender_user_id' => $one_message->sender_user_id,
            'message'        => $one_message->message,
            'image_flag'     => $imgFlag,
            'send_time'      => $dateClass->format('H:i'),
        ];
    }

    $tcd_membership_vars['template']  = 'muse_detail_message';
    $tcd_membership_vars['list_message'] = $list_message;
    $tcd_membership_vars['title_user_name'] = $display_user->display_name;
}
add_action('tcd_membership_action-detail_message', 'tcd_membership_action_detail_message');
