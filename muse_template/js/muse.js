// ハンバーガーボタン押すことによる、サイドバーの開閉動作
jQuery(function($) {
    function slideMenu() {
        var activeState = jQuery(".menu-list").hasClass("active");
        jQuery(".menu-list").animate({ left: activeState ? "0%" : "-300px" }, 400);
    }

    jQuery("#menu-wrapper").click(function(event) {

        event.stopPropagation();
        jQuery("#hamburger-menu").toggleClass("open");
        jQuery(".menu-list").toggleClass("active");
        slideMenu();

        if (jQuery("#hamburger-menu").hasClass("open")) {
            jQuery(".orver-lay").fadeIn();
            jQuery('body').css({
                'position': 'fixed',
                'width': '100%',
                'z-index': '100',
            });

        } else {
            jQuery(".orver-lay").fadeOut();
            jQuery('body').css({
                'position': 'relative',
                'width': 'auto',
                'top': 'auto'
            });
        }
    });

    jQuery(".orver-lay").click(function(event) {
        var active = jQuery("#hamburger-menu").hasClass("open");
        if (active == true) {
            jQuery(".orver-lay").fadeOut();
            event.stopPropagation();
            jQuery("#hamburger-menu").toggleClass("open");
            jQuery(".menu-list").toggleClass("active");
            slideMenu();
            jQuery('body').css({
                'position': 'relative',
                'width': 'auto',
                'top': 'auto'
            });
        }
    });
});

// 通常新規登録ページ(sign_up.html)
// 入力項目のフォーカスが外れた際に処理を実行
jQuery(function($) {
    // メールアドレスのフォーカスが外れた際にcheckInput実行
    jQuery('#email').on('blur', function($) {
        checkInput();
    });
    // 会員規約がクリックされた際にcheckInput実行
    jQuery('#terms').on('click', function($) {
        checkInput();
    });
    // 仮登録ボタンを押された際に、メール送信済みメッセージを表示
    jQuery('#register-btn').on('click', function($) {
        showEmailSentMsg();
    });
});

// 入力項目を確認し、仮登録ボタン有効化/無効化切り替え
function checkInput() {
    // メールアドレスが入力された場合、emailCheckにtrueを格納
    var emailCheck = false;
    // メールアドレスの入力フォーム要素を取得
    var email = document.getElementById('email');
    // 会員規約のチェックボックス要素を取得
    var terms = document.getElementById('terms');
    // 仮登録のボタン要素を取得
    var registerBtn = document.getElementById('register-btn');

    // メールアドレスに空白文字が含まれていないかを確認
    if (!email.value.match(/[\x20\u3000]/)) {
        // メールアドレスのフォーマットを確認
        emailCheck = validateEmail(email.value);
    }

    // メールアドレスが入力されている、かつ会員規約にチェックがついている場合ボタンを有効化
    registerBtn.disabled = true;
    if (emailCheck === true && terms.checked === true) {
        registerBtn.disabled = false;
    }
}

/**
 * パスワードリセットページ
 */
// 入力項目のフォーカスが外れた際に処理を実行
jQuery(function($) {
    // メールアドレスのフォーカスが外れた際にcheckPwResetInput実行
    jQuery('#pwResetEmail').on('blur', function($) {
        checkPwResetInput();
    });
});

// 入力項目を確認し、パスワード再発行ボタンを有効化/無効化切り替え
function checkPwResetInput() {
    // パスワード再発行ボタン有効化フラグ
    var disabledFlag = true;

    // 入力項目フラグ定義
    var pwResetEmail = false;

    // メールアドレスの値取得
    var pwResetEmailVal = jQuery('#pwResetEmail').val();

    // メールアドレスが入力されているかを確認
    if (pwResetEmailVal.length > 0) {
        // メールアドレスが入力されている場合、エラーメッセージを非表示
        jQuery('#emailErrMsg').hide();
        // メールアドレスに空白文字が含まれていないかを確認
        if (!pwResetEmailVal.match(/[\x20\u3000]/)) {
            // メールアドレスのフォーマットを確認
            pwResetEmail = validateEmail(pwResetEmailVal);
        }
    } else {
        // メールアドレスが入力されていない場合、エラーメッセージを表示
        showTypeEmailMsg();
    }

    // 入力項目の値が正しい場合、パスワード再発行ボタンを有効化
    if (pwResetEmail === true) {
        disabledFlag = false;
    }
    jQuery('#resetpw-btn').attr('disabled', disabledFlag);
}

// メールアドレスが入力されていない場合、メッセージを表示
function showTypeEmailMsg() {
    jQuery('#inputEmailMsg').empty().append("<p id=\"emailErrMsg\">メールアドレスを入力してください</p>");
}

/**
 * ログインページ(login.html)
 */
// 入力項目のフォーカスが外れた際に処理を実行
jQuery(function($) {
    // メールアドレスのフォーカスが外れた際にcheckLoginInput実行
    jQuery('#loginEmail').on('blur', function($) {
        checkLoginInput();
    });
    // パスワードのフォーカスが外れた際にcheckLoginInput実行
    jQuery('#loginPassword').on('blur', function($) {
        checkLoginInput();
    });
});

// 入力項目を確認し、ログインボタン有効化/無効化切り替え
function checkLoginInput() {
    // ログインボタン有効化フラグ
    var disabledFlag = true;

    // 入力項目フラグ定義
    var loginEmail = false;
    var loginPassword = false;

    // メールアドレスの値取得
    var emailVal = jQuery('#loginEmail').val();
    // パスワードの値取得
    var passwordVal = jQuery('#loginPassword').val();

    // メールアドレスが入力されているかを確認
    if (emailVal.length > 0) {
        // メールアドレスに空白文字が含まれていないかを確認
        if (!emailVal.match(/[\x20\u3000]/)) {
            // メールアドレスのフォーマットを確認
            loginEmail = validateEmail(emailVal);
        }
    }
    // パスワードが入力されているかを確認
    if (passwordVal.length > 0) {
        // パスワードに空白文字が含まれていないかを確認
        if (!passwordVal.match(/[\x20\u3000/]/)) {
            // パスワードのフォーマットを確認
            loginPassword = validatePassword(passwordVal);
        }
    }

    // 入力項目の値が正しい場合、ログインボタンを有効化
    if (loginEmail === true && loginPassword === true) {
        disabledFlag = false;
    }
    jQuery('#login-btn').attr('disabled', disabledFlag);
}

// 画像サイズの検証
function validateImageSize(file, fileInput) {
    const sizeLimit = 1024 * 1024 * 100;
    if (file.size > sizeLimit) {
        alert('ファイルのサイズは100MB以下にしてください');
        fileInput.value = '';
        exit();
    }
}

// 選択した画像に置き換える
function replaceImage(file, image) {
    let fr = new FileReader();
    fr.readAsDataURL(file);
    fr.onload = function($) {
        image.setAttribute('src', fr.result);
    }
}

// メール送信済みメッセージを表示
function showEmailSentMsg() {
    jQuery('#emailSentMsg').append("<p>下記のメールアドレスに仮登録メールを送信いたしました。</p>");
}

/**
 * 本登録ページ(register.html)
 */
// 入力項目のフォーカスが外れた際に処理を実行
jQuery(function($) {
    // ユーザーネームのフォーカスが外れた際にcheckRegisterInput実行
    jQuery('#username').on('blur', function($) {
        checkRegisterInput();
    });
    // 名前のフォーカスが外れた際にcheckRegisterInput実行
    jQuery('#name').on('blur', function($) {
        checkRegisterInput();
    });
    // パスワードのフォーカスが外れた際にcheckRegisterInput実行
    jQuery('#password').on('blur', function($) {
        checkRegisterInput();
    });
    // パスワードを再入力のフォーカスが外れた際にcheckRegisterInput実行
    jQuery('#password_confirmation').on('blur', function($) {
        checkRegisterInput();
    });
});

// 入力項目を確認し、新規登録ボタン有効化/無効化切り替え
function checkRegisterInput() {
    // 新規登録ボタン有効化フラグ
    var disabledFlag = true;

    // 入力項目フラグ定義
    var usernameFlag = false;
    var nameFlg = false;
    var passwordFlg = false;
    var pwConfirmFlg = false;

    // ユーザーネームの値取得
    var usernameVal = jQuery('#username').val();
    // 名前の値取得
    var nameVal = jQuery('#name').val();
    // パスワードの値取得
    var passwordVal = jQuery('#password').val();
    // パスワードを再入力の値取得
    var pwConfirmVal = jQuery('#password_confirmation').val();

    // ユーザーネームが入力されているかを確認
    if (usernameVal.length > 0) {
        // ユーザーネームに空白文字が含まれていないかを確認
        if (!usernameVal.match(/[\x20\u3000]/)) {
            usernameFlag = true;
        }
    }

    // 名前が入力されているかを確認
    if (nameVal.length > 0) {
        // 名前に空白文字が含まれていないかを確認
        if (!nameVal.match(/[\x20\u3000]/)) {
            nameFlg = true;
        }
    }

    // パスワードが入力されているかを確認
    if (passwordVal.length > 0) {
        // パスワードが入力されている場合、エラーメッセージを非表示
        jQuery('#inputPwErrMsg').hide();
        // パスワードに空白文字が含まれていないかを確認
        if (!passwordVal.match(/[\x20\u3000]/)) {
            // パスワードのフォーマットを確認
            var passwordFlg = validatePassword(passwordVal);
            if (passwordFlg === false) {
                // パスワードのフォーマットが正しくない場合、エラーメッセージを表示
                showPwValidateMsg();
            }
        } else {
            showPwValidateMsg2();
        }
    }

    // パスワードを再入力が入力されているかを確認
    if (pwConfirmVal.length > 0) {
        // パスワードを再入力が入力されている場合、エラーメッセージを非表示
        jQuery('#inputPwConfirmErrMsg').hide();
        // パスワードとパスワードを再入力の値が同じかを確認
        if (passwordVal === pwConfirmVal) {
            pwConfirmFlg = true;
        } else {
            // パスワードが合っていない場合、エラーメッセージを表示
            showPwNotMatchMsg();
        }
    }

    // 入力項目の値が正しい場合、新規登録ボタンを有効化
    if (usernameFlag === true && nameFlg === true && passwordFlg === true && pwConfirmFlg === true) {
        disabledFlag = false;
    }
    jQuery('#register-btn').attr('disabled', disabledFlag);
}

/**
 * パスワードリセットページ(pass_reset.html)
 */
// 入力項目のフォーカスが外れた際に処理を実行
jQuery(function($) {
    // パスワードのフォーカスが外れた際にcheckSetPwInput実行
    jQuery('#newPw').on('blur', function($) {
        checkSetPwInput();
        showTypePwMsg();
    });
    // 新しいパスワードを再入力のフォーカスが外れた際にcheckSetPwInput実行
    jQuery('#newPwConfirm').on('blur', function($) {
        checkSetPwInput();
        showTypePwConfirmMsg();
    });
});

// 入力項目を確認し、新規登録ボタン有効化/無効化切り替え
function checkSetPwInput() {
    // 新規登録ボタン有効化フラグ
    var disabledFlag = true;

    // 入力項目フラグ定義
    var flagNewPw = false;
    var flagNewPwConfirm = false;

    // パスワードの値取得
    var newPwVal = jQuery('#newPw').val();
    // パスワードを再入力の値取得
    var newPwConfirmVal = jQuery('#newPwConfirm').val();

    // パスワードが入力されているかを確認
    if (newPwVal.length > 0) {
        // パスワードが入力されている場合、エラーメッセージを非表示
        jQuery('#inputPwErrMsg').hide();
        // パスワードに空白文字が含まれていないかを確認
        if (!newPwVal.match(/[\x20\u3000]/)) {
            // パスワードのフォーマットを確認
            var flagNewPw = validatePassword(newPwVal);
            if (flagNewPw === false) {
                // パスワードのフォーマットが正しくない場合、エラーメッセージを表示
                showPwValidateMsg();
            }
        }
    }

    // パスワードを再入力が入力されているかを確認
    if (newPwConfirmVal.length > 0) {
        // パスワードを再入力が入力されている場合、エラーメッセージを非表示
        jQuery('#inputPwConfirmErrMsg').hide();
        // パスワードとパスワードを再入力の値が同じかを確認
        if (newPwVal === newPwConfirmVal) {
            flagNewPwConfirm = true;
        } else {
            // パスワードが合っていない場合、エラーメッセージを表示
            showPwNotMatchMsg();
        }
    }

    // 入力項目の値が正しい場合、新規登録ボタンを有効化
    if (flagNewPw === true && flagNewPwConfirm === true) {
        disabledFlag = false;
    }
    jQuery('#setpw-btn').attr('disabled', disabledFlag);
}

// パスワードが入力されていない場合、メッセージを表示
function showTypePwMsg() {
    // パスワードの値取得
    var newPwLength = jQuery('#newPw').val().length;
    if (newPwLength <= 0) {
        jQuery('#inputPwMsg').empty().append("<p id=\"inputPwErrMsg\" class=\"pwResetErrMsg\">パスワードを入力してください</p>");
    }
}

// パスワードを再入力が入力されていない場合、メッセージを表示
function showTypePwConfirmMsg() {
    // パスワードを再入力の値取得
    var newPwConfirmLength = jQuery('#newPwConfirm').val().length;
    if (newPwConfirmLength <= 0) {
        jQuery('#inputPwConfirmMsg').empty().append("<p id=\"inputPwConfirmErrMsg\" class=\"pwResetErrMsg\">パスワードを入力してください</p>");
    }
}

// パスワードのフォーマットが正しくない場合、メッセージを表示
function showPwValidateMsg() {
    jQuery('#inputPwMsg').empty().append("<p id=\"inputPwErrMsg\" class=\"pwResetErrMsg\">パスワードは半角英小文字、大文字、数字を含む9文字以上32文字以内を入力してください</p>");
}

// パスワードに空欄がある場合、メッセージを表示
function showPwValidateMsg2() {
    jQuery('#inputPwMsg').empty().append("<p id=\"inputPwErrMsg\" class=\"pwResetErrMsg\">パスワードにスペースは含めないでください</p>");
}

// パスワードが合っていない場合、メッセージを表示
function showPwNotMatchMsg() {
    jQuery('#inputPwConfirmMsg').empty().append("<p id=\"inputPwConfirmErrMsg\" class=\"pwResetErrMsg\">パスワードが一致しません</p>");
}

// 検索オプションのモーダル開閉
jQuery(function($) {
    var open = jQuery('.modal-open'),
        container = jQuery('.modal-container');

    //開くボタンをクリックしたらモーダルを表示する
    open.on('click', function($) {
        container.addClass('active');
        return false;
    });

    //モーダルの外側をクリックしたらモーダルを閉じる
    jQuery(document).on('click', function(e) {
        if (!jQuery(e.target).closest('.modal-body').length) {
            container.removeClass('active');
        }
    });
});

// タブの選択機能（post_search.html,request_searched_list.html）
jQuery(function($) {

    jQuery('#front_search_box').on('blur', function($) {
        var search_txt = jQuery('#front_search_box').val();
        jQuery('#modal_search_box').val(search_txt);
    });

    jQuery('#desc').click(function($) {
        selectTab(jQuery(this));
    });

    jQuery('#asc').click(function($) {
        selectTab(jQuery(this));
    });

    jQuery('#low').click(function($) {
        selectTab(jQuery(this));
    });

    jQuery('#high').click(function($) {
        selectTab(jQuery(this));
    });

});

// キープ済み、キープの選択機能（request_searched_list.html,request_received_list_html）
jQuery(function($) {
    jQuery(document).on('click', '.keep_off', function($) {
        let keep_on = jQuery('<div class="rounded-pill text-center mb-1 px-1 keep_on"><img src="assets/img/icon/keep_on.png" alt="keep-on" class="keep-on"></div>');
        jQuery(this).replaceWith(keep_on);
    });

    jQuery(document).on('click', '.keep_on', function($) {
        let keep_off = jQuery('<div class="border rounded-pill text-center mb-1 px-1 keep_off"><img src="assets/img/icon/keep_off.png" alt="keep-off" class="keep-off"></div>');
        jQuery(this).replaceWith(keep_off);
    });
});

/**
 * 作品依頼（通常依頼）提案ページ
 */
// ファイルが選択された際、ファイル名を表示
jQuery('#requestFile').on('change', function($) {
    // 添付されたファイルを取得
    var selectedFile = jQuery(this).prop('files')[0];
    // ファイルが存在している場合
    if (selectedFile) {
        // 選択されたファイルが10文字以上ある場合、10文字以下を「...」で省略
        var selectedFileName = selectedFile.name.length > 10 ? (selectedFile.name).slice(0, 10) + "..." : selectedFile.name;
        // ファイル名を表示
        jQuery('#outputFileName').text(selectedFileName);
        // バリデーション文言を非表示
        jQuery('#inputRequestErrMsgArea').addClass('d-none');
    } else {
        // 添付ファイルを空に変更
        this.value = '';
        // ファイル名を空に変更
        jQuery('#outputFileName').text('');
        // バリデーション文言を表示
        jQuery('#inputRequestErrMsgArea').removeClass('d-none');
    }
    // 必須項目のチェック
    checkRequestInput();
});
/**
 * 作品依頼（通常依頼）提案ページ
 */
// ファイル選択ボタンがクリックされた際、バリデーション文言を表示
jQuery('#requestFile').on('click', function($) {
    // ファイルが存在しない場合、バリデーション文言を表示
    if (this.files.length === 0) {
        jQuery('#inputRequestErrMsgArea').removeClass('d-none');
    };
    // 必須項目のチェック
    checkRequestInput();
});

// 入力項目のフォーカスが外れた際に処理を実行
jQuery(function($) {
    // 依頼タイトルのフォーカスが外れた際にcheckRequestInput実行
    jQuery('#requestTitle').on('blur', function($) {
        checkRequestInput();
        typeRequestTitleMsg();
    });
    // 作品タイトルのフォーカスが外れた際にcheckRequestInput実行
    jQuery('#workTitle').on('blur', function($) {
        checkRequestInput();
        typeWorkTitleMsg();
    });
    // 本文のフォーカスが外れた際にcheckRequestInput実行
    jQuery('#text').on('blur', function($) {
        checkRequestInput();
        typeTextMsg();
    });
    // 構図のフォーカスが外れた際にcheckRequestInput実行
    jQuery('#composition').on('blur', function($) {
        checkRequestInput();
        typeCompositionMsg();
    });
    // キャラクターのフォーカスが外れた際にcheckRequestInput実行
    jQuery('#character').on('blur', function($) {
        checkRequestInput();
        typeCharacterMsg();
    });
    // 参考URLのフォーカスが外れた際にcheckRequestInput実行
    jQuery('#refUrl').on('blur', function($) {
        checkRequestInput();
        typeRefUrlMsg();
    });
    // 予算のフォーカスが外れた際にcheckRequestInput実行
    jQuery('#budget').on('blur', function($) {
        checkRequestInput();
        typeBudgetMsg();
    });
    // 応募期限（年）のフォーカスが外れた際にcheckRequestInput実行
    jQuery('#appDeadlineY').on('blur', function($) {
        checkRequestInput();
        typeAppDeadlineMsg();
    });
    // 応募期限（月）のフォーカスが外れた際にcheckRequestInput実行
    jQuery('#appDeadlineM').on('blur', function($) {
        checkRequestInput();
        typeAppDeadlineMsg();
    });
    // 応募期限（日）のフォーカスが外れた際にcheckRequestInput実行
    jQuery('#appDeadlineD').on('blur', function($) {
        checkRequestInput();
        typeAppDeadlineMsg();
    });
});

// 入力項目を確認し、依頼投稿確認ボタン有効化/無効化切り替え
function checkRequestInput() {
    // 新規登録ボタン有効化フラグ
    var disabledFlag = true;

    // 入力項目フラグ定義
    var flagRequestTitle = false;
    var flagWorkTitle = false;
    var flagText = false;
    var flagComposition = false;
    var flagCharacter = false;
    var flagRequestFile = false;
    var flagRefUrl = false;
    var flagBudget = false;
    var flagAppDeadline = false;

    // 依頼タイトルの値取得
    var requestTitleVal = jQuery('#requestTitle').val();
    // 作品タイトルの値取得
    var workTitleVal = jQuery('#workTitle').val();
    // 本文の値取得
    var textVal = jQuery('#text').val();
    // 構図の値取得
    var compositionVal = jQuery('#composition').val();
    // キャラクターの値取得
    var characterVal = jQuery('#character').val();
    // 添付ファイルの値取得
    var requestFileVal = jQuery('#requestFile').val();
    // 参考URLの値取得
    var refUrlVal = jQuery('#refUrl').val();
    // 予算の値取得
    var budgetVal = jQuery('#budget').val();
    // 応募期限（年）の値取得
    var appDeadlineYVal = jQuery('#appDeadlineY').val();
    // 応募期限（月）の値取得
    var appDeadlineMVal = jQuery('#appDeadlineM').val();
    // 応募期限（日）の値取得
    var appDeadlineDVal = jQuery('#appDeadlineD').val();

    // 依頼タイトルが入力されているかを確認
    if (requestTitleVal.length > 0) {
        // 依頼タイトルが入力されている場合、エラーメッセージを非表示
        jQuery('#inputRequestErrMsg').hide();
        // 依頼タイトルに空白文字が含まれていないかを確認
        if (!requestTitleVal.match(/[\x20\u3000]/)) {
            flagRequestTitle = true;
        }
    }

    // 作品タイトルが入力されているかを確認
    if (workTitleVal.length > 0) {
        // 作品タイトルが入力されている場合、エラーメッセージを非表示
        jQuery('#inputWorkErrMsg').hide();
        // 作品タイトルに空白文字が含まれていないかを確認
        if (!workTitleVal.match(/[\x20\u3000]/)) {
            flagWorkTitle = true;
        }
    }

    // 本文が入力されているかを確認
    if (textVal.length > 0) {
        // 本文が入力されている場合、エラーメッセージを非表示
        jQuery('#inputTextErrMsg').hide();
        // 本文に空白文字が含まれていないかを確認
        if (!textVal.match(/[\x20\u3000]/)) {
            flagText = true;
        }
    }

    // 構図が入力されているかを確認
    if (compositionVal.length > 0) {
        // 構図が入力されている場合、エラーメッセージを非表示
        jQuery('#inputCompositionErrMsg').hide();
        // 構図に空白文字が含まれていないかを確認
        if (!compositionVal.match(/[\x20\u3000]/)) {
            flagComposition = true;
        }
    }

    // キャラクターが入力されているかを確認
    if (characterVal.length > 0) {
        // キャラクターが入力されている場合、エラーメッセージを非表示
        jQuery('#inputCharacterErrMsg').hide();
        // キャラクターに空白文字が含まれていないかを確認
        if (!characterVal.match(/[\x20\u3000]/)) {
            flagCharacter = true;
        }
    }

    // 添付ファイルが入力されているかを確認
    if (requestFileVal) {
        // 添付ファイルが入力されている場合、エラーメッセージを非表示
        flagRequestFile = true;
        jQuery('#inputRequestErrMsgArea').addClass('d-none');
    }

    // 参考URLが入力されているかを確認
    jQuery('#validRefUrlErrMsg').hide();
    if (refUrlVal.length > 0) {
        // 参考URLに空白文字が含まれていないかを確認
        if (!refUrlVal.match(/[\x20\u3000]/)) {
            // 参考URLの形式を確認
            flagRefUrl = validateUrl(refUrlVal);
            if (flagRefUrl === true) {
                // 参考URLが入力されている場合、エラーメッセージを非表示
                jQuery('#validRefUrlErrMsg').hide();
            }
        }
    } else {
        // 参考URLに何も入力されていない場合、URLのフラグはtrue
        flagRefUrl = true;
    }

    // 予算が入力されているかを確認
    if (budgetVal.length > 0) {
        // 予算が入力されている場合、エラーメッセージを非表示
        jQuery('#inputBudgetErrMsg').hide();
        // 予算に空白文字が含まれていないかを確認
        if (!budgetVal.match(/[\x20\u3000]/)) {
            flagBudget = true;
        }
    }

    // 応募期限（年）が入力されている場合
    if (appDeadlineYVal.length > 0) {
        // 年のフォーマットを確認
        yearValidated = validateYear(appDeadlineYVal);
        if (yearValidated === true) {
            // 年のフォーマットが正しい場合、エラーメッセージを非表示
            jQuery('#dateFormatYErrMsg').hide();
            // 応募期限（月）が入力されている場合
            if (appDeadlineMVal.length > 0) {
                // 月のフォーマットを確認
                monthValidated = validateMonth(appDeadlineMVal);
                if (monthValidated === true) {
                    // 月のフォーマットが正しい場合、エラーメッセージを非表示
                    jQuery('#dateFormatMErrMsg').hide();
                    // 応募期限（日）が入力されている場合
                    if (appDeadlineDVal.length > 0) {
                        // 日のフォーマットを確認
                        dayValidated = validateDay(appDeadlineDVal);
                        if (dayValidated === true) {
                            // 日のフォーマットが正しい場合、エラーメッセージを非表示
                            jQuery('#dateFormatDErrMsg').hide();
                            // 応募期限フラグをtrueに設定
                            flagAppDeadline = true;
                            // 年月日が設定されている場合、エラーメッセージを非表示
                            jQuery('#inputAppDeadlineMsg').hide();
                        } else {
                            dateFormatDInvalidMsg();
                        }
                    }
                } else {
                    dateFormatMInvalidMsg();
                }
            }
        } else {
            dateFormatYInvalidMsg();
        }
    }

    // 入力項目の値が正しい場合、新規登録ボタンを有効化
    if (flagRequestTitle === true && flagWorkTitle === true && flagText === true && flagComposition === true && flagCharacter === true && flagRefUrl === true && flagBudget === true && flagAppDeadline === true && flagRequestFile === true) {
        disabledFlag = false;
    }
    jQuery('#requestBtn').attr('disabled', disabledFlag);
}

// 依頼タイトルが入力されていない場合、メッセージを表示
function typeRequestTitleMsg() {
    // 依頼タイトルの値取得
    var requestTitleLength = jQuery('#requestTitle').val().length;
    if (requestTitleLength <= 0) {
        jQuery('#inputRequestTitle').empty().append("<p id=\"inputRequestErrMsg\" class=\"inputRequestErrMsg\">依頼タイトルを入力してください</p>");
    }
}
// 作品タイトルが入力されていない場合、メッセージを表示
function typeWorkTitleMsg() {
    // 作品タイトルの値取得
    var workTitleLength = jQuery('#workTitle').val().length;
    if (workTitleLength <= 0) {
        jQuery('#inputWorkTitle').empty().append("<p id=\"inputWorkErrMsg\" class=\"inputRequestErrMsg mt-1\">作品タイトルを入力してください</p>");
    }
}
// 本文が入力されていない場合、メッセージを表示
function typeTextMsg() {
    // 本文の値取得
    var textLength = jQuery('#text').val().length;
    if (textLength <= 0) {
        jQuery('#inputText').empty().append("<p id=\"inputTextErrMsg\" class=\"inputRequestErrMsg mt-1\">本文タイトルを入力してください</p>");
    }
}
// 構図が入力されていない場合、メッセージを表示
function typeCompositionMsg() {
    // 構図の値取得
    var compositionLength = jQuery('#composition').val().length;
    if (compositionLength <= 0) {
        jQuery('#inputComposition').empty().append("<p id=\"inputCompositionErrMsg\" class=\"inputRequestErrMsg mt-1\">構図を入力してください</p>");
    }
}
// キャラクターが入力されていない場合、メッセージを表示
function typeCharacterMsg() {
    // キャラクターの値取得
    var characterLength = jQuery('#character').val().length;
    if (characterLength <= 0) {
        jQuery('#inputCharacter').empty().append("<p id=\"inputCharacterErrMsg\" class=\"inputRequestErrMsg mt-1\">キャラクターを入力してください</p>");
    }
}
// 参考URLの形式が正しくない場合、メッセージを表示
function typeRefUrlMsg() {
    // 参考URLの値を取得
    var refUrlVal = jQuery('#refUrl').val();
    // 参考URLの形式を確認
    refUrlValid = validateUrl(refUrlVal);
    if (refUrlVal.length > 0) {
        if (refUrlValid === false) {
            jQuery('#validRefUrl').empty().append("<p id=\"validRefUrlErrMsg\" class=\"inputRequestErrMsg mt-1\">参考URLの形式が間違っています</p>");
        }
    }
}
// 予算が入力されていない場合、メッセージを表示
function typeBudgetMsg() {
    // 予算の値取得
    var budgetLength = jQuery('#budget').val().length;
    if (budgetLength <= 0) {
        jQuery('#inputBudget').empty().append("<p id=\"inputBudgetErrMsg\" class=\"inputRequestErrMsg mt-1\">予算を入力してください</p>");
    }
}
// 応募期限が入力されていない場合、メッセージを表示
function typeAppDeadlineMsg() {
    // 応募期限（年）の値取得
    var appDeadlineYLength = jQuery('#appDeadlineY').val().length;
    // 応募期限（月）の値取得
    var appDeadlineMLength = jQuery('#appDeadlineM').val().length;
    // 応募期限（日）の値取得
    var appDeadlineDLength = jQuery('#appDeadlineD').val().length;
    // 応募期限の年月日がそれぞれ入力されていない場合、エラーメッセージを表示
    if (appDeadlineYLength <= 0 || appDeadlineMLength <= 0 || appDeadlineDLength <= 0) {
        jQuery('#inputAppDeadline').empty().append("<p id=\"inputAppDeadlineMsg\" class=\"inputRequestErrMsg mt-1\">応募期限を年月日それぞれ入力してください</p>");
    }
}
// 応募期限（年）のフォーマットが正しくない場合、メッセージを表示
function dateFormatYInvalidMsg() {
    jQuery('#inputAppDeadline').empty().append("<p id=\"dateFormatYErrMsg\" class=\"inputRequestErrMsg mt-1\">年のフォーマットが正しくありません</p>");
}
// 応募期限（月）のフォーマットが正しくない場合、メッセージを表示
function dateFormatMInvalidMsg() {
    jQuery('#inputAppDeadline').empty().append("<p id=\"dateFormatMErrMsg\" class=\"inputRequestErrMsg mt-1\">月のフォーマットが正しくありません</p>");
}
// 応募期限（日）のフォーマットが正しくない場合、メッセージを表示
function dateFormatDInvalidMsg() {
    jQuery('#inputAppDeadline').empty().append("<p id=\"dateFormatDErrMsg\" class=\"inputRequestErrMsg mt-1\">日付のフォーマットが正しくありません</p>");
}

// タブの選択表示
function selectTab(target) {
    let sortTabs = jQuery('#sort_tab > button').siblings();
    sortTabs.removeClass('selected-tab');
    sortTabs.addClass('not-selected-tab');
    target.removeClass('not-selected-tab');
    target.addClass('selected-tab');
}
// 画像変更（profile_edit.html）
jQuery(function($) {
    jQuery('#cover_img_file_input').change(function($) {
        let file = this.files[0];
        let fileInput = jQuery('#cover_img_file_input').get(0);
        let image = jQuery('#cover_image').get(0);
        validateImageSize(file, fileInput)
        replaceImage(file, image);
    });

    // jQuery('#profile_img_file_input').change(function($) {
    //   let file = this.files[0];
    //   let fileInput = jQuery('#profile_img_file_input').get(0);
    //   let image = jQuery('#profile_image').get(0);
    //   validateImageSize(file, fileInput)
    //   replaceImage(file, image);
    // });
});

// 名前・ユーザーネーム入力確認（profile_edit.html）
jQuery(function($) {
    // 名前のフォーカスが外れた際にcheck_ProfileInput実行
    jQuery('#name_box').on('blur', function($) {
        check_ProfileInput();
    });
    // ユーザーネームのフォーカスが外れた際にcheck_ProfileInput実行
    jQuery('#user_name_box').on('blur', function($) {
        check_ProfileInput();
    });
    // 生年月日のフォーカスが外れた際にcheck_ProfileInput実行
    jQuery('#calendar_box').on('blur', function($) {
        check_ProfileInput();
    });
    // webサイトのフォーカスが外れた際にcheck_ProfileInput実行
    jQuery('#url_box').on('blur', function($) {
        check_ProfileInput();
    });

});

// 名前・ユーザーネーム入力判定
function check_ProfileInput() {
    jQuery('#NameMsg').hide();
    jQuery('#UserNameMsg').hide();
    jQuery('#CalendarMsg').hide();
    jQuery('#UrlMsg').hide();
    // 保存ボタン有効化フラグ
    var disabledFlag = true;

    // 入力項目フラグ定義
    var name_flg = false;
    var user_name_flg = false;
    var calendar_flg = false;
    var url_flg = false;

    // 名前の値取得
    var nameVal = jQuery('#name_box').val();
    // ユーザーネームの値取得
    var user_nameVal = jQuery('#user_name_box').val();
    // URLの値取得
    var urlVal = jQuery('#url_box').val();
    // 生年月日の値取得
    var calendarVal = jQuery('#calendar_box').val();

    // 名前が入力されているかを確認
    if (nameVal.length > 0) {
        if (!nameVal.match(/^\s+?$/ || /^　+?$/)) {
            name_flg = true;
        } else {
            showNameMsg();
        }
    } else {
        showNameMsg();
    }

    // ユーザーネームが入力されているかを確認
    if (user_nameVal.length > 0) {
        if (!user_nameVal.match(/^\s+?$/ || /^　+?$/)) {
            user_name_flg = true;
        } else {
            showUserNameMsg();
        }
    } else {
        showUserNameMsg();
    }

    // 生年月日が入力されているかを確認
    if (calendarVal.length > 0) {
        // 生年月日の形式を確認
        if (!calendarVal.match(/^\d{4}\-\d{2}\-\d{2}$/)) {
            // 形式が間違っている場合エラーメッセージ表示
            showCalendarMsg();
        } else {
            calendar_flg = true;
        };
    } else {
        calendar_flg = true;
    };

    // URLが入力されているかを確認
    if (urlVal.length > 0) {
        // URLの空白を確認
        if (!urlVal.match(/[\x20\u3000]/)) {
            // URLのフォーマットを確認
            url_flg = validateUrl(urlVal);
            // URLが間違っている場合エラーメッセージ表示
            if (url_flg === false) {
                showUrlMsg()
            };
            // URLに空欄が入っている場合エラーメッセージ表示
        } else {
            showUrlMsg()
        };
    } else {
        url_flg = true;
    }

    // 正しく入力されている場合、保存ボタンを有効化
    if (name_flg === true && user_name_flg === true && calendar_flg == true && url_flg === true) {
        disabledFlag = false;
    }

    // ボタンの「disabled」の置き換え
    jQuery('#save-btn').attr('disabled', disabledFlag);
}

function showNameMsg() {
    // 名前空欄のメッセージ
    jQuery('#NameMsg').show();
    jQuery('#NameMsg').empty().append("<p id=\"inputNameErrMsg\" class=\"NameErrMsg mb-0\">名前を入力してください</p>");

}

function showUserNameMsg() {
    // ユーザーネーム空欄のメッセージ
    jQuery('#UserNameMsg').show();
    jQuery('#UserNameMsg').empty().append("<p id=\"inputUserNameErrMsg\" class=\"UserNameErrMsg mb-0\">ユーザーネームを入力してください</p>");

}

function showCalendarMsg() {
    // 日付間違っている場合のメッセージ
    jQuery('#CalendarMsg').show();
    jQuery('#CalendarMsg').empty().append("<p id=\"inputCalendarErrMsg\" class=\"CalendarErrMsg mb-0\">生年月日を正しく選択してください</p>");

}

function showUrlMsg() {
    // URL間違っている場合のメッセージ
    jQuery('#UrlMsg').show();
    jQuery('#UrlMsg').empty().append("<p id=\"inputUrlErrMsg\" class=\"UrlErrMsg mb-0\">URLを確認してください</p>");
}

jQuery(function($) {
    jQuery('#chat_button').on('click', function($) {
        let inputText = document.getElementById('chat_input');
        let appendArea = document.getElementById('message_show_area');
        outputMessage(inputText, appendArea);
    });
});

// メッセージを画面に出力
function outputMessage(text, area) {
    if (!text.value) return false;
    let time = new Date();
    let hour = ('00' + time.getHours()).slice(-2);
    let min = ('00' + time.getMinutes()).slice(-2);
    let message = jQuery(`<div class="col-12 pb-5 mb-5 pr-0" style="z-index: -1;"><div class="balloon_r"><div class="faceicon"><img src="assets/img/pixta_64747350_M.jpg" class="rounded-circle" alt=""><div class="ml-xl-4 ml-1">${hour + ":" + min }</div></div><div class="says"><p>${text.value}</p></div></div></div>`);
    jQuery(area).append(message);
}

// 画像を画面に出力
function outputImage(imgSrc, area) {
    if (!imgSrc) return false;
    let time = new Date();
    let hour = ('00' + time.getHours()).slice(-2);
    let min = ('00' + time.getMinutes()).slice(-2);
    let image = jQuery(`<div class="col-12 pb-5 mb-5 pr-0" style="z-index: -1;" ><div class="balloon_r"><div class="faceicon"><img src="assets/img/pixta_64747350_M.jpg" class="rounded-circle" alt=""><div class="ml-xl-4 ml-1">${hour + ":" + min }</div></div><img src="${imgSrc}" class="post-image result"></div></div>`);
    jQuery(area).append(image);
}

// メッセージ詳細画面（message_show.html）
jQuery(function($) {
    jQuery('#chat_button').on('click', function($) {
        let inputText = document.getElementById('chat_input');
        let appendArea = document.getElementById('message_show_area');
        outputMessage(inputText, appendArea);
        inputText.value = '';
    });

    jQuery('#messages_file_input').change(function($) {
        let file = this.files[0];
        let fr = new FileReader();
        fr.readAsDataURL(file);
        fr.onload = function($) {
            jQuery('.bigimg').children().attr('src', fr.result).css({
                'width': '40vh',
                'height': '30vh',
                'object-fit': 'cover'
            });
            jQuery('.modal').fadeIn();
            return false;
        }
    });
    jQuery('#post_image_btn').on('click', function($) {
        let imgResult = jQuery('.bigimg').children().attr('src')
        let appendArea = document.getElementById('message_show_area');
        outputImage(imgResult, appendArea)
        jQuery('.modal').fadeOut();
    });
});

jQuery(function($) {
    // 販売形式のラジオボタン変更で、表示するフォーム切り替え
    jQuery('[name="saleType"]:radio').change(function($) {
        // 通常販売にチェックがついている場合
        if (jQuery('#sale').prop('checked')) {
            jQuery('.saleTypeSection').hide();
            jQuery('.saleSection').show();
            jQuery('.termsSection').show();
            // オークションにチェックがついている場合
            // } else if (jQuery('#auction').prop('checked')) {
            //     jQuery('.saleTypeSection').hide();
            //     jQuery('.auctionSection').show();
            //     jQuery('.termsSection').show();
            // 販売しないにチェックがついている場合
        } else {
            jQuery('.saleTypeSection').hide();
            jQuery('.termsSection').hide();
            jQuery('.notForSaleSection').show();
        }
    });
});

jQuery(function($) {
    // オークション開催有無のラジオボタン変更で、表示するフォーム切り替え
    jQuery('[name="selectAuction"]:radio').change(function($) {
        // オークション開催ありにチェックがついている場合
        if (jQuery('#auction').prop('checked')) {
            jQuery('.notholdauctionSection').hide();
            jQuery('.holdauctionSection').show();
        } else {
            jQuery('.holdauctionSection').hide();
            jQuery('.notholdauctionSection').show();
        }
    });
});

/**
 * タイムラインページ(timeline.html)
 * スライダー処理
 */
jQuery(function($) {
        // ページ内に該当のクラス名のカウント
        var swiper_list = document.querySelectorAll('.swiperlist');
        var swiper_tum = document.querySelectorAll('.swipertum');


        if (swiper_list.length > 0) {
            // スライダーのループ処理    
            for (let i = 0; i < swiper_list.length; i++) {
                swiper_list[i].className += i;
                swiper_tum[i].className += i;
                var swiper = new Swiper('.swiperlist' + i, {
                    spaceBetween: 10, //サムネイルの隙間
                    slidesPerView: 4, //表示するサムネイル数
                    freeMode: true,
                    watchSlidesProgress: true,
                });
                var swiper_tumnail = new Swiper('.swipertum' + i, {
                    thumbs: {
                        swiper: swiper,
                    },
                });
            }
        }
    })
    // Swiperによる、タブ切り替え（notification.html）
jQuery(function($) {
    //初期化
    // ページ内に該当のクラス名のカウント
    var swiper_list = document.querySelectorAll('.tab-menu');
    if (swiper_list.length > 0) {
        const galleryThumbs = new Swiper('.tab-menu', {
            spaceBetween: 20,
            slidesPerView: 'auto',
            watchSlidesVisibility: true,
            watchSlidesProgress: true,
            slideActiveClass: 'swiper-slide-active'
        });
        const galleryTop = new Swiper('.tab-contents', {
            autoHeight: true,
            thumbs: {
                swiper: galleryThumbs
            }
        });
    }

});

// tableの列にリンク設定（ranking.html）
// jQuery( function($) {
//     jQuery('tbody tr[data-href]').addClass('clickable').click( function($) {
//         window.location = jQuery(this).attr('data-href');
//     }).find('a').hover( function($) {
//         jQuery(this).parents('tr').unbind('click');
//     }, function($) {
//         jQuery(this).parents('tr').click( function($) {
//             window.location = jQuery(this).attr('data-href');
//         });
//     });
// });

// ランキングページ詳細開閉（ranking.html）
jQuery(function($) {
    jQuery('.sp-btn').click(function($) {
        var parent = jQuery(this).closest("tr").attr('class').split(" ")[0];
        var detail_rank = ".detail-" + parent
        if (jQuery(this).hasClass('more')) {
            jQuery(detail_rank).removeClass('not-show');
            jQuery(this).removeClass('more');
            jQuery(this).addClass('less');
        } else {
            jQuery(detail_rank).addClass('not-show');
            jQuery(this).removeClass('less');
            jQuery(this).addClass('more');
        }
    });
})

// 通報内容確認（report.html）
jQuery(function($) {
    // タイトルのフォーカスが外れた際にcheck_ProfileInput実行
    jQuery('#report-reason').on('blur', function($) {
        check_ReportInput();
    });

    jQuery('#sel_report').on('change', function($) {
        check_ReportInput();
    });
});

// 通報内容入力判定
function check_ReportInput() {
    jQuery('#inputReportReasonMsg').hide();
    // 保存ボタン有効化フラグ
    var disabledFlag = true;

    // 入力項目フラグ定義
    // var textarea_flg = false;

    // // 通報理由の値取得
    var textarea_val = jQuery('#report-reason').val();

    // 通報理由任意に伴い無効化
    // // 通報理由が入力されているかを確認
    // if (textarea_val.length > 0) {
    //     textarea_flg = true;
    // } else {
    //     showReportReasonMsg();
    // }

    // 項目のチェックボックス要素を取得
    // var checkbox_1 = document.getElementById('inlineCheckbox1');
    // var checkbox_2 = document.getElementById('inlineCheckbox2');
    // var checkbox_3 = document.getElementById('inlineCheckbox3');

    // 正しく入力されている場合、通報ボタンを有効化
    // if (checkbox_1.checked === true) {
    //     disabledFlag = false;
    // } else if (checkbox_2.checked === true) {
    //     disabledFlag = false;
    // } else if (checkbox_3.checked === true && textarea_val.length > 0) {
    //     disabledFlag = false;
    // }

    var sel_repot_val = jQuery('#sel_report').val();
    console.log(sel_repot_val);
    if (sel_repot_val > 0) {
        disabledFlag = false;
    }

    // ボタンの「disabled」の置き換え
    jQuery('#report-btn').attr('disabled', disabledFlag);
}

// 通報理由任意に伴い無効化
// function showReportReasonMsg() {
//     // 通報理由が入力されてない際のメッセージ
//     var ReportReasonLength = jQuery('#report-reason').val().length;
//     if (ReportReasonLength <= 0) {
//         jQuery('#inputReportReason').empty().append("<p id=\"inputReportReasonMsg\" class=\"inputReportReasonMsg postErrMsg my-0\">理由を入力して下さい</p>");
//     }
// }

jQuery(function($) {
    // ページ内に該当のクラス名のカウント
    var cropper_profile = document.querySelectorAll('#profile_img_file_input');
    if (cropper_profile.length > 0) {
        jQuery(document).ready(function($) {
            // エンドポイントを定義
            const endpoint = "http://localhost:3000/api";

            // 拡大表示で使用する変数定義
            let $zoom = jQuery('#zoom');
            $zoom.data('oldVal', $zoom.val());

            // モーダル、画像、クロッパーの初期化
            let $modal = jQuery('#modal');
            let image = document.getElementById('image');
            let cropper;

            // ファイル選択後のイベント
            jQuery("body").on("change", ".image", function(e) {
                let files = e.target.files;
                let done = function(url) {
                    image.src = url;
                    $modal.modal('show');
                };
                console.log(image);
                // FileReader、選択ファイル、生成URLを初期化
                let reader;
                let file;
                let url;

                // ファイルが選択された場合
                if (files && files.length > 0) {
                    file = files[0];
                    if (URL) {
                        done(URL.createObjectURL(file));
                    } else if (FileReader) {
                        reader = new FileReader();
                        reader.onload = function(e) {
                            done(reader.result);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            });

            // cropper.jsでトリミング可能な画像を表示
            $modal.on('shown.bs.modal', function(event) {
                cropper = new Cropper(image, {
                    aspectRatio: 1,
                    initialAspectRatio: 1,
                    autoCropArea: 1,
                    cropBoxResizable: false,
                    dragMode: 'move',
                    viewMode: 3,
                    zoomable: true,
                    // preview: '.preview',
                });
            }).on('hidden.bs.modal', function($) {
                cropper.destroy();
                cropper = null;
            });
            console.log(cropper);
            // 保存ボタンを押下時のイベント
            jQuery("#crop").click(function($) {
                canvas = cropper.getCroppedCanvas({
                    width: cropper['cropBoxData']['width'],
                    height: cropper['cropBoxData']['height'],
                });
                console.log(canvas);
                canvas.toBlob(function(blob) {
                    url = URL.createObjectURL(blob);
                    let reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = function($) {
                        let base64data = reader.result;
                        const base64EncodedFile = base64data.replace(/data:.*\/.*;base64,/, '');
                        jQuery('#profile_image').attr('src', base64data);
                        $modal.modal('hide');
                        $zoom.val(0);
                        $zoom.data('oldVal', 0);
                        console.log(cropper);
                        jQuery('#upload-image-x').val(cropper['cropBoxData']['left']);
                        jQuery('#upload-image-y').val(cropper['cropBoxData']['top']);
                        jQuery('#upload-image-w').val(cropper['cropBoxData']['width']);
                        jQuery('#upload-image-h').val(cropper['cropBoxData']['height']);
                    }
                });
            })

            // <!-- NOTE:拡大バー一旦処理外す。 -->
            // 画像拡大用のスクロールバーを変更した時のイベント
            jQuery('#zoom').on('input', function($) {
                let oldVal = $zoom.data('oldVal');
                let volume = jQuery(this).val();
                let result = volume - oldVal;
                cropper.zoom(result);
                console.log(result);
                $zoom.data('oldVal', volume);
            });
        });
    }
});

jQuery(function($) {
    // ページ内に該当のクラス名のカウント
    var cropper_post = document.querySelectorAll('#post_file');
    if (cropper_post.length > 0) {

        jQuery(document).ready(function($) {
            // エンドポイントを定義
            const endpoint = "http://localhost:3000/api";

            // 拡大表示で使用する変数定義
            let $zoom = jQuery('#zoom');
            $zoom.data('oldVal', $zoom.val());
            // モーダル、画像、クロッパーの初期化
            let $modal = jQuery('#modal');
            let image = document.getElementById('image');
            let cropper_post;

            // ファイル選択後のイベント
            jQuery("body").on("change", "#postFile", function(e) {
                let files = e.target.files;
                let done = function(url) {
                    image.src = url;
                    $modal.modal('show');
                };
                console.log(image);
                // FileReader、選択ファイル、生成URLを初期化
                let reader;
                let file;
                let url;

                // ファイルが選択された場合
                if (files && files.length > 0) {
                    console.log(2)
                    file = files[0];
                    if (URL) {
                        done(URL.createObjectURL(file));
                    } else if (FileReader) {
                        reader = new FileReader();
                        reader.onload = function(e) {
                            done(reader.result);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            });

            // cropper.jsでトリミング可能な画像を表示
            $modal.on('shown.bs.modal', function(event) {
                cropper_post = new Cropper(image, {
                    aspectRatio: 9 / 16,
                    initialAspectRatio: 1,
                    autoCropArea: 1,
                    cropBoxResizable: false,
                    dragMode: 'move',
                    viewMode: 3,
                    zoomable: false,
                    // preview: '.preview',
                });
            }).on('hidden.bs.modal', function($) {
                cropper_post.destroy();
                cropper_post = null;
            });

            // 保存ボタンを押下時のイベント
            jQuery("#crop").click(function($) {
                // cover_imgの数カウント

                var img_id = "#cover_img1";
                var img_src = jQuery(img_id).attr('src');
                if (img_src === "") {
                    var cover_img = img_id
                    var upload_image_x = "#upload-image-x";
                    var upload_image_y = "#upload-image-y";
                    var upload_image_w = "#upload-image-w";
                    var upload_image_h = "#upload-image-h";
                }
                jQuery('#post_file').css('height', 'auto');

                canvas = cropper_post.getCroppedCanvas({
                    width: cropper_post['cropBoxData']['width'],
                    height: cropper_post['cropBoxData']['height'],
                });
                jQuery(cover_img).removeClass('d-none')
                canvas.toBlob(function(blob) {
                    url = URL.createObjectURL(blob);
                    let reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = function($) {
                        let base64data = reader.result;
                        const base64EncodedFile = base64data.replace(/data:.*\/.*;base64,/, '');
                        jQuery(cover_img).attr('src', base64data);
                        $modal.modal('hide');
                        $zoom.val(0);
                        $zoom.data('oldVal', 0);
                        console.log(cropper_post);
                        jQuery(upload_image_x).val(cropper_post['cropBoxData']['left']);
                        jQuery(upload_image_y).val(cropper_post['cropBoxData']['top']);
                        jQuery(upload_image_w).val(cropper_post['cropBoxData']['width']);
                        jQuery(upload_image_h).val(cropper_post['cropBoxData']['height']);
                    }
                });
            })

            // <!-- NOTE:拡大バー一旦処理外す。 -->
            // 画像拡大用のスクロールバーを変更した時のイベント
            // jQuery('#zoom').on('input', function () {
            // let oldVal = $zoom.data('oldVal');
            // let volume = jQuery(this).val();
            // let result = volume - oldVal;
            // cropper.zoom(result);
            // $zoom.data('oldVal', volume);
            // });
        });
    };
});

// SPアコーディオンメニュー
jQuery(function($) {
    jQuery('.more_text').click(function($) {
        jQuery(this).toggleClass('active');
    });
});

// ▼ post.htmlでのJS
// 画像投稿ページ 画像登録のJS
jQuery(function() {

    jQuery("body").on("change", "#files", function(e) {
        var file = e.target.files[0];
        var reader = new FileReader();

        reader.onload = (function(file) {
            return function(e) {
                console.log(e.target.result);
                add_file = e.target.result;
                viewHtml(add_file);
            };
        })(file);
        reader.readAsDataURL(file);
    });

    jQuery("#filename, #btn_upload_file").on("click", function(e) {
        jQuery('#files').trigger('click');
    });

    jQuery("body").on("click", "#delete_post_image", function() {

        var index = jQuery(this).data('count');
        console.log(index);
        jQuery('#image_' + index).val('');
        viewHtml('');
    });

    // タイトルからフォーカス外れた時に実行
    jQuery("body").on('blur', '#postTitle', function($) {
        validatePostImage();
    });

    // 投稿内容からフォーカス外れた時に実行
    jQuery("body").on('blur', '#postDetail', function($) {
        validatePostImage();
    });

    // 販売形式のチェックが変更された時に実行
    jQuery("body").on('click', 'input[name=saleType]', function($) {
        validatePostImage();
    });

    // 対象のチェックが変更された時に実行
    jQuery("body").on('click', 'input[name=restrictedAge]', function($) {
        validatePostImage();
    });

    // オークション開始日時のチェックが変更された時に実行
    jQuery("body").on('click', 'input[name=selectAuction]', function($) {
        validatePostImage();
    });

    // オークションの開始時間指定のチェックが変更になった時に実行
    jQuery("body").on('click', 'input[name=auctionStartDate]', function($) {
        validatePostImage();
    });


    // 販売価格のフォーカスが外れた時に実行
    jQuery("body").on('blur', '#imagePrice', function($) {
        validatePostImage();
    });

    // 即決価格がのフォーカスが外れた時に実行
    jQuery("body").on('blur', '#binPrice', function($) {
        validatePostImage();
    });

    // オークション開始日時の年が変更されたときに実行
    jQuery("body").on('change', '#auctionDateY', function($) {
        validatePostImage();
    });

    // オークション開始日時の月が変更されたときに実行
    jQuery("body").on('change', '#auctionDateM', function($) {
        validatePostImage();
    });

    // オークション開始日時の日が変更されたときに実行
    jQuery("body").on('change', '#auctionDateD', function($) {
        validatePostImage();
    });

    // オークション開始日時の時が変更されたときに実行
    jQuery("body").on('change', '#auctionDateH', function($) {
        validatePostImage();
    });

    // オークション開始日時の分が変更されたときに実行
    jQuery("body").on('change', '#auctionDateMin', function($) {
        validatePostImage();
    });

    // オークション終了日時の年が変更されたときに実行
    jQuery("body").on('change', '#auctionEndDateY', function($) {
        validatePostImage();
    });

    // オークション終了日時の月が変更されたときに実行
    jQuery("body").on('change', '#auctionEndDateM', function($) {
        validatePostImage();
    });

    // オークション終了日時の日が変更されたときに実行
    jQuery("body").on('change', '#auctionEndDateD', function($) {
        validatePostImage();
    });

    // オークション終了日時の時が変更されたときに実行
    jQuery("body").on('change', '#auctionEndDateH', function($) {
        validatePostImage();
    });

    // オークション終了日時の分が変更されたときに実行
    jQuery("body").on('change', '#auctionEndDateMin', function($) {
        validatePostImage();
    });

    // オークション自動延長のチェックが変更されたときに実行
    jQuery("body").on('click', 'input[name=enableAutoExtend]', function($) {
        validatePostImage();
    });

    // 利用規約のチェックが変更されたときに実行
    jQuery("body").on('click', '#postTermsCheck', function($) {
        validatePostImage();
    });

    // オークション表示の場合の日付の初期表示の取得
    setAuctionSelBox();
});

// 登録内容のバリデート
function validatePostImage() {

    var validateFlag = true;
    var flagNft = false;

    // バリデート文言の初期化
    jQuery('#validatePostTitle').html('');
    jQuery('#validatePostDetail').html('');
    jQuery('#validatePostImage').html('');
    jQuery('#validateAuctionEnd').html('');
    jQuery('#validateAuctionDate').html('');
    jQuery('#validateImagePrice').html('');
    jQuery('#validateBinPrice').html('');

    // 共通
    // タイトルの必須入力
    var flagPostTitle = true;
    var postTitle = jQuery('#postTitle').val();
    var postTitle = postTitle.replace(/\s+/g, "");
    if (postTitle === "") {
        // 文字列が空ではない場合
        flagPostTitle = false;
        jQuery('#validatePostTitle').html('タイトルは必須入力です。');
    }

    // 投稿内容の必須入力
    var flagPostDetail = true;
    var postDetail = jQuery('#postDetail').val();
    var postDetail = postDetail.replace(/\s+/g, "");
    if (postDetail === "") {
        // 文字列が空ではない場合
        flagPostDetail = false;
        jQuery('#validatePostDetail').html('投稿内容は必須入力です。');
    }

    // 投稿画像の確認
    var flagPostImage = true;
    var image_0 = jQuery('#image_0').val();
    if (image_0 === '') {
        flagPostImage = false;
        jQuery('#validatePostImage').html('投稿画像は最低1つは投稿して下さい');
    }

    // 販売形式がNFT販売にチェックされた場合
    var chkSale = jQuery("#sale:checked").val();
    if (chkSale === 'sale') {
        flagNft = validateTypeNft();
    }

    if (
        flagPostTitle === false &&
        flagPostDetail === false &&
        flagPostImage === false &&
        flagNft === false
    ) {
        validateFlag = false;
    }

    jQuery("#postBtn").prop("disabled", validateFlag);
}

// NFT販売の場合のバリデート
function validateTypeNft() {

    var flagDefault = true;
    var flagAuction = false;

    // 共通

    // 販売価格の必須入力
    var flagImagePrice = true;
    var imagePrice = jQuery('#imagePrice').val();
    var imagePrice = imagePrice.replace(/\s+/g, "");
    if (imagePrice === "") {
        // 文字列が空の場合
        flagImagePrice = false;
        jQuery('#validateImagePrice').html('販売価格は必須入力です。');
    }

    // 即決価格の必須入力
    var flagBinPrice = true;
    var binPrice = jQuery('#binPrice').val();
    var binPrice = binPrice.replace(/\s+/g, "");
    if (binPrice === "") {
        // 文字列が空の場合
        flagBinPrice = false;
        jQuery('#validateBinPrice').html('即決価格は必須入力です。');
    }

    // 利用規約
    var chekTerm = jQuery("#postTermsCheck").prop("checked");

    // オークションの開始時間指定がされている場合
    var chkSpecify = jQuery("#specify:checked").val();
    if (chkSpecify === 'specify') {

        // 現在日時の取得
        var nowDate = new Date();

        // オークション開始日時のチェック
        var auctionDateY = jQuery('#auctionDateY').val();
        var auctionDateM = jQuery('#auctionDateM').val();
        var auctionDateD = jQuery('#auctionDateD').val();
        var auctionDate = new Date(auctionDateY, auctionDateM, auctionDateD);

        // オークション終了日時のチェック
        var auctionEndDateY = jQuery('#auctionEndDateY').val();
        var auctionEndDateM = jQuery('#auctionEndDateM').val();
        var auctionEndDateD = jQuery('#auctionEndDateD').val();
        var auctionEndDate = new Date(auctionEndDateY, auctionEndDateM, auctionEndDateD);

        var flgSetAuction = true;
        if (auctionDate.getTime() > auctionEndDate.getTime()) {
            flgSetAuction = false;
            jQuery('#validateAuctionEnd').html('オークション終了日時はオークション開始日時より未来日で登録して下さい');
        }

        // オークション開始日時 と オークション終了日時の比較
        var flagNowAuction = true;
        if (nowDate.getTime() > auctionDate.getTime()) {
            flagNowAuction = false;
            jQuery('#validateAuctionDate').html('オークション開始日時は未来日で登録して下さい');
        }

        if (flgSetAuction === false && flagNowAuction === false) {
            flagAuction === false;
        }
    }

    if (flagImagePrice === false &&
        flagBinPrice === false &&
        chekTerm === true &&
        flagAuction === false
    ) {
        flagDefault = false;
    }

    return flagDefault;
}

/**
 * 選択画像をページ上に表示
 */
function viewHtml(add_file) {

    var count = 0;
    var arrayImage = [];
    var image_html = '';

    var image_0 = jQuery('#image_0').val();
    if (image_0 !== '') {
        arrayImage[count] = image_0;
        count += 1;
    }

    var image_1 = jQuery('#image_1').val();
    if (image_1 !== '') {
        arrayImage[count] = image_1;
        count += 1;
    }

    var image_2 = jQuery('#image_2').val();
    if (image_2 !== '') {
        arrayImage[count] = image_2;
        count += 1;
    }

    var image_3 = jQuery('#image_3').val();
    if (image_3 !== '') {
        arrayImage[count] = image_3;
        count += 1;
    }

    if (arrayImage.length >= 4) {
        alert('投稿画像が多いです。');
        return false;
    }

    console.log(add_file);
    if (add_file !== '') {
        // 画像データが存在する場合
        arrayImage[count] = add_file;
    }

    console.log(arrayImage.length);
    console.log(arrayImage);
    if (arrayImage.length === 1) {
        // 画像登録が初回の場合
        jQuery.each(arrayImage, function(index, value) {
            image_html += '<div class="form-imgarea-area2-1">';
            image_html += '<div class="form-imgarea-area2-1-1">';
            image_html += '<div class="form-imgarea-area2-img1-1"><img src="' + value + '"></div>';
            image_html += '<div class="form-imgarea-area2-img2-1"><img id="delete_post_image" data-count ="' + index + '" src="/wp-content/themes/muse_template/assets/img/icon/post-x.png"></div>';
            image_html += '</div>';
            image_html += '</div>';
            jQuery('#image_' + index).val(value);
        });
    } else {
        // 画像登録が2つ以上の場合
        jQuery.each(arrayImage, function(index, value) {
            console.log(index + ':' + value);
            image_html += '<div class="form-imgarea-area2">';
            image_html += '<div class="form-imgarea-area2-img1"><img src="' + value + '"></div>';
            image_html += '<div class="form-imgarea-area2-img2"><img id="delete_post_image" data-count ="' + index + '" src="/wp-content/themes/muse_template/assets/img/icon/post-x.png"></div>';
            image_html += '</div>';
            jQuery('#image_' + index).val(value);
        })
    }

    jQuery('#add_image').css('clearfix', '');
    jQuery('#image_html').html(image_html);
    validatePostImage();
}

/**
 * オークション開始日時の表示切替
 */
jQuery(function($) {
    // オークション開始日時指定の表示切替
    jQuery('[name="auctionStartDate"]:radio').change(function($) {
        if (jQuery('#specify').prop('checked')) {
            jQuery('#auction_datetime').removeClass('d-none');
        } else {
            jQuery('#auction_datetime').addClass('d-none');
        }
    });
});

/**
 * オークションの開始日時の終了日時の初期化
 */
function setAuctionSelBox() {

    var nowYear = new Date().getFullYear();

    var setAuctionDateY = jQuery('#setAuctionDateY').val();
    var htmlAuctionDateY = '';
    for (var year = nowYear; year < nowYear + 3; year++) {
        if (year == setAuctionDateY) {
            htmlAuctionDateY += '<option value="' + year + '" selected>' + year + '</option>';
        } else {
            htmlAuctionDateY += '<option value="' + year + '">' + year + '</option>';
        }
    }
    jQuery('#auctionDateY').html(htmlAuctionDateY);


    var setAuctionEndDateY = jQuery('#setAuctionEndDateY').val();
    var htmlAuctionEndDateY = '';
    for (var year = nowYear; year < nowYear + 3; year++) {
        if (year == setAuctionEndDateY) {
            htmlAuctionEndDateY += '<option value="' + year + '" selected>' + year + '</option>';
        } else {
            htmlAuctionEndDateY += '<option value="' + year + '">' + year + '</option>';
        }
    }
    jQuery('#auctionEndDateY').html(htmlAuctionEndDateY);

    var setAuctionDateM = jQuery('#setAuctionDateM').val();
    var htmlAuctionDateM = '';
    for (var month = 1; month <= 12; month++) {
        if (month == setAuctionDateM) {
            htmlAuctionDateM += '<option value="' + month + '" selected>' + month + '</option>';
        } else {
            htmlAuctionDateM += '<option value="' + month + '">' + month + '</option>';
        }
    }
    jQuery('#auctionDateM').html(htmlAuctionDateM);

    var setAuctionEndDateM = jQuery('#setAuctionEndDateM').val();
    var htmlAuctionEndDateM = '';
    for (var month = 1; month <= 12; month++) {
        if (month == setAuctionEndDateM) {
            htmlAuctionEndDateM += '<option value="' + month + '" selected>' + month + '</option>';
        } else {
            htmlAuctionEndDateM += '<option value="' + month + '">' + month + '</option>';
        }
    }
    jQuery('#auctionEndDateM').html(htmlAuctionEndDateM);

    var setAuctionDateD = jQuery('#setAuctionDateD').val();
    var htmlAuctionDateD = '';
    for (var day = 1; day <= 31; day++) {
        if (day == setAuctionDateD) {
            htmlAuctionDateD += '<option value="' + day + '" selected>' + day + '</option>';
        } else {
            htmlAuctionDateD += '<option value="' + day + '">' + day + '</option>';
        }
    }
    jQuery('#auctionDateD').html(htmlAuctionDateD);

    var setAuctionEndDateD = jQuery('#setAuctionEndDateD').val();
    var htmlAuctionEndDateD = '';
    for (var day = 1; day <= 31; day++) {
        if (day == setAuctionEndDateD) {
            htmlAuctionEndDateD += '<option value="' + day + '" selected>' + day + '</option>';
        } else {
            htmlAuctionEndDateD += '<option value="' + day + '">' + day + '</option>';
        }
    }
    jQuery('#auctionEndDateD').html(htmlAuctionEndDateD);

    var setAuctionDateH = jQuery('#setAuctionDateH').val();
    var htmlAuctionDateH = '';
    for (var hour = 1; hour <= 23; hour++) {
        if (hour == setAuctionDateH) {
            htmlAuctionDateH += '<option value="' + hour + '" selected>' + hour + '</option>';
        } else {
            htmlAuctionDateH += '<option value="' + hour + '">' + hour + '</option>';
        }
    }
    jQuery('#auctionDateH').html(htmlAuctionDateH);

    var setAuctionEndDateH = jQuery('#setAuctionEndDateH').val();
    var htmlAuctionEndDateH = '';
    for (var hour = 1; hour <= 23; hour++) {
        if (hour == setAuctionEndDateH) {
            htmlAuctionEndDateH += '<option value="' + hour + '" selected>' + hour + '</option>';
        } else {
            htmlAuctionEndDateH += '<option value="' + hour + '">' + hour + '</option>';
        }
    }
    jQuery('#auctionEndDateH').html(htmlAuctionEndDateH);

    var setAuctionDateMin = jQuery('#setAuctionDateMin').val();
    var htmlAuctionDateMin = '';
    for (var min = 1; min <= 59; min++) {
        if (min == setAuctionDateMin) {
            htmlAuctionDateMin += '<option value="' + min + '" selected>' + min + '</option>';
        } else {
            htmlAuctionDateMin += '<option value="' + min + '">' + min + '</option>';
        }
    }
    jQuery('#auctionDateMin').html(htmlAuctionDateMin);

    var setAuctionEndDateMin = jQuery('#setAuctionEndDateMin').val();
    var htmlAuctionEndDateMin = '';
    for (var min = 1; min <= 59; min++) {
        if (min == setAuctionEndDateMin) {
            htmlAuctionEndDateMin += '<option value="' + min + '" selected>' + min + '</option>';
        } else {
            htmlAuctionEndDateMin += '<option value="' + min + '">' + min + '</option>';
        }
    }
    jQuery('#auctionEndDateMin').html(htmlAuctionEndDateMin);
}
// ▲ post.htmlでのJS