<?php
global $dp_options;
if (!$dp_options) $dp_options = get_design_plus_option();

get_header();
?>
<div class="container mt-3 confirm-area">
    <form method="POST">
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
            <div class="col-12 mb-2">
                <div class="mb-2">
                    販売しない
                </div>
                <div>
                    <?php echo esc_attr($tcd_membership_vars['postData']['r18String']); ?>
                </div>
            </div>
        </div>
    </form>
</div>
<?php
get_footer();
