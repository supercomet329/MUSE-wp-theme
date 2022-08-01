<?php
global $dp_options, $tcd_membership_vars;
// TODO 2022/05/11 メッセージの仕様確認 by H.Okabe
get_header();
?>
<div class="container pt-2">
    <form id="comfirm_request" method="post">
        <div class="row">
            <div class="col-12">
                <label for="title" class="text-muted">依頼タイトル:</label>
            </div>
            <div class="col-12 border-bottom">
                <?php echo $tcd_membership_vars['requestData']['title']; ?>
            </div>
            <div class="col-12 pt-2">
                <label for="content" class="text-muted">依頼内容:</label>
            </div>
            <div class="col-12 border-bottom">
                <?php echo nl2br($tcd_membership_vars['requestData']['content']); ?>
            </div>
            <div class="col-12 pt-2">
                <label for="" class="text-muted">添付ファイル:</label>
            </div>
            <div class="col-12 border-bottom">
                <?php if (isset($tcd_membership_vars['requestData']['request_file_url']) && !empty($tcd_membership_vars['requestData']['request_file_url'])) { ?>
                    <a href="<?php echo $tcd_membership_vars['requestData']['request_file_url']; ?>" target="_blank">
                        <?php echo $tcd_membership_vars['requestData']['request_file_name']; ?>
                    </a>
                <?php } ?>
            </div>
            <div class="col-12 pt-2">
                <label for="" class="text-muted">参考URL:</label>
            </div>
            <div class="col-12 border-bottom">
                <?php if (isset($tcd_membership_vars['requestData']['url']) && !empty($tcd_membership_vars['requestData']['url'])) { ?>
                    <a href="<?php echo $tcd_membership_vars['requestData']['url']; ?>" target="_blank">
                        <?php echo $tcd_membership_vars['requestData']['url']; ?>
                    </a>
                <?php } ?>
            </div>
            <div class="col-12 pt-2">
                <label for="" class="text-muted">予算:</label>
            </div>
            <div class="col-12 border-bottom">
                <?php if (isset($tcd_membership_vars['requestData']['sales_format']) && $tcd_membership_vars['requestData']['sales_format'] > 0) { ?>
                    <?php echo number_format($tcd_membership_vars['requestData']['money']); ?>円
                <?php } else { ?>
                    相談して決める
                <?php } ?>
            </div>
            <div class="col-12 pt-2">
                <label for="" class="text-muted">納品希望日:</label>
            </div>
            <div class="col-12 border-bottom">
                <?php echo $tcd_membership_vars['requestData']['deadline']; ?>
            </div>
            <div class="col-12 pt-2">
                <label for="" class="text-muted">特記事項:</label>
            </div>
            <div class="col-12 border-bottom">
                <?php echo nl2br($tcd_membership_vars['requestData']['special_report']); ?>
            </div>
            <div class="col-12 pt-2 ">
                メッセージ一覧
            </div>
            <div class="col-12">
                <ul style="margin:0; padding:0">
                    <li class="d-flex align-items-start pt-2">
                        <figure><img src="https://i.imgur.com/JgYD2nQ.jpg" class="rounded-circle" width="60" height="60"></figure>
                        <div><span class="mr-2">UserName</span><span>2022/04/11 16:00</span><br>こんにちは</div>
                    </li>
                    <li class="d-flex align-items-start pt-2">
                        <figure><img src="assets/img/pixta_64747350_M.jpg" class="rounded-circle" width="60" height="60"></figure>
                        <div><span class="mr-2">UserName</span><span>2022/04/11 16:30</span><br>よろしくお願いします。</div>
                    </li>
                </ul>
            </div>
            <div class="col-12">
                <?php if ($tcd_membership_vars['requestData']['viewReceivedButton']) { ?>
                    <div class="d-flex justify-content-center pt-4 pb-2">
                        <button id="buttonReceived" type="button" class="btn btn-primary text-white btn-block gradient-custom-4 font-weight-bold">受注する
                        </button><br />
                    </div>
                <?php } ?>

                <div class="d-flex justify-content-center pt-1 pb-2">
                    <button id="addComment" type="submit" class="btn btn-primary text-white btn-block gradient-custom-4 font-weight-bold">受託する
                    </button><br />
                </div>
                <div class="d-flex justify-content-center pt-1 pb-2">
                    <button id="back" type="button" class="btn btn-secondary text-white btn-block gradient-custom-4 font-weight-bold">戻る
                    </button><br />
                </div>
            </div>
        </div>
        <input type="hidden" name="nonce"   value="<?php echo esc_attr(wp_create_nonce('tcd_membership_confirm_request')); ?>">
        <input type="hidden" name="post_id" value="<?php echo $tcd_membership_vars['requestData']['post_id']; ?>">
        <input type="hidden" name="request_type" value="confirm">
    </form>
</div>
<script>
    $('#back').on('click', function() {
        window.location.href = "<?php echo get_tcd_membership_memberpage_url('confirm_request'); ?>&request_id=<?php echo $tcd_membership_vars['requestData']['post_id']; ?>";
    });
</script>
<?php
get_footer();
