<?php
// Add 2022/05/10 by H.Okabe
/**
 * 依頼している依頼の詳細画面
 * TODO: 2022/05/11 メッセージのやり取りの対応
 */
function tcd_membership_action_comfirm_request()
{
    global $wpdb, $tcd_membership_vars;

    $request_id = $_GET['request_id'];
    $rowResuestData = get_request($request_id);

    if (count($rowResuestData) <= 0) {
        wp_safe_redirect(user_trailingslashit(home_url()));
        exit;
    }

    // テンプレート指定
    $tcd_membership_vars['template']  = 'muse_comfirm_request';

    $user = wp_get_current_user();
    $requestData = [];

    // 作品ID
    $post_id = $rowResuestData[0]->post_id;
    $requestData['post_id'] = $post_id;

    // 依頼タイトル
    $requestData['title'] = $rowResuestData[0]->post_title;

    // 依頼内容
    $requestData['content'] = $rowResuestData[0]->post_content;

    // 構図
    $requestData['composition'] = get_post_meta($post_id, 'composition', true);

    // キャラクター
    $requestData['character'] = get_post_meta($post_id, 'character', true);

    // 受付依頼数
    $requestData['orderQuantity'] = get_post_meta($post_id, 'orderQuantity', true);

    // 添付ファイル
    $requestData['requestFileName'] = get_post_meta($post_id, 'requestFileName', true);
    $requestData['requestFileUrl']  = get_post_meta($post_id, 'requestFileUrl', true);
    $filePathArray = explode('/', $requestData['requestFileUrl']);
    $fileName = end($filePathArray);
    $checkFile = __DIR__ . '/../../upload_file/' . $fileName;
    $requestData['requestFileFlag']  = exif_imagetype($checkFile);

    // 参考URL
    $requestData['refUrl']  = get_post_meta($post_id, 'refUrl', true);

    // 予算
    $requestData['budget']  = get_post_meta($post_id, 'budget', true);

    // 特記事項
    $requestData['specialNotes']  = get_post_meta($post_id, 'specialNotes', true);

    // 応募期限
    $appDeadlineDate = get_post_meta($post_id, 'appDeadlineDate', true);
    $appDeadClass = new DateTime($appDeadlineDate);
    $requestData['appDeadlineDate']  = $appDeadClass->format('Y/m/d');

    // 納品希望日
    $requestData['desiredDate']  = false;
    $desiredDate = get_post_meta($post_id, 'desiredDate', true);
    if(! empty($desiredDate)) {
        $desiredDateClass = new DateTime($desiredDate);
        $desiredDate = $desiredDateClass->format('Y/m/d');
    }
    $requestData['desiredDate']  = $desiredDate;

    // プロフィールイメージ
    $author_id = $rowResuestData[0]->post_author;
    $profileImageData = get_user_meta($author_id, 'profile_image', true);
    $profile_image = get_template_directory_uri() . '/assets/img/icon/non_profile_image.png';
    if (!empty($profileImageData)) {
        $profile_image = $profileImageData;
    }
    $requestData['profile_image'] = $profile_image;

    $author = get_user_by('id', $author_id);
    $requestData['display_name'] = $author->data->display_name;

    $viewReceivedButton = false;
    if ((int)$author_id !== (int)$user->ID) {
        $viewReceivedButton = true;
    }
    $requestData['viewReceivedButton'] = $viewReceivedButton;

    nocache_headers();
    if (!$user) {
        wp_safe_redirect(user_trailingslashit(home_url()));
        exit;
    }
    $tcd_membership_vars['requestData']  = $requestData;
}
add_action('tcd_membership_action-comfirm_request', 'tcd_membership_action_comfirm_request');
