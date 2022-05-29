// 通常新規登録ページ(sign_up.html)
// 入力項目のフォーカスが外れた際に処理を実行
jQuery(function($) {
    // メールアドレスのフォーカスが外れた際にcheckInput実行
    $('#email').on('blur', function() {
        checkInput();
    });
    // 会員規約がクリックされた際にcheckInput実行
    $('#terms').on('click', function() {
            checkInput();
        })
        // 仮登録ボタンを押された際に、メール送信済みメッセージを表示
    $('#register-btn').on('click', function() {
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
    $('#pwResetEmail').on('blur', function() {
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
    $('#inputEmailMsg').empty().append("<p id=\"emailErrMsg\">メールアドレスを入力してください</p>");
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
    $('#emailSentMsg').append("<p>下記のメールアドレスに仮登録メールを送信いたしました。</p>");
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