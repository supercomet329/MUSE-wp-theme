<?php
global $dp_options, $tcd_membership_vars;
$tcd_membership_vars['list_like'];
get_header();
?>
<div style="margin-top:500px;"></div>

<div class="container pt-2">
    <form class="p-membership-form p-membership-form--registration<?php if (!empty($tcd_membership_vars['registration']['complete'])) echo ' is-complete'; ?>" action="<?php echo esc_attr(get_tcd_membership_memberpage_url('modify_request')); ?>" enctype="multipart/form-data" method="post">
        <?php if (isset($tcd_membership_vars['error_message'])) : ?>
            <?php foreach ($tcd_membership_vars['error_message'] as $one_message) { ?>
                <div class="p-membership-form__error"><?php echo esc_attr($one_message); ?></div>
            <?php } ?>
        <?php endif; ?>

        <?php if (isset($_GET['status'])) : ?>
            <div class="p-membership-form__error">更新が完了しました。</div>
        <?php endif; ?>

        <div class="row">
            <div class="col-12">
                <label for="title">依頼タイトル　（必須）</label>
            </div>
            <div class="col-12 pb-3">
                <input type="text" name="title" class="form-control" placeholder="タイトルを入力" value="<?php echo esc_attr(isset($_REQUEST['title']) ? $_REQUEST['title'] : $tcd_membership_vars['requestData']->post_title); ?>" required>
            </div>
            <div class="col-12 pb-2">
                <div class="form-group">
                    <label for="content">依頼内容　（必須）</label>
                    <textarea class="form-control" name="content" id="content" rows="6" required><?php echo esc_textarea(isset($_REQUEST['content']) ? $_REQUEST['content'] : $tcd_membership_vars['requestData']->post_content); ?></textarea>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="">添付ファイル　（任意）</label>
                    <?php /** 2022/05/11 アップロードできるファイルを確認  */ ?>
                    <input type="file" name="file" accept="image/png, image/jpeg, image/gif, application/pdf, application/zip">
                </div>
            </div>
            <?php if (!empty($tcd_membership_vars['requestData']->request_file_url)) { ?>
                <div class="col-12">
                    <div class="form-group">
                        <label for="">登録添付ファイル</label>
                        <?php /** 2022/05/11 アップロードできるファイルを確認  */ ?>
                        <a href="<?php echo $tcd_membership_vars['requestData']->request_file_url; ?>" target="_blank">
                            <?php echo $tcd_membership_vars['requestData']->request_file_name; ?>
                        </a>
                    </div>
                </div>
            <?php } ?>
            <div class="col-12">
                <label for="selling_price">参考URL（任意）</label>
            </div>
            <div class="col-12 pb-3">
                <input type="url" name="url" class="form-control" value="<?php echo esc_attr(isset($_REQUEST['url']) ? $_REQUEST['url'] : $tcd_membership_vars['requestData']->url); ?>" />
            </div>
            <div class="col-12">
                <label for="">予算　（必須）</label>
            </div>
            <?php
            $sales_format_on  = '';
            $sales_format_off = 'checked';
            if (isset($_REQUEST['sales_format']) && (int)$_REQUEST['sales_format'] === 1) {
                $sales_format_on  = 'checked';
                $sales_format_off = '';
            } else if ($tcd_membership_vars['requestData']->sales_format === 1) {
                $sales_format_on  = 'checked';
                $sales_format_off = '';
            }

            ?>
            <div class="col-12 pb-2">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="normal_sales" name="sales_format" value="1" class="custom-control-input" <?php echo $sales_format_on; ?>>
                    <label class="custom-control-label" for="normal_sales">指定する</label>
                </div>
            </div>
            <div class="col-12 pb-4">
                <input type="number" name="money" class="form-control" value="<?php echo esc_attr(isset($_REQUEST['money']) ? $_REQUEST['money'] : $tcd_membership_vars['requestData']->money); ?>" placeholder="金額を入力" />
            </div>
            <div class="col-12 pb-3">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="auction" name="sales_format" value="0" class="custom-control-input" <?php echo $sales_format_off; ?>>
                    <label class="custom-control-label" for="auction">指定しない　（相談して決める）</label>
                </div>
            </div>
            <div class="col-12">
                <label for="deadline">応募期限　（必須）</label>
            </div>
            <div class="col-12 pb-3">
                <select name="deadline" id="deadline">
                    <?php foreach ($tcd_membership_vars['sel_deadline'] as $one_deadLine) { ?>
                        <option value="<?php echo esc_attr($one_deadLine['value']); ?>" <?php echo esc_attr($one_deadLine['check']); ?>><?php echo esc_attr($one_deadLine['text']); ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-12">
                <label for="receptions_count">受付依頼数</label>
            </div>
            <div class="col-12 pb-3">
                <input type="number" name="receptions_count" id="receptions_count" class="form-control" value="<?php echo esc_attr(isset($_REQUEST['receptions_count']) ? $_REQUEST['receptions_count'] : $request->receptions_count); ?>" />
            </div>
            <div class="col-12">
                <label for="bin_price">納品希望日　（任意）</label>
            </div>
            <div class="col-12 pb-3">
                <input type="date" name="delivery_request" value="<?php if (isset($_REQUEST['delivery_request'])) {
                                                                        echo $_REQUEST['delivery_request'];
                                                                    } else {
                                                                        $tcd_membership_vars['requestData']->delivery_request;
                                                                    } ?>">
            </div>
            <div class="col-12 ">
                <div class="form-group">
                    <label for="special_report">特記事項　（任意）</label>
                    <textarea class="form-control" name="special_report" id="special_report" rows="4"><?php if (isset($_REQUEST['special_report'])) {
                                                                                                            echo $_REQUEST['special_report'];
                                                                                                        } else {
                                                                                                            $tcd_membership_vars['requestData']->special_report;
                                                                                                        }
                                                                                                        ?></textarea>
                </div>
            </div>
            <div class="col-12">
                <div class="d-flex justify-content-center pt-4 pb-2">
                    <button type="submit" class="btn btn-primary text-white btn-block gradient-custom-4 font-weight-bold">
                        更新する
                    </button>
                </div>
            </div>
        </div>
        <input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('tcd_membership_action_request')); ?>">
        <input type="hidden" name="request_type" value="input">
        <input type="hidden" name="post_id" value="<?php if (isset($_REQUEST['post_id'])) {
                                                        echo $_REQUEST['post_id'];
                                                    } else {
                                                        echo $tcd_membership_vars['requestData']->post_id;
                                                    }
                                                    ?>" />
    </form>
</div>
<?php
get_footer();
