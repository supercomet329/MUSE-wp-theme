<?php
global $dp_options;
if (!$dp_options) $dp_options = get_design_plus_option();

// 202206/14 TODO: 決済方法が決まったら決済部の対応
get_header();
?>
<div class="container mt-3 confirm-area">
    <form action="POST">
        <div class="row">
            <div class="col-12 item-text mb-2">
                投稿画像（必須）
            </div>
            <div class="col-12 mb-4 confirm-image-area">
                <img src="<?php echo esc_url($tcd_membership_vars['postData']['post_image']); ?>">
            </div>
            <div class="col-12 item-text mb-2">
                タイトル（必須）
            </div>
            <div class="col-12 mb-4">
                <?php echo esc_attr($tcd_membership_vars['postData']['post_title']); ?>
            </div>
            <div class="col-12 item-text mb-2">
                詳細（任意）
            </div>
            <div class="col-12 mb-4">
                <?php echo nl2br($tcd_membership_vars['postData']['post_content']); ?>
            </div>
            <div class="col-12 mb-2 item-text">
                販売形式（必須）
            </div>
            <div class="col-12 mb-4">
                <div class="mb-2">
                    オークション
                </div>
                <div>
                    <?php echo esc_attr($tcd_membership_vars['postData']['r18String']); ?>
                </div>
            </div>
            <div class="col-12 item-text mb-2">
                オークション開始日時（必須）
            </div>
            <div class="col-12 mb-4">
                <?php if ($tcd_membership_vars['postData']['auctionFlag']) { ?>
                    開始時間指定
                <?php } else { ?>
                    開始時間指定なし
                <?php } ?>
            </div>
            <?php if ($tcd_membership_vars['postData']['auctionFlag']) { ?>
                <div class="col-12 item-text mb-2">
                    オークション開始日時
                </div>
                <div class="col-12 mb-4">
                    <?php echo esc_attr($tcd_membership_vars['postData']['auctionStartDate']); ?>
                </div>
                <div class="col-12 item-text mb-2">
                    オークション終了日時
                </div>
                <div class="col-12 mb-4">
                    <?php echo esc_attr($tcd_membership_vars['postData']['auctionEndDate']); ?>
                </div>
                <div class="col-12 item-text mb-2">
                    オークション自動延長
                </div>
                <div class="col-12 mb-2">
                    <input type="text" value="あり" class="border border-0" readonly>
                </div>
                <div class="text-danger mb-3 ml-3 small">
                    ※終了5分前に入札されると、5分延長されます。
                </div>
            <?php } ?>
            <?php if ($tcd_membership_vars['postData']['viewButtonFlag']) { ?>
                <div class="col-12 my-2">
                    <div class="text-center custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="terms_service">
                        <label class="custom-control-label font-weight-bold small" for="terms_service">利用規約に同意する</label>
                    </div>
                </div>
                <div class="col-12 my-3 text-center">
                    <button type="submit" class="btn btn-primary save-btn text-white" id="save_btn" disabled>画像投稿</button>
                </div>
            <?php } ?>
        </div>
        <input type="hidden" name="post_id" value="<?php echo $tcd_membership_vars['postData']['post_id']; ?>" ?>
    </form>
</div>
<?php
get_footer();
