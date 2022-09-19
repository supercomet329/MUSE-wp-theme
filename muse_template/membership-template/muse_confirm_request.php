<?php
global $dp_options, $tcd_membership_vars;
get_header();
?>
<div class="container pt-2 request_show">
    <div class="row mb-2">
        <div class="col-12">
            <a href="javascript:history.back();">← 戻る</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mb-2">
            <?php
            if (isset($_SESSION['messageUpdateConfirm'])) {
                $message = $_SESSION['messageUpdateConfirm'];
                unset($_SESSION['messageUpdateConfirm']);
            ?>
                <div class="error_message"><?php echo esc_attr($message); ?></div>
            <?php }
            /** endif */ ?>
        </div>
        <div class="col-12 item-text mb-2">
            <?php echo esc_attr($tcd_membership_vars['title']); ?>
        </div>
        <div class="mb-2 col-8 d-flex justify-content-start text-center">
            <img src="<?php echo esc_url($tcd_membership_vars['profile_image']); ?>" alt="profile" class="rounded-circle" width="50">
            <span class="font-weight-bold mr-auto">
                <?php echo esc_attr($tcd_membership_vars['display_name']); ?>
            </span>
        </div>
        <div class="col-4 my-auto">
            <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('page_report')); ?>&request_id=<?php echo esc_attr($tcd_membership_vars['request_id']); ?>" class="btn btn-primary text-white rounded-pill btn-sm text-white btn-lg main-color float-right">通報する</a>
        </div>
    </div>


    <div class="row d-flex justify-content-center">
        <div class="col-12 tab-area text-center pt-1 pb-1 ml-1 mr-2">
            <ul class="nav nav-pills nav-fill">
                <li class="nav-item each-tab <?php echo $tcd_membership_vars['tabStyle']; ?>">
                    <a class="nav-link active btn text-white" id="contents-tab" data-toggle="tab" href="#contents" role="tab" aria-controls="contents" aria-selected="true">
                        <div class="mx-auto">依頼内容</div>
                    </a>
                </li>
                <li class="nav-item each-tab <?php echo $tcd_membership_vars['tabStyle']; ?>">
                    <a class="nav-link btn text-white not-selected-tab" id="files-tab" data-toggle="tab" href="#files" role="tab" aria-controls="files" aria-selected="false">
                        <div class="mx-auto">添付ファイル<br>参考URL</div>
                    </a>
                </li>
                <li class="nav-item each-tab col-3">
                    <a class="nav-link btn text-white not-selected-tab" id="budgets-tab" data-toggle="tab" href="#budgets" role="tab" aria-controls="budgets" aria-selected="false">
                        <div class="mx-auto">予算<br>納品希望日</div>
                    </a>
                </li>
                <?php if ($tcd_membership_vars['flgComment'] === TRUE) { ?>
                    <li class="nav-item each-tab <?php echo $tcd_membership_vars['tabStyle']; ?>">
                        <a class="nav-link btn text-white not-selected-tab" id="comments-tab" data-toggle="tab" href="#comments" role="tab" aria-controls="comments" aria-selected="false">
                            <div class="mx-auto">コメント</div>
                        </a>
                    </li>
                <?php }
                /** endif */ ?>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="tab-content w-100">
            <div class="tab-pane active" id="contents" role="tabpanel" aria-labelledby="contents-tab">
                <div class="container">
                    <div class="row">
                        <?php if ($tcd_membership_vars['flgView'] === TRUE) { ?>
                            <div class="col-12 mt-2 item-text border-bottom-solid ">
                                依頼タイトル
                            </div>
                            <div class="col-12 mt-1 ">
                                <?php echo esc_attr($tcd_membership_vars['workTitle']); ?>
                            </div>
                        <?php } ?>
                        <div class="col-12 mt-4 item-text border-bottom-solid ">
                            本文
                        </div>
                        <div class="col-12 mt-1 ">
                            <?php echo nl2br($tcd_membership_vars['content']); ?>
                        </div>
                        <div class="col-12 mt-4 item-text border-bottom-solid ">
                            構図
                        </div>
                        <div class="col-12 mt-1 ">
                            <?php echo nl2br($tcd_membership_vars['composition']); ?>
                        </div>
                        <?php if ($tcd_membership_vars['flgView'] === TRUE) { ?>
                            <div class="col-12 mt-4 item-text border-bottom-solid ">
                                キャラクター
                            </div>
                            <div class="col-12 mt-1 ">
                                <?php echo nl2br($tcd_membership_vars['character']); ?>
                            </div>
                            <?php if ($tcd_membership_vars['specifyUserId'] === false) { ?>
                            <div class="col-12 mt-4 item-text border-bottom-solid">
                                受付依頼数
                            </div>
                            <div class="col-12 mt-1">
                                <?php echo nl2br($tcd_membership_vars['orderQuantity']); ?>件
                            </div>
                            <?php } /** endif */ ?>
                        <?php } ?>

                        <?php if ($tcd_membership_vars['flgReceived'] === TRUE) { ?>
                            <div class="col-12 mt-4 mt-xl-4 pt-xl-3 mb-5 text-center">
                                <form action="<?php echo get_tcd_membership_memberpage_url('confirm_request'); ?>" method="POST">
                                    <button type="submit" class="btn text-white save-btn">依頼を受ける</button>
                                    <input type="hidden" name="request_type" value='received' />
                                    <input type="hidden" name="request_id" value='<?php echo esc_attr($tcd_membership_vars['request_id']); ?>' />
                                    <input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('tcd-membership-confirm_message-' . $tcd_membership_vars['request_id'])); ?>">
                                </form>
                            </div>
                        <?php }
                        /** endif */ ?>

                        <?php if ($tcd_membership_vars['flgComplete'] === TRUE) { ?>
                            <div class="col-12 mt-4 mt-xl-4 pt-xl-3 mb-5 text-center">
                                <form action="<?php echo get_tcd_membership_memberpage_url('confirm_request'); ?>" method="POST">
                                    <button type="submit" class="btn text-white save-btn">依頼を完了にする</button>
                                    <input type="hidden" name="request_type" value='complete' />
                                    <input type="hidden" name="request_id" value='<?php echo esc_attr($tcd_membership_vars['request_id']); ?>' />
                                    <input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('tcd-membership-confirm_message-' . $tcd_membership_vars['request_id'])); ?>">
                                </form>
                            </div>
                        <?php }
                        /** endif */ ?>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="files" role="tabpanel" aria-labelledby="files-tab">
                <div class="container">
                    <div class="row">
                        <div class="col-12 mt-2 item-text border-bottom-solid">
                            添付ファイル
                        </div>
                        <div class="col-12 mt-1">
                            <a href="<?php echo esc_url($tcd_membership_vars['requestFileUrl']); ?>">
                                <?php echo esc_url($tcd_membership_vars['requestFileName']); ?>
                            </a>
                        </div>

                        <?php if (!empty($tcd_membership_vars['refUrl'])) { ?>
                            <div class="col-12 mt-4 item-text border-bottom-solid">
                                参考URL
                            </div>
                            <div class="col-12 mt-1">
                                <a target="_blank" href="<?php echo esc_url($tcd_membership_vars['refUrl']); ?>">
                                    <?php echo esc_url($tcd_membership_vars['refUrl']); ?>
                                </a>
                            </div>
                        <?php }
                        /** endif */ ?>
                        <?php if ($tcd_membership_vars['flgReceived'] === TRUE) { ?>
                            <div class="col-12 mt-4 mt-xl-4 pt-xl-3 mb-5 text-center">
                                <form action="<?php echo get_tcd_membership_memberpage_url('confirm_request'); ?>" method="POST">
                                    <button type="submit" class="btn text-white save-btn">依頼を受ける</button>
                                    <input type="hidden" name="request_type" value='received' />
                                    <input type="hidden" name="request_id" value='<?php echo esc_attr($tcd_membership_vars['request_id']); ?>' />
                                    <input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('tcd-membership-confirm_message-' . $tcd_membership_vars['request_id'])); ?>">
                                </form>
                            </div>
                        <?php }
                        /** endif */ ?>

                        <?php if ($tcd_membership_vars['flgComplete'] === TRUE) { ?>
                            <div class="col-12 mt-4 mt-xl-4 pt-xl-3 mb-5 text-center">
                                <form action="<?php echo get_tcd_membership_memberpage_url('confirm_request'); ?>" method="POST">
                                    <button type="submit" class="btn text-white save-btn">依頼を完了にする</button>
                                    <input type="hidden" name="request_type" value='complete' />
                                    <input type="hidden" name="request_id" value='<?php echo esc_attr($tcd_membership_vars['request_id']); ?>' />
                                    <input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('tcd-membership-confirm_message-' . $tcd_membership_vars['request_id'])); ?>">
                                </form>
                            </div>
                        <?php }
                        /** endif */ ?>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="budgets" role="tabpanel" aria-labelledby="budgets-tab">
                <div class="container block">
                    <div class="row">
                        <?php if ($tcd_membership_vars['flgView'] === TRUE) { ?>

                            <div class="col-12 mt-2 item-text border-bottom-solid">
                                予算
                            </div>
                            <div class="col-12 mt-1">
                                <?php echo esc_attr($tcd_membership_vars['budget']); ?>
                            </div>
                            <div class="col-12 mt-4 item-text border-bottom-solid">
                                応募期限
                            </div>
                            <div class="col-12 mt-1">
                                <?php echo esc_attr($tcd_membership_vars['app_deadline_date']); ?>
                            </div>
                        <?php } ?>
                        <?php if (!empty($tcd_membership_vars['desired_date'])) { ?>
                            <div class="col-12 mt-4 item-text border-bottom-solid">
                                納品希望日
                            </div>
                            <div class="col-12 mt-1">
                                <?php echo esc_attr($tcd_membership_vars['desired_date']); ?>
                            </div>
                        <?php }
                        /** endif */ ?>
                        <?php if ($tcd_membership_vars['flgReceived'] === TRUE) { ?>
                            <div class="col-12 mt-4 mt-xl-4 pt-xl-3 mb-5 text-center">
                                <form action="<?php echo get_tcd_membership_memberpage_url('confirm_request'); ?>" method="POST">
                                    <button type="submit" class="btn text-white save-btn">依頼を受ける</button>
                                    <input type="hidden" name="request_type" value='received' />
                                    <input type="hidden" name="request_id" value='<?php echo esc_attr($tcd_membership_vars['request_id']); ?>' />
                                    <input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('tcd-membership-confirm_message-' . $tcd_membership_vars['request_id'])); ?>">
                                </form>
                            </div>
                        <?php }
                        /** endif */ ?>

                        <?php if ($tcd_membership_vars['flgComplete'] === TRUE) { ?>
                            <div class="col-12 mt-4 mt-xl-4 pt-xl-3 mb-5 text-center">
                                <form action="<?php echo get_tcd_membership_memberpage_url('confirm_request'); ?>" method="POST">
                                    <button type="submit" class="btn text-white save-btn">依頼を完了にする</button>
                                    <input type="hidden" name="request_type" value='complete' />
                                    <input type="hidden" name="request_id" value='<?php echo esc_attr($tcd_membership_vars['request_id']); ?>' />
                                    <input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('tcd-membership-confirm_message-' . $tcd_membership_vars['request_id'])); ?>">
                                </form>
                            </div>
                        <?php }
                        /** endif */ ?>
                    </div>
                </div>
            </div>
            <?php if ($tcd_membership_vars['flgComment'] === TRUE) { ?>
                <div class="tab-pane" id="comments" role="tabpanel" aria-labelledby="comments-tab">
                    <div class="col-12 mt-2 item-text border-bottom-solid">
                        コメント
                    </div>
                    <div class="col-12 mt-1">
                        <?php foreach ($tcd_membership_vars['comments'] as $comments) { ?>
                            <div class="row my-3">
                                <div class="col-3 col-sm-2 col-lg-1 pr-0">
                                    <img src="<?php echo esc_url($comments['profile_image']); ?>" class="rounded-circle" width="60" height="60">
                                </div>
                                <div class="col-8 col-sm-9 col-lg-10 bg-gray p-2 rounded">
                                    <div class="row">
                                        <div class="col-12 msg-detail">
                                            <span class="mr-2 msg-name font-weight-bold">
                                                <?php echo esc_attr($comments['display_name']); ?>
                                            </span>
                                            <span class="msg-date">
                                                <?php echo esc_attr($comments['date']); ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 msg">
                                            <p class="mb-0">
                                                <?php echo nl2br($comments['comment']); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                        /** endforeach */ ?>
                    </div>

                    <form action="<?php echo get_tcd_membership_memberpage_url('confirm_request'); ?>" method="POST">
                        <div class="col-12 mt-5 text-center">
                            <textarea name="comment" rows="3" id="chat_input" class="w-100 border border-0 request-comment"></textarea>
                        </div>
                        <div class="col-12 mt-1 text-center">
                            <button type="submit" class="btn text-white save-btn">コメントを投稿</button>
                        </div>
                        <input type="hidden" name="request_type" value='comment' />
                        <input type="hidden" name="request_id" value='<?php echo esc_attr($tcd_membership_vars['request_id']); ?>' />
                        <input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('tcd-membership-confirm_message-' . $tcd_membership_vars['request_id'])); ?>">

                        <?php if (isset($tcd_membership_vars['error_message']['comment'])) { ?>
                            <div class="col-12 mt-2 text-center">
                                <div class="error_message"><?php echo esc_attr($tcd_membership_vars['error_message']['comment']); ?></div>
                            </div>
                        <?php }
                        /** endif */ ?>
                    </form>
                </div>
            <?php }
            /** endif */ ?>
        </div>
    </div>
</div>

<?php
get_footer();
