<?php
global $dp_options, $tcd_membership_vars;
get_header();
?>
<div class="pc-center">

    <div class="container pt-2">
        <div class="row mb-2">
            <div class="col-12">
                <a href="javascript:history.back();">← 戻る</a>
            </div>
        </div>
        <form method="POST" action="<?php echo esc_attr(get_tcd_membership_memberpage_url('request')); ?>" enctype="multipart/form-data" method="POST">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-left font-weight-bold request-title">依頼タイトル（必須）</h1>
                </div>
                <hr class="request-hr">
                <div class="col-12 pb-4">
                    <input class="form-control request-input" type="text" name="requestTitle" id="requestTitle" placeholder="タイトル" value="<?php echo esc_attr(isset($_REQUEST['requestTitle']) ? $_REQUEST['requestTitle'] : ''); ?>" required>
                </div>
                <div class="col-12">
                    <div class="inputRequestTitle" id="inputRequestTitle">
                        <p id="inputRequestErrMsg" class="inputRequestErrMsg">
                            <?php if (isset($tcd_membership_vars['error_message']['requestTitle'])) { ?>
                                依頼タイトルを入力してください
                            <?php }
                            /** endif */ ?>
                        </p>
                    </div>
                </div>
                <div class="col-12">
                    <div class="requestTitleMsg" id="requestTitleMsg"></div>
                </div>
                <div class="col-12 pt-2">
                    <h1 class="text-left font-weight-bold request-title">依頼内容（必須）</h1>
                </div>
                <hr class="request-hr">
                <div class="col-12">
                    <!-- 不特定多数の場合非表示 -->
                    <label for="work-title" class="label-text request-input-title">作品タイトル</label>
                </div>
                <div class="col-12">
                    <!-- 不特定多数の場合非表示 -->

                    <?php if ($tcd_membership_vars['specifyUser'] === TRUE) { ?>
                        <!-- 不特定多数の場合非表示 -->
                        <input class="form-control request-input" type="text" name="workTitle" id="workTitle" placeholder="作品タイトル" value="<?php echo esc_attr(isset($_REQUEST['workTitle']) ? $_REQUEST['workTitle'] : ''); ?>" required>
                    <?php } else { ?>
                        <!-- 不特定多数の場合表示 -->
                        <select class="form-control" name="workTitle" id="workTitle">
                            <option value="selectbox-1">セレクトボックス1</option>
                            <option value="selectbox-2">セレクトボックス2</option>
                            <option value="selectbox-3">セレクトボックス3</option>
                            <option value="selectbox-4">セレクトボックス4</option>
                        </select>
                    <?php } ?>
                </div>
                <div class="col-12">
                    <div class="inputWorkTitle" id="inputWorkTitle">
                        <p id="inputWorkErrMsg" class="inputRequestErrMsg mt-1">
                            <?php if (isset($tcd_membership_vars['error_message']['workTitle'])) { ?>
                                作品タイトルを入力してください
                            <?php }
                            /** endif */ ?>
                        </p>
                    </div>
                </div>

                <div class="col-12 mt-4">
                    <label for="text" class="label-text request-input-title">本文</label>
                </div>
                <div class="col-12">
                    <textarea class="form-control" name="content" id="text" placeholder="本文" rows="5"><?php echo esc_attr(isset($_REQUEST['content']) ? $_REQUEST['content'] : ''); ?></textarea>
                </div>
                <div class="col-12">
                    <div class="inputText" id="inputText">
                        <p id="inputTextErrMsg" class="inputRequestErrMsg mt-1">
                            <?php if (isset($tcd_membership_vars['error_message']['content'])) { ?>
                                本文を入力してください

                            <?php }
                            /** endif */ ?>
                        </p>
                    </div>
                </div>
                <div class="col-12 mt-4">
                    <label for="composition" class="label-text request-input-title">構図</label>
                </div>
                <div class="col-12">
                    <input class="form-control request-input" type="text" name="composition" id="composition" placeholder="構図" value="<?php echo esc_attr(isset($_REQUEST['composition']) ? $_REQUEST['composition'] : ''); ?>" required>
                </div>
                <div class="col-12">
                    <div class="inputComposition" id="inputComposition">
                        <p id="inputCompositionErrMsg" class="inputRequestErrMsg mt-1">
                            <?php if (isset($tcd_membership_vars['error_message']['composition'])) { ?>
                                構図を入力してください

                            <?php }
                            /** endif */ ?>
                        </p>
                    </div>
                </div>

                <div class="col-12 mt-4">
                    <label for="character" class="label-text request-input-title">キャラクター</label>
                </div>
                <div class="col-12">
                    <input class="form-control request-input" type="text" name="character" id="character" placeholder="キャラクター" value="<?php echo esc_attr(isset($_REQUEST['character']) ? $_REQUEST['character'] : ''); ?>" required>
                </div>
                <div class="col-12 mb-3">
                    <div class="inputCharacter" id="inputCharacter">
                        <p id="inputCharacterErrMsg" class="inputRequestErrMsg mt-1">
                            <?php if (isset($tcd_membership_vars['error_message']['character'])) { ?>
                                キャラクターを入力してください
                            <?php }
                            /** endif */ ?>
                        </p>
                    </div>
                </div>
                <div class="col-12 mt-4">
                    <h1 class="text-left font-weight-bold request-title">添付ファイル</h1>
                </div>
                <hr class="request-hr">
                <div class="col-12 request-file-input">
                    <label class="request-file">
                        <input type="file" name="requestFile" id="requestFile">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/camera_BGblue.png" class="request-file-img">
                        <div class="col-12 mb-3">
                            <p id="outputFileName">
                            </p>
                        </div>
                    </label>
                    <!-- div class="col-12 mb-3 d-none" id="inputRequestErrMsgArea">
                        <div class="inputFile" id="inputFile">
                            <p id="inputRequestErrMsg" class="alert-color font-weight-bold">添付ファイルを入力してください</p>
                        </div>
                    </div -->
                </div>
                <div class="col-12 mt-4">
                    <h1 class="text-left font-weight-bold request-title">参考URL（任意）</h1>
                </div>
                <hr class="request-hr">
                <div class="col-12">
                    <input class="form-control request-input" type="text" name="refUrl" id="refUrl" placeholder="参考URL" value="<?php echo esc_attr(isset($_REQUEST['refUrl']) ? $_REQUEST['refUrl'] : ''); ?>">
                </div>
                <div class="col-12 mb-4">
                    <div class="validRefUrl" id="validRefUrl">
                        <p id="validRefUrlErrMsg" class="inputRequestErrMsg mt-1">
                            <?php if (isset($tcd_membership_vars['error_message']['refUrl'])) { ?>
                                参考URLの形式が間違っています
                            <?php }
                            /** endif */ ?>
                        </p>
                    </div>
                </div>
                <div class="col-12 mt-2">
                    <h1 class="text-left font-weight-bold request-title">予算（必須）</h1>
                </div>
                <hr class="request-hr">
                <div class="col-11">
                    <select name="budget" id="budget" class="deadline-input budget-area">
                        <?php foreach ($tcd_membership_vars['array_budget'] as $key => $value) { ?>
                            <option value="<?php echo $key; ?>" <?php echo ($tcd_membership_vars['budget'] === $key) ? 'selected' : ''; ?>><?php echo $value; ?></option>
                        <?php }
                        /** endforeach */ ?>
                    </select>
                    <div class="request-budget-jpy">
                        円
                    </div>
                </div>
                <div class="col-12 mb-4">
                    <div class="inputBudget">
                        <p id="inputBudget" class="inputRequestErrMsg mt-1"></p>
                    </div>
                </div>
                <div class="col-12 mt-2">
                    <h1 class="text-left font-weight-bold request-title">応募期限（必須）</h1>
                </div>
                <hr class="request-hr mb-2">
                <div class="col-12 row">
                    <div class="col-4">
                        <select name="appDeadline" class="deadline-input">
                            <?php foreach ($tcd_membership_vars['array_app_dead_line'] as $key => $value) { ?>
                                <option value="<?php echo $key; ?>" <?php echo ($tcd_membership_vars['app_dead_line'] === $key) ? 'selected' : ''; ?>><?php echo $value; ?></option>
                            <?php }
                            /** endforeach */ ?>
                        </select>
                    </div>
                </div>
                <div class="col-12 mb-4">
                    <div class="inputAppDeadline" id="inputAppDeadline"></div>
                </div>
                <div class="col-12 mt-2">
                    <h1 class="text-left font-weight-bold request-title">納品希望日（必須）</h1>
                </div>
                <hr class="request-hr mb-2">
                <div class="col-12 pb-4 row">
                    <div class="col-4">
                        <select name="desiredDateY" class="deadline-input" id="desiredDateY">
                        </select>
                        <p class="deadline-date">年</p>
                        <input type="hidden" id="hideDesiredDateY" value="<?php echo esc_attr($tcd_membership_vars['desiredDateY']); ?>" />
                    </div>
                    <div class="col-4">
                        <select name="desiredDateM" class="deadline-input" id="desiredDateM">
                        </select>
                        <p class="deadline-date">月</p>
                        <input type="hidden" id="hideDesiredDateM" value="<?php echo esc_attr($tcd_membership_vars['desiredDateM']); ?>" />
                    </div>
                    <div class="col-4">
                        <select name="desiredDateD" id="desiredDateD" class="deadline-input">
                        </select>
                        <p class="deadline-date">日</p>
                        <input type="hidden" id="hideDesiredDateD" value="<?php echo esc_attr($tcd_membership_vars['desiredDateD']); ?>" />
                    </div>
                </div>
                <div class="col-12">
                    <div class="inputDesiredDate" id="inputDesiredDate"></div>
                </div>

                <?php
                if ($tcd_membership_vars['specifyUserId'] === false) {
                    // ユーザー指定がない場合 => 受付依頼数の入力欄の追加
                ?>
                    <div class="col-12 mt-2">
                        <h1 class="text-left font-weight-bold request-title">受付依頼数</h1>
                    </div>
                    <hr class="request-hr mb-2">
                    <div class="col-12 pb-4 row">
                        <div class="col-4">
                            <input type="number" class="deadline-input" name="orderQuantity" id="orderQuantity" value="<?php echo esc_attr(isset($_REQUEST['orderQuantity']) ? $_REQUEST['orderQuantity'] : 1); ?>">
                            <p class="deadline-date">件</p>
                        </div>
                    </div>
                <?php
                } else {
                    // ユーザー指定がない場合 => 受付依頼数の入力欄を固定にする
                ?>
                    <input type="hidden" name="orderQuantity" id="orderQuantity" value="1">
                <?php }
                /** endif */ ?>
                <div class="col-12 text-center mt-3 mb-5">
                    <button type="submit" class="btn btn-primary text-white submit-btn" id="requestBtn" disabled>依頼投稿確認</button>
                </div>
            </div>
            <input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('tcd_membership_action_request')); ?>">
            <input type="hidden" name="specify_user_id" value="<?php echo esc_attr($tcd_membership_vars['specifyUserId']); ?>">
            <input type="hidden" name="request_type" id="request_type" value="input">
            <input type="hidden" id="minimum_order_price" value="<?php echo esc_attr($tcd_membership_vars['minimumOrderPrice']); ?>">
        </form>
    </div>
    <?php
    get_footer();
