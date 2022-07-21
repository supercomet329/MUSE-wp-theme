<?php

/**
 * ログインフォーム
 */
function tcd_membership_login_form($args = array())
{
    global $dp_options, $tcd_membership_vars;

    $default_args = array(
        'echo' => true,
        'form_id' => 'loginform',
        'label_username' => $dp_options['membership']['field_label_email'],
        'label_password' => $dp_options['membership']['field_label_password'],
        'label_remember' => $dp_options['membership']['field_label_login_remember'],
        'label_log_in' => __('Login', 'tcd-w'),
        'modal' => false,
        'redirect' => !empty($_REQUEST['redirect_to']) ? $_REQUEST['redirect_to'] : '',
        'remember' => true,
        'value_username' => '',
        'value_remember' => false,
    );

    $errorMessage = '';
    if (isset($tcd_membership_vars['login']['errors'])) {
        $errorMessage = 'メールアドレス もしくは パスワードが違います。';
    }

    $args = wp_parse_args($args, apply_filters('login_form_default_args', $default_args));
    $args = apply_filters('tcd_membership_login_form_args', $args);

    // マルチサイトの他サイトにログイン中でこのサイトのアクセス権がない場合はメッセージ表示して終了
    $ms_message = tcd_membership_multisite_other_site_logged_in_message();
    if ($ms_message) :
        $ms_message = '<div class="p-body">' . $ms_message . '</div>' . "\n";
        if ($args['echo']) :
            echo $ms_message;
            return false;
        else :
            return $ms_message;
        endif;
    endif;

    if (!$args['echo']) :
        ob_start();
    endif;

    $successMessage = '';
    if (isset($_GET['message']) && $_GET['message'] === 'registration_account_complete') {
        $successMessage = '新規ユーザーを作成致しました。';
    }

    if (isset($_GET['reset_password']) && $_GET['reset_password'] === 'complete') {
        $successMessage = 'パスワードの変更を完了しました。';
    }

    if (!$args['value_username'] && !empty($_COOKIE['tcd_login_email'])) :
        $tcd_login_email = $_COOKIE['tcd_login_email'];
        // メールアドレスでなければ復号化
        if (!is_email($tcd_login_email) && function_exists('openssl_decrypt') && defined('NONCE_KEY') && NONCE_KEY) :
            $tcd_login_email = openssl_decrypt($tcd_login_email, 'AES-128-ECB', NONCE_KEY);
        endif;
        if ($tcd_login_email && is_email($tcd_login_email)) :
            $args['value_username'] = $tcd_login_email;
        endif;
    endif;
?>
    <div class="pt-sm-5 mt-sm-5">
        <div class="container pt-5">
            <form action="<?php echo esc_attr(get_tcd_membership_memberpage_url('login')); ?>" method="post">
                <?php if (!empty($errorMessage)) { ?>
                    <?php /** 2022/05/28 TODO: エラーメッセージの表示 */ ?>
                    <div class="p-membership-form__error"><?php echo wpautop($errorMessage); ?></div>
                <?php }
                /** endif */ ?>

                <div class="row">
                    <div class="col-12">
                        <h1 class="text-center mb-4 contents-title font-weight-bold">ログイン</h1>
                        <div class="emailSentMsg" id="emailSentMsg">
                            <?php if (!empty($successMessage)) : ?>
                                <p><?php echo $successMessage; ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="email" class="label-text">メールアドレス</label>
                    </div>
                    <div class="col-12 pt-2 pb-2">
                        <input class="form-control email-form" type="email" name="log" id="loginEmail" placeholder="aaaa@muse.co.jp" value="<?php echo esc_attr(isset($_REQUEST['log']) ? $_REQUEST['log'] : $args['value_username']); ?>" required>
                    </div>
                    <div class="col-12">
                        <label for="loginPassword" class="label-text">パスワード</label>
                    </div>
                    <div class="col-12 pt-2 pb-2">
                        <input class="form-control email-form" type="password" name="pwd" value="" id="loginPassword" placeholder="Musepass1" required>
                    </div>
                    <div class="col-12 reset-password" style="text-align: center;">
                        <a href="<?php echo esc_attr(get_tcd_membership_memberpage_url('reset_password')); ?>" class="reset-password-link" style="font-size: 12px;">&gt;&gt;パスワードを忘れた場合はこちら</a>
                    </div>
                    <div class="col-12 text-center pt-2">
                        <button type="submit" class="btn btn-primary text-white submit-btn" id="login-btn" disabled>ログイン</button>
                    </div>
                    <div class="col-12 text-center pt-3">
                        <input class="form-check-input" type="checkbox" value="forever" id="remember" name="rememberme">
                        <label class="form-check-label terms-check pb-2" for="remember">
                            <p class="remember">ログイン情報を記憶する</p>
                        </label>
                    </div>
                </div>
            </form>


            <hr class="hr-line">
            <!-- TODO: Twitterログイン実装 -->
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center mt-3 mb-3 contents-title font-weight-bold">SNSログイン</h1>
                </div>
                <?php echo makeTwitterOauthLogin(); ?>
                <!-- div class="col-12 login-with-sns">
                    <a href="https://twitter.com" target="_blank" rel="noreferrer">
                        <button class="twitter-btn">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/twitter_icon.png" alt="twitter" class="twitter-icon">
                            Twitterでログインする
                        </button>
                    </a>
                </div -->
                <!-- div class="col-12 login-with-sns mt-3">
                    <a href="https://google.com" target="_blank" rel="noreferrer">
                        <button class="google-btn">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/g-logo.png" alt="google" class="google-icon">
                            Googleアカウントでログインする
                        </button>
                    </a>
                </div -->
            </div>
            <hr class="hr-line mt-3">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center mt-3 mb-3 contents-title font-weight-bold">新規会員登録</h1>
                </div>
                <div class="col-12 register-notes">
                    <p class="register-notes-text" style="text-align: center;">
                        会員ではない方は会員登録してください
                    </p>
                </div>
                <div class="col-12 text-center pt-1">
                    <a class="btn btn-primary text-white submit-btn" href="<?php echo esc_attr(get_tcd_membership_memberpage_url('registration')); ?>">
                        新規会員登録はこちら
                    </a>
                </div>
            </div>
        </div>
    </div> <?php

            if (!$args['echo']) :
                return ob_get_clean();
            endif;
        }

        /**
         * 仮会員登録フォーム
         */
        function tcd_membership_registration_form($args = array())
        {
            global $dp_options, $tcd_membership_vars;

            $default_args = array(
                'echo' => true,
                'form_id' => 'js-registration-form',
                'label_email' => __('Email Address', 'tcd-w'),
                'label_password' => __('Password', 'tcd-w'),
                'label_password_confirm' => __('Password (confirm)', 'tcd-w'),
                'modal' => false
            );
            $args = wp_parse_args($args, apply_filters('login_form_default_args', $default_args));
            $args = apply_filters('tcd_membership_registration_form_args', $args);

            // マルチサイトの他サイトにログイン中でこのサイトのアクセス権がない場合はメッセージ表示して終了
            $ms_message = tcd_membership_multisite_other_site_logged_in_message();
            if ($ms_message) :
                $ms_message = '<div class="p-body">' . $ms_message . '</div>' . "\n";
                if ($args['echo']) :
                    echo $ms_message;
                    return false;
                else :
                    return $ms_message;
                endif;
            endif;

            $email = '';
            if (isset($_REQUEST['complete_email'])) {
                $email = $_REQUEST['complete_email'];
            }

            if (isset($_REQUEST['email'])) {
                $email = $_REQUEST['email'];
            }

            if (!$args['echo']) :
                ob_start();
            endif;
            ?>
    <div class="pt-sm-5 mt-sm-5">
        <div class="container pt-5">
            <form action="<?php echo esc_attr(get_tcd_membership_memberpage_url('registration')); ?>" method="post">
                <div class="row">
                    <div class="col-12">
                        <h1 class="text-center mt-3 mb-4 contents-title font-weight-bold">会員登録</h1>
                    </div>
                    <div class="col-12">
                        <div class="emailSentMsg" id="emailSentMsg">
                            <?php if (isset($tcd_membership_vars['registration']['complete'])) : ?>
                                <p>下記のメールアドレスに仮登録メールを送信いたしました。</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="emailSentMsg" id="emailSentMsg">
                            <?php if (isset($tcd_membership_vars['error_message'])) : ?>
                                <?php echo $tcd_membership_vars['error_message']; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="email" class="label-text">メールアドレス</label>
                    </div>
                    <div class="col-12 pt-2 pb-2">
                        <input class="form-control email-form" type="email" name="email" id="email" placeholder="aaaa@muse.co.jp" value="<?php echo esc_attr($email); ?>" required>
                        <input name="pass1" type="hidden" value="dummy_pass" />
                    </div>
                    <div class="col-12 text-center pt-4">
                        <input class="form-check-input" type="checkbox" value="1" id="terms" name="flg_service_on">
                        <label class="form-check-label terms-check pb-2" for="terms">
                            <p class="agree">
                                <a href="<?php echo esc_attr(get_tcd_membership_memberpage_url('terms')); ?>" target="_blank" rel="noreferrer" class="terms-link">会員規約</a>に同意をしてください
                            </p>
                        </label>
                    </div>
                    <div class="col-12 text-center pt-3">
                        <button type="submit" class="btn btn-primary text-white submit-btn" id="register-btn" disabled>仮登録</button>
                    </div>
                </div>
                <input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('tcd-membership-registration')); ?>">
            </form>
        </div>
    </div>
    <?php
            if (!$args['echo']) :
                return ob_get_clean();
            endif;
        }

        /**
         * 本会員登録・アカウント作成フォーム
         *
         */
        function tcd_membership_registration_account_form($args = array())
        {
            global $dp_options, $tcd_membership_vars;

            $default_args = array(
                'echo' => true,
                'form_id' => 'js-registration-account-form',
            );
            $args = wp_parse_args($args, $default_args);
            $args = apply_filters('tcd_membership_registration_account_form_args', $args);

            // マルチサイトの他サイトにログイン中でこのサイトのアクセス権がない場合はメッセージ表示して終了
            $ms_message = tcd_membership_multisite_other_site_logged_in_message();
            if ($ms_message) :
                $ms_message = '<div class="p-body">' . $ms_message . '</div>' . "\n";
                if ($args['echo']) :
                    echo $ms_message;
                    return false;
                else :
                    return $ms_message;
                endif;
            endif;

            if (!$args['echo']) :
                ob_start();
            endif;

            // 正常トークンフラグがある場合はフォーム表示
            if (!empty($tcd_membership_vars['registration_account']['valid_registration_token'])) :
    ?>
        <div class="pt-sm-5 mt-sm-5">
            <div class="container pt-5">
                <form class="validateRegisterForm p-membership-form p-membership-form--registration_account" action="<?php echo esc_attr(get_tcd_membership_memberpage_url('registration_account')); ?>" method="post">
                    <div class="row">
                        <div class="col-12">
                            <h1 class="text-center mt-1 mb-4 contents-title font-weight-bold">会員登録</h1>
                        </div>

                        <?php
                        render_tcd_membership_user_form_fields(
                            'registration_account',
                            null,
                            [
                                'use_confirm' => true,
                                'indent' => 7,
                                'email_readonly' => isset($tcd_membership_vars['registration_account']['email']) ? $tcd_membership_vars['registration_account']['email'] : null
                            ] + $args
                        );

                        echo apply_filters('tcd_membership_registration_account_form_table', '', $args);
                        ?>

                        <div class="col-12 pt-4">
                            <label for="password" class="label-text">パスワード</label>
                        </div>
                        <div class="col-12 pb-2">
                            <input class="form-control register-form" type="password" name="pass1" id="password" placeholder="Musepass1" required>
                        </div>
                        <div class="col-12 pt-4">
                            <label for="password_confirmation" class="label-text">パスワードを再入力</label>
                        </div>
                        <div class="col-12 pb-4">
                            <input class="form-control register-form" type="password" name="pass2" id="password_confirmation" placeholder="Musepass1" required>
                        </div>
                        <div class="col-12 text-center pt-3">
                            <button type="submit" class="btn btn-primary text-white submit-btn" id="register-btn" disabled>新規登録</button>
                        </div>
                    </div>
                    <input type="hidden" name="gender" value="notselected" />
                    <input type="hidden" name="area" value="" />
                    <input type="hidden" name="mail_magazine" value="yes" />
                    <input type="hidden" name="member_news_notify" value="yes" />
                    <input type="hidden" name="social_notify" value="yes" />
                    <input type="hidden" name="messages_notify" value="yes" />
                    <input type="hidden" name="_birthday[year]" value="" />
                    <input type="hidden" name="_birthday[month]" value="" />
                    <input type="hidden" name="_birthday[day]" value="" />
                    <input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('tcd-membership-registration_account')); ?>">
                    <?php if (!empty($tcd_membership_vars['registration_account']['registration_token'])) { ?>
                        <input type="hidden" name="token" value="<?php echo esc_attr($tcd_membership_vars['registration_account']['registration_token']); ?>">
                    <?php } ?>
                </form>
            </div>
        </div>
        <?php
                if (!$args['echo']) :
                    return ob_get_clean();
                endif;

            // 完了画面
            elseif (!empty($tcd_membership_vars['registration_account']['complete'])) :
        ?>
        <div class="p-membership-form__complete-static">
            <?php
                if ($dp_options['membership']['registration_account_complete_headline']) :
            ?>
                <h2 class="p-member-page-headline--color"><?php echo esc_html($dp_options['membership']['registration_account_complete_headline']); ?></h2>
            <?php
                endif;
                if ($dp_options['membership']['registration_account_complete_desc']) :
                    $registration_account_complete_desc = $dp_options['membership']['registration_account_complete_desc'];
                    $registration_account_complete_desc = str_replace('[user_email]', $tcd_membership_vars['registration_account']['user_email'], $registration_account_complete_desc);
                    $registration_account_complete_desc = str_replace('[user_display_name]', $tcd_membership_vars['registration_account']['user_display_name'], $registration_account_complete_desc);
                    $registration_account_complete_desc = str_replace('[user_name]', $tcd_membership_vars['registration_account']['user_display_name'], $registration_account_complete_desc);
                    $registration_account_complete_desc = str_replace('[login_url]', get_tcd_membership_memberpage_url('login'), $registration_account_complete_desc);
                    $registration_account_complete_desc = str_replace('[login_button]', '<a class="p-button p-rounded-button" href="' . get_tcd_membership_memberpage_url('login') . '">' . __('Login', 'tcd-w') . '</a>', $registration_account_complete_desc);
            ?>
                <div class="p-membership-form__body p-body p-membership-form__desc"><?php echo wpautop($registration_account_complete_desc); ?></div>
            <?php
                endif;
            ?>
        </div>
    <?php

            // エラー画面
            elseif (!empty($tcd_membership_vars['error_message'])) :
    ?>
        <section class="vh-100 bg-image">
            <div class="mask d-flex align-items-center h-100 gradient-custom-3">
                <div class="container">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col-12 col-lg-9 col-xl-7">
                            <div class="card" style="border-radius: 15px;">
                                <div class="card-body shadow">
                                    <h5 class="text-center font-weight-bold my-3">
                                        <?php echo wpautop($tcd_membership_vars['error_message']); ?>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    <?php
            endif;
        }

        /**
         * アカウント編集フォーム
         */
        function tcd_membership_edit_account_form($args = array())
        {
            global $dp_options, $tcd_membership_vars;

            $default_args = array(
                'echo' => true,
                'form_id' => 'js-edit-account-form'
            );
            $args = wp_parse_args($args, $default_args);
            $args = apply_filters('tcd_membership_edit_account_form_args', $args);

            $user = wp_get_current_user();

            if (!$args['echo']) :
                ob_start();
            endif;
    ?>
    <form id="<?php echo esc_attr($args['form_id']); ?>" class="p-membership-form js-membership-form--normal" action="<?php echo esc_attr(get_tcd_membership_memberpage_url('edit_account')); ?>" method="post">
        <h2 class="p-member-page-headline"><?php _e('Edit Account', 'tcd-w'); ?></h2>
        <div class="p-membership-form__body p-body">
            <?php
            if (!empty($tcd_membership_vars['message'])) :
            ?>
                <div class="p-membership-form__message"><?php echo wpautop($tcd_membership_vars['message']); ?></div>
                <?php
            endif;
                ?><?php
                    if (!empty($tcd_membership_vars['error_message'])) :
                    ?>
                <div class="p-membership-form__error"><?php echo wpautop($tcd_membership_vars['error_message']); ?></div>
            <?php
                    endif;
            ?>
            <table class="p-membership-form__table">
                <?php
                render_tcd_membership_user_form_fields('edit_account', $user, $args);

                echo apply_filters('tcd_membership_edit_account_form_table', '', $args);
                ?>
            </table>
            <?php
            echo apply_filters('tcd_membership_edit_account_form', '', $args);
            ?>
            <div class="p-membership-form__button">
                <button class="p-button p-rounded-button p-submit-button" type="submit"><?php _e('Save', 'tcd-w'); ?></button>
                <input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('tcd-membership-edit_account')); ?>">
            </div>
        </div>
    </form>
    <?php
            if (!$args['echo']) :
                return ob_get_clean();
            endif;
        }

        /**
         * プロフィール編集フォーム
         */
        function tcd_membership_edit_profile_form($args = array())
        {
            global $dp_options, $tcd_membership_vars;

            $default_args = array(
                'echo' => true,
                'form_id' => 'js-edit-profile-form'
            );
            $args = wp_parse_args($args, $default_args);
            $args = apply_filters('tcd_membership_edit_profile_form_args', $args);

            $user = wp_get_current_user();
            $profileImageData = get_user_meta(get_current_user_id(), 'profile_image', true);
            $profile_image = get_template_directory_uri() . '/assets/img/icon/non_profile_image.png';
            if (!empty($profileImageData)) {
                $profile_image = $profileImageData;
            }

            $headerImageData = get_user_meta(get_current_user_id(), 'header_image', true);
            $header_image = get_template_directory_uri() . '/assets/img/add_image360-250.png';
            if (!empty($headerImageData)) {
                $header_image = $headerImageData;
            }

            $last_name = '';
            $lastNameData = get_user_meta(get_current_user_id(), 'last_name', true);
            if (!empty($lastNameData)) {
                $last_name = $lastNameData;
            }

            $description = '';
            $descriptionData = get_user_meta(get_current_user_id(), 'description', true);
            if (!empty($descriptionData)) {
                $description = $descriptionData;
            }

            $area = '';
            $areaData = get_user_meta(get_current_user_id(), 'area', true);
            if (!empty($areaData)) {
                $area = $areaData;
            }

            $birthday = '';
            $birthdayData = get_user_meta(get_current_user_id(), 'birthday', true);
            if (!empty($birthdayData)) {
                $birthday = str_replace('/', '-', $birthdayData);
            }

            $inReception = 0;
            $receptionData = get_user_meta(get_current_user_id(), 'request_box', true);
            if (!empty($receptionData)) {
                $inReception = $receptionData;
            }

            $strIdentification = '未確認';
            $identificationData = get_user_meta(get_current_user_id(), 'identification', true);
            if (!empty($identificationData) && $identificationData > 0) {
                $strIdentification = '確認済';
            }

            $strAccountNumber = '未確認';
            $accountNumberData = get_user_meta(get_current_user_id(), 'account_number', true);
            if (!empty($accountNumberData)) {
                $strAccountNumber = $accountNumberData;
            }

            $successMessage = '';
            if (isset($_GET['message']) && $_GET['message'] === 'updated') {
                $successMessage = 'プロフィール情報の更新を行いました。';
            }

            if (!$args['echo']) :
                ob_start();
            endif;
    ?>
    <div class="container">
        <div class="row mb-2">
            <div class="col-12">
                <a href="javascript:history.back();">← 戻る</a>
            </div>
        </div>
    </div>
    <form action="<?php echo esc_attr(get_tcd_membership_memberpage_url('edit_profile')); ?>" enctype="multipart/form-data" method="post">
        <div class="cover-area">
            <img src="<?php echo esc_url($header_image); ?>" class="img-fluid cover-image" id="cover_image">
            <label>
                <input type="file" name="header_image" id="cover_img_file_input" accept="image/png, image/jpeg" class="image">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/camera_BGblue.png" class="camera-image rounded-circle" id="camera_image" alt="camera-image">
            </label>
        </div>
        <div class="emailSentMsg" id="emailSentMsg">
            <?php if (!empty($successMessage)) : ?>
                <p><?php echo $successMessage; ?></p>
            <?php endif; ?>

            <?php
                if (isset($_SESSION['success_twitter_message'])) {
                    $massage = $_SESSION['success_twitter_message'];
                    unset($_SESSION['success_twitter_message']);
            ?>
                <p><?php echo $massage; ?></p>
            <?php } ?>
        </div>
        <div class="container">
            <div class="row profile-edit-area">
                <div class="col-12 text-center pt-3">
                    <label>
                        <input type="file" name="profile_image" id="profile_img_file_input" accept="image/png, image/jpeg" class="image">
                        <img src="<?php echo esc_url($profile_image); ?>" class="profile-image rounded-circle" id="profile_image">
                    </label>
                </div>
                <div class="col-12 text-center title my-2" id="NameMsg"></div>
                <div class="col-12 text-center title my-2" id="UserNameMsg"></div>
                <div class="col-12 text-center title my-2" id="CalendarMsg"></div>
                <div class="col-12 text-center title my-2" id="UrlMsg"></div>
                <div class="col-6 text-left title py-2 mt-0 border-bottom-dashed">
                    名前
                </div>
                <input type="text" name="last_name" value="<?php echo esc_attr($last_name); ?>" id="name_box" name="name_box" class="col-6 border-bottom-dashed">
                <div class="col-6 text-left title border-bottom-dashed mt-0 py-2">
                    ユーザーネーム
                </div>
                <input type="text" name="display_name" value="<?php echo esc_attr($user->data->display_name); ?>" id="user_name_box" name="user_name_box" class="col-6 border-bottom-dashed">
                <div class="col-6 text-left title border-bottom-dashed d-flex align-items-center py-2 mt-0">
                    プロフィール
                </div>
                <textarea name="description" type="text" class="col-6 border-bottom-dashed py-1" cols="50" rows="3"><?php echo esc_attr($description); ?></textarea>
                <div class="col-6 text-left title py-2 mt-0 border-bottom-dashed">
                    生年月日
                </div>
                <input type="date" name="birthday" value="<?php echo esc_attr($birthday); ?>" class="col-6 border-bottom-dashed" id="calendar_box">
                <div class="col-6 text-left title py-2 mt-0 border-bottom-dashed">
                    所在地
                </div>
                <input name="area" type="text" value="<?php echo esc_attr($area); ?>​" class="col-6 border-bottom-dashed">
                <div class="col-6 text-left title py-2 mt-0 border-bottom-dashed my-auto">
                    webサイト
                </div>

                <input type="text" name="website_url" value="<?php echo esc_attr($user->data->user_url); ?>" id="url_box" name="url_box" class="col-6 border-bottom-dashed text-primary">
                <div class="col-6 text-left title border-bottom-dashed mt-0 py-2">
                    依頼
                </div>
                <select id="request_box" name="request_box" class="col-6 border-top-0 border-right-0 border-left-0 border-bottom-dashed">
                    <option value="1" <?php echo ($inReception > 0) ? 'selected' : ''; ?>>受付中</option>
                    <option value="0" <?php echo ($inReception <= 0) ? 'selected' : ''; ?>>受け付けない</option>
                </select>
                <div class="col-6 text-left title border-bottom-dashed mt-0 py-2">
                    本人確認
                </div>
                <div class="col-6 text-left border-bottom-dashed mt-0 py-2 d-flex">
                    <?php echo esc_attr($strIdentification); ?>
                </div>
                <div class="col-6 text-left title border-bottom-dashed mt-0 py-2">
                    口座
                </div>
                <div class="col-6 text-left border-bottom-dashed mt-0 py-2 d-flex">
                    <?php echo esc_attr($strAccountNumber); ?>
                </div>

                <div class="col-12 text-center my-4">
                    <button type="submit" class="btn btn-lg btn-danger save-btn" id="save-btn">　保存　</button>
                </div>

            </div>
        </div>
        <input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('tcd-membership-edit_profile')); ?>">
        <input type="hidden" id="icon-file" name="icon_file" value="0" />
    </form>
    <?php echo makeTwitterOauthLoginLink(); ?>

    <!-- モーダル -->
    <div class="modal fade profile-edit-modal" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <div class="row">
                            <div class="col-md-8">
                                <img id="image" id="preview" src="https://avatars0.githubusercontent.com/u/3456749">
                            </div>

                            <div class="mt-3 col-md-8">
                                <input type="range" value="0" id="zoom" min="0" max="3" step="0.1" class="w-100">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="scrollbar"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                    <button type="button" class="btn btn-primary" id="crop">保存</button>
                </div>
            </div>
        </div>
    </div>
    <!-- cropper.js -->
    <script src="<?php echo get_template_directory_uri(); ?>/assets/js/cropper.min.js"></script>

    <?php
            if (!$args['echo']) :
                return ob_get_clean();
            endif;
        }
        /**
         * アカウント・プロフィール共通処理 フィールド設定取得
         */
        function get_tcd_membership_user_form_fields_settings($form_type = null, $add_settings = array())
        {
            global $dp_options;
            // var_dump($dp_options);exit;
            $default_fields_settings = array(
                'form_type' => $form_type,
                'indent' => 6,
                'use_confirm' => false,
                'show_display_name' => false,
                'show_email_readonly' => false,
                'show_email' => false,
                'show_fullname' => false,
                'show_gender' => false,
                'show_area' => false,
                'show_birthday' => false,
                'show_company' => false,
                'show_job' => false,
                'show_description' => false,
                'show_website' => false,
                'show_facebook' => false,
                'show_twitter' => false,
                'show_instagram' => false,
                'show_youtube' => false,
                'show_tiktok' => false,
                'show_mail_magazine' => false,
                'show_member_news_notify' => false,
                'show_social_notify' => false,
                'show_messages_notify' => false,
                'validate_display_name' => false,
                'validate_email' => false,
                'validate_email_exists' => false,
                'validate_password' => false,
                'validate_new_password' => false,
                'validate_change_password' => false,
                'validate_fullname' => false,
                'validate_gender' => false,
                'validate_area' => false,
                'validate_birthday' => false,
                'validate_company' => false,
                'validate_job' => false,
                'validate_description' => false,
                'validate_website' => false,
                'validate_facebook' => false,
                'validate_twitter' => false,
                'validate_instagram' => false,
                'validate_youtube' => false,
                'validate_tiktok' => false,
                'validate_mail_magazine' => false,
                'validate_member_news_notify' => false,
                'validate_social_notify' => false,
                'validate_messages_notify' => false,
                'label_display_name' => $dp_options['membership']['field_label_display_name'],
                'label_email' => $dp_options['membership']['field_label_email'],
                'label_password' => $dp_options['membership']['field_label_password'],
                'label_password_confirm' => $dp_options['membership']['field_label_password_confirm'],
                'label_current_password' => $dp_options['membership']['field_label_current_password'],
                'label_new_password' => $dp_options['membership']['field_label_new_password'],
                'label_new_password_confirm' => $dp_options['membership']['field_label_new_password_confirm'],
                'label_fullname' => $dp_options['membership']['field_label_fullname'],
                'label_first_name' => $dp_options['membership']['field_label_first_name'],
                'label_last_name' => $dp_options['membership']['field_label_last_name'],
                'label_gender' => $dp_options['membership']['field_label_gender'],
                'label_area' => $dp_options['membership']['field_label_area'],
                'label_birthday' => $dp_options['membership']['field_label_birthday'],
                'label_company' => $dp_options['membership']['field_label_company'],
                'label_job' => $dp_options['membership']['field_label_job'],
                'label_description' => $dp_options['membership']['field_label_desc'],
                'label_website' => $dp_options['membership']['field_label_website'],
                'label_facebook' => $dp_options['membership']['field_label_facebook'],
                'label_twitter' => $dp_options['membership']['field_label_twitter'],
                'label_instagram' => $dp_options['membership']['field_label_instagram'],
                'label_youtube' => $dp_options['membership']['field_label_youtube'],
                'label_tiktok' => $dp_options['membership']['field_label_tiktok'],
                'label_mail_magazine' => $dp_options['membership']['field_label_mail_magazine'],
                'label_member_news_notify' => $dp_options['membership']['field_label_member_news_notify'],
                'label_social_notify' => $dp_options['membership']['field_label_social_notify'],
                'label_messages_notify' => $dp_options['membership']['field_label_messages_notify'],
                'required_fullname' => $dp_options['membership']['field_required_fullname'],
                'required_gender' => $dp_options['membership']['field_required_gender'],
                'required_area' => $dp_options['membership']['field_required_area'],
                'required_birthday' => $dp_options['membership']['field_required_birthday'],
                'required_company' => $dp_options['membership']['field_required_company'],
                'required_job' => $dp_options['membership']['field_required_job'],
                'required_description' => $dp_options['membership']['field_required_desc'],
                'required_website' => $dp_options['membership']['field_required_website'],
                'required_facebook' => $dp_options['membership']['field_required_facebook'],
                'required_twitter' => $dp_options['membership']['field_required_twitter'],
                'required_instagram' => $dp_options['membership']['field_required_instagram'],
                'required_youtube' => $dp_options['membership']['field_required_youtube'],
                'required_tiktok' => $dp_options['membership']['field_required_tiktok'],
                'required_mail_magazine' => $dp_options['membership']['field_required_mail_magazine'],
                'required_member_news_notify' => $dp_options['membership']['field_required_member_news_notify'],
                'required_social_notify' => $dp_options['membership']['field_required_social_notify'],
                'required_messages_notify' => $dp_options['membership']['field_required_messages_notify'],
                'required_html' => $dp_options['membership']['field_required_html']
            );

            if (!$form_type && !empty($add_settings['form_type'])) {
                $form_type = $add_settings['form_type'];
            }

            $fields_settings = array();

            if ('registration' === $form_type) {
            } elseif ('registration_account' === $form_type) {
                // FIXED: 2022/05/29 不要な項目の削除 by 岡部
                $fields_settings = array(
                    'show_display_name' => true,
                    'show_email_readonly' => true,
                    'show_fullname' => true,
                    //					'show_gender' => $dp_options['membership']['show_registration_gender'],
                    //					'show_area' => $dp_options['membership']['show_registration_area'],
                    //					'show_birthday' => $dp_options['membership']['show_registration_birthday'],
                    //					'show_company' => $dp_options['membership']['show_registration_company'],
                    //					'show_job' => $dp_options['membership']['show_registration_job'],
                    //					'show_description' => $dp_options['membership']['show_registration_desc'],
                    //					'show_website' => $dp_options['membership']['show_registration_website'],
                    //					'show_facebook' => $dp_options['membership']['show_registration_facebook'],
                    //					'show_twitter' => $dp_options['membership']['show_registration_twitter'],
                    //					'show_instagram' => $dp_options['membership']['show_registration_instagram'],
                    //					'show_youtube' => $dp_options['membership']['show_registration_youtube'],
                    //					'show_tiktok' => $dp_options['membership']['show_registration_tiktok'],
                    //					'show_mail_magazine' => $dp_options['membership']['use_mail_magazine'],
                    //					'show_member_news_notify' => $dp_options['membership']['use_member_news_notify'],
                    //					'show_social_notify' => $dp_options['membership']['use_social_notify'],
                    //					'show_messages_notify' => $dp_options['membership']['use_messages_notify'],
                    'validate_display_name' => true,
                    'validate_fullname' => $dp_options['membership']['show_registration_fullname'],
                    'validate_change_password' => true
                    //					'validate_gender' => $dp_options['membership']['show_registration_gender'],
                    //					'validate_area' => $dp_options['membership']['show_registration_area'],
                    //					'validate_birthday' => $dp_options['membership']['show_registration_birthday'],
                    //					'validate_company' => $dp_options['membership']['show_registration_company'],
                    //					'validate_job' => $dp_options['membership']['show_registration_job'],
                    //					'validate_description' => $dp_options['membership']['show_registration_desc'],
                    //					'validate_website' => $dp_options['membership']['show_registration_website'],
                    //					'validate_facebook' => $dp_options['membership']['show_registration_facebook'],
                    //					'validate_twitter' => $dp_options['membership']['show_registration_twitter'],
                    //					'validate_instagram' => $dp_options['membership']['show_registration_instagram'],
                    //					'validate_youtube' => $dp_options['membership']['show_registration_youtube'],
                    //					'validate_tiktok' => $dp_options['membership']['show_registration_tiktok'],
                    //					'validate_mail_magazine' => $dp_options['membership']['use_mail_magazine'],
                    //					'validate_member_news_notify' => $dp_options['membership']['use_member_news_notify'],
                    //					'validate_social_notify' => $dp_options['membership']['use_social_notify'],
                    //					'validate_messages_notify' => $dp_options['membership']['use_messages_notify']
                );
            } elseif ('edit_account' === $form_type) {
                $fields_settings = array(
                    'show_display_name' => true,
                    'show_email' => true,
                    'show_gender' => $dp_options['membership']['show_account_gender'],
                    'show_area' => $dp_options['membership']['show_account_area'],
                    'show_birthday' => $dp_options['membership']['show_account_birthday'],
                    'show_mail_magazine' => $dp_options['membership']['use_mail_magazine'],
                    'show_member_news_notify' => $dp_options['membership']['use_member_news_notify'],
                    'show_social_notify' => $dp_options['membership']['use_social_notify'],
                    'show_messages_notify' => $dp_options['membership']['use_messages_notify'],
                    'validate_display_name' => true,
                    // 'validate_email' => true,
                    'validate_gender' => $dp_options['membership']['show_account_gender'],
                    'validate_area' => $dp_options['membership']['show_account_area'],
                    'validate_birthday' => $dp_options['membership']['show_account_birthday'],
                    'validate_mail_magazine' => $dp_options['membership']['use_mail_magazine'],
                    'validate_member_news_notify' => $dp_options['membership']['use_member_news_notify'],
                    'validate_social_notify' => $dp_options['membership']['use_social_notify'],
                    'validate_messages_notify' => $dp_options['membership']['use_messages_notify']
                );
            } elseif ('edit_profile' === $form_type) {
                // FIXED: 2022/05/09 不要な項目の削除 by 岡部
                $fields_settings = array(
                    'show_display_name' => true,
                    // 'show_email' => true,
                    // 'show_fullname' => $dp_options['membership']['show_profile_fullname'],
                    'show_area' => $dp_options['membership']['show_profile_area'],
                    'show_birthday' => $dp_options['membership']['show_profile_birthday'],
                    // 'show_company' => $dp_options['membership']['show_profile_company'],
                    // 'show_job' => $dp_options['membership']['show_profile_job'],
                    'show_description' => $dp_options['membership']['show_profile_desc'],
                    'show_website' => $dp_options['membership']['show_profile_website'],
                    // Add 2022/05/09 H.Okabe
                    'show_telphone' => true,
                    // ADD 2022/07/07 追加 H.Okabe
                    'show_request_box'     => $dp_options['membership']['request_box'],
                    // 'show_facebook' => $dp_options['membership']['show_profile_facebook'],
                    // 'show_twitter' => $dp_options['membership']['show_profile_twitter'],
                    // 'show_instagram' => $dp_options['membership']['show_profile_instagram'],
                    // 'show_youtube' => $dp_options['membership']['show_profile_youtube'],
                    // 'show_tiktok' => $dp_options['membership']['show_profile_tiktok'],
                    'validate_display_name' => true,
                    //'validate_email' => true,
                    // 'validate_change_password' => true,
                    // 'validate_fullname' => $dp_options['membership']['show_profile_fullname'],
                    // 'validate_area' => $dp_options['membership']['show_profile_area'],
                    'validate_birthday' => $dp_options['membership']['show_profile_birthday'],
                    // 'validate_company' => $dp_options['membership']['show_profile_company'],
                    // 'validate_job' => $dp_options['membership']['show_profile_job'],
                    'validate_description' => $dp_options['membership']['show_profile_desc'],
                    'validate_website' => $dp_options['membership']['show_profile_website'],
                    // Add 2022/05/09 H.Okabe
                    'validate_telphone' => true,
                    // 'validate_facebook' => $dp_options['membership']['show_profile_facebook'],
                    // 'validate_twitter' => $dp_options['membership']['show_profile_twitter'],
                    // 'validate_instagram' => $dp_options['membership']['show_profile_instagram'],
                    // 'validate_youtube' => $dp_options['membership']['show_profile_youtube'],
                    // 'validate_tiktok' => $dp_options['membership']['show_profile_tiktok']
                );
            } elseif ('change_password' === $form_type) {
                $fields_settings = array(
                    'validate_change_password' => true
                );
            } elseif ('reset_password_email' === $form_type) {
                $fields_settings = array(
                    'validate_email' => true,
                    'validate_email_exists' => true
                );
            } elseif ('reset_password_new_password' === $form_type) {
                $fields_settings = array(
                    'validate_new_password' => true
                );
            }

            $fields_settings = array_merge($default_fields_settings, $fields_settings);

            if ($add_settings) {
                $fields_settings = wp_parse_args($add_settings, $fields_settings);
            }

            $fields_settings = apply_filters('get_tcd_membership_user_form_fields_settings', $fields_settings, $form_type);

            return $fields_settings;
        }

        /**
         * アカウント・プロフィール共通処理 フィールド出力
         */
        function render_tcd_membership_user_form_fields($form_type = null, $user = null, $args = array())
        {
            global $dp_options, $gender_options, $receive_options, $notify_options;

            $args = wp_parse_args($args, get_tcd_membership_user_form_fields_settings($form_type));
            $args = apply_filters('render_tcd_membership_user_form_fields_args', $args, $form_type, $user);

            if (!$user) :
                $user = wp_get_current_user();
            endif;

            ob_start();

            if ($args['show_display_name']) {
    ?>
        <div class="col-12">
            <label for="username" class="label-text">ユーザーネーム</label>
        </div>
        <div class="col-12 pb-2">
            <input class="form-control register-form" type="text" name="display_name" id="username" placeholder="username" value="<?php echo esc_attr(isset($_REQUEST['display_name']) ? $_REQUEST['display_name'] : $user->display_name); ?>" required>
        </div>
    <?php
            }
    ?>
    <?php
            if ($args['show_description']) :
    ?>

        <h6 class="text-left font-weight-bold mt-3">
            <?php
                echo esc_html($args['label_description']);
                if ($args['required_description']) :
                    echo $args['required_html'];
                endif;
            ?>
        </h6>
        <div class="row">
            <div class="col-12 pb-3">
                <textarea class="form-control form-control-lg" name="description" id="" cols="30" rows="3"><?php echo esc_textarea(isset($_REQUEST['description']) ? $_REQUEST['description'] : $user->description); ?></textarea>
            </div>
        </div>
    <?php
            endif;
    ?>


    <?php
            if ($args['show_website']) :
    ?>

        <h6 class="text-left font-weight-bold mt-3">
            <label for="user_url">
                <?php
                echo esc_html($args['label_website']);
                if ($args['required_website']) :
                    echo $args['required_html'];
                endif;
                ?>
            </label>
        </h6>
        <div class="row">
            <div class="col-12 pb-3">
                <input type="url" name="website_url" class="form-control form-control-lg" value="<?php echo esc_attr(isset($_REQUEST['website_url']) ? $_REQUEST['website_url'] : $user->user_url); ?>" />
            </div>
        </div>
    <?php
            endif;
    ?>

    <?php
            if ($args['show_email_readonly'] && isset($args['email_readonly'])) :
    ?>
        <input class="readonly-email form-control form-control-lg" type="hidden" value="<?php echo esc_attr($args['email_readonly']); ?>" readonly<?php if ($args['use_confirm']) echo ' data-confirm-label="' . esc_attr($args['label_email']) . '"'; ?>>
    <?php
            elseif ($args['show_email']) :
    ?>
        <h6 class="text-left font-weight-bold mt-3"><label for="email"><?php echo esc_html($args['label_email']) . $args['required_html']; ?></label></h6>
        <div class="row">
            <div class="col-12 pb-3">
                <input type="email" id="email" name="email" class="form-control form-control-lg" value="<?php echo esc_attr(isset($_REQUEST['email']) ? $_REQUEST['email'] : $user->user_email); ?>" />
            </div>
        </div>
    <?php
            endif;
    ?>

    <?php
            if ($args['show_telphone']) :
    ?>

        <h6 class="text-left font-weight-bold mt-3">電話番号</h6>
        <div class="row">
            <div class="col-12 pb-3">
                <input type="tel" name="telphone" id="" class="form-control form-control-lg" value="<?php echo esc_attr(isset($_REQUEST['telphone']) ? $_REQUEST['telphone'] : $user->telphone); ?>" />
            </div>
        </div>

    <?php
            endif;
    ?>

    <?php
            if ($args['show_fullname']) :
                if ('type1' === $dp_options['membership']['fullname_type']) :
    ?>
            <div class="col-12 pt-4">
                <label for="name" class="label-text">名前</label>
            </div>
            <div class="col-12 pb-2">
                <input class="form-control register-form" type="text" name="last_name" id="name" placeholder="namae" value="<?php echo esc_attr(isset($_REQUEST['last_name']) ? $_REQUEST['last_name'] : $user->last_name); ?>" required>
                <input class="form-control register-form" type="hidden" name="first_name" id="name" placeholder="namae" value="aaa" required>
            </div>
            <?php /**
			<tr>
				<th><label for="last_name"><?php
											echo esc_html($args['label_fullname']);
											if ($args['required_fullname']) :
												echo $args['required_html'];
											endif;
											?></label></th>
				<td class="p-membership-form__table-fullname">
					<div class="p-membership-form__table-fullname-2col">
						<input type="text" class="last_name" name="last_name" value="<?php echo esc_attr(isset($_REQUEST['last_name']) ? $_REQUEST['last_name'] : $user->last_name); ?>" placeholder="<?php echo esc_attr($args['label_last_name']); ?>" <?php if ($args['required_fullname']) echo ' required'; ?>>
						<input type="text" class="first_name" name="first_name" value="<?php echo esc_attr(isset($_REQUEST['first_name']) ? $_REQUEST['first_name'] : $user->first_name); ?>" placeholder="<?php echo esc_attr($args['label_first_name']); ?>" <?php if ($args['required_fullname']) echo ' required'; ?>>
					</div>
					<?php
					// 確認用ダミー要素
					if (!empty($args['use_confirm'])) :
					?>
						<input type="hidden" class="fullname-hidden" value="" data-confirm-label="<?php echo esc_attr($args['label_fullname']); ?>">
					<?php
					endif;
					?>
				</td>
			</tr>
                     */ ?>
        <?php
                else :
        ?>
            <tr>
                <th><label for="first_name"><?php
                                            echo esc_html($args['label_fullname']);
                                            if ($args['required_fullname']) :
                                                echo $args['required_html'];
                                            endif;
                                            ?></label></th>
                <td class="p-membership-form__table-fullname">
                    <div class="p-membership-form__table-fullname-2col">
                        <input type="text" class="first_name" name="first_name" value="<?php echo esc_attr(isset($_REQUEST['first_name']) ? $_REQUEST['first_name'] : $user->first_name); ?>" placeholder="<?php echo esc_attr($args['label_first_name']); ?>" <?php if ($args['required_fullname']) echo ' required'; ?>>
                        <input type="text" class="last_name" name="last_name" value="<?php echo esc_attr(isset($_REQUEST['last_name']) ? $_REQUEST['last_name'] : $user->last_name); ?>" placeholder="<?php echo esc_attr($args['label_last_name']); ?>" <?php if ($args['required_fullname']) echo ' required'; ?>>
                    </div>
                    <?php
                    // 確認用ダミー要素
                    if (!empty($args['use_confirm'])) :
                    ?>
                        <input type="hidden" class="fullname-hidden" value="" data-confirm-label="<?php echo esc_attr($args['label_fullname']); ?>">
                    <?php
                    endif;
                    ?>
                </td>
            </tr>
        <?php
                endif;
            endif;

            if (!empty($args['show_gender'])) {
        ?>
        <div class="row">
            <div class="col-12 pb-3">
                <label for="gender">
                    <?php
                    echo esc_html($args['label_gender']);
                    if ($args['required_gender']) :
                        echo $args['required_html'];
                    endif;
                    ?>
                </label>
                <?php echo get_tcd_user_profile_input_radio('gender', $gender_options, isset($_REQUEST['gender']) ? $_REQUEST['gender'] : $user->gender, 'man'); ?>
            </div>
        </div>

    <?php
            }

            if (!empty($args['show_area'])) {
    ?>
        <div class="row">
            <div class="col-12 pb-3">
                <label for="area">
                    <?php
                    echo esc_html($args['label_area']);
                    if ($args['required_area']) :
                        echo $args['required_html'];
                    endif;
                    ?>
                </label>
                <?php echo get_tcd_user_profile_input_area(isset($_REQUEST['area']) ? $_REQUEST['area'] : $user->area, $args['required_area'], $args['use_confirm'] ? $args['label_area'] : null); ?>
            </div>
        </div>
    <?php
            }

            if ($args['show_birthday']) {
    ?>
        <div class="row">
            <div class="col-12 pb-3">
                <label for="birthday">
                    <?php
                    echo esc_html($args['label_birthday']);
                    if ($args['required_birthday']) :
                        echo $args['required_html'];
                    endif;
                    ?>
                </label>
                <?php echo get_tcd_user_profile_input_birthday('_birthday', isset($_REQUEST['_birthday']) ? $_REQUEST['_birthday'] : $user->_birthday, $args['required_birthday'], $args['use_confirm'] ? $args['label_birthday'] : null); ?>
            </div>
        </div>
    <?php
            }

            if ($args['show_company']) :
    ?>
        <tr>
            <th><label for="company"><?php
                                        echo esc_html($args['label_company']);
                                        if ($args['required_company']) :
                                            echo $args['required_html'];
                                        endif;
                                        ?></label></th>
            <td><input type="text" name="company" value="<?php echo esc_attr(isset($_REQUEST['company']) ? $_REQUEST['company'] : $user->company); ?>" <?php
                                                                                                                                                        if ($args['required_company']) echo ' required';
                                                                                                                                                        if ($args['use_confirm']) echo ' data-confirm-label="' . esc_attr($args['label_company']) . '"';
                                                                                                                                                        ?>></td>
        </tr>
    <?php
            endif;

            if ($args['show_job']) :
    ?>
        <tr>
            <th><label for="job"><?php
                                    echo esc_html($args['label_job']);
                                    if ($args['required_job']) :
                                        echo $args['required_html'];
                                    endif;
                                    ?></label></th>
            <td><input type="text" name="job" value="<?php echo esc_attr(isset($_REQUEST['job']) ? $_REQUEST['job'] : $user->job); ?>" <?php
                                                                                                                                        if ($args['required_job']) echo ' required';
                                                                                                                                        if ($args['use_confirm']) echo ' data-confirm-label="' . esc_attr($args['label_job']) . '"';
                                                                                                                                        ?>></td>
        </tr>
    <?php
            endif;
    ?>

    <?php
            if ($args['show_facebook']) :
    ?>
        <tr>
            <th><label for="facebook_url"><?php
                                            echo esc_html($args['label_facebook']);
                                            if ($args['required_facebook']) :
                                                echo $args['required_html'];
                                            endif;
                                            ?></label></th>
            <td><input type="url" name="facebook_url" value="<?php echo esc_attr(isset($_REQUEST['facebook_url']) ? $_REQUEST['facebook_url'] : $user->facebook_url); ?>" <?php
                                                                                                                                                                            if ($args['required_company']) echo ' facebook';
                                                                                                                                                                            if ($args['use_confirm']) echo ' data-confirm-label="' . esc_attr($args['label_facebook']) . '"';
                                                                                                                                                                            ?>></td>
        </tr>
    <?php
            endif;

            if ($args['show_twitter']) :
    ?>
        <tr>
            <th><label for="twitter_url"><?php
                                            echo esc_html($args['label_twitter']);
                                            if ($args['required_twitter']) :
                                                echo $args['required_html'];
                                            endif;
                                            ?></label></th>
            <td><input type="url" name="twitter_url" value="<?php echo esc_attr(isset($_REQUEST['twitter_url']) ? $_REQUEST['twitter_url'] : $user->twitter_url); ?>" <?php
                                                                                                                                                                        if ($args['required_twitter']) echo ' required';
                                                                                                                                                                        if ($args['use_confirm']) echo ' data-confirm-label="' . esc_attr($args['label_twitter']) . '"';
                                                                                                                                                                        ?>></td>
        </tr>
    <?php
            endif;

            if ($args['show_instagram']) :
    ?>
        <tr>
            <th><label for="instagram_url"><?php
                                            echo esc_html($args['label_instagram']);
                                            if ($args['required_instagram']) :
                                                echo $args['required_html'];
                                            endif;
                                            ?></label></th>
            <td><input type="url" name="instagram_url" value="<?php echo esc_attr(isset($_REQUEST['instagram_url']) ? $_REQUEST['instagram_url'] : $user->instagram_url); ?>" <?php
                                                                                                                                                                                if ($args['required_instagram']) echo ' required';
                                                                                                                                                                                if ($args['use_confirm']) echo ' data-confirm-label="' . esc_attr($args['label_instagram']) . '"';
                                                                                                                                                                                ?>></td>
        </tr>
    <?php
            endif;

            if ($args['show_youtube']) :
    ?>
        <tr>
            <th><label for="youtube_url"><?php
                                            echo esc_html($args['label_youtube']);
                                            if ($args['required_youtube']) :
                                                echo $args['required_html'];
                                            endif;
                                            ?></label></th>
            <td><input type="url" name="youtube_url" value="<?php echo esc_attr(isset($_REQUEST['youtube_url']) ? $_REQUEST['youtube_url'] : $user->youtube_url); ?>" <?php
                                                                                                                                                                        if ($args['required_youtube']) echo ' required';
                                                                                                                                                                        if ($args['use_confirm']) echo ' data-confirm-label="' . esc_attr($args['label_youtube']) . '"';
                                                                                                                                                                        ?>></td>
        </tr>
    <?php
            endif;

            if ($args['show_tiktok']) :
    ?>
        <tr>
            <th><label for="tiktok_url"><?php
                                        echo esc_html($args['label_tiktok']);
                                        if ($args['required_tiktok']) :
                                            echo $args['required_html'];
                                        endif;
                                        ?></label></th>
            <td><input type="url" name="tiktok_url" value="<?php echo esc_attr(isset($_REQUEST['tiktok_url']) ? $_REQUEST['tiktok_url'] : $user->tiktok_url); ?>" <?php
                                                                                                                                                                    if ($args['required_tiktok']) echo ' required';
                                                                                                                                                                    if ($args['use_confirm']) echo ' data-confirm-label="' . esc_attr($args['label_tiktok']) . '"';
                                                                                                                                                                    ?>></td>
        </tr>
    <?php
            endif;

            if ($args['show_mail_magazine']) {
    ?>

        <div class="row">
            <div class="col-12 pb-3">
                <label for="mail_magazine">
                    <?php
                    echo esc_html($args['label_mail_magazine']);
                    if ($args['required_mail_magazine']) :
                        echo $args['required_html'];
                    endif;
                    ?>
                </label>
                <?php echo get_tcd_user_profile_input_radio('mail_magazine', $receive_options, isset($_REQUEST['mail_magazine']) ? $_REQUEST['mail_magazine'] : $user->mail_magazine, 'yes', $args['use_confirm'] ? $args['label_mail_magazine'] : null); ?>
            </div>
        </div>
    <?php
            }

            if ($args['show_member_news_notify']) {
    ?>
        <div class="row">
            <div class="col-12 pb-3">
                <label for="member_news_notify">
                    <?php
                    echo esc_html($args['label_member_news_notify']);
                    if ($args['required_member_news_notify']) :
                        echo $args['required_html'];
                    endif;
                    ?>
                </label>
                <?php echo get_tcd_user_profile_input_radio('member_news_notify', $notify_options, isset($_REQUEST['member_news_notify']) ? $_REQUEST['member_news_notify'] : $user->member_news_notify, 'yes', $args['use_confirm'] ? $args['label_member_news_notify'] : null); ?>
            </div>
        </div>
    <?php
            }

            if ($args['show_social_notify']) {
    ?>
        <div class="row">
            <div class="col-12 pb-3">
                <label for="social_notify">
                    <?php
                    echo esc_html($args['label_social_notify']);
                    if ($args['required_social_notify']) :
                        echo $args['required_html'];
                    endif;
                    ?>
                </label>
                <?php echo get_tcd_user_profile_input_radio('social_notify', $notify_options, isset($_REQUEST['social_notify']) ? $_REQUEST['social_notify'] : $user->social_notify, 'yes', $args['use_confirm'] ? $args['label_social_notify'] : null); ?>
            </div>
        </div>
    <?php
            }

            if ($args['show_messages_notify']) {
    ?>

        <div class="row">
            <div class="col-12 pb-3">
                <label for="messages_notify">
                    <?php
                    echo esc_html($args['label_messages_notify']);
                    if ($args['required_messages_notify']) :
                        echo $args['required_html'];
                    endif;
                    ?>
                </label>
                <?php echo get_tcd_user_profile_input_radio('messages_notify', $notify_options, isset($_REQUEST['messages_notify']) ? $_REQUEST['messages_notify'] : $user->messages_notify, 'yes', $args['use_confirm'] ? $args['label_messages_notify'] : null); ?>
            </div>
        </div>
<?php
            }

            $html = ob_get_clean();

            if ($args['form_type']) :
                $html = apply_filters('render_tcd_membership_user_form_fields-' . $args['form_type'], $html, $form_type, $user, $args);
            endif;

            $html = apply_filters('render_tcd_membership_user_form_fields', $html, $form_type, $user, $args);

            if ($args['indent'] && is_int($args['indent'])) :
                $indent = str_repeat("\t", $args['indent']);
                $html = $indent . preg_replace("#\n(\t|<tr|</tr)#", "\n{$indent}$1", rtrim($html)) . "\n";
                $html = apply_filters('render_tcd_membership_user_form_fields_after_indent', $html, $form_type, $user, $args);
            endif;

            echo $html;
        }

        /**
         * アカウント・プロフィール共通処理 バリデーション及びエラーメッセージ取得
         */
        function get_tcd_membership_user_form_fields_error_messages($form_type = null, $data, $user = null, $args = array())
        {
            global $dp_options, $gender_options, $receive_options, $notify_options;

            $args = wp_parse_args($args, get_tcd_membership_user_form_fields_settings($form_type));
            $args = apply_filters('get_tcd_membership_user_form_fields_error_messages_args', $args, $form_type, $data, $user);

            $error_messages = array();

            if ($args['validate_display_name']) {
                if (empty($data['display_name'])) {
                    $error_messages[] = sprintf(__('%s is required.', 'tcd-w'), $args['label_display_name']);
                } elseif (false !== strpos($data['display_name'], ' ')) {
                    $error_messages[] = sprintf(__('Spaces are not allowed in the %s.', 'tcd-w'), $args['label_display_name']);
                } elseif (false !== strpos($data['display_name'], '@')) {
                    $error_messages[] = sprintf(__('"@" is not allowed in the %s.', 'tcd-w'), $args['label_display_name']);
                } elseif (tcd_membership_check_forbidden_words($data['display_name'])) {
                    $error_messages[] = sprintf(__('%s has forbidden words.', 'tcd-w'), $args['label_display_name']);
                } elseif (3 > mb_strlen($data['display_name']) || 50 < mb_strlen($data['display_name'])) {
                    $error_messages[] = sprintf(__('%s must be between %d and %d characters length.', 'tcd-w'), $data['display_name'], 3, 50);
                } elseif (tcd_membership_user_field_exists('display_name', $data['display_name'], $user && $user->ID ? $user->ID : null)) {
                    $error_messages[] = sprintf(__('This %s has already been registered, please enter another.', 'tcd-w'), $args['label_display_name']);
                }
            }

            if ($args['validate_email']) {
                if (empty($data['email'])) {
                    $error_messages[] = sprintf(__('%s is required.', 'tcd-w'), $args['label_email']);
                } elseif (!is_email($data['email'])) {
                    $error_messages[] = sprintf(__('%s is invalid format.', 'tcd-w'), $args['label_email']);
                } elseif (100 < strlen($data['email'])) {
                    $error_messages[] = sprintf(__('%s must be 100 characters or less.', 'tcd-w'), $args['label_email']);
                } elseif ($args['validate_email_exists']) {
                    if (!email_exists($data['email'])) {
                        $error_messages[] = __('This email is not registered.', 'tcd-w');
                    }
                } elseif (tcd_membership_user_field_exists('user_email', $data['email'], $user && $user->ID ? $user->ID : null)) {
                    $error_messages[] = sprintf(__('This %s has already been registered, please enter another.', 'tcd-w'), $args['label_email']);
                }
            }

            if ($args['validate_password']) {
                if (empty($data['pass1'])) {
                    $error_messages[] = __('Please enter a password.', 'tcd-w');
                } elseif (8 > strlen($data['pass1'])) {
                    $error_messages[] = __('Passwords must be at least 8 characters.', 'tcd-w');
                } elseif (empty($data['pass2']) || $data['pass1'] !== $data['pass2']) {
                    $error_messages[] = __('Please enter the same password in both password fields.', 'tcd-w');
                }
            }

            if ($args['validate_new_password']) {
                if (empty($data['new_pass1'])) {
                    $error_messages[] = __('Please enter a new password.', 'tcd-w');
                } elseif (8 > strlen($data['new_pass1'])) {
                    $error_messages[] = __('Passwords must be at least 8 characters.', 'tcd-w');
                } elseif (empty($data['new_pass2']) || $data['new_pass1'] !== $data['new_pass2']) {
                    $error_messages[] = __('Please enter the same password in both new password fields.', 'tcd-w');
                }
            }

            if ($args['validate_change_password']) {
                if (!$user) {
                    $user = wp_get_current_user();
                }

                if (!$user || !$user->ID) {
                    // $error_messages[] = __('Require login.', 'tcd-w');
                } elseif (empty($data['current_pass'])) {
                    $error_messages[] = __('Please enter a current password.', 'tcd-w');
                } elseif (!wp_check_password($data['current_pass'], $user->user_pass, $user->ID)) {
                    $error_messages[] = __('Current password is incorrect.', 'tcd-w');
                } elseif (empty($data['new_pass1'])) {
                    $error_messages[] = __('Please enter a new password.', 'tcd-w');
                } elseif (8 > strlen($data['new_pass1'])) {
                    $error_messages[] = __('Passwords must be at least 8 characters.', 'tcd-w');
                } elseif (empty($data['new_pass2']) || $data['new_pass1'] !== $data['new_pass2']) {
                    $error_messages[] = __('Please enter the same password in both new password fields.', 'tcd-w');
                }
            }

            if ($args['validate_fullname']) {
                if ($args['required_fullname'] && (empty($data['last_name']) || empty($data['first_name']))) {
                    $error_messages[] = sprintf(__('%s is required.', 'tcd-w'), $args['label_fullname']);
                } elseif (!empty($data['last_name']) && tcd_membership_check_forbidden_words($data['last_name'])) {
                    $error_messages[] = sprintf(__('%s has forbidden words.', 'tcd-w'), $args['label_fullname']);
                } elseif (!empty($data['first_name']) && tcd_membership_check_forbidden_words($data['first_name'])) {
                    $error_messages[] = sprintf(__('%s has forbidden words.', 'tcd-w'), $args['label_fullname']);
                }
            }

            if ($args['validate_gender']) {
                // ラジオのため$args['required_gender'] は無視します
                if (empty($data['gender']) || !array_key_exists($data['gender'], $gender_options)) {
                    $error_messages[] = sprintf(__('Please select a %s.', 'tcd-w'), $args['label_gender']);
                }
            }

            if ($args['validate_area']) {
                if ($args['required_area'] && empty($data['area'])) {
                    $error_messages[] = sprintf(__('Please select a %s.', 'tcd-w'), $args['label_area']);
                }
            }

            if ($args['validate_birthday']) {

                // 20220529 Fixed 生年月日の対応 H.Okabe
                if (!empty($data['birthday'])) {
                    $explodeBirthDay = explode('/', $data['birthday']);
                    $data['_birthday']['year']  = $explodeBirthDay[0];
                    $data['_birthday']['month'] = $explodeBirthDay[1];
                    $data['_birthday']['day']   = $explodeBirthDay[2];
                }

                if ($args['required_birthday'] && (empty($data['_birthday']['year']) || empty($data['_birthday']['month']) || empty($data['_birthday']['day']))) {
                    $error_messages[] = sprintf(__('Please select a %s.', 'tcd-w'), $args['label_birthday']);
                }
            }

            foreach (array(
                'company',
                'job',
                'description'
            ) as $field) {
                if ($args['validate_' . $field]) {
                    if (!empty($data[$field])) {
                        $data[$field] = trim($data[$field]);
                    }
                    if (empty($data[$field])) {
                        if ($args['required_' . $field]) {
                            $error_messages[] = sprintf(__('%s is required.', 'tcd-w'), $args['label_' . $field]);
                        }
                    } elseif (tcd_membership_check_forbidden_words($data[$field])) {
                        $error_messages[] = sprintf(__('%s has forbidden words.', 'tcd-w'), $args['label_' . $field]);
                    }
                }
            }

            foreach (array(
                'website',
                'facebook',
                'twitter',
                'instagram',
                'youtube',
                'tiktok'
            ) as $field) {
                if ($args['validate_' . $field]) {
                    if (empty($data[$field . '_url'])) {
                        if ($args['required_' . $field]) {
                            $error_messages[] = sprintf(__('%s is required.', 'tcd-w'), $args['label_' . $field]);
                        }
                    } elseif (!preg_match('#^https?://\S+\.\S+$#i', $data[$field . '_url'])) {
                        $error_messages[] = sprintf(__('%s is an invalid url.', 'tcd-w'), $args['label_' . $field]);
                    }
                }
            }

            // 2022/05/09 H.Okabe
            if ($args['validate_telphone']) {
                if (!empty($data['telphone'])) {
                    if (!preg_match('/^0[0-9]{1,4}-[0-9]{1,4}-[0-9]{3,4}\z/', $data['telphone'])) {
                        $error_messages[] = '電話番号を正しく入力してください';
                    }
                }
            }

            if ($args['validate_mail_magazine']) {
                // ラジオのため$args['required_validate_mail_magazine'] は無視します
                if (empty($data['mail_magazine']) || !array_key_exists($data['mail_magazine'], $receive_options)) {
                    $error_messages[] = sprintf(__('Please select a %s.', 'tcd-w'), $args['label_mail_magazine']);
                }
            }

            foreach (array(
                'member_news_notify',
                'social_notify',
                'messages_notify'
            ) as $field) {
                if ($args['validate_' . $field]) {
                    // ラジオのため$args['required_' . $field ] は無視します
                    if (empty($data[$field]) || !array_key_exists($data[$field], $notify_options)) {
                        $error_messages[] = sprintf(__('Please select a %s.', 'tcd-w'), $args['label_' . $field]);
                    }
                }
            }

            $error_messages = apply_filters('get_tcd_membership_user_form_fields_error_messages', $error_messages, $form_type, $data, $args, $user);

            return $error_messages;
        }

        /**
         * アカウント・プロフィール共通処理 ユーザーメタ保存
         */
        function tcd_membership_user_form_fields_save_metas($form_type = null, $data, $user, $args = array())
        {
            global $dp_options, $wpdb;

            if ($user instanceof WP_User) {
            } elseif (is_int($user)) {
                $user = get_user_by('id', $user);
            }

            if (empty($user->ID) || 1 > $user->ID) {
                return false;
            }

            $args = wp_parse_args($args, get_tcd_membership_user_form_fields_settings($form_type));
            $args = apply_filters('tcd_membership_user_form_fields_save_metas', $args, $form_type, $data, $user);

            $metadata = array();

            if ($args['show_fullname']) {
                $meta_key = 'first_name';
                $metadata[$meta_key] = isset($data[$meta_key]) ? tcd_membership_sanitize_content($data[$meta_key]) : '';
                $meta_key = 'last_name';
                $metadata[$meta_key] = isset($data[$meta_key]) ? tcd_membership_sanitize_content($data[$meta_key]) : '';
            }

            if ($args['show_gender']) {
                $meta_key = 'gender';
                $metadata[$meta_key] = isset($data[$meta_key]) ? tcd_membership_sanitize_content($data[$meta_key]) : 'man';
            }

            if ($args['show_area']) {
                $meta_key = 'area';
                $metadata[$meta_key] = isset($data[$meta_key]) ? tcd_membership_sanitize_content($data[$meta_key]) : '';
            }

            if ($args['show_birthday']) {

                // 20220529 Fixed H.Okabe 生年月日の対応
                if (!empty($data['birthday'])) {

                    $explodeBirthDay = explode('-', $data['birthday']);
                    $data['_birthday']['year']  = $explodeBirthDay[0];
                    $data['_birthday']['month'] = $explodeBirthDay[1];
                    $data['_birthday']['day']   = $explodeBirthDay[2];

                    if (checkdate($data['_birthday']['month'], $data['_birthday']['day'], $data['_birthday']['year'])) {
                        // 日付データがおかしい場合はDBに登録をしない
                        $meta_key = '_birthday';
                        $metadata[$meta_key] = isset($data[$meta_key]) ? $data[$meta_key] : '';
                        $meta_key2 = 'birthday';
                        $metadata[$meta_key2] = get_tcd_user_profile_birthday($metadata[$meta_key]);
                    }
                }
            }

            foreach (array(
                'company',
                'job',
                'description'
            ) as $meta_key) {
                if ($args['show_' . $meta_key]) {
                    $metadata[$meta_key] = isset($data[$meta_key]) ? tcd_membership_sanitize_content($data[$meta_key]) : '';
                }
            }

            foreach (array(
                'website',
                'facebook',
                'twitter',
                'instagram',
                'youtube',
                'tiktok'
            ) as $field) {
                if ($args['show_' . $field]) {
                    $meta_key = $field . '_url';
                    $metadata[$meta_key] = isset($data[$meta_key]) ? tcd_membership_sanitize_content($data[$meta_key]) : '';
                }
            }

            foreach (array(
                'mail_magazine',
                'member_news_notify',
                'social_notify',
                'messages_notify',
                // ADD 2022/05/09 H.Okabe Add
                'telphone',
                'request_box'
            ) as $meta_key) {
                if ($args['show_' . $meta_key]) {
                    $metadata[$meta_key] = isset($data[$meta_key]) ? tcd_membership_sanitize_content($data[$meta_key]) : 'yes';

                    // 本会員登録・アカウント作成時はオプション変更時対策でyesを入れておく
                } elseif ('registration_account' === $form_type) {
                    $metadata[$meta_key] = 'yes';
                }
            }

            $metadata = apply_filters('tcd_membership_user_form_fields_save_metas_metadata', $metadata, $form_type, $data, $user, $args);

            if ($metadata) {
                foreach ($metadata as $meta_key => $meta_value) {
                    // ウェブサイトはusermetaではなくusersテーブルのため例外処理
                    if ('website_url' === $meta_key) {
                        if ($user->user_url !== $meta_value) {
                            $result = $wpdb->update(
                                $wpdb->users,
                                array(
                                    'user_url' => $meta_value
                                ),
                                array(
                                    'ID' => $user->ID
                                ),
                                array(
                                    '%s'
                                ),
                                array(
                                    '%d'
                                )
                            );
                        }
                    } else {
                        update_user_meta($user->ID, $meta_key, $meta_value);
                    }
                }

                return count($metadata);
            }

            return true;
        }
