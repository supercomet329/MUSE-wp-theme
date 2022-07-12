<?php
// Add 2022/05/10 by H.Okabe
/**
 * 投稿画像コメントページ
 */
function tcd_membership_action_post_comment()
{
    global $tcd_membership_vars;
    nocache_headers();

    // $_REQUESTでのpost_idの取得
    if (!isset($_REQUEST['post_id']) || empty($_REQUEST['post_id'])) {
        // 取得できない場合 => トップページにリダイレクト
        wp_safe_redirect('/');
        exit();
    }
    $post_id = $_REQUEST['post_id'];
    $tcd_membership_vars['post_id'] = $post_id;

    // ユーザー存在チェック
    $user_id = get_current_user_id();

    // 投稿ボタンの表示 / 非表示
    $flg_submit_flag = false;
    if ((int)$user_id > 0) {
        $flg_submit_flag = true;
    }
    $tcd_membership_vars['flg_submit_flag']  = $flg_submit_flag;

    // コメントがPOSTされた場合の処理
    if ('POST' === $_SERVER['REQUEST_METHOD']) {
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'tcd_membership_action-post_comment')) {

            // 文字列のバリデート

            // DBの登録(wp_comments)
            if (!empty($_POST['message'])) {
                // wp_commentの登録
                $data = [
                    'comment_post_ID'  => $post_id,
                    'comment_content'  => $_POST['message'],
                    'user_id'          => get_current_user_id(),
                    'comment_date'     => date('Y-m-d H:i:s'),
                    'comment_approved' => 1,
                ];
                wp_insert_comment($data);
            }

            // DB登録成功時(同ページへリダイレクト)
            wp_safe_redirect(esc_url(get_tcd_membership_memberpage_url('post_comment')) . '&post_id=' . $post_id);
            exit();
        }
    }

    // 画像情報の取得
    $post_image = get_post_meta($post_id, 'main_image', true);
    if (empty($post_image)) {
        wp_safe_redirect('/');
        exit();
    }
    $post_image_array = [];
    $post_image_array[] = $post_image;

    $main_image2 = get_post_meta($post_id, 'main_image2', true);
    if (!empty($main_image2)) {
        $post_image_array[] = $main_image2;
    }

    $main_image3 = get_post_meta($post_id, 'main_image3', true);
    if (!empty($main_image3)) {
        $post_image_array[] = $main_image3;
    }

    $main_image4 = get_post_meta($post_id, 'main_image4', true);
    if (!empty($main_image4)) {
        $post_image_array[] = $main_image4;
    }
    $tcd_membership_vars['post_image_array']  = $post_image_array;

    // 画像のコメント一覧の取得(wp_comments)
    $array_comment = muse_list_comment($post_id);
    $tcd_membership_vars['comment']  = $array_comment;

    // テンプレートの設定
    $tcd_membership_vars['template']  = 'muse_post_comment';
}
add_action('tcd_membership_action-post_comment', 'tcd_membership_action_post_comment');

function muse_list_comment($post_id)
{
    $args = array(
        'post_id' => $post_id,
        'order'   => 'DESC',
    );
    $row_comment = get_comments($args);

    $list_comment = [];
    foreach ($row_comment as $one_comment) {

        if((int)$one_comment->user_id <= 0) {
            // ユーザーIDが0の場合落とす
            continue;
        }

        $comment = [];

        // ユーザーアイコンの取得
        $profileImageData  = get_user_meta($one_comment->user_id, 'profile_image', true);
        $profile_image     = get_template_directory_uri() . '/assets/img/icon/non_profile_image.png';
        if (!empty($profileImageData)) {
            $profile_image = $profileImageData;
        }
        $comment['profile_image'] = $profile_image;

        $user = get_userdata($one_comment->user_id);
        // ユーザーネームの取得
        $comment['display_name'] = $user->data->display_name;

        // コメントの取得
        $comment['comment'] = $one_comment->comment_content;

        // コメント投稿日時の取得
        $dateClass = new DateTime($one_comment->comment_date);
        $dateClass->setTimezone(new DateTimeZone('Asia/Tokyo'));
        $comment['date'] = $dateClass->format('Y/m/d H:i');
        $list_comment[] = $comment;
    }

    return $list_comment;
}
