<?php
// Add 2022/05/10 by H.Okabe
/**
 * 投稿画像コメントページ
 */
function tcd_membership_action_post_comment()
{
    global $tcd_membership_vars;

    // $_REQUESTでのpost_idの取得
        // 取得できない場合 => トップページにリダイレクト

    nocache_headers();

    // ユーザー存在チェック
    $user = wp_get_current_user();

    // 投稿ボタンの表示 / 非表示
    if (!$user) {
        wp_safe_redirect(user_trailingslashit(home_url()));
        exit;
    }

    // コメントがPOSTされた場合の処理

    // 文字列のバリデート

    // DBの登録(wp_comments)

    // DB登録成功時(同ページへリダイレクト)

    // 画像情報の取得

    // 画像のコメント一覧の取得(wp_comments)

    // テンプレートの設定
    $tcd_membership_vars['template']  = 'muse_post_comment';

    // 渡す値の対応

}
add_action('tcd_membership_action-post_comment', 'tcd_membership_action_post_comment');