<?php
global $dp_options, $tcd_membership_vars;

get_header();
?>
<form method="POST">
    <div class="container request_show">
        <div class="row">
            <div class="mt-4 col-12 item-text">
                <?php echo esc_attr($tcd_membership_vars['requestData']['post_name']); ?>
            </div>
            <div class="mt-4 mb-2 col-12 d-flex justify-content-start text-center">
                <img src="<?php echo esc_url($tcd_membership_vars['requestData']['profile_image']); ?>" alt="profile" class="rounded-circle" width="50">
                <span class="font-weight-bold mr-auto"><?php echo esc_attr($tcd_membership_vars['requestData']['display_name']); ?></span>
                <div class="w-25">
                    <?php if ($tcd_membership_vars['requestData']['viewReceivedButton']) { ?>
                        <div class="border rounded-pill py-1 px-1 f-size-10 font-weight-bold keep_off">
                            <?php if (is_keep($tcd_membership_vars['requestData']['post_id'])) { ?>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/keep_on.png" alt="keep-off" class="js-toggle-keep keep-on" data-post-id="<?php echo $tcd_membership_vars['requestData']['post_id']; ?>">
                            <?php } else { ?>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/keep_off.png" alt="keep-off" class="js-toggle-keep keep-on" data-post-id="<?php echo $tcd_membership_vars['requestData']['post_id']; ?>">
                            <?php }
                            /** endif */ ?>
                        </div>
                    <?php }
                    /** endif */ ?>

                </div>
            </div>
            <div class="tab-area">
                <ul class="nav nav-tabs tab-menu d-flex justify-content-between" id="horizontal_list" role="tablist">
                    <li class="nav-item item mt-auto mb-auto py-1 pl-2">
                        <a class="nav-link active small font-weight-bold rounded-pill" id="contents-tab" data-toggle="tab" href="#contents" role="tab" aria-controls="contents" aria-selected="true">依頼内容</a>
                    </li>
                    <li class="nav-item mt-auto mb-auto py-1">
                        <a class="nav-link small font-weight-bold rounded-pill" id="files-tab" data-toggle="tab" href="#files" role="tab" aria-controls="files" aria-selected="false">添付ファイル<br>参考URL</span></a>
                    </li>
                    <li class="nav-item mt-auto mb-auto py-1">
                        <a class="nav-link small font-weight-bold rounded-pill" id="budgets-tab" data-toggle="tab" href="#budgets" role="tab" aria-controls="budgets" aria-selected="false">予算<br>納品希望日</a>
                    </li>
                    <li class="nav-item mt-auto mb-auto py-1 pr-2">
                        <a class="nav-link small font-weight-bold rounded-pill" id="comments-tab" data-toggle="tab" href="#comments" role="tab" aria-controls="comments" aria-selected="false">コメント</a>
                    </li>
                </ul>
            </div>

            <div class="tab-content w-100">

                <div class="tab-pane active" id="contents" role="tabpanel" aria-labelledby="contents-tab">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 mt-4 item-text border-bottom-solid ">
                                依頼タイトル
                            </div>
                            <div class="col-12 mt-1 ">
                                <?php echo esc_attr($tcd_membership_vars['requestData']['title']); ?>
                            </div>
                            <div class="col-12 mt-4 item-text border-bottom-solid ">
                                本文
                            </div>
                            <div class="col-12 mt-1 ">
                                <?php echo nl2br($tcd_membership_vars['requestData']['content']); ?>
                            </div>
                            <div class="col-12 mt-4 item-text border-bottom-solid ">
                                構図
                            </div>
                            <div class="col-12 mt-1 ">
                                <?php echo nl2br($tcd_membership_vars['requestData']['composition']); ?>
                            </div>
                            <div class="col-12 mt-4 item-text border-bottom-solid ">
                                キャラクター
                            </div>
                            <div class="col-12 mt-1 ">
                                <?php echo nl2br($tcd_membership_vars['requestData']['character']); ?>
                            </div>
                            <div class="col-12 mt-4 item-text border-bottom-solid">
                                受付依頼数
                            </div>
                            <div class="col-12 mt-1">
                                <?php echo nl2br($tcd_membership_vars['requestData']['orderQuantity']); ?>
                                件
                            </div>
                            <div class="col-12 mt-4 item-text border-bottom-solid">
                                特記事項
                            </div>
                            <div class="col-12 mt-1">
                                <?php echo nl2br($tcd_membership_vars['requestData']['specialNotes']); ?>
                            </div>
                            <?php if ($tcd_membership_vars['requestData']['viewReceivedButton']) { ?>
                                <form method="POST" action="<?php echo esc_attr(get_tcd_membership_memberpage_url('comfirm_request')); ?>">
                                    <div class="col-12 mt-4 mt-xl-4 pt-xl-3 mb-5 text-center">
                                        <?php /** FIXED 受託になると思うのでボタン変更 */ ?>
                                        <!-- button class="btn text-white save-btn">依頼投稿</button -->
                                        <button type="submit" class="btn text-white save-btn">依頼を受ける</button>
                                        <input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('tcd-membership-confirm_request-' . $tcd_membership_vars['requestData']['post_id'])); ?>">
                                        <input type="hidden" name="request_id" value="<?php echo esc_attr($tcd_membership_vars['requestData']['post_id']); ?>">
                                        <input type="hidden" name="request_type" value="contract">
                                    </div>
                                </form>
                            <?php }
                            /** endif */ ?>
                        </div>
                    </div>
                </div>


                <div class="tab-pane" id="files" role="tabpanel" aria-labelledby="files-tab">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 mt-4 item-text border-bottom-solid">
                                添付ファイル
                            </div>
                            <div class="col-12 mt-1">
                                <?php if ($tcd_membership_vars['requestData']['requestFileFlag']) { ?>
                                    <img src="<?php echo esc_url($tcd_membership_vars['requestData']['requestFileUrl']); ?>" alt="upload_image" class="w-100">
                                <?php } else { ?>
                                    <a target="_blank" href="<?php echo esc_url($tcd_membership_vars['requestData']['requestFileUrl']); ?>"><?php echo esc_attr($tcd_membership_vars['requestData']['requestFileName']); ?></a>
                                <?php } ?>
                            </div>
                            <div class="col-12 mt-4 item-text border-bottom-solid">
                                参考URL
                            </div>
                            <div class="col-12 mt-1">
                                <a target="_blank" href="<?php echo esc_url($tcd_membership_vars['requestData']['refUrl']); ?>"><?php echo esc_attr($tcd_membership_vars['requestData']['refUrl']); ?></a>
                            </div>
                            <?php if ($tcd_membership_vars['requestData']['viewReceivedButton']) { ?>
                                <form method="POST" action="<?php echo esc_attr(get_tcd_membership_memberpage_url('comfirm_request')); ?>">
                                    <div class="col-12 mt-4 mt-xl-4 pt-xl-3 mb-5 text-center">
                                        <?php /** FIXED 受託になると思うのでボタン変更 */ ?>
                                        <!-- button class="btn text-white save-btn">依頼投稿</button -->
                                        <button type="submit" class="btn text-white save-btn">依頼を受ける</button>
                                        <input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('tcd-membership-confirm_request-' . $tcd_membership_vars['requestData']['post_id'])); ?>">
                                        <input type="hidden" name="request_id" value="<?php echo esc_attr($tcd_membership_vars['requestData']['post_id']); ?>">
                                        <input type="hidden" name="request_type" value="contract">
                                    </div>
                                </form>
                            <?php }
                            /** endif */ ?>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="budgets" role="tabpanel" aria-labelledby="budgets-tab">
                    <div class="container block">
                        <div class="row">
                            <div class="col-12 mt-4 item-text border-bottom-solid">
                                予算
                            </div>
                            <div class="col-12 mt-1">
                                <?php echo esc_attr($tcd_membership_vars['requestData']['budget']); ?>円
                            </div>
                            <div class="col-12 mt-4 item-text border-bottom-solid">
                                応募期限
                            </div>
                            <div class="col-12 mt-1">
                                <?php echo esc_attr($tcd_membership_vars['requestData']['appDeadlineDate']); ?>
                            </div>
                            <?php if ($tcd_membership_vars['requestData']['desiredDate']) { ?>
                                <div class="col-12 mt-4 item-text border-bottom-solid">
                                    納品希望日
                                </div>
                                <div class="col-12 mt-1">
                                    <?php echo esc_attr($tcd_membership_vars['requestData']['desiredDate']); ?>
                                </div>
                            <?php } /* endif **/ ?>
                            <?php if ($tcd_membership_vars['requestData']['viewReceivedButton']) { ?>
                                <form method="POST" action="<?php echo esc_attr(get_tcd_membership_memberpage_url('comfirm_request')); ?>">
                                    <div class="col-12 mt-4 mt-xl-4 pt-xl-3 mb-5 text-center">
                                        <?php /** FIXED 受託になると思うのでボタン変更 */ ?>
                                        <!-- button class="btn text-white save-btn">依頼投稿</button -->
                                        <button type="submit" class="btn text-white save-btn">依頼を受ける</button>
                                        <input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('tcd-membership-confirm_request-' . $tcd_membership_vars['requestData']['post_id'])); ?>">
                                        <input type="hidden" name="request_id" value="<?php echo esc_attr($tcd_membership_vars['requestData']['post_id']); ?>">
                                        <input type="hidden" name="request_type" value="contract">
                                    </div>
                                </form>
                            <?php }
                            /** endif */ ?>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="comments" role="tabpanel" aria-labelledby="comments-tab">
                    <div class="container message-show-area" id="message_show_area">
                        <?php /** FIXED 複数のユーザー想定なので 表示させない */ ?>
                        <!-- div class="font-weight-bold title border-bottom-solid mt-4">
                            相手のユーザー名
                        </div-->
                        <div class="row mb-5 pb-3">
                            <?php
                            foreach ($tcd_membership_vars['list_comment'] as $key => $array_comment) {
                                $dateClass = new DateTime($key);
                            ?>
                                <div class="d-flex col-12 justify-content-center">
                                    <div class="main-color font-weight-bold text-white text-center rounded-pill small w-25 mt-4">
                                        <?php echo esc_attr($dateClass->format('Y/m/d')); ?>
                                    </div>
                                </div>
                                <?php foreach ($array_comment as $one_comment) { ?>
                                    <?php if ($tcd_membership_vars['requestData']['author_id'] === (int)$one_comment['user_id']) { ?>
                                        <?php /** 発言が発注者の場合 */ ?>
                                        <div class="col-12">
                                            <div class="balloon_r">
                                                <div class="faceicon">
                                                    <img src="<?php echo esc_url($one_comment['profile_image']) ?>" class="rounded-circle" alt="">
                                                    <div class="ml-xl-4 ml-1">
                                                        <?php echo esc_attr($one_comment['comment_date']) ?>
                                                    </div>
                                                </div>
                                                <div class="says">
                                                    <p>
                                                        <?php echo nl2br($one_comment['comment']) ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                    <?php } else { ?>
                                        <?php /** 発言が発注者ではない場合 */ ?>
                                        <div class="col-12">
                                            <div class="balloon_l">
                                                <div class="faceicon">
                                                    <img src="<?php echo esc_url($one_comment['profile_image']) ?>" alt="" class="rounded-circle">
                                                    <div class="ml-xl-4 ml-1">
                                                        <?php echo esc_attr($one_comment['comment_date']) ?>
                                                    </div>
                                                </div>
                                                <p class="says">
                                                    <?php echo nl2br($one_comment['comment']) ?>
                                                </p>
                                            </div>
                                        </div>

                                    <?php }
                                    /** endif */ ?>
                                <?php }
                                /** endforeach */ ?>
                            <?php }
                            /** endforeach */ ?>
                        </div>

                        <form method="POST" action="<?php echo esc_attr(get_tcd_membership_memberpage_url('comfirm_request')); ?>">
                            <div class="row text-center message-create">
                                <div class="col-9">
                                    <textarea name="message" rows="3" id="chat_input" class="border border-0"></textarea>
                                </div>
                                <div class="col-2 icon-area">
                                    <div>
                                        <?php /** 画像を登録する必要はない */ ?>

                                        <!-- label>
                                        <input type="file" name="file" accept="image/png, image/jpeg" id="messages_file_input">
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/camera_bule.png" class="camera" alt="camera">
                                    </label -->
                                    </div>
                                    <label>
                                        <input type="image" name="btn_confirm" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/send.png" class="send" alt="send" id="chat_button">
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('tcd-membership-confirm_message-' . $tcd_membership_vars['requestData']['post_id'])); ?>">
                            <input type="hidden" name="request_id" value="<?php echo esc_attr($tcd_membership_vars['requestData']['post_id']); ?>">
                            <input type="hidden" name="request_type" value="message">
                        </form>
                        <!-- 画像投稿時のモーダル -->
                        <?php /** 画像を登録する必要はない */ ?>
                        <!-- div class="modal">
                            <div class="text-center title">
                                投稿画像確認
                            </div>
                            <div class="bigimg"><img src="" alt="bigimg"></div>
                            <p class="close-btn"><a href="">✖</a></p>
                            <button type="submit" class="btn btn-primary rounded-pill btn-sm text-white btn-lg main-color post-image-btn" id="post_image_btn">投稿する</button>
                        </div -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?php
get_footer();
