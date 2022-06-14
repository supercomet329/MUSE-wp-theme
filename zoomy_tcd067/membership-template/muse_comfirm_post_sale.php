<?php
global $dp_options;
if (!$dp_options) $dp_options = get_design_plus_option();

// 202206/14 TODO: 決済方法が決まったら決済部の対応

get_header();
?>
<div class="container mt-3 confirm-area">
    <form action="#" method="POST">
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
                    通常販売
                </div>
                <div>
                    <?php echo esc_attr($tcd_membership_vars['postData']['r18String']); ?>
                </div>
            </div>
            <div class="col-12 item-text mb-2">
                販売価格（必須）
            </div>
            <div class="col-12 mb-4">
                <div class="mb-2">
                    <?php echo esc_attr($tcd_membership_vars['postData']['imagePrice']); ?> 円
                </div>
                <div>
                    （手数料差引額〇〇〇円）
                </div>
            </div>
            <div class="col-12 item-text mb-2">
                即決価格（必須）
            </div>
            <div class="col-12 mb-2">
                <?php echo esc_attr($tcd_membership_vars['postData']['binPrice']); ?> 円
            </div>
            <?php if ($tcd_membership_vars['postData']['viewButtonFlag']) { ?>
                <div class="col-12 my-2">
                    <div class="text-center custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="terms_service">
                        <label class="custom-control-label font-weight-bold small" for="terms_service">利用規約に同意する</label>
                    </div>
                </div>
                <div class="col-12 my-3 text-center">
                    <button type="submit" class="btn btn-primary save-btn text-white" id="save_btn" disabled>画像購入</button>
                </div>
            <?php } ?>
        </div>
        <input type="hidden" name="post_id" value="<?php echo $tcd_membership_vars['postData']['post_id']; ?>" ?>
    </form>
</div>
<?php
get_footer();
