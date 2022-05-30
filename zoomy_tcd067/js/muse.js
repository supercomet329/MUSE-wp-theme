// 通常新規登録ページ(sign_up.html)
// 入力項目のフォーカスが外れた際に処理を実行
jQuery(function($) {
    // メールアドレスのフォーカスが外れた際にcheckInput実行
    jQuery('#email').on('blur', function() {
        checkInput();
    });
    // 会員規約がクリックされた際にcheckInput実行
    jQuery('#terms').on('click', function() {
            checkInput();
        })
        // 仮登録ボタンを押された際に、メール送信済みメッセージを表示
    jQuery('#register-btn').on('click', function() {
        showEmailSentMsg();
    })
});

// 入力項目を確認し、仮登録ボタン有効化/無効化切り替え
function checkInput() {
    // メールアドレスが入力された場合、emailCheckにtrueを格納
    var emailCheck = '';
    if (document.getElementById('email').value.length > 0) {
        emailCheck = true;
    } else {
        emailCheck = false;
    }

    // 会員規約のチェックボックス要素を取得
    var terms = document.getElementById('terms');

    // メールアドレスが入力されている、かつ会員規約にチェックがついている場合ボタンを有効化
    var registerBtn = document.getElementById('register-btn');
    if (emailCheck === true && terms.checked === true) {
        registerBtn.disabled = false;
    } else {
        registerBtn.disabled = true;
    }
}

/**
 * パスワードリセットページ
 */
// 入力項目のフォーカスが外れた際に処理を実行
jQuery(function($) {
    // メールアドレスのフォーカスが外れた際にcheckPwResetInput実行
    jQuery('#pwResetEmail').on('blur', function() {
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
    jQuery('#loginEmail').on('blur', function() {
        checkLoginInput();
    });
    // パスワードのフォーカスが外れた際にcheckLoginInput実行
    jQuery('#loginPassword').on('blur', function() {
        checkLoginInput();
    })
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
    fr.onload = function() {
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
    jQuery('#username').on('blur', function() {
        checkRegisterInput();
    });
    // 名前のフォーカスが外れた際にcheckRegisterInput実行
    jQuery('#name').on('blur', function() {
        checkRegisterInput();
    });
    // パスワードのフォーカスが外れた際にcheckRegisterInput実行
    jQuery('#password').on('blur', function() {
        checkRegisterInput();
    });
    // パスワードを再入力のフォーカスが外れた際にcheckRegisterInput実行
    jQuery('#password_confirmation').on('blur', function() {
        checkRegisterInput();
    });
});

// 入力項目を確認し、新規登録ボタン有効化/無効化切り替え
function checkRegisterInput() {
    // 新規登録ボタン有効化フラグ
    var disabledFlag = true;

    // 入力項目フラグ定義
    var username = false;
    var name = false;
    var password = false;
    var pwConfirm = false;

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
            username = true;
        }
    }

    // 名前が入力されているかを確認
    if (nameVal.length > 0) {
        // 名前に空白文字が含まれていないかを確認
        if (!nameVal.match(/[\x20\u3000]/)) {
            name = true;
        }
    }

    // パスワードが入力されているかを確認
    if (passwordVal.length > 0) {
        // パスワードのフォーマットを確認
        var password = validatePassword(passwordVal);
    }

    // パスワードを再入力が入力されているかを確認
    if (pwConfirmVal.length > 0) {
        // パスワードとパスワードを再入力の値が同じかを確認
        if (passwordVal === pwConfirmVal) {
            pwConfirm = true;
        }
    }

    // 入力項目の値が正しい場合、新規登録ボタンを有効化
    if (username === true && name === true && password === true && pwConfirm === true) {
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
    jQuery('#newPw').on('blur', function() {
        checkSetPwInput();
        showTypePwMsg();
    });
    // 新しいパスワードを再入力のフォーカスが外れた際にcheckSetPwInput実行
    jQuery('#newPwConfirm').on('blur', function() {
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

// パスワードが合っていない場合、メッセージを表示
function showPwNotMatchMsg() {
    jQuery('#inputPwConfirmMsg').empty().append("<p id=\"inputPwConfirmErrMsg\" class=\"pwResetErrMsg\">パスワードが一致しません</p>");
}