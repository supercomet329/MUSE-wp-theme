<?php
global $dp_options, $tcd_membership_vars, $tcd_membership_post, $post;

get_header();
?>
<?php if ($tcd_membership_vars['params']['post_image']) { ?>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/swiper-bundle.min.css">
<?php } ?>
<div class="pc-center">
    <sidebar class="d-block d-sm-none">
        <ul class="menu-list accordion">
            <li class="toggle accordion-toggle side_mar my-3"><a href="#" class="py-0 pl-4"><span>項目1</span></a></li>
            <li class="toggle accordion-toggle side_mar my-3"><a href="#" class="py-0 pl-4"><span>項目2</span></a></li>
            <li class="toggle accordion-toggle side_mar my-3"><a href="#" class="py-0 pl-4"><span>項目3</span></a></li>
            <li class="toggle accordion-toggle side_mar my-3"><a href="#" class="py-0 pl-4"><span>項目4</span></a></li>
            <li class="toggle accordion-toggle side_mar my-3"><a href="#" class="py-0 pl-4"><span>項目5</span></a></li>
            <li class="toggle accordion-toggle side_mar my-3"><a href="#" class="py-0 pl-4"><span>項目6</span></a></li>
            <li class="toggle accordion-toggle side_mar my-3"><a href="#" class="py-0 pl-4"><span>項目7</span></a></li>
            <li class="toggle accordion-toggle side_mar my-3"><a href="#" class="py-0 pl-4"><span>項目8</span></a></li>
            <li class="toggle accordion-toggle side_mar my-3"><a href="#" class="py-0 pl-4"><span>項目9</span></a></li>
            <li class="toggle accordion-toggle side_mar my-3"><a href="#" class="py-0 pl-4"><span>項目10</span></a></li>
            <div class="side_down">&nbsp;</div>
        </ul>
    </sidebar>

    <div class="container pt-2 bg-gray report">
        <div class="row mb-2">
            <div class="col-12">
                <a href="javascript:history.back();">← 戻る</a>
            </div>
        </div>
        <div class="text-center font-weight-bold title">
            通報内容
        </div>
        <form action="<?php echo esc_attr(get_tcd_membership_memberpage_url('page_report')); ?>" method="POST" enctype="multipart/form-data">
            <div class="row my-2 py-2">
                <div class="col-12 report-subject">
                    <?php if ($tcd_membership_vars['params']['post_image']) { ?>
                        <!-- 画像の場合 -->
                        <label class="form-label font-weight-bold mb-2">対象画像</label>
                        <div class="my-2 slid-img swiper swipertum">
                            <div class="swiper-wrapper d-flex align-items-center">
                                <?php foreach ($tcd_membership_vars['params']['post_image'] as $post_image) { ?>
                                    <div class="swiper-slide">
                                        <img class="img-fluid mx-auto" src="<?php echo esc_url($post_image); ?>" />
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="swiper slid-list swiperlist">
                            <div class="swiper-wrapper">
                                <?php if (count($tcd_membership_vars['params']['post_image']) > 1) { ?>
                                    <?php foreach ($tcd_membership_vars['params']['post_image'] as $post_image) { ?>
                                        <div class="swiper-slide"><img src="<?php echo esc_url($post_image); ?>" /></div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
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
                <div class="container message-show-area">
                    <select id="sel_report" name="sel_report" class="shadow-none form-control form-control-sm col-12 col-md-5 col-lg-4 mb-2">
                        <option value="0" <?php echo ($report_key === 0) ? 'selected' : ''; ?>>通報内容を選択して下さい</option>
                        <?php foreach ($tcd_membership_vars['report_array'] as $report_key => $report_one) { ?>
                            <option value="<?php echo $report_key; ?>" <?php echo ($report_key === $tcd_membership_vars['sel_report']) ? 'selected' : ''; ?>><?php echo $report_one; ?></option>
                        <?php }
                        /** endforeach */ ?>
                    </select>
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
            <input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('tcd_membership_message_report')); ?>">

            <?php if ($tcd_membership_vars['params']['post_id']) { ?>
                <input type="hidden" name="post_id" value="<?php echo $tcd_membership_vars['params']['post_id']; ?>">
            <?php } else if ($tcd_membership_vars['params']['request_id']) { ?>
                <input type="hidden" name="request_id" value="<?php echo $tcd_membership_vars['params']['request_id']; ?>">
            <?php } ?>
        </form>
    </div>

    <?php if ($tcd_membership_vars['params']['post_image']) { ?>
        <!-- Swiper JS -->
        <script src="<?php echo get_template_directory_uri(); ?>/assets/js/swiper-bundle.min.js"></script>
    <?php } ?>
    <?php
    get_footer();
