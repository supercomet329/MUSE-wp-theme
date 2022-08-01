<?php
global $dp_options, $tcd_membership_vars;
get_header();
?>
<div class="container pt-2">
    <form id="request_confirm" class="p-membership-form p-membership-form--registration<?php if (!empty($tcd_membership_vars['registration']['complete'])) echo ' is-complete'; ?>" enctype="multipart/form-data" method="post">
        <?php if (isset($tcd_membership_vars['error_message'])) : ?>
            <?php foreach ($tcd_membership_vars['error_message'] as $one_message) { ?>
                <div class="p-membership-form__error"><?php echo esc_attr($one_message); ?></div>
            <?php } ?>
        <?php endif; ?>

        <div class="row">
            <div class="col-12">
                <label for="title">依頼タイトル　（必須）</label>
            </div>
            <div class="col-12 pb-3">
                <?php echo esc_attr($_REQUEST['title']); ?>
            </div>
            <div class="col-12 pb-2">
                <div class="form-group">
                    <label for="content">依頼内容　（必須）</label>
                    <?php echo nl2br($_REQUEST['content']); ?>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="">添付ファイル　（任意）</label>
                    <?php /** 2022/05/11 アップロードできるファイルを確認  */ ?>
                    <a target="_blank" href="<?php echo $tcd_membership_vars['post_data']['request_file_url']; ?>"><?php echo $tcd_membership_vars['post_data']['request_file_name']; ?></a>
                </div>
            </div>
            <div class="col-12">
                <label for="selling_price">参考URL（任意）</label>
            </div>
            <div class="col-12 pb-3">
                <?php echo esc_attr($_REQUEST['url']); ?>
            </div>
            <div class="col-12">
                <label for="">予算　（必須）</label>
            </div>
            <div class="col-12 pb-2">
                <div class="custom-control custom-radio custom-control-inline">
                    <?php if (isset($_REQUEST['sales_format']) && (int)$_REQUEST['sales_format'] === 1) { ?>
                        指定する
                    <?php } else { ?>
                        指定しない
                    <?php } ?>
                </div>
            </div>
            <?php if (isset($_REQUEST['sales_format']) && (int)$_REQUEST['sales_format'] === 1) { ?>
                <div class="col-12 pb-4">
                    <?php echo esc_attr($_REQUEST['money']); ?>
                </div>
            <?php } ?>

            <div class="col-12">
                <label for="deadline">応募期限　（必須）</label>
            </div>
            <div class="col-12 pb-3">
                <?php echo esc_attr($tcd_membership_vars['view_deadline']); ?>
            </div>
            <div class="col-12">
                <label for="receptions_count">受付依頼数</label>
            </div>
            <div class="col-12 pb-3">
                <?php echo esc_attr($_REQUEST['receptions_count']); ?>
            </div>
            <div class="col-12">
                <label for="bin_price">納品希望日　（任意）</label>
            </div>
            <div class="col-12 pb-3">
                <?php echo esc_attr($_REQUEST['delivery_request']); ?>
            </div>
            <div class="col-12 ">
                <div class="form-group">
                    <label for="special_report">特記事項　（任意）</label>
                    <?php echo nl2br($_REQUEST['special_report']); ?>
                </div>
            </div>
            <div class="col-12">
                <div class="d-flex justify-content-center pt-4 pb-2">
                    <a id="complete" class="btn btn-primary text-white btn-block gradient-custom-4 font-weight-bold">
                        依頼する
                    </a>
                </div>
                <div class="d-flex justify-content-center pt-1 pb-2">
                    <a id="back" class="btn btn-secondary text-white btn-block gradient-custom-4 font-weight-bold">
                        戻る
                    </a>
                </div>
            </div>
        </div>
        <input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('tcd_membership_action_request')); ?>">

        <?php foreach ($tcd_membership_vars['post_data'] as $key => $value) { ?>
            <?php if ($key !== 'request_type') { ?>
                <input type="hidden" name="<?php echo $key; ?>" value="<?php echo $value; ?>">
            <?php } ?>
        <?php } ?>
    </form>
</div>
<script>
    $('#complete').on('click', function() {

        $('#request_confirm').append($('<input/>', {type: 'hidden', name: 'request_type', value: 'confirm'}))
        $('#request_confirm').submit();
    });

    $('#back').on('click', function() {

        $('#request_confirm').append($('<input/>', {type: 'hidden', name: 'request_type', value: 'back'}))
        $('#request_confirm').submit();
    });
</script>
<?php
get_footer();
