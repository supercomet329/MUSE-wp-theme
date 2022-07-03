<?php
global $dp_options, $tcd_membership_vars, $tcd_membership_post, $post;

get_header();
?>
<form action="<?php echo esc_attr(get_tcd_membership_memberpage_url('page_report')); ?>" method="POST" enctype="multipart/form-data">
    <div class="container pt-2 bg-gray report">
        <div class="row mb-2">
            <div class="col-12">
                <a href="javascript:history.back();">← 戻る</a>
            </div>
        </div>
        <div class="text-center font-weight-bold title">
            通報内容
        </div>
        <div class="row my-2 py-2">
            <div class="col-12 report-subject">
                <?php if ($tcd_membership_vars['params']['post_image']) { ?>
                    <!-- 画像の場合 -->
                    <label class="form-label font-weight-bold mb-2">対象画像</label>
                    <img class="post-img text-center" src="<?php echo $tcd_membership_vars['params']['post_image']; ?>" alt="">
                <?php } ?>

                <!-- ユーザーの場合 -->
                <!-- <label class="form-label font-weight-bold mb-2">対象ユーザー</label>
                    <p class="user-name mb-1">UserName</p> -->
                <?php if ($tcd_membership_vars['params']['request_title']) { ?>
                    <!-- 依頼の場合 -->
                    <label class="form-label font-weight-bold mb-2">対象依頼</label>
                    <p class="post-request mb-1"><?php echo $tcd_membership_vars['params']['request_title']; ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12 report-reason">
                <label class="form-label font-weight-bold mb-2">通報理由</label>
            </div>
            <div class="col-12 report-reason">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="inlineCheckbox1" id="inlineCheckbox1" value="option1" <?php echo (isset($tcd_membership_vars['params']['inlineCheckbox1'])) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="inlineCheckbox1">項目1</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="inlineCheckbox2" id="inlineCheckbox2" value="option2" <?php echo (isset($tcd_membership_vars['params']['inlineCheckbox2'])) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="inlineCheckbox2">項目2</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="inlineCheckbox3" id="inlineCheckbox3" value="option3" <?php echo (isset($tcd_membership_vars['params']['inlineCheckbox3'])) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="inlineCheckbox3">その他</label>
                </div>
            </div>
            <div class="col-12 report-reason">
                <textarea id="report-reason" name="report_reason" class="form-control" rows="3"><?php echo $tcd_membership_vars['params']['report_reason']; ?></textarea>
                <!-- 通報理由任意に伴い無効化 -->
                <!-- <div class="inputReportReason" id="inputReportReason"></div> -->
            </div>
        </div>
        <div class="row my-2 py-2">
            <div class="col-12 text-center my-4">
                <button type="submit" class="btn btn-lg btn-danger report-btn" id="report-btn" disabled>　通報　</button>
            </div>
        </div>
    </div>

    <input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('tcd_membership_message_report')); ?>">

    <?php if ($tcd_membership_vars['params']['post_id']) { ?>
        <input type="hidden" name="post_id" value="<?php echo $tcd_membership_vars['params']['post_id']; ?>">
    <?php } else if ($tcd_membership_vars['params']['request_id']) { ?>
        <input type="hidden" name="request_id" value="<?php echo $tcd_membership_vars['params']['request_id']; ?>">
    <?php } ?>
</form>
<?php
get_footer();
