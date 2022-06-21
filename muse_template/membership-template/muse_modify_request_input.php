<?php
global $dp_options, $tcd_membership_vars;
get_header();
?>
<div class="pt-sm-5 mt-sm-5">
    <div class="container pt-5">
        <form method="POST" action="<?php echo esc_attr(get_tcd_membership_memberpage_url('modify_request')); ?>" enctype="multipart/form-data" method="post">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-left font-weight-bold request-title">依頼タイトル（必須）</h1>
                </div>
                <hr class="request-hr">
                <div class="col-12 pb-4">
                    <input class="form-control request-input" type="text" name="requestTitle" id="requestTitle" placeholder="タイトル" value="<?php echo esc_attr(isset($_REQUEST['requestTitle']) ? $_REQUEST['requestTitle'] : $tcd_membership_vars['requestData']['title']); ?>" required>
                </div>

                <div class="col-12">
                    <div class="inputRequestTitle" id="inputRequestTitle">
                        <?php if (isset($tcd_membership_vars['error_message']['requestTitle'])) { ?>
                            <p id="inputRequestErrMsg" class="inputRequestErrMsg">依頼タイトルを入力してください</p>

                        <?php }
                        /** endif */ ?>
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
                    <label for="work-title" class="label-text request-input-title">作品タイトル</label>
                </div>
                <div class="col-12">
                    <input class="form-control request-input" type="text" name="workTitle" id="workTitle" placeholder="作品タイトル" value="<?php echo esc_attr(isset($_REQUEST['workTitle']) ? $_REQUEST['workTitle'] : $tcd_membership_vars['requestData']['post_name']); ?>" required>
                </div>

                <div class="col-12">
                    <div class="inputWorkTitle" id="inputWorkTitle">
                        <?php if (isset($tcd_membership_vars['error_message']['workTitle'])) { ?>
                            <p id="inputWorkErrMsg" class="inputRequestErrMsg mt-1">作品タイトルを入力してください</p>

                        <?php }
                        /** endif */ ?>

                    </div>
                </div>

                <div class="col-12 mt-4">
                    <label for="text" class="label-text request-input-title">本文</label>
                </div>
                <div class="col-12">
                    <input class="form-control request-input" type="text" name="content" id="text" placeholder="本文" value="<?php echo esc_attr(isset($_REQUEST['content']) ? $_REQUEST['content'] : $tcd_membership_vars['requestData']['content']); ?>" required>
                </div>

                <div class="col-12">
                    <div class="inputText" id="inputText">
                        <?php if (isset($tcd_membership_vars['error_message']['content'])) { ?>
                            <p id="inputTextErrMsg" class="inputRequestErrMsg mt-1">本文タイトルを入力してください</p>

                        <?php }
                        /** endif */ ?>
                    </div>
                </div>

                <div class="col-12 mt-4">
                    <label for="composition" class="label-text request-input-title">構図</label>
                </div>
                <div class="col-12">
                    <input class="form-control request-input" type="text" name="composition" id="composition" placeholder="構図" value="<?php echo esc_attr(isset($_REQUEST['composition']) ? $_REQUEST['composition'] : $tcd_membership_vars['requestData']['composition']); ?>" required>
                </div>
                <div class="col-12">
                    <div class="inputComposition" id="inputComposition">
                        <?php if (isset($tcd_membership_vars['error_message']['composition'])) { ?>
                            <p id="inputCompositionErrMsg" class="inputRequestErrMsg mt-1">構図を入力してください</p>

                        <?php }
                        /** endif */ ?>
                    </div>
                </div>

                <div class="col-12 mt-4">
                    <label for="character" class="label-text request-input-title">キャラクター</label>
                </div>
                <div class="col-12">
                    <input class="form-control request-input" type="text" name="character" id="character" placeholder="キャラクター" value="<?php echo esc_attr(isset($_REQUEST['character']) ? $_REQUEST['character'] : $tcd_membership_vars['requestData']['character']); ?>" required>
                </div>

                <div class="col-12 mb-3">
                    <div class="inputCharacter" id="inputCharacter">
                        <?php if (isset($tcd_membership_vars['error_message']['character'])) { ?>
                            <p id="inputCharacterErrMsg" class="inputRequestErrMsg mt-1">キャラクターを入力してください</p>
                        <?php }
                        /** endif */ ?>
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
                        <p id="outputFileName"></p>
                    </label>
                    <div class="col-12 mb-3 <?php if (isset($tcd_membership_vars['error_message']['requestFile'])) { ?>d-none<?php } ?>" id="inputRequestErrMsgArea">
                        <div class="inputFile" id="inputFile">
                            <p id="inputRequestErrMsg" class="alert-color font-weight-bold">添付ファイルを入力してください</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-4">
                    <h1 class="text-left font-weight-bold request-title">参考URL（任意）</h1>
                </div>
                <hr class="request-hr">
                <div class="col-12">
                    <input class="form-control request-input" type="text" name="refUrl" id="refUrl" placeholder="参考URL" value="<?php echo esc_attr(isset($_REQUEST['refUrl']) ? $_REQUEST['refUrl'] : $tcd_membership_vars['requestData']['refUrl']); ?>">
                </div>

                <div class="col-12 mb-4">
                    <div class="validRefUrl" id="validRefUrl">
                        <?php if (isset($tcd_membership_vars['error_message']['refUrl'])) { ?>
                            <p id="validRefUrlErrMsg" class="inputRequestErrMsg mt-1">参考URLの形式が間違っています</p>
                        <?php }
                        /** endif */ ?>

                    </div>
                </div>
                <div class="col-12 mt-2">
                    <h1 class="text-left font-weight-bold request-title">予算（必須）</h1>
                </div>
                <hr class="request-hr">
                <div class="col-11">
                    <input class="form-control request-input request-budget-input" type="number" name="budget" id="budget" placeholder="10000" value="<?php echo esc_attr(isset($_REQUEST['budget']) ? $_REQUEST['budget'] : $tcd_membership_vars['requestData']['budget']); ?>" required>
                    <div class="request-budget-jpy">
                        円～
                    </div>
                </div>

                <div class="col-12 mb-4">
                    <div class="inputBudget" id="inputBudget">
                        <?php if (isset($tcd_membership_vars['error_message']['refUrl'])) { ?>
                            <p id="validRefUrlErrMsg" class="inputRequestErrMsg mt-1">参考URLの形式が間違っています</p>
                        <?php }
                        /** endif */ ?>

                    </div>
                </div>
                <div class="col-12 mt-2">
                    <h1 class="text-left font-weight-bold request-title">応募期限（必須）</h1>
                </div>
                <hr class="request-hr mb-2">
                <div class="col-12 row">
                    <div class="col-4">
                        <?php
                        $appDeadlineDateClass = new DateTime($tcd_membership_vars['requestData']['appDeadlineDate']);
                        ?>
                        <input type="number" class="deadline-input" placeholder="yyyy" name="appDeadlineY" id="appDeadlineY" value="<?php echo esc_attr(isset($_REQUEST['appDeadlineY']) ? $_REQUEST['appDeadlineY'] : $appDeadlineDateClass->format('Y')); ?>" required>
                        <p class="deadline-date">年</p>
                    </div>
                    <div class="col-4">
                        <input type="number" class="deadline-input" placeholder="mm" name="appDeadlineM" id="appDeadlineM" value="<?php echo esc_attr(isset($_REQUEST['appDeadlineM']) ? $_REQUEST['appDeadlineM'] : $appDeadlineDateClass->format('m')); ?>" required>
                        <p class="deadline-date">月</p>
                    </div>
                    <div class="col-4">
                        <input type="number" class="deadline-input" placeholder="dd" name="appDeadlineD" id="appDeadlineD" value="<?php echo esc_attr(isset($_REQUEST['appDeadlineD']) ? $_REQUEST['appDeadlineD'] : $appDeadlineDateClass->format('d')); ?>" required>
                        <p class="deadline-date">日</p>
                    </div>
                </div>
                <div class="col-12 mb-4">
                    <div class="inputAppDeadline" id="inputAppDeadline">
                        <?php if (isset($tcd_membership_vars['error_message']['appDeadline'])) { ?>
                            <p id="inputAppDeadlineMsg" class="inputRequestErrMsg mt-1">応募期限を年月日それぞれ入力してください</p>
                        <?php }
                        /** endif */ ?>
                    </div>
                </div>
                <div class="col-12 mt-2">
                    <h1 class="text-left font-weight-bold request-title">納品希望日（任意）</h1>
                </div>
                <hr class="request-hr mb-2">
                <div class="col-12 pb-4 row">
                    <?php
                    $desiredDateY = '';
                    $desiredDateM = '';
                    $desiredDateD = '';
                    if (!empty($tcd_membership_vars['requestData']['desiredDate'])) {
                        $desiredDateClass = new DateTime($tcd_membership_vars['requestData']['desiredDate']);
                        $desiredDateY = $desiredDateClass->format('Y');
                        $desiredDateM = $desiredDateClass->format('m');
                        $desiredDateD = $desiredDateClass->format('d');
                    }
                    ?>
                    <div class="col-4">
                        <input type="number" class="deadline-input" placeholder="yyyy" name="desiredDateY" id="desiredDateY" value="<?php echo esc_attr(isset($_REQUEST['desiredDateY']) ? $_REQUEST['desiredDateY'] : $desiredDateY); ?>">
                        <p class="deadline-date">年</p>
                    </div>
                    <div class="col-4">
                        <input type="number" class="deadline-input" placeholder="mm" name="desiredDateM" id="desiredDateM" value="<?php echo esc_attr(isset($_REQUEST['desiredDateM']) ? $_REQUEST['desiredDateM'] : $desiredDateM); ?>">
                        <p class="deadline-date">月</p>
                    </div>
                    <div class="col-4">
                        <input type="number" class="deadline-input" placeholder="dd" name="desiredDateD" id="desiredDateD" value="<?php echo esc_attr(isset($_REQUEST['desiredDateD']) ? $_REQUEST['desiredDateD'] : $desiredDateD); ?>">
                        <p class="deadline-date">日</p>
                    </div>
                </div>

                <div class="col-12">
                    <div class="inputDesiredDate" id="inputDesiredDate">
                        <?php if (isset($tcd_membership_vars['error_message']['appDeadline'])) { ?>
                            <p id="inputAppDeadlineMsg" class="inputRequestErrMsg mt-1">応募期限を年月日それぞれ入力してください</p>
                        <?php }
                        /** endif */ ?>
                    </div>
                </div>
                <div class="col-12 mt-2">
                    <h1 class="text-left font-weight-bold request-title">受付依頼数</h1>
                </div>
                <hr class="request-hr mb-2">
                <div class="col-12 pb-4 row">
                    <div class="col-4">
                        <input type="number" class="deadline-input" name="orderQuantity" id="orderQuantity" value="<?php echo esc_attr(isset($_REQUEST['orderQuantity']) ? $_REQUEST['orderQuantity'] : $tcd_membership_vars['requestData']['orderQuantity']); ?>" required>
                        <p class="deadline-date">件</p>
                    </div>
                </div>
                <div class="col-12 mt-2">
                    <h1 class="text-left font-weight-bold request-title">特記事項（任意）</h1>
                </div>
                <hr class="request-hr">
                <div class="col-12 pb-4">
                    <textarea class="form-control request-notes-input" name="specialNotes" id="specialNotes" placeholder="特記事項"><?php echo esc_attr(isset($_REQUEST['specialNotes']) ? $_REQUEST['specialNotes'] : $tcd_membership_vars['requestData']['specialNotes']); ?></textarea>
                </div>
                <div class="col-12 text-center mt-3 mb-5">
                    <button type="submit" class="btn btn-primary text-white submit-btn" id="requestBtn" disabled>依頼投稿確認</button>
                </div>
            </div>
            <input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('tcd_membership_action_request')); ?>">
            <input type="hidden" name="request_type" value="input">
            <input type="hidden" name="request_id" value="<?php echo $tcd_membership_vars['requestData']['request_id']; ?>" />
        </form>
    </div>
</div>
<?php
get_footer();
